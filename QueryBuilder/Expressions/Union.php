<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions;

use Codememory\Components\Database\Interfaces\QueryDataDestinationInterface;

/**
 * Trait Union
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions
 *
 * @author  Codememory
 */
final class Union
{

    /**
     * @param QueryDataDestinationInterface ...$selects
     *
     * @return string
     */
    public function distinct(string ...$selects): string
    {

        $unionSelect = implode(' UNION DISTINCT ', array_map(function (string $destination) {
            return $destination;
        }, $selects));

        return sprintf('%s UNION DISTINCT', $unionSelect);

    }

    /**
     * @param QueryDataDestinationInterface ...$selects
     *
     * @return string
     */
    public function all(string ...$selects): string
    {

        $unionSelect = implode(' UNION ALL ', array_map(function (string $destination) {
            return $destination;
        }, $selects));

        return sprintf('%s UNION ALL', $unionSelect);

    }

    /**
     * @param QueryDataDestinationInterface $select
     *
     * @return string
     */
    public function group(string $select): string
    {

        return sprintf('(%s)', $select);

    }

}