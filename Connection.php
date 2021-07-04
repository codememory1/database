<?php

namespace Codememory\Components\Database;

use Codememory\Components\Database\Builders\AbstractBuilder;
use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use Codememory\Components\Database\Exceptions\ConnectionNotExistException;
use Codememory\Components\Database\Exceptions\DriverNotAvailableException;
use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use Codememory\Components\Database\Interfaces\ConnectorInterface;
use Codememory\Components\Database\Interfaces\DriverInterface;
use PDO;
use PDOException;

/**
 * Class ConnectionConfiguration
 *
 * @package Codememory\Components\Database
 *
 * @author  Codememory
 */
class Connection implements ConnectionInterface
{

    /**
     * @var ConnectorInterface
     */
    private ConnectorInterface $connector;

    /**
     * @var string
     */
    private string $connectionName;

    /**
     * @var ConnectionDataInterface
     */
    private ConnectionDataInterface $connectionData;

    /**
     * @var bool
     */
    private bool $connectionState = false;

    /**
     * @var PDO|null
     */
    private ?PDO $connected;

    /**
     * Connection constructor.
     *
     * @param ConnectorInterface $connector
     * @param string             $connectionName
     *
     * @throws ConnectionNotExistException
     * @throws DriverNotAvailableException
     */
    public function __construct(ConnectorInterface $connector, string $connectionName)
    {

        $this->connector = $connector;
        $this->connectionName = $connectionName;

        if (false === $this->connector->existConnection($this->connectionName)) {
            $this->throwAboutNotExistConnection($this->connectionName);
        }

        $this->connectionData = $this->connector->getConnections()[$this->connectionName]->getConnectionData();
        $this->connected = $this->makeConnection();

    }

    /**
     * @inheritDoc
     */
    public function getDriver(): DriverInterface
    {

        $driver = $this->connectionData->getDriver();

        $driver->setConnection($this);

        return $driver;

    }

    /**
     * @inheritDoc
     */
    public function getConnected(): ?PDO
    {

        return $this->connected;

    }

    /**
     * @inheritDoc
     */
    public function closeConnection(): void
    {

        $this->connected = null;
        $this->connectionState = false;

    }

    /**
     * @inheritDoc
     */
    public function isConnection(): bool
    {

        return $this->connectionState;

    }

    /**
     * @inheritDoc
     */
    public function isFullConnection(): bool
    {

        return $this->isConnection() && !empty($this->getConnectionData()->getDbname());

    }

    /**
     * @inheritDoc
     */
    public function getBuilder(): AbstractBuilder
    {

        return $this->getDriver()->getBuilder();

    }

    /**
     * @inheritDoc
     */
    public function getSchemaCompiler(): AbstractCompiler
    {

        return $this->getDriver()->getSchemaCompiler();

    }

    /**
     * @inheritDoc
     */
    public function getConnectionData(): ConnectionDataInterface
    {

        return $this->connectionData;

    }

    /**
     * @inheritDoc
     * @throws ConnectionNotExistException
     * @throws DriverNotAvailableException
     */
    public function reconnect(callable $callback): ConnectionInterface
    {

        $cloneConnection = $this->cloneConnection();

        $cloneConnection->connector->changeConnectionConfiguration($this->connectionName, $callback);
        $cloneConnection->__construct($cloneConnection->connector, $this->connectionName);

        return $cloneConnection;

    }

    /**
     * @inheritDoc
     */
    public function cloneConnection(): ConnectionInterface
    {

        return clone $this;

    }

    /**
     * @return PDO|null
     * @throws DriverNotAvailableException
     */
    private function makeConnection(): ?PDO
    {

        $driverName = $this->getDriver()->getDriverName();

        if (!in_array($driverName, PDO::getAvailableDrivers())) {
            throw new DriverNotAvailableException($driverName);
        }

        try {
            $this->connectionState = true;

            return $this->getDriver()->getConnect();
        } catch (PDOException) {
            $this->connectionState = false;

            return null;
        }

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