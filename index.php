<?php

ini_set('display_errors', 1);

use Codememory\Components\Database\Builders\Compilers\Configs\TableConfig;
use Codememory\Components\Database\Connectors\Connector;
use Codememory\Components\Database\Connection;
use Codememory\Components\Database\Connectors\Drivers\MysqlDriver;
use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Codememory\Components\Database\ORM\EntityManager;
use App\Entity\TestEntity;
use Codememory\Components\Database\QueryBuilder\Expressions\Operators;
use Codememory\Components\Database\QueryBuilder\QueryBuilder;

require_once 'vendor/autoload.php';

$connector = new Connector();
$connector
    ->addConnection('test', function (ConnectionConfigurationInterface $connectionConfiguration) {
        $connectionConfiguration
            ->setHost('localhost')
            ->setDbname('danil')
            ->setUsername('admin')
            ->setPassword('admin')
            ->setDriver(new MysqlDriver());

        return $connectionConfiguration;
    })
    ->addConnection('test2', function (ConnectionConfigurationInterface $connectionConfiguration) {
        $connectionConfiguration
            ->setHost('localhost')
            ->setDbname('red')
            ->setUsername('admin')
            ->setPassword('admin')
            ->setDriver(new MysqlDriver());

        return $connectionConfiguration;
    });

$testConnection = new Connection($connector, 'test');

$em = new EntityManager($testConnection);




