<?php

namespace Codememory\Components\Database\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class DriverNotAvailableException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
class DriverNotAvailableException extends ConnectorException
{

    /**
     * DriverNotAvailableException constructor.
     *
     * @param string $driverName
     */
    #[Pure]
    public function __construct(string $driverName)
    {

        parent::__construct(sprintf('Unable to use the %s driver due to its absence', $driverName));

    }

}