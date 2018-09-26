<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

final class ProductVendor
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    public static function fromMoney(array $data): self
    {
        return new self($data['Vyrobce_ID'], $data['Vyrobce']);
    }

    private function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
