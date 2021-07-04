<?php

namespace Codememory\Components\Database\Interfaces;

/**
 * Interface ConnectionDataInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface ConnectionDataInterface
{

    /**
     * @return DriverInterface
     */
    public function getDriver(): DriverInterface;

    /**
     * @return string|null
     */
    public function getHost(): ?string;

    /**
     * @return int|null
     */
    public function getPort(): ?int;

    /**
     * @return string|null
     */
    public function getDbname(): ?string;

    /**
     * @return string|null
     */
    public function getUsername(): ?string;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;

    /**
     * @return string|null
     */
    public function getCharset(): ?string;

}