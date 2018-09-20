<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge;

use Clovnrian\MoneyBridge\Domain\IMoneyBridge;
use Clovnrian\MoneyBridge\Domain\Product\Product;
use Clovnrian\MoneyBridge\Domain\Product\ProductCollection;
use Clovnrian\MoneyBridge\Domain\Product\ProductRepository;

final class MoneyBridge implements IMoneyBridge
{
    /** @var ProductRepository */
    private $repository;

    public function getAllProducts(int $limit = 200, $offset = 0): ProductCollection
    {
        $productCollection = $this->repository->find($limit, $offset);

        /** @var Product $product */
        foreach ($productCollection->getIterator() as $product) {
            $product->setCategories(
                ...$this->repository->findCategoriesForProduct($product->getId())
            );

            $product->setStocks(
                ...$this->repository->findStocksForProduct($product->getId())
            );
        }

        return $productCollection;
    }
}
