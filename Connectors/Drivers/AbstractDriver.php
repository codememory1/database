<?php

namespace Codememory\Components\Database\Connectors\Drivers;

use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use Codememory\Components\Database\Interfaces\DriverInterface;
use PDO;

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
     * @var ConnectionDataInterface
     */
    protected ConnectionDataInterface $connectionData;

    /**
     * AbstractDriver constructor.
     *
     * @param ConnectionDataInterface $connectionData
     */
    public function __construct(ConnectionDataInterface $connectionData)
    {

        $this->connectionData = $connectionData;

    }

}