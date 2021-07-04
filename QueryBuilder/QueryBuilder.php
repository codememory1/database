<?php

namespace Codememory\Components\Database\QueryBuilder;

use Codememory\Components\Database\Exceptions\QueryTypeNotExistException;
use Codememory\Components\Database\Interfaces\JoinSpecificationsInterface;
use Codememory\Components\Database\Interfaces\QueryBuilderInterface;
use Codememory\Components\Database\Interfaces\QueryDataDestinationInterface;
use Codememory\Components\Database\QueryBuilder\Expressions\Expression;
use Codememory\Components\Database\QueryBuilder\Expressions\Traits\ShieldingTrait;
use Codememory\Components\Database\QueryBuilder\Expressions\Union;
use Codememory\Support\Str;

/**
 * Class QueryBuilder
 *
 * @package Codememory\Components\Database
 *
 * @author  Codememory
 */
class QueryBuilder extends AbstractBuilder implements QueryBuilderInterface
{

    use ShieldingTrait;

    /**
     * @var QueryDataDestinationInterface|null
     */
    protected ?QueryDataDestinationInterface $builder = null;

    /**
     * @var string|null
     */
    protected ?string $query = null;

    /**
     * @var string|null
     */
    protected ?string $rowColumns = null;

    /**
     * @var string|null
     */
    protected ?string $distinct = null;

    /**
     * @var string|null
     */
    protected ?string $from = null;

    /**
     * @var string|null
     */
    protected ?string $where = null;

    /**
     * @var string|null
     */
    protected ?string $order = null;

    /**
     * @var string|null
     */
    protected ?string $limit = null;

    /**
     * @var string|null
     */
    protected ?string $group = null;

    /**
     * @var string|null
     */
    protected ?string $having = null;

    /**
     * @var string|null
     */
    protected ?string $sqlJoin = null;

    /**
     * @var array
     */
    protected array $parameters = [];

    /**
     * @var string|null
     */
    protected ?string $queryType = null;

    /**
     * @var array
     */
    protected array $values = [];

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @var string|null
     */
    protected ?string $table = null;

    /**
     * @var string|null
     */
    protected ?string $subQuery = null;

