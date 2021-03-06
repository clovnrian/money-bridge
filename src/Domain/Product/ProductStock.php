<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

final class ProductStock
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $quantity;

    public static function fromMoney(array $data): self
    {
        return new self(
            $data['Sklad_ID'],
            $data['Nazev'],
            (int) ($data['DostupneMnozstvi'])
        );
    }

    private function __construct(string $id, string $name, int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
