<?php

namespace Codememory\Components\Database\Interfaces;

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
     * @return PDO
     */
    public function getConnect(): PDO;

    /**
     * @return string
     */
    public function getDriverName(): string;

}