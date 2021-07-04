<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions\Traits;

/**
 * Trait ConditionalTrait
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions\Traits
 *
 * @author  Codememory
 */
trait ConditionalTrait
{

    use ShieldingTrait;

    /**
     * @param string           $column
     * @param string           $arithmeticOperator
     * @param int|float|string $value
     *
     * @return string
     */
    public function conditional(string $column, string $arithmeticOperator, int|float|string $value): string
    {

        return "{$this->shieldingColumnName($column)} $arithmeticOperator '$value'";

    }

}