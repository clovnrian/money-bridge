<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

final class ProductImage
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $size;

    /** @var string */
    private $imageData;

    /** @var string */
    private $iconData;

    /** @var \DateTimeInterface */
    private $created;

    public static function fromMoney(array $data): self
    {
        return new self(
            $data['ID'],
            $data['Description'],
            $data['Size'],
            $data['FileImage'],
            $data['IconImage'],
            $data['Create_Date']
        );
    }

    private function __construct(
        string $id,
        string $name,
        int $size,
        string $imageData,
        string $iconData,
        \DateTimeInterface $created
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->imageData = $imageData;
        $this->iconData = $iconData;
        $this->created = $created;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getImageData(): string
    {
        return $this->imageData;
    }

    public function getIconData(): string
    {
        return $this->iconData;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }
}
