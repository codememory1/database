<?php

namespace Codememory\Components\Database\Connectors;

use Codememory\Components\Database\Exceptions\ConnectionNamedExist;
use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Codememory\Components\Database\Interfaces\ConnectorInterface;
use LogicException;

/**
 * Class Connector
 *
 * @package Codememory\Components\Database\Connectors
 *
 * @author  Codememory
 */
class Connector implements ConnectorInterface
{

    /**
     * @var ConnectionConfiguration[]
     */
    private array $connections = [];

    /**
     * @inheritDoc
     * @throws ConnectionNamedExist
     */
    public function addConnection(string $connectionName, callable $callbackConfiguration): ConnectorInterface
    {

        if ($this->existConnection($connectionName)) {
            throw new ConnectionNamedExist($connectionName);
        }

        $callCallbackConfiguration = call_user_func($callbackConfiguration, new ConnectionConfiguration());

        $this->throwInvalidReturnCallbackConfiguration($callCallbackConfiguration);

        $this->connections[$connectionName] = call_user_func($callbackConfiguration, new ConnectionConfiguration());

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function existConnection(string $connectionName): bool
    {

        return array_key_exists($connectionName, $this->connections);

    }

    /**
     * @inheritDoc
     */
    public function getConnections(): array
    {

        return $this->connections;

    }

    /**
     * @inheritDoc
     */
    public function changeConnectionConfiguration(string $connectionName, callable $callback): bool
    {

        if($this->existConnection($connectionName)) {
            $callCallbackConfiguration = call_user_func($callback, $this->connections[$connectionName]);

            $this->throwInvalidReturnCallbackConfiguration($callCallbackConfiguration);

            $this->connections[$connectionName] = $callCallbackConfiguration;

            return true;
        }

        return false;

    }

    /**
     * @param mixed $callCallbackConfiguration
     */
    private function throwInvalidReturnCallbackConfiguration(mixed $callCallbackConfiguration): void
    {

        if (!$callCallbackConfiguration instanceof ConnectionConfigurationInterface) {
            throw new LogicException(sprintf('Callback of addConnection method should return connection configuration(%s)', ConnectionConfigurationInterface::class));
        }

    }

}