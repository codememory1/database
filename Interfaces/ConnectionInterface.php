<?php

namespace Codememory\Components\Database\Interfaces;

use Codememory\Components\Database\Builders\AbstractBuilder;
use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use PDO;

/**
 * Interface ConnectionInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface ConnectionInterface
{

    /**
     * @return DriverInterface
     */
    public function getDriver(): DriverInterface;

    /**
     * @return PDO|null
     */
    public function getConnected(): ?PDO;

    /**
     * @return void
     */
    public function closeConnection(): void;

    /**
     * @return bool
     */
    public function isConnection(): bool;

    /**
     * @return bool
     */
    public function isFullConnection(): bool;

    /**
     * @return AbstractBuilder
     */
    public function getBuilder(): AbstractBuilder;

    /**
     * @return AbstractCompiler
     */
    public function getSchemaCompiler(): AbstractCompiler;

    /**
     * @return ConnectionDataInterface
     */
    public function getConnectionData(): ConnectionDataInterface;

    /**
     * @param callable $callback
     *
     * @return ConnectionInterface
     */
    public function reconnect(callable $callback): ConnectionInterface;

    /**
     * @return ConnectionInterface
     */
    public function cloneConnection(): ConnectionInterface;

}