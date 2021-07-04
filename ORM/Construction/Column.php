<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class Column
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Column
{

    /**
     * Column constructor.
     *
     * @param string   $name
     * @param string   $type
     * @param int|null $length
     * @param bool     $nullable
     * @param string   $charset
     */
    public function __construct(
        private string $name,
        private string $type,
        private ?int $length = null,
        private bool $nullable = false,
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
    public function getType(): string
    {

        return $this->type;

    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {

        return $this->length;

    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {

        return $this->nullable;

    }

    /**
     * @return string
     */
    public function getCharset(): string
    {

        return $this->charset;

    }

}