    /**
     * @inheritDoc
     * @throws QueryTypeNotExistException
     */
    public function generateQuery(): QueryBuilderInterface|QueryDataDestinationInterface
    {

        $this->query = $this->getQueryCollector()->getQuery();

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function select(array $columns = []): QueryBuilderInterface
    {

        $columnsPerRow = null;

        if ([] === $columns) {
            $columnsPerRow = '*';
        } else {
            foreach ($columns as $as => $column) {
                $columnsPerRow .= $this->shieldingColumnName($column);
                $columnsPerRow .= is_string($as) ? sprintf(' AS `%s`', $as) : null;
                $columnsPerRow .= ',';
            }

            $columnsPerRow = mb_substr($columnsPerRow, 0, -1);
        }

        $this->rowColumns = $columnsPerRow;

        $this->setQueryType('select');

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function customSelect(string $select): QueryBuilderInterface
    {

        $this->rowColumns = $select;

        $this->setQueryType('select');

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function distinct(bool $row = false): QueryBuilderInterface
    {

        $this->distinct = $row ? 'DISTINCTROW' : 'DISTINCT';

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function from(string $tableName, ?string $alias = null): QueryBuilderInterface
    {

        $this->from .= sprintf(' FROM %s ', $this->shieldingColumnName($tableName));
        $this->from .= null !== $alias ? sprintf('AS %s ', $alias) : null;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function where(string ...$expressions): QueryBuilderInterface
    {

        $formattedExpressions = trim(Str::trimToSymbol(implode(' ', $expressions), ' '));

        $this->where .= sprintf('WHERE %s', $formattedExpressions);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function orderBy(string|array $columns, string|array $orderIndex): QueryBuilderInterface
    {

        $columns = is_string($columns) ? [$columns] : $columns;
        $orderIndex = is_string($orderIndex) ? [$orderIndex] : $orderIndex;

        $this->order .= 'ORDER BY ';

        foreach ($columns as $index => $column) {
            $currentOrderIndex = Str::toUppercase($orderIndex[$index] ?? $orderIndex[array_key_last($orderIndex)]);

            $this->order .=  sprintf('%s %s,', $this->shieldingColumnName($column), $currentOrderIndex);
        }

        $this->order = mb_substr($this->order, 0, -1);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function limit(int $with, ?int $before = null): QueryBuilderInterface
    {

        $limit = sprintf('LIMIT %s', $with);

        if (null !== $before) {
            $limit .= sprintf('OFFSET %s', $before);
        }

        $this->limit .= $limit;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function groupBy(array $columns, bool $rollup = false): QueryBuilderInterface
    {

        $columns = array_map(fn (string $column) => $this->shieldingColumnName($column), $columns);

        $this->group = sprintf('GROUP BY %s', implode(',', $columns));

        if($rollup) {
            $this->group .= ' WITH ROLLUP';
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function having(string ...$expressions): QueryBuilderInterface
    {

        $formattedExpressions = trim(Str::trimToSymbol(implode(' ', $expressions), ' '));

        $this->having .= sprintf('HAVING %s ', $formattedExpressions);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function customHaving(string $expression): QueryBuilderInterface
    {

        $this->having .= sprintf('HAVING %s ', trim($expression));

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function innerJoin(string|array $tables, array|string $aliases = null, ?string $specification = null): QueryBuilderInterface
    {

        $this->handlerSaveJoin('inner', $tables, $aliases ?: '', $specification);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function leftJoin(string|array $tables, array|string $aliases = null, ?string $specification = null): QueryBuilderInterface
    {

        $this->handlerSaveJoin('left', $tables, $aliases ?: '', $specification);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function rightJoin(string|array $tables, array|string $aliases = null, ?string $specification = null): QueryBuilderInterface
    {

        $this->handlerSaveJoin('right', $tables, $aliases ?: '', $specification);

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function expression(): Expression
    {

        return $this->expression;

    }

    /**
     * @inheritDoc
     */
    public function joinSpecification(): JoinSpecificationsInterface
    {

        return $this->join;

    }

    /**
     * @inheritDoc
     */
    public function setParameter(string $name, string $value): QueryBuilderInterface
    {

        $this->parameters[$name] = $value;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setParameters(array $parameters): QueryBuilderInterface
    {

        foreach ($parameters as $name => $value) {
            $this->setParameter((string) $name, (string) $value);
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function insert(string $table): QueryBuilderInterface
    {

        $this->setQueryType('INSERT');

        $this->table = $table;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function insertWithSelect(string $tableOfWrite, QueryDataDestinationInterface $queryBuilder): QueryBuilderInterface
    {

        $this->insert($tableOfWrite);
        
        $this->subQuery = $queryBuilder->getQuery();
        
        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setValue(string $column, string|int|float $value): QueryBuilderInterface
    {

        $this->values[$column] = $value;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setValues(array $columnsWithValue): QueryBuilderInterface
    {

        foreach ($columnsWithValue as $key => $value) {
            $this->setValue($key, $value);
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setColumns(string ...$columns): QueryBuilderInterface
    {

        $this->columns = $columns;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function update(string $table, ?string $alias = null): QueryBuilderInterface
    {

        $this->setQueryType('UPDATE');

        $this->table = $table;

        if(null !== $alias) {
            $this->table .= sprintf(' AS %s', $alias);
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function delete(string $table, ?string $alias = null): QueryBuilderInterface
    {

        $this->setQueryType('DELETE');

        $this->table = $table;

        if(null !== $alias) {
            $this->table .= sprintf(' AS %s', $alias);
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function unionModifiers(): Union
    {

        return $this->union;

    }

    /**
     * @inheritDoc
     */
    public function union(string ...$selects): QueryBuilderInterface
    {

        $query = implode(' ', $selects);

        $this->query = Str::trimAfterSymbol(Str::trimAfterSymbol($query, ' ', false), ' ', false);

        return $this;

    }

    /**
     * @param string       $reference
     * @param string|array $tables
     * @param string|array $aliases
     * @param string|null  $specification
     *
     * @return void
     */
    private function handlerSaveJoin(string $reference, string|array $tables, string|array $aliases, ?string $specification): void
    {

        $tables = is_string($tables) ? [$tables] : $tables;
        $aliases = is_string($aliases) ? [$aliases] : $aliases;

        $this->sqlJoin .= $this->join->getAssembledJoin($reference, $tables, $aliases, empty($specification) ? '' : $specification);

    }

}