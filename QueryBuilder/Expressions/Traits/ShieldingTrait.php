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

        return "`$columnName`";

    }

}