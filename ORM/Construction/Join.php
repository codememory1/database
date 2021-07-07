<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class Join
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Join
{

    /**
     * Join constructor.
     *
     * @param string $entity
     * @param array  $columns
     */
    public function __construct(
        private string $entity,
        private array $columns
    )
    {
    }

}