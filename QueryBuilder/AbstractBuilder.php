<?php

namespace Codememory\Components\Database\QueryBuilder;

use Codememory\Components\Database\Interfaces\ConnectionInterface;
use Codememory\Components\Database\Interfaces\QueryDataDestinationInterface;
use Codememory\Components\Database\ORM\EntityHelper;
use Codememory\Components\Database\QueryBuilder\Expressions\Expression;
use Codememory\Components\Database\QueryBuilder\Expressions\Join;
use Codememory\Components\Database\QueryBuilder\Expressions\Union;
use Codememory\Support\ConvertType;
use Codememory\Support\Str;
use JetBrains\PhpStorm\Pure;

/**
 * Class AbstractBuilder
 *
 * @package Codememory\Components\Database\QueryBuilder
 *
 * @author  Codememory
 */
abstract class AbstractBuilder implements QueryDataDestinationInterface
{

    /**
     * @var ConnectionInterface
     */
    protected ConnectionInterface $connection;

    /**
     * @var Expression
     */
    protected Expression $expression;

    /**
     * @var Join
     */
    protected Join $join;

    /**
     * @var Union
     */
    protected Union $union;

    /**
     * @var ConvertType
     */
    protected ConvertType $convertType;

    /**
     * @var Query
     */
    protected Query $queryExecutor;

    /**
     * @var string|null
     */
    private ?string $queryType = null;

    /**
     * QueryBuilder constructor.
     *
     * @param ConnectionInterface $connection
     */
    #[Pure]
    public function __construct(ConnectionInterface $connection)
    {

        $this->connection = $connection;
        $this->expression = new Expression();
        $this->join = new Join();
        $this->union = new Union();
        $this->convertType = new ConvertType();
        $this->queryExecutor = new Query($this->connection);

    }

    /**
     * @inheritDoc
     */
    public function getQueryType(): ?string
    {

        return $this->queryType;

    }

    /**
     * @inheritDoc
     */
    public function getRowColumns(): ?string
    {

        return $this->rowColumns;

    }

    /**
     * @inheritDoc
     */
    public function getDistinct(): ?string
    {

        return $this->distinct;

    }

    /**
     * @inheritDoc
     */
    public function getFrom(): ?string
    {

        return $this->from;

    }

    /**
     * @inheritDoc
     */
    public function getWhere(): ?string
    {

        return $this->where;

    }

    /**
     * @inheritDoc
     */
    public function getOrder(): ?string
    {

        return $this->order;

    }

    /**
     * @inheritDoc
     */
    public function getLimit(): ?string
    {

        return $this->limit;

    }

    /**
     * @inheritDoc
     */
    public function getGroup(): ?string
    {

        return $this->group;

    }

    /**
     * @inheritDoc
     */
    public function getHaving(): ?string
    {

        return $this->having;

    }

    /**
     * @inheritDoc
     */
    public function getSqlJoin(): ?string
    {

        return $this->sqlJoin;

    }

    /**
     * @inheritDoc
     */
    public function getValues(): array
    {

        return $this->values;

    }

    /**
     * @inheritDoc
     */
    public function getColumns(): array
    {

        return $this->columns;

    }

    /**
     * @inheritDoc
     */
    public function getTable(): array
    {

        if(preg_match('/(?<name>[^\s]+)\sAS\s(?<alias>[^`]+)/', $this->table, $match)) {
            return $match;
        }

        return [
            'name'  => $this->table,
            'alias' => null
        ];

    }

    /**
     * @inheritDoc
     */
    public function getSubQuery(): ?string
    {

        return $this->subQuery;

    }

    /**
     * @inheritDoc
     */
    public function getQuery(): ?string
    {

        return trim($this->query);

    }

    /**
     * @return QueryCollector
     */
    #[Pure]
    protected function getQueryCollector(): QueryCollector
    {

        return new QueryCollector($this);

    }

    /**
     * @param string $type
     *
     * @return void
     */
    protected function setQueryType(string $type): void
    {

        $this->queryType = Str::toUppercase($type);

    }

}