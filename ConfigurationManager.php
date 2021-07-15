<?php

namespace Codememory\Components\Database;

use Codememory\Components\Database\Connectors\Drivers\MysqlDriver;
use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Codememory\Components\Database\Interfaces\ConnectorInterface;
use Codememory\Components\Database\ORM\EntityManager;

/**
 * Class ConfigurationManager
 *
 * @package Codememory\Components\Database
 *
 * @author  Codememory
 */
class ConfigurationManager
{

    /**
     * @var ConnectorInterface
     */
    private ConnectorInterface $connector;

    /**
     * @var Utils
     */
    private Utils $utils;

    /**
     * ConfigurationManager constructor.
     *
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {

        $this->connector = $connector;
        $this->utils = new Utils();

        $this->makeConnections();

    }

    /**
     * @param string $connectionName
     *
     * @return EntityManager
     * @throws Exceptions\ConnectionNotExistException
     * @throws Exceptions\DriverNotAvailableException
     */
    public function getEntityManager(string $connectionName): EntityManager
    {

        $connection = new Connection($this->connector, $connectionName);

        return new EntityManager($connection);

    }

    /**
     * @return array
     */
    private function getConnections(): array
    {

        $connections = [];
        $connectionNames = array_keys($this->utils->getConnections());

        foreach ($connectionNames as $connectionName) {
            $connections[$connectionName] = $this->utils->getDataConnection($connectionName);
        }

        return $connections;

    }

    /**
     * @return void
     */
    private function makeConnections(): void
    {

        $connections = $this->getConnections();

        foreach ($connections as $connectionName => $connectionData) {
            $this->connector->addConnection($connectionName, function (ConnectionConfigurationInterface $configuration) use ($connectionData) {
                $configuration->setHost($connectionData['host']);

                if (null !== $connectionData['port']) {
                    $configuration->setPort($connectionData['port']);
                }

                $configuration
                    ->setDbname($connectionData['dbname'])
                    ->setUsername($connectionData['username'])
                    ->setPassword($connectionData['password'])
                    ->setDriver(new MysqlDriver());

                if (null !== $connectionData['charset']) {
                    $configuration->setCharset($connectionData['charset']);
                }

                return $configuration;
            });
        }

    }

}