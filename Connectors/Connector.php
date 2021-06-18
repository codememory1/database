<?php

namespace Codememory\Components\Database\Connectors;

use Codememory\Components\Database\Connectors\Drivers\MysqlDriver;
use Codememory\Components\Database\Connectors\Drivers\PostgresDriver;
use Codememory\Components\Database\Connectors\Drivers\SqliteDriver;
use Codememory\Components\Database\Connectors\Drivers\SqlServerDriver;
use Codememory\Components\Database\Exceptions\ConnectionNamedExist;
use Codememory\Components\Database\Exceptions\ConnectionNotExistException;
use Codememory\Components\Database\Exceptions\DriverNotAvailableException;
use PDO;
use PDOException;

/**
 * Class Connector
 *
 * @package Codememory\Components\Database\Connectors
 *
 * @author  Codememory
 */
class Connector
{

    public const MYSQL_DRIVER = MysqlDriver::class;
    public const SQLITE_DRIVER = SqliteDriver::class;
    public const POSTGRES_DRIVER = PostgresDriver::class;
    public const SQL_SERVER_DRIVER = SqlServerDriver::class;

    /**
     * @var array
     */
    private array $connections = [];

    /**
     * @var array
     */
    private array $connectionStates = [];

    /**
     * @var array
     */
    private array $connected = [];

    /**
     * @param string   $connectionName
     * @param callable $callback
     *
     * @return $this
     * @throws ConnectionNamedExist
     */
    public function addConnection(string $connectionName, callable $callback): Connector
    {

        if (array_key_exists($connectionName, $this->connections)) {
            throw new ConnectionNamedExist($connectionName);
        }

        $this->connections[$connectionName] = call_user_func($callback, new Connection());

        return $this;

    }

    /**
     * @param string $connectionName
     *
     * @return $this
     * @throws ConnectionNotExistException
     * @throws DriverNotAvailableException
     */
    public function makeConnection(string $connectionName): Connector
    {

        if (false === $this->existConnection($connectionName)) {
            $this->throwAboutNotExistConnection($connectionName);
        }

        /** @var Connection $connection */
        $connection = $this->connections[$connectionName];
        $connectionData = $connection->getConnectionData();
        $driver = $connectionData->getDriver();

        if (!in_array($driver->getDriverName(), PDO::getAvailableDrivers())) {
            throw new DriverNotAvailableException($driver->getDriverName());
        }

        try {
            $pdo = $driver->getConnect();

            $this->connected[$connectionName] = $pdo;
            $this->connectionStates[$connectionName] = true;
        } catch (PDOException) {
            $this->connectionStates[$connectionName] = false;
        }

        return $this;

    }

    /**
     * @param string $connectionName
     *
     * @return bool|null
     */
    public function isConnection(string $connectionName): ?bool
    {

        if (array_key_exists($connectionName, $this->connectionStates)) {
            return $this->connectionStates[$connectionName];
        }

        return null;

    }

    /**
     * @param string $connectionName
     *
     * @return PDO
     * @throws ConnectionNotExistException
     */
    public function getConnection(string $connectionName): PDO
    {

        if (false === array_key_exists($connectionName, $this->connected)) {
            $this->throwAboutNotExistConnection($connectionName);
        }

        return $this->connected[$connectionName];

    }

    /**
     * @param string $connectionName
     *
     * @return bool
     */
    public function existConnection(string $connectionName): bool
    {

        return array_key_exists($connectionName, $this->connections);

    }

    /**
     * @param string $connectionName
     *
     * @throws ConnectionNotExistException
     */
    private function throwAboutNotExistConnection(string $connectionName): void
    {

        throw new ConnectionNotExistException($connectionName);

    }

}