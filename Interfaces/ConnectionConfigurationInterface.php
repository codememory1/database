<?php

namespace Codememory\Components\Database\Interfaces;

/**
 * interface ConnectionConfigurationInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface ConnectionConfigurationInterface
{

    /**
     * @param DriverInterface $driver
     *
     * @return ConnectionConfigurationInterface
     */
    public function setDriver(DriverInterface $driver): ConnectionConfigurationInterface;

    /**
     * @param string $host
     *
     * @return ConnectionConfigurationInterface
     */
    public function setHost(string $host): ConnectionConfigurationInterface;

    /**
     * @param int $port
     *
     * @return ConnectionConfigurationInterface
     */
    public function setPort(int $port): ConnectionConfigurationInterface;

    /**
     * @param string|null $dbname
     *
     * @return ConnectionConfigurationInterface
     */
    public function setDbname(?string $dbname): ConnectionConfigurationInterface;

    /**
     * @param string $username
     *
     * @return ConnectionConfigurationInterface
     */
    public function setUsername(string $username): ConnectionConfigurationInterface;

    /**
     * @param string $password
     *
     * @return ConnectionConfigurationInterface
     */
    public function setPassword(string $password): ConnectionConfigurationInterface;

    /**
     * @param string $charset
     *
     * @return ConnectionConfigurationInterface
     */
    public function setCharset(string $charset): ConnectionConfigurationInterface;

}