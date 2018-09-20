<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain;

use Clovnrian\MoneyBridge\Domain\Product\ProductCollection;

interface IMoneyBridge
{
    public function getAllProducts(int $limit = 200, $offset = 0): ProductCollection;
}
