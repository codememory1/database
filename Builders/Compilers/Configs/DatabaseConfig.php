<?php

namespace Codememory\Components\Database\Builders\Compilers\Configs;

/**
 * Class DatabaseConfig
 *
 * @package Codememory\Components\Database\Builders\Compilers\Configs
 *
 * @author  Codememory
 */
final class DatabaseConfig
{

    /**
     * @var string|null
     */
    private ?string $charsetName = null;

    /**
     * @var string|null
     */
    private ?string $collationName = null;

    /**
     * @param string $charsetName
     *
     * @return $this
     */
    public function setCharacter(string $charsetName): DatabaseConfig
    {

        $this->charsetName = $charsetName;

        return $this;

    }

    /**
     * @param string $collationName
     *
     * @return $this
     */
    public function setCollate(string $collationName): DatabaseConfig
    {

        $this->collationName = $collationName;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCharsetName(): ?string
    {

        return $this->charsetName;

    }

    /**
     * @return string|null
     */
    public function getCollationName(): ?string
    {

        return $this->collationName;

    }


}