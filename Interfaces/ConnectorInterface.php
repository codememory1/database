<?php

namespace Codememory\Components\Database\Interfaces;

use Codememory\Components\Database\Connectors\ConnectionConfiguration;

/**
 * Interface ConnectorInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface ConnectorInterface
{

    /**
     * @param string   $connectionName
     * @param callable $callbackConfiguration
     *
     * @return ConnectorInterface
     */
    public function addConnection(string $connectionName, callable $callbackConfiguration): ConnectorInterface;

    /**
     * @param string $connectionName
     *
     * @return bool
     */
    public function existConnection(string $connectionName): bool;

    /**
     * @return ConnectionConfiguration[]
     */
    public function getConnections(): array;

    /**
     * @param string   $connectionName
     * @param callable $callback
     *
     * @return bool
     */
    public function changeConnectionConfiguration(string $connectionName, callable $callback): bool;

}