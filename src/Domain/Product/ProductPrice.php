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
            (float) ($data['Cena']),
            (int) ($data['SazbaDPH'])
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getPriceList(): PriceList
    {
        return $this->priceList;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVat(): int
    {
        return $this->vat;
    }
}
