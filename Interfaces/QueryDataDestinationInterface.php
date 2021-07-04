<?php

namespace Codememory\Components\Database\Interfaces;

/**
 * interface QueryDataDestinationInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface QueryDataDestinationInterface
{

    /**
     * @return string|null
     */
    public function getQueryType(): ?string;

    /**
     * @return string|null
     */
    public function getRowColumns(): ?string;

    /**
     * @return string|null
     */
    public function getDistinct(): ?string;

    /**
     * @return string|null
     */
    public function getFrom(): ?string;

    /**
     * @return string|null
     */
    public function getWhere(): ?string;

    /**
     * @return string|null
     */
    public function getOrder(): ?string;

    /**
     * @return string|null
     */
    public function getLimit(): ?string;

    /**
     * @return string|null
     */
    public function getGroup(): ?string;

    /**
     * @return string|null
     */
    public function getHaving(): ?string;

    /**
     * @return string|null
     */
    public function getSqlJoin(): ?string;

    /**
     * @return array
     */
    public function getValues(): array;

    /**
     * @return array
     */
    public function getColumns(): array;

    /**
     * @return array
     */
    public function getTable(): array;

    /**
     * @return string|null
     */
    public function getSubQuery(): ?string;

    /**
     * @return string|null
     */
    public function getQuery(): ?string;

}