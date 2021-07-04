<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class Entity
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Entity
{

    /**
     * Entity constructor.
     *
     * @param string $repository
     */
    public function __construct(
        private string $repository
    )
    {
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {

        return $this->repository;

    }

}