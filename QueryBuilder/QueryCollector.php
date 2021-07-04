<?php

namespace Codememory\Components\Database\QueryBuilder;

use Codememory\Components\Database\Exceptions\QueryTypeNotExistException;
use Codememory\Components\Database\Interfaces\QueryDataDestinationInterface;
use Codememory\Components\Database\QueryBuilder\Expressions\Traits\QueryTypeMethodsTrait;

/**
 * Class QueryCollector
 *
 * @package Codememory\Components\Database\QueryBuilder
 *
 * @author  Codememory
 */
class QueryCollector
{

    use QueryTypeMethodsTrait;

    private const QUERY_TYPE_METHODS = [
        'SELECT' => 'select',
        'INSERT' => 'insert',
        'UPDATE' => 'update',
        'DELETE' => 'delete'
    ];

    /**
     * @var QueryDataDestinationInterface
     */
    private QueryDataDestinationInterface $queryDataDestination;

    /**
     * QueryCollector constructor.
     *
     * @param QueryDataDestinationInterface $queryDataDestination
     */
    public function __construct(QueryDataDestinationInterface $queryDataDestination)
    {

        $this->queryDataDestination = $queryDataDestination;

    }

    /**
     * @return string|null
     * @throws QueryTypeNotExistException
     */
    public function getQuery(): ?string
    {

        return $this->handlerQueryCollector();

    }

    /**
     * @param string|null ...$operators
     *
     * @return string|null
     */
    private function formatting(?string ...$operators): ?string
    {

        $stringOperators = null;

        foreach ($operators as $operator) {
            if(!empty($operator)) {
                $stringOperators .= sprintf('%s ', trim($operator));
            }
        }

        return $stringOperators;

    }

    /**
     * @return string|null
     * @throws QueryTypeNotExistException
     */
    private function handlerQueryCollector(): ?string
    {

        $currentQueryType = $this->queryDataDestination->getQueryType();

        if(!array_key_exists($currentQueryType, self::QUERY_TYPE_METHODS)) {
            throw new QueryTypeNotExistException($currentQueryType);
        }

        return call_user_func([$this, self::QUERY_TYPE_METHODS[$currentQueryType]]);

    }

}