<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

use Clovnrian\MoneyBridge\Domain\PriceList\PriceList;

final class ProductPrice
{
    /** @var string */
    private $id;

    /** @var PriceList */
    private $priceList;

    /** @var string */
    private $currency;

    /** @var float */
    private $price;

    /** @var int */
    private $vat;

    public static function fromMoney(array $data): self
    {
        return new self(
            $data['ID'],
            PriceList::fromMoney($data),
            $data['KodMeny'],
            floatval($data['Cena']),
            intval($data['SazbaDPH'])
        );
    }

    private function __construct(string $id, PriceList $priceList, string $currency, float $price, int $vat)
    {
        $this->id = $id;
        $this->priceList = $priceList;
        $this->currency = $currency;
        $this->price = $price;
        $this->vat = $vat;
    }


}
