<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions;

use Codememory\Components\Database\QueryBuilder\Expressions\Traits\ShieldingTrait;

/**
 * Class Range
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions
 *
 * @author  Codememory
 */
final class Range
{

    use ShieldingTrait;

    /**
     * @param string $column
     * @param int    $start
     * @param int    $end
     *
     * @return string
     */
    public function is(string $column, int $start, int $end): string
    {

        return $this->compose(false, $column, $start, $end);

    }

    /**
     * @param string $column
     * @param int    $start
     * @param int    $end
     *
     * @return string
     */
    public function notIs(string $column, int $start, int $end): string
    {

        return $this->compose(true, $column, $start, $end);

    }

    /**
     * @param bool   $isNot
     * @param string $column
     * @param int    $start
     * @param int    $end
     *
     * @return string
     */
    private function compose(bool $isNot, string $column, int $start, int $end): string
    {

        $operator = $isNot ? 'NOT BETWEEN' : 'BETWEEN';

        return sprintf('%s %s %s AND %s', $this->shieldingColumnName($column), $operator, $this->shieldingValue($start), $this->shieldingValue($end));

    }

}