<?php

namespace Codememory\Components\Database\Connectors\Drivers;

use Codememory\Components\Database\Builders\AbstractBuilder;
use Codememory\Components\Database\Builders\Compilers\AbstractCompiler;
use Codememory\Components\Database\Builders\Compilers\MysqlCompiler;
use Codememory\Components\Database\Builders\MysqlBuilder;
use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use JetBrains\PhpStorm\Pure;
use PDO;

/**
 * Class MysqlDriver
 *
 * @package Codememory\Components\Database\Connectors\Drivers
 *
 * @author  Codememory
 */
class MysqlDriver extends AbstractDriver
{

    /**
     * @inheritDoc
     */
    public function getConnect(): PDO
    {

        $connectionData = $this->connection->getConnectionData();

        return new PDO(
            $this->getCollectedDns($connectionData),
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

        return 'mysql';

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getSchemaCompiler(): AbstractCompiler
    {

        return new MysqlCompiler($this);

    }

    /**
     * @inheritDoc
     */
    public function getBuilder(): AbstractBuilder
    {

        return new MysqlBuilder($this->connection);

    }

    /**
     * @param ConnectionDataInterface $connectionData
     *
     * @return string
     */
    private function getCollectedDns(ConnectionDataInterface $connectionData): string
    {

        $dnsInString = null;
        $dnsInArray = [
            'host'    => $connectionData->getHost(),
            'port'    => $connectionData->getPort(),
            'dbname'  => $connectionData->getDbname(),
            'charset' => $connectionData->getCharset()
        ];

        foreach ($dnsInArray as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $dnsInString .= sprintf('%s=%s;', $key, $value);
        }

        return $this->getDriverName() . ':' . $dnsInString;

    }

}