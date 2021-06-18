<?php

namespace Codememory\Components\Database\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class ConnectorException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
abstract class ConnectorException extends ErrorException
{

    /**
     * ConnectorException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    #[Pure]
    public function __construct(string $message = "", int $code = 0)
    {

        parent::__construct($message, $code);

    }

}