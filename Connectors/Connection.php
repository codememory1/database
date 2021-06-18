<?php

namespace Codememory\Components\Database\Connectors;

use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class Connection
 *
 * @package Codememory\Components\Database\Connectors
 *
 * @author  Codememory
 */
class Connection implements ConnectionInterface
{

    /**
     * @var ?string
     */
    private ?string $driver = null;

    /**
     * @var string|null
     */
    private ?string $host = null;

    /**
     * @var int|null
     */
    private ?int $port = null;

    /**
     * @var string|null
     */
    private ?string $dbname = null;

    /**
     * @var string|null
     */
    private ?string $username = null;

    /**
     * @var string|null
     */
    private ?string $password = null;

    /**
     * @var string|null
     */
    private ?string $charset = null;

    /**
     * @inheritDoc
     */
    public function setDriver(string $namespaceDriver): ConnectionInterface
    {

        $this->driver = $namespaceDriver;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setHost(string $host): ConnectionInterface
    {

        $this->host = $host;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setPort(int $port): ConnectionInterface
    {

        $this->port = $port;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setDbname(string $dbname): ConnectionInterface
    {

        $this->dbname = $dbname;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setUsername(string $username): ConnectionInterface
    {

        $this->username = $username;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setPassword(string $password): ConnectionInterface
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setCharset(string $charset): ConnectionInterface
    {

        $this->charset = $charset;

        return $this;

    }

    /**
     * @return ConnectionDataInterface
     */
    #[Pure]
    public function getConnectionData(): ConnectionDataInterface
    {

        return new ConnectionData(
            $this->driver,
            $this->host,
            $this->port,
            $this->dbname,
            $this->username,
            $this->password,
            $this->charset
        );

    }

}