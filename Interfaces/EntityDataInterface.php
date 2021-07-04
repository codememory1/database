<?php

namespace Codememory\Components\Database\Interfaces;

/**
 * Interface EntityDataInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface EntityDataInterface
{

    /**
     * @return string|null
     */
    public function getNamespaceRepository(): ?string;

    /**
     * @return string|null
     */
    public function getTableName(): ?string;

    /**
     * @return array
     */
    public function getColumns(): array;

}