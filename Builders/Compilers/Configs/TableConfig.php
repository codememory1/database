<?php

namespace Codememory\Components\Database\Builders\Compilers\Configs;

/**
 * Class TableConfig
 *
 * @package Codememory\Components\Database\Builders\Compilers\Configs
 *
 * @author  Codememory
 */
class TableConfig
{

    /**
     * @var array
     */
    private array $columns = [];

    /**
     * @var string
     */
    private string $engine = 'innoDB';

    /**
     * @var string|null
     */
    private ?string $charset = null;

    /**
     * @param string      $name
     * @param string      $type
     * @param int|null    $length
     * @param bool        $ai
     * @param bool        $nullable
     * @param string|null $default
     * @param string|null $collation
     *
     * @return TableConfig
     */
    public function addColumn(string $name, string $type, ?int $length = null, bool $ai = false, bool $nullable = false, ?string $default = null, ?string $collation = null): TableConfig
    {

        $this->columns[] = compact('name', 'type', 'length', 'ai', 'nullable', 'default', 'collation');

        return $this;

    }

    /**
     * @return array
     */
    public function getColumns(): array
    {

        return $this->columns;

    }

    /**
     * @param string $engine
     *
     * @return TableConfig
     */
    public function setEngine(string $engine): TableConfig
    {

        $this->engine = $engine;

        return $this;

    }

    /**
     * @return string
     */
    public function getEngine(): string
    {

        return $this->engine;

    }

    /**
     * @param string $charset
     *
     * @return TableConfig
     */
    public function setCharset(string $charset): TableConfig
    {

        $this->charset = $charset;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCharset(): ?string
    {

        return $this->charset;

    }

}