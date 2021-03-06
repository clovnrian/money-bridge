<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge;

use Clovnrian\MoneyBridge\Domain\IMoneyBridge;
use Clovnrian\MoneyBridge\Infrastructure\Dibi\DibiProductRepository;
use Dibi\Connection;

final class MoneyBridgeFactory
{
    public static function create(array $config): IMoneyBridge
    {
        if (!\is_array($config)) {
            throw new \InvalidArgumentException('Configuration must be array.');
        }

        $dataConnection = new Connection([
            'driver' => 'sqlsrv',
            'host' => $config['host'],
            'username' => $config['username'],
            'password' => $config['password'],
            'database' => $config['database'],
            'version' => '11.0',
        ]);

        $docConnection = new Connection([
            'driver' => 'sqlsrv',
            'host' => $config['host'],
            'username' => $config['username'],
            'password' => $config['password'],
            'database' => $config['database'] . '_Doc',
            'version' => '11.0',
        ]);

        $repository = new DibiProductRepository($dataConnection, $docConnection);
        return new MoneyBridge($repository);
    }
}
