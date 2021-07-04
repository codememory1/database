<?php

namespace Codememory\Components\Database\Connectors\Drivers;

use Codememory\Components\Database\Builders\AbstractBuilder;
use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use Codememory\Components\Database\Builders\Compilers\SqlServerCompiler;
use Codememory\Components\Database\Builders\SqlServerBuilder;
use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use JetBrains\PhpStorm\Pure;
use PDO;

/**
 * Class SqlServerDriver
 *
 * @package Codememory\Components\Database\Connectors\Drivers
 *
 * @author  Codememory
 */
class SqlServerDriver extends AbstractDriver
{

    /**
     * @inheritDoc
     */
    public function getConnect(): PDO
    {

        $connectionData = $this->connection->getConnectionData();

        return new PDO(
            $this->getCollectedDNS($connectionData),
            $connectionData->getUsername(),
            $connectionData->getPassword(),
            $this->options
        );

    }

    /**
     * @inheritDoc
     */
    public function getDriverName(): string
    {

        return 'sqlsrv';

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getSchemaCompiler(): AbstractCompiler
    {

        return new SqlServerCompiler($this);

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getBuilder(): AbstractBuilder
    {

        return new SqlServerBuilder($this->connection);

    }

    /**
     * @param ConnectionDataInterface $connectionData
     *
     * @return string
     */
    private function getCollectedDNS(ConnectionDataInterface $connectionData): string
    {

        $server = $connectionData->getHost();

        if (null !== $connectionData->getPort()) {
            $server .= sprintf(',%s', $connectionData->getPort());
        }

        return sprintf('%s:Server=%s;Database=%s;', $this->getDriverName(), $server, $connectionData->getDbname());

    }

}