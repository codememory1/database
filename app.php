<?php

use Codememory\Components\Database\Connection;
use Codememory\Components\Database\Connectors\Connector;
use Codememory\Components\Database\Connectors\Drivers\MysqlDriver;
use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Symfony\Component\Console\Application;
use Codememory\Components\Database\Commands\CreateDatabaseCommand;

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

$app = new Application();

$app->add(new CreateDatabaseCommand($testConnection));

$app->run();