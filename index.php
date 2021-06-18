<?php

ini_set('display_errors', 1);

use Codememory\Components\Database\Connectors\Connector;
use Codememory\Components\Database\Connectors\Drivers\MysqlDriver;
use Codememory\Components\Database\Interfaces\ConnectionInterface;

require_once 'vendor/autoload.php';

$connector = new Connector();

$connector
    ->addConnection('test', function (ConnectionInterface $connection) {
        $connection
            ->setHost('localhost')
            ->setDbname('test')
            ->setUsername('admin')
            ->setPassword('admin')
            ->setDriver(Connector::MYSQL_DRIVER);

        return $connection;
    })
    ->addConnection('red', function (ConnectionInterface $connection) {
        $connection
            ->setHost('localhost')
            ->setDbname('red')
            ->setUsername('admin')
            ->setPassword('admin')
            ->setCharset('utf8')
            ->setDriver(Connector::MYSQL_DRIVER);

        return $connection;
    })
    ->makeConnection('test')
    ->makeConnection('red');

dd($connector->getConnection('red')->query('SELECT * FROM users')->fetchAll());

