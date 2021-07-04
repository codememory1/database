<?php

namespace Codememory\Components\Database\Connectors\Drivers;

use Codememory\Components\Database\Builders\AbstractBuilder;
use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use Codememory\Components\Database\Builders\Compilers\PostgreCompiler;
use Codememory\Components\Database\Builders\PostgreBuilder;
use JetBrains\PhpStorm\Pure;
use PDO;

/**
 * Class PostgreDriver
 *
 * @package Codememory\Components\Database\Connectors\Drivers
 *
 * @author  Codememory
 */
class PostgreDriver extends AbstractDriver
{

    /**
     * @inheritDoc
     */
    public function getConnect(): PDO
    {

        return new PDO($this->getCollectedDns(), options: $this->options);

    }

    /**
     * @inheritDoc
     */
    public function getDriverName(): string
    {

        return 'pgsql';

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getSchemaCompiler(): AbstractCompiler
    {

        return new PostgreCompiler($this);

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getBuilder(): AbstractBuilder
    {

        return new PostgreBuilder($this->connection);

    }

    /**
     * @return string
     */
    private function getCollectedDns(): string
    {

        $connectionData = $this->connection->getConnectionData();

        return sprintf(
            '%s:host=%s;port=%s;dbname=%s;user=%s;password=%s;',
            $this->getDriverName(),
            $connectionData->getHost(),
            $connectionData->getPort(),
            $connectionData->getDbname(),
            $connectionData->getUsername(),
            $connectionData->getPassword(),
        );

    }

}