<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

final class ProductParameter
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $value;

    public static function fromMoney(array $data): self
    {
        return new self(
            $data['ID'],
            $data['Nazev'],
            $data['Hodnota']
        );
    }

    private function __construct(string $id, string $name, string $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
