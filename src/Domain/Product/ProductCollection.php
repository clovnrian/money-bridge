<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

use ArrayIterator;
use Countable;
use IteratorAggregate;

final class ProductCollection implements IteratorAggregate, Countable
{
    /** @var Product[] */
    private $products;

    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->products);
    }

    public function count(): int
    {
        return \count($this->products);
    }
}
