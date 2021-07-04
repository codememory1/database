<?php

namespace Codememory\Components\Database\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class QueryTypeNotExistException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
class QueryTypeNotExistException extends QueryBuilderException
{

    /**
     * QueryTypeNotExistException constructor.
     *
     * @param string $queryType
     */
    #[Pure]
    public function __construct(string $queryType)
    {

        parent::__construct(sprintf('Unable to execute query type %s due to its absence', $queryType));

    }

}