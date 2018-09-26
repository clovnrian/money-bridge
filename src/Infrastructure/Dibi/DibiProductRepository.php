<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Infrastructure\Dibi;

use Clovnrian\MoneyBridge\Domain\Product\Product;
use Clovnrian\MoneyBridge\Domain\Product\ProductCategory;
use Clovnrian\MoneyBridge\Domain\Product\ProductCollection;
use Clovnrian\MoneyBridge\Domain\Product\ProductImage;
use Clovnrian\MoneyBridge\Domain\Product\ProductPrice;
use Clovnrian\MoneyBridge\Domain\Product\ProductRepository;
use Clovnrian\MoneyBridge\Domain\Product\ProductStock;
use Dibi\Connection;
use Dibi\Row;

final class DibiProductRepository implements ProductRepository
{
    /** @var Connection */
    private $db;

    /** @var Connection */
    private $documentDb;

    public function __construct(Connection $db, Connection $documentDb)
    {
        $this->db = $db;
        $this->documentDb = $documentDb;
    }

    public function find(int $limit, int $offset): ProductCollection
    {
        $products = $this->db->select('
			a.Nazev,
			CAST(a.ID AS char(36)) ID,
			a.PLU,
			CAST(a.NadrazenyArtikl_ID AS char(36)) NadrazenyArtikl_ID,
			a.Katalog,
			a.CarovyKod,
			CAST(a.Vyrobce_Firma_ID AS char(36)) Vyrobce_ID,
			v.Nazev Vyrobce,
			a.Create_Date,
			a.Modify_Date,
			a.Popis
			')
            ->from('CSW_EObchod_Artikl a')
            ->join('CSW_EObchod_Vyrobce v')->on('v.ID = a.Vyrobce_Firma_ID')
            ->where('a.Deleted = 0 AND a.Hidden = 0 AND v.Deleted = 0 AND v.Hidden = 0')
            ->where('EXISTS (SELECT 1 FROM CSW_EObchod_ArtiklKategorie WHERE Parent_ID = a.ID)')
            ->where('EXISTS (SELECT 1 FROM CSW_EObchod_PolozkaCeniku WHERE Artikl_ID = a.ID)')
            ->where('EXISTS (SELECT 1 FROM CSW_EObchod_Zasoba WHERE Artikl_ID = a.ID)')
            ->fetchAll($offset, $limit);

        return new ProductCollection(
            ...array_map(
                function(Row $row) { return Product::fromMoney($row->toArray()); },
                $products
            )
        );
    }

    /**
     * @return ProductCategory[]
     */
    public function findCategoriesForProduct(string $productId): array
    {
        $categories = $this->db->select(
            'CAST(ac.Kategorie_ID AS char(36)) Kategorie_ID, c.Nazev, CAST(c.NadrazenaKategorie_ID AS char(36)) NadrazenaKategorie_ID'
        )
            ->from('CSW_EObchod_ArtiklKategorie ac')
            ->join('CSW_EObchod_Kategorie c')->on('c.ID = ac.Kategorie_ID')
            ->where('ac.Root_ID = %s', $productId)
            ->where('ac.Deleted = 0 AND ac.Hidden = 0 AND ac.Locked = 0')
            ->where('c.Deleted = 0 AND c.Hidden = 0 AND c.Locked = 0')
            ->fetchAll();

        return array_map(
            function(Row $row) { return ProductCategory::fromMoney($row->toArray()); },
            $categories
        );
    }

    /**
     * @return ProductStock[]
     */
    public function findStocksForProduct(string $productId): array
    {
        $stocks = $this->db->select(
            'CAST(os.Sklad_ID AS char(36)) Sklad_ID, s.Nazev, z.DostupneMnozstvi'
        )
            ->from('CSW_EObchod_ObchodSklad os')
            ->join('CSW_EObchod_Sklad s')->on('s.ID = os.Sklad_ID')
            ->join('CSW_EObchod_Zasoba z')->on('z.Sklad_ID = os.Sklad_ID AND z.Artikl_ID = %s', $productId)
            ->where('os.Deleted = 0')
            ->fetchAll();

        return array_map(
            function(Row $row) { return ProductStock::fromMoney($row->toArray()); },
            $stocks
        );
    }

    /**
     * @return ProductPrice[]
     */
    public function findPricesForProduct(string $productId): array
    {
        $prices = $this->db->select('
                CAST(pc.ID AS char(36)) ID,
                pc.Cena,
                pc.SazbaDPH,
                m.Kod KodMeny,
                CAST(c.PlatnostDo AS char(50)) PlatnostDo,
                CAST(c.PlatnostOd AS char(50)) PlatnostOd,
                CAST(oc.Cenik_ID AS char(36)) Cenik_ID,
                c.Nazev,
                c.Kod
		    ')
            ->from('CSW_EObchod_ObchodCenik oc')
            ->join('Ceniky_Cenik c')->on('c.ID = oc.Cenik_ID')
            ->join('CSW_EObchod_PolozkaCeniku pc')->on('pc.Cenik_ID = oc.Cenik_ID')
            ->join('CSW_EObchod_Mena m')->on('m.ID = c.Mena_ID')
            ->where('pc.Artikl_ID = %s', $productId)
            ->where('c.Neaktivni = 0')
            ->orderBy('pc.Cena ASC')
            ->fetchAll();

        return array_map(
            function(Row $row) { return ProductPrice::fromMoney($row->toArray()); },
            $prices
        );
    }

    public function findImagesForProduct(string $productId): array
    {
        $images = $this->documentDb->select(
            'CAST(ID AS char(36)) ID, Description, Create_Date, Size, FileImage, IconImage'
        )
            ->from('System_Attachment')
            ->where('Object_Name=%s AND Object_ID=%s AND Deleted=0', 'Artikl', $productId)
            ->fetchAll();

        return array_map(
            function(Row $row) { return ProductImage::fromMoney($row->toArray()); },
            $images
        );
    }
}
