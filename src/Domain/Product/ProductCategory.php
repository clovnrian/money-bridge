<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

final class ProductCategory
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string|null */
    private $parentCategoryId;

    public static function fromMoney(array $data): self
    {
        return new self(
            $data['Kategorie_ID'],
            $data['Nazev'],
            $data['NadrazenaKategorie_ID']
        );
    }

    private function __construct(string $id, string $name, string $parentCategoryId = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentCategoryId = $parentCategoryId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getParentCategoryId()
    {
        return $this->parentCategoryId;
    }
}
