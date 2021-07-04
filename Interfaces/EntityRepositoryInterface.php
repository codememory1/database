<?php

namespace Codememory\Components\Database\Interfaces;

/**
 * interface EntityRepositoryInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface EntityRepositoryInterface
{

    /**
     * @return QueryBuilderInterface
     */
    public function createQueryBuilder(): QueryBuilderInterface;

}