<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions\Traits;

/**
 * Trait ShieldingTrait
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions\Traits
 *
 * @author  Codememory
 */
trait ShieldingTrait
{

    /**
     * @param string $columnName
     *
     * @return string
     */
    public function shieldingColumnName(string $columnName): string
    {

        if(preg_match('/[.]+/', $columnName)) {
            return $columnName;
        }

        return sprintf('`%s`', $columnName);

    }

    /**
     * @param string|float|int|null $value
     *
     * @return string|int|float|null
     */
    public function shieldingValue(null|string|float|int $value): string|int|null|float
    {

        if(preg_match('/^:/', $value) || preg_match('/[.]+/', $value)) {
            return $value;
        }

        return sprintf('\'%s\'', $value);

    }

}