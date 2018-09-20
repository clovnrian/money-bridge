<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge;

use Clovnrian\MoneyBridge\Domain\IMoneyBridge;

final class MoneyBridgeFactory
{
    public static function create(): IMoneyBridge
    {
        return new MoneyBridge();
    }
}
