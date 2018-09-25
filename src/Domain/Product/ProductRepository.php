<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\Product;

interface ProductRepository
{
    public function find(int $limit, int $offset): ProductCollection;

    /**
     * @return ProductCategory[]
     */
    public function findCategoriesForProduct(string $productId): array;

    /**
     * @return ProductStock[]
     */
    public function findStocksForProduct(string $productId): array;

    /**
     * @return ProductPrice[]
     */
    public function findPricesForProduct(string $productId): array;
}
