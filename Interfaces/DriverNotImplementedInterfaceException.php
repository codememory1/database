<?php

namespace Codememory\Components\Database\Interfaces;

use Codememory\Components\Database\Exceptions\ConnectorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class DriverNotImplementedInterfaceException
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
class DriverNotImplementedInterfaceException extends ConnectorException
{

    /**
     * DriverNotImplementedInterfaceException constructor.
     *
     * @param string $namespaceDriver
     * @param string $interface
     */
    #[Pure]
    public function __construct(string $namespaceDriver, string $interface)
    {

        parent::__construct(sprintf('The %s driver must implement the %s interface', $namespaceDriver, $interface));

    }

}