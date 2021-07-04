<?php

namespace Codememory\Components\Database\Builders;

use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use Codememory\Components\Database\Builders\Compilers\Configs\DatabaseConfig;
use Codememory\Components\Database\Builders\Compilers\Configs\TableConfig;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use LogicException;
use PDO;

/**
 * Class AbstractBuilder
 *
 * @package Codememory\Components\Database\Builders
 *
 * @author  Codememory
 */
abstract class AbstractBuilder
{

    /**
     * @var ConnectionInterface
     */
    protected ConnectionInterface $connection;

    /**
     * @var PDO|null
     */
    protected ?PDO $connected;

    /**
     * @var AbstractCompiler
     */
    protected AbstractCompiler $compiler;

    /**
     * AbstractBuilder constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {

        $this->connection = $connection;
        $this->connected = $this->connection->getConnected();
        $this->compiler = $connection->getSchemaCompiler();

    }

    /**
     * @param string              $dbname
     * @param DatabaseConfig|null $config
     *
     * @return AbstractBuilder
     */
    public function createDatabase(string $dbname, ?DatabaseConfig $config = null): AbstractBuilder
    {

        throw new LogicException(sprintf('The %s driver does not support creating a database', $this->connection->getDriver()->getDriverName()));

    }

    /**
     * @param string $dbname
     *
     * @return AbstractBuilder
     */
    public function dropDatabase(string $dbname): AbstractBuilder
    {

        throw new LogicException(sprintf('The %s driver does not support dropping a database', $this->connection->getDriver()->getDriverName()));

    }

    /**
     * @param string           $tableName
     * @param TableConfig|null $config
     *
     * @return AbstractBuilder
     */
    public function createTable(string $tableName, ?TableConfig $config = null): AbstractBuilder
    {

        throw new LogicException(sprintf('The %s driver does not support creating tables', $this->connection->getDriver()->getDriverName()));

    }

    /**
     * @param string $tableName
     *
     * @return AbstractBuilder
     */
    public function dropTable(string $tableName): AbstractBuilder
    {

        throw new LogicException(sprintf('The %s driver does not support dropping tables', $this->connection->getDriver()->getDriverName()));

    }

    /**
     * @param string $dbname
     *
     * @return bool
     */
    public function databaseExist(string $dbname): bool
    {

        throw new LogicException(sprintf('Driver %s does not support database existence check', $this->connection->getDriver()->getDriverName()));

    }

    /**
     * @param string $tableName
     *
     * @return bool
     */
    public function tableExist(string $tableName): bool
    {

        throw new LogicException(sprintf('Driver %s does not support table existence check', $this->connection->getDriver()->getDriverName()));

    }

}