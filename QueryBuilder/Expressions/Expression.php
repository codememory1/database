<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions;

use Codememory\Components\Database\QueryBuilder\Expressions\Traits\ConditionalTrait;
use Codememory\Components\Database\QueryBuilder\Expressions\Traits\LogicOperatorTrait;
use JetBrains\PhpStorm\Pure;

/**
 * Class Expression
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions
 *
 * @author  Codememory
 */
final class Expression
{

    use LogicOperatorTrait;
    use ConditionalTrait;

    /**
     * @return Range
     */
    #[Pure]
    public function range(): Range
    {

        return new Range();

    }

    /**
     * @return RegexpLike
     */
    #[Pure]
    public function like(): RegexpLike
    {

        return new RegexpLike();

    }

    /**
     * @param string|array $columns
     *
     * @return string
     */
    public function isNull(string|array $columns): string
    {

        return $this->composeNullable('IS NULL', $columns);

    }

    /**
     * @param string|array $columns
     *
     * @return string
     */
    public function isNotNull(string|array $columns): string
    {

        return $this->composeNullable('IS NOT NULL', $columns);

    }

    /**
     * @param string       $operator
     * @param string|array $columns
     *
     * @return string
     */
    private function composeNullable(string $operator, string|array $columns): string
    {

        $columns = is_string($columns) ? [$columns] : $columns;
        $assembledColumns = [];

        foreach ($columns as $column) {
            $assembledColumns[] = "`$column` $operator";
        }

        return implode(' AND ', $assembledColumns);

    }

}