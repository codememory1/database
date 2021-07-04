<?php

namespace Codememory\Components\Database\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class QueryBuilderException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
abstract class QueryBuilderException extends ErrorException
{

    /**
     * QueryBuilderException constructor.
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