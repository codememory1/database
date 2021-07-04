<?php

namespace Codememory\Components\Database\Connectors\Drivers;

use Codememory\Components\Database\Connection;
use Codememory\Components\Database\Interfaces\DriverInterface;

/**
 * Class AbstractDriver
 *
 * @package Codememory\Components\Database\Connectors\Drivers
 *
 * @author  Codememory
 */
abstract class AbstractDriver implements DriverInterface
{

    /**
     * @var array
     */
    protected array $options = [];

    /**
     * @var Connection|null
     */
    protected ?Connection $connection = null;

    /**
     * @param Connection $connection
     *
     * @return DriverInterface
     */
    public function setConnection(Connection $connection): DriverInterface
    {

        $this->connection = $connection;

        return $this;

    }

    /**
     * @param int $option
     * @param int $value
     *
     * @return DriverInterface
     */
    public function addOption(int $option, int $value): DriverInterface
    {

        $this->options[$option] = $value;

        return $this;

    }

}