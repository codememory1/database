<?php

namespace Codememory\Components\Database\Interfaces;

use Codememory\Components\Database\Builders\AbstractBuilder;
use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use Codememory\Components\Database\Connection;
use PDO;

/**
 * Interface DriverInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface DriverInterface
{

    /**
     * @param Connection $connection
     *
     * @return DriverInterface
     */
    public function setConnection(Connection $connection): DriverInterface;

    /**
     * @param int $option
     * @param int $value
     *
     * @return DriverInterface
     */
    public function addOption(int $option, int $value): DriverInterface;

    /**
     * @return PDO
     */
    public function getConnect(): PDO;

    /**
     * @return string
     */
    public function getDriverName(): string;

    /**
     * @return AbstractCompiler
     */
    public function getSchemaCompiler(): AbstractCompiler;

    /**
     * @return AbstractBuilder
     */
    public function getBuilder(): AbstractBuilder;

}