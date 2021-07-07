<?php

namespace Codememory\Components\Database\QueryBuilder\Expressions\Traits;

/**
 * Trait QueryTypeMethodsTrait
 *
 * @package Codememory\Components\Database\QueryBuilder\Expressions\Traits
 *
 * @author  Codememory
 */
trait QueryTypeMethodsTrait
{

    use ShieldingTrait;

    /**
     * @return string
     */
    private function select(): string
    {

        $queryDataDestination = $this->queryDataDestination;

        return $this->formatting(
            'SELECT',
            $this->queryDataDestination->getDistinct(),
            $queryDataDestination->getRowColumns(),
            $queryDataDestination->getFrom(),
            $queryDataDestination->getSqlJoin(),
            $queryDataDestination->getWhere(),
            $queryDataDestination->getGroup(),
            $queryDataDestination->getHaving(),
            $queryDataDestination->getOrder(),
            $queryDataDestination->getLimit()
        );

    }

    /**
     * @return string|null
     */
    private function insert(): ?string
    {

        $queryDataDestination = $this->queryDataDestination;
        $rowColumns = implode(',', array_map(function (string $column) {

            return $this->shieldingColumnName($column);
        }, $queryDataDestination->getColumns()));
        $values = null;

        if ([] !== $queryDataDestination->getValues()) {
            foreach ($queryDataDestination->getValues() as $key => $value) {
                $rowColumns .= sprintf('%s,', $this->shieldingColumnName($key));
                $values .= sprintf('%s,', $this->shieldingValue($value));
            }

            $rowColumns = mb_substr($rowColumns, 0, -1);
            $values = mb_substr($values, 0, -1);
        }

        return $this->formatting(
            'INSERT INTO',
            $this->shieldingColumnName($queryDataDestination->getTable()['name']),
            sprintf('(%s)', $rowColumns),
            null !== $values ? sprintf('VALUES (%s)', $values) : null,
            $queryDataDestination->getSubQuery()
        );

    }

    /**
     * @return string|null
     */
    private function update(): ?string
    {

        $queryDataDestination = $this->queryDataDestination;
        $assignment = null;

        foreach ($queryDataDestination->getValues() as $key => $value) {
            $assignment .= sprintf('%s = %s,', $this->shieldingColumnName($key), $this->shieldingValue($value));
        }

        return $this->formatting(
            'UPDATE',
            $this->getSqlFormatTableName($queryDataDestination->getTable()['name']),
            $queryDataDestination->getSqlJoin(),
            'SET',
            mb_substr($assignment, 0, -1),
            $queryDataDestination->getWhere(),
            $queryDataDestination->getOrder(),
            $queryDataDestination->getLimit()
        );

    }

    /**
     * @return string|null
     */
    private function delete(): ?string
    {

        $queryDataDestination = $this->queryDataDestination;

        return $this->formatting(
            sprintf('DELETE %s', $this->shieldingColumnName($queryDataDestination->getTable()['name'])),
            sprintf('FROM %s', $this->getSqlFormatTableName($queryDataDestination->getTable())),
            $queryDataDestination->getSqlJoin(),
            $queryDataDestination->getWhere(),
            $queryDataDestination->getOrder(),
            $queryDataDestination->getLimit()
        );

    }

    /**
     * @param array $tableData
     *
     * @return string
     */
    private function getSqlFormatTableName(array $tableData): string
    {

        if (null === $tableData['alias']) {
            return $this->shieldingColumnName($tableData['name']);
        }

        return sprintf('%s AS %s', $this->shieldingColumnName($tableData['name']), $tableData['alias']);

    }

}