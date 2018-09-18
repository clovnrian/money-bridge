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

    /** @var float */
    private $price;

    /** @var int */
    private $stock;

    /** @var int|null */
    private $vat;

    /** @var ProductImage[] */
    private $images;

    /** @var ProductCategory[] */
    private $categories;

    /** @var ProductParameter[] */
    private $parameters;
}
