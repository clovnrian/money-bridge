<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

final class Product
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $plu;

    /** @var string|null */
    private $ean;

    /** @var string|null */
    private $catalogNumber;

    /** @var ProductVendor|null */
    private $vendor;

    /** @var \DateTimeInterface */
    private $created;

    /** @var \DateTimeInterface */
    private $updated;

    /** @var ProductStock[] */
    private $stocks;

    /** @var ProductImage[] */
    private $images;

    /** @var ProductCategory[] */
    private $categories;

    /** @var ProductParameter[] */
    private $parameters;

    /** @var ProductPrice[] */
    private $prices;

    public static function fromMoney(array $data): self
    {
        $vendor = ($data['Vyrobce_ID'] && $data['Vyrobce'])
            ? ProductVendor::fromMoney($data)
            : null;

        return new self(
            $data['ID'],
            $data['Nazev'],
            $data['Create_Date'],
            $data['Modify_Date'],
            $vendor,
            $data['Popis'],
            $data['PLU'],
            $data['CarovyKod'],
            $data['Katalog']
        );
    }

    private function __construct(
        string $id,
        string $name,
        \DateTimeInterface $created,
        \DateTimeInterface $updated,
        ProductVendor $vendor = null,
        string $description = null,
        string $plu= null,
        string $ean= null,
        string $catalogNumber= null,
        array $stocks = [],
        array $images = [],
        array $categories = [],
        array $parameters = [],
        array $prices = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->plu = $plu;
        $this->ean = $ean;
        $this->catalogNumber = $catalogNumber;
        $this->vendor = $vendor;
        $this->created = $created;
        $this->updated = $updated;
        $this->stocks = $stocks;
        $this->images = $images;
        $this->categories = $categories;
        $this->parameters = $parameters;
        $this->prices = $prices;
    }

    public function setCategories(ProductCategory ...$categories)
    {
        $this->categories = $categories;
    }

    public function setStocks(ProductStock ...$stocks)
    {
        $this->stocks = $stocks;
    }

    public function setPrices(ProductPrice ...$prices)
    {
        $this->prices = $prices;
    }

    public function setImages(ProductImage ...$images)
    {
        $this->images = $images;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
