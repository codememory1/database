<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class Table
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Table
{

    /**
     * Table constructor.
     *
     * @param string $name
     * @param string $charset
     */
    public function __construct(
        private string $name,
        private string $charset = 'utf8_general_ci'
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {

        return $this->name;

    }

    /**
     * @return string
     */
    public function getCharset(): string
    {

        return $this->charset;

    }

}