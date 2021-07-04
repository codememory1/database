<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions;

use JetBrains\PhpStorm\Pure;

/**
 * Class RegexpLike
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions
 *
 * @author  Codememory
 */
final class RegexpLike
{

    /**
     * @param string $column
     * @param string $value
     *
     * @return string
     */
    #[Pure]
    public function starts(string $column, string $value): string
    {

        return $this->compose($column, "^$value");

    }

    /**
     * @param string $column
     * @param string $value
     *
     * @return string
     */
    #[Pure]
    public function ends(string $column, string $value): string
    {

        return $this->compose($column, "$value$");

    }

    /**
     * @param string $column
     * @param string $value
     *
     * @return string
     */
    #[Pure]
    public function contains(string $column, string $value): string
    {

        return $this->compose($column, "$value");

    }

    /**
     * @param string $column
     * @param int    $length
     *
     * @return string
     */
    #[Pure]
    public function onlyCertainLength(string $column, int $length): string
    {

        return $this->compose($column, sprintf('^.{%s}$', $length));

    }

    /**
     * @param string $column
     * @param string $regexp
     *
     * @return string
     */
    #[Pure]
    public function custom(string $column, string $regexp): string
    {

        return $this->compose($column, $regexp);

    }

    /**
     * @param string $column
     * @param string $regexp
     *
     * @return string
     */
    public function not(string $column, string $regexp): string
    {

        return "$column NOT REGEXP '$regexp'";

    }

    /**
     * @param string $column
     * @param string $regexp
     *
     * @return string
     */
    private function compose(string $column, string $regexp): string
    {

        return "REGEXP_LIKE($column, '$regexp')";

    }

}