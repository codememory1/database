<?php

namespace Codememory\Components\Database\Connectors\Drivers;

use LogicException;
use PDO;

/**
 * Class SqliteDriver
 *
 * @package Codememory\Components\Database\Connectors\Drivers
 *
 * @author  Codememory
 */
class SqliteDriver extends AbstractDriver
{

    /**
     * @var bool
     */
    private bool $tmp = false;

    /**
     * @var bool
     */
    private bool $toMemory = false;

    /**
     * @inheritDoc
     */
    public function getConnect(): PDO
    {

        return new PDO($this->getCollectedDns());

    }

    /**
     * @inheritDoc
     */
    public function getDriverName(): string
    {

        return 'sqlite';

    }

    /**
     * @param bool $allow
     *
     * @return $this
     */
    public function tmpDatabase(bool $allow = true): SqliteDriver
    {

        $this->tmp = $allow;

        return $this;

    }

    /**
     * @param bool $allow
     *
     * @return $this
     */
    public function databaseToMemory(bool $allow = true): SqliteDriver
    {

        $this->toMemory = $allow;

        return $this;

    }

    /**
     * @return string
     */
    private function getCollectedDns(): string
    {

        if ($this->tmp && $this->toMemory) {
            throw new LogicException('Can\'t specify two parameters to create SQLite database');
        }

        return match (true) {
            $this->tmp      => sprintf('%s:', $this->getDriverName()),
            $this->toMemory => sprintf('%s:%s', $this->getDriverName(), ':memory:'),
            default         => sprintf('%s:%s', $this->getDriverName(), $this->connectionData->getDbname()),
        };

    }

}