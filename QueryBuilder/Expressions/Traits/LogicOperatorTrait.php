<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions\Traits;

use Codememory\Support\Str;
use JetBrains\PhpStorm\Pure;

/**
 * Trait LogicOperatorTrait
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions
 *
 * @author  Codememory
 */
trait LogicOperatorTrait
{

    /**
     * @param string ...$expressions
     *
     * @return string
     */
    public function exprOr(string ...$expressions): string
    {

        return $this->composeLogicExpression('or', ...$expressions);

    }

    /**
     * @param string ...$expressions
     *
     * @return string
     */
    public function exprAnd(string ...$expressions): string
    {

        return $this->composeLogicExpression('and', ...$expressions);

    }

    /**
     * @param string ...$expressions
     *
     * @return string
     */
    public function exprXor(string ...$expressions): string
    {

        return $this->composeLogicExpression('xor', ...$expressions);

    }

    /**
     * @param string $operator
     * @param string ...$expression
     *
     * @return string
     */
    protected function composeLogicExpression(string $operator, string ...$expression): string
    {

        $expr = sprintf(
            '%1$s %2$s %1$s',
            Str::toUppercase($operator),
            implode(Str::toUppercase(" $operator "), $expression)
        );

         return Str::trimAfterSymbol($expr, ' ', false);
    }

}