<?php

namespace Codememory\Components\Database\Interfaces;

use Codememory\Components\Database\QueryBuilder\Expressions\Expression;
use Codememory\Components\Database\QueryBuilder\Expressions\Union;

/**
 * Interface QueryBuilderInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface QueryBuilderInterface
{

    /**
     * @return QueryBuilderInterface|QueryDataDestinationInterface
     */
    public function generateQuery(): QueryBuilderInterface|QueryDataDestinationInterface;

    /**
     * @param array $columns
     *
     * @return QueryBuilderInterface
     */
    public function select(array $columns = []): QueryBuilderInterface;

    /**
     * @param string $select
     *
     * @return QueryBuilderInterface
     */
    public function customSelect(string $select): QueryBuilderInterface;

    /**
     * @param bool $row
     *
     * @return QueryBuilderInterface
     */
    public function distinct(bool $row = false): QueryBuilderInterface;

    /**
     * @param string      $tableName
     * @param string|null $alias
     *
     * @return QueryBuilderInterface
     */
    public function from(string $tableName, ?string $alias = null): QueryBuilderInterface;

    /**
     * @param string ...$expressions
     *
     * @return QueryBuilderInterface
     */
    public function where(string ...$expressions): QueryBuilderInterface;

    /**
     * @param string|array $columns
     * @param string|array $orderIndex
     *
     * @return QueryBuilderInterface
     */
    public function orderBy(string|array $columns, string|array $orderIndex): QueryBuilderInterface;

    /**
     * @param int      $with
     * @param int|null $before
     *
     * @return QueryBuilderInterface
     */
    public function limit(int $with, ?int $before = null): QueryBuilderInterface;

    /**
     * @param array $columns
     * @param bool  $rollup
     *
     * @return QueryBuilderInterface
     */
    public function groupBy(array $columns, bool $rollup = false): QueryBuilderInterface;

    /**
     * @param string ...$expressions
     *
     * @return QueryBuilderInterface
     */
    public function having(string ...$expressions): QueryBuilderInterface;

    /**
     * @param string $expression
     *
     * @return QueryBuilderInterface
     */
    public function customHaving(string $expression): QueryBuilderInterface;

    /**
     * @param string|array      $tables
     * @param string|array|null $aliases
     * @param string|null       $specification
     *
     * @return QueryBuilderInterface
     */
    public function innerJoin(string|array $tables, string|array $aliases = null, ?string $specification = null): QueryBuilderInterface;

    /**
     * @param string|array      $tables
     * @param string|array|null $aliases
     * @param string|null       $specification
     *
     * @return QueryBuilderInterface
     */
    public function leftJoin(string|array $tables, string|array $aliases = null, ?string $specification = null): QueryBuilderInterface;

    /**
     * @param string|array      $tables
     * @param string|array|null $aliases
     * @param string|null       $specification
     *
     * @return QueryBuilderInterface
     */
    public function rightJoin(string|array $tables, string|array $aliases = null, ?string $specification = null): QueryBuilderInterface;

    /**
     * @return Expression
     */
    public function expression(): Expression;

    /**
     * @return JoinSpecificationsInterface
     */
    public function joinSpecification(): JoinSpecificationsInterface;

    /**
     * @param string $name
     * @param string $value
     *
     * @return QueryBuilderInterface
     */
    public function setParameter(string $name, string $value): QueryBuilderInterface;

    /**
     * @param array $parameters
     *
     * @return QueryBuilderInterface
     */
    public function setParameters(array $parameters): QueryBuilderInterface;

    /**
     * @param string $table
     *
     * @return QueryBuilderInterface
     */
    public function insert(string $table): QueryBuilderInterface;

    /**
     * @param string                        $tableOfWrite
     * @param QueryDataDestinationInterface $queryBuilder
     *
     * @return QueryBuilderInterface
     */
    public function insertWithSelect(string $tableOfWrite, QueryDataDestinationInterface $queryBuilder): QueryBuilderInterface;

    /**
     * @param string           $column
     * @param string|int|float $value
     *
     * @return QueryBuilderInterface
     */
    public function setValue(string $column, string|int|float $value): QueryBuilderInterface;

    /**
     * @param array $columnsWithValue
     *
     * @return QueryBuilderInterface
     */
    public function setValues(array $columnsWithValue): QueryBuilderInterface;

    /**
     * @param string ...$columns
     *
     * @return QueryBuilderInterface
     */
    public function setColumns(string ...$columns): QueryBuilderInterface;

    /**
     * @param string      $table
     * @param string|null $alias
     *
     * @return QueryBuilderInterface
     */
    public function update(string $table, ?string $alias = null): QueryBuilderInterface;

    /**
     * @param string      $table
     * @param string|null $alias
     *
     * @return QueryBuilderInterface
     */
    public function delete(string $table, ?string $alias = null): QueryBuilderInterface;

    /**
     * @return Union
     */
    public function unionModifiers(): Union;

    /**
     * @param string ...$selects
     *
     * @return QueryBuilderInterface
     */
    public function union(string ...$selects): QueryBuilderInterface;

}