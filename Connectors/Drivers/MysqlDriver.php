<?php

namespace Codememory\Components\Database\Connectors\Drivers;

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

        return new PDO($this->getCollectedDns(), $this->connectionData->getUsername(), $this->connectionData->getPassword());

    }

    /**
     * @inheritDoc
     */
    public function getDriverName(): string
    {

        return 'mysql';

    }

    /**
     * @return string
     */
    private function getCollectedDns(): string
    {

        $dnsInString = null;
        $dnsInArray = [
            'host'    => $this->connectionData->getHost(),
            'port'    => $this->connectionData->getPort(),
            'dbname'  => $this->connectionData->getDbname(),
            'charset' => $this->connectionData->getCharset()
        ];

        foreach ($dnsInArray as $key => $value) {
            if (null === $value) {
                continue;
            }

            $dnsInString .= sprintf('%s=%s;', $key, $value);
        }

        return $this->getDriverName() . ':' . $dnsInString;

    }

}