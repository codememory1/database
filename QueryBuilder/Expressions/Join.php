<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions;

use Codememory\Components\Database\Interfaces\JoinSpecificationsInterface;
use Codememory\Components\Database\QueryBuilder\Expressions\Traits\ShieldingTrait;
use Codememory\Support\Str;
use JetBrains\PhpStorm\Pure;

/**
 * Class Join
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions
 *
 * @author  Codememory
 */
final class Join implements JoinSpecificationsInterface
{

    use ShieldingTrait;

    /**
     * @inheritDoc
     */
    public function on(string $expressions): string
    {

        return $this->composeSpecification('on', trim(Str::trimToSymbol($expressions, ' ')));

    }

    /**
     * @inheritDoc
     */
    public function using(array $columns): string
    {

        $columns = array_map(fn (string $column) => $this->shieldingColumnName($column), $columns);

        return $this->composeSpecification('using', implode(',', $columns));

    }

    /**
     * @param string $reference
     * @param array  $tables
     * @param array  $aliases
     * @param string $specification
     *
     * @return string
     */
    public function getAssembledJoin(string $reference, array $tables, array $aliases, string $specification): string
    {

        $rowTables = null;

        foreach ($tables as $index => $table) {
            $alias = array_key_exists($index, $aliases) && !empty($aliases[$index]) ? "AS $aliases[$index]" : null;

            $rowTables .= sprintf('`%s` %s,', $table, $alias);
        }

        return sprintf('%s JOIN (%s) %s ', Str::toUppercase($reference), trim(mb_substr(trim($rowTables), 0, -1)), $specification);

    }

    /**
     * @param string $specification
     * @param string $expressionsOrColumns
     *
     * @return string
     */
    #[Pure]
    private function composeSpecification(string $specification, string $expressionsOrColumns): string
    {

        return sprintf('%s (%s)', Str::toUppercase($specification), $expressionsOrColumns);

    }

}