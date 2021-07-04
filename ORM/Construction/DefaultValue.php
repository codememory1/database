<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class DefaultValue
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class DefaultValue
{

    /**
     * DefaultValue constructor.
     *
     * @param int|string $defaultValue
     */
    public function __construct(
        private int|string $defaultValue
    )
    {
    }

    /**
     * @return int|string
     */
    public function getDefaultValue(): int|string
    {

        return $this->defaultValue;

    }

}