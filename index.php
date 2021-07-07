<?php

ini_set('display_errors', 1);

use App\Respository\TestRepository;
use Codememory\Components\Database\Builders\Compilers\Configs\TableConfig;
use Codememory\Components\Database\Connectors\Connector;
use Codememory\Components\Database\Connection;
use Codememory\Components\Database\Connectors\Drivers\MysqlDriver;
use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Codememory\Components\Database\ORM\Construction\Column;
use Codememory\Components\Database\ORM\Construction\Join;
use Codememory\Components\Database\ORM\EntityManager;
use App\Entity\TestEntity;
use Codememory\Components\Database\QueryBuilder\Expressions\Operators;
use Codememory\Components\Database\QueryBuilder\QueryBuilder;
use Codememory\Components\Database\ORM\Inspector;
use Codememory\Components\Database\ORM\EntityHelper;

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
$query = new QueryBuilder($testConnection);

/** @var TestRepository $testRepository */
$testRepository = $em->getRepository(new TestEntity());

dd($testRepository->tests());

//$in = new Inspector(new TestEntity());
//
//dd($in->strictColumnExist('id'));

//$helper = new EntityHelper(new TestEntity());
//
//dd($helper->identifyJoinPropertyByColumnNames(['col1', 'col2']));
