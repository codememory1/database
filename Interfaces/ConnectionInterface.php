<?php

namespace Codememory\Components\Database\Interfaces;

use Codememory\Components\Database\Connectors\Drivers\AbstractDriver;

/**
 * interface ConnectionInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface ConnectionInterface
{

    /**
     * @param string $namespaceDriver
     *
     * @return ConnectionInterface
     */
    public function setDriver(string $namespaceDriver): ConnectionInterface;

    /**
     * @param string $host
     *
     * @return ConnectionInterface
     */
    public function setHost(string $host): ConnectionInterface;

    /**
     * @param int $port
     *
     * @return ConnectionInterface
     */
    public function setPort(int $port): ConnectionInterface;

    /**
     * @param string $dbname
     *
     * @return ConnectionInterface
     */
    public function setDbname(string $dbname): ConnectionInterface;

    /**
     * @param string $username
     *
     * @return ConnectionInterface
     */
    public function setUsername(string $username): ConnectionInterface;

    /**
     * @param string $password
     *
     * @return ConnectionInterface
     */
    public function setPassword(string $password): ConnectionInterface;

    /**
     * @param string $charset
     *
     * @return ConnectionInterface
     */
    public function setCharset(string $charset): ConnectionInterface;

}