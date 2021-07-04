<?php

namespace Codememory\Components\Database\Connectors;

use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use Codememory\Components\Database\Interfaces\DriverInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class ConnectionConfiguration
 *
 * @package Codememory\Components\Database\Connectors
 *
 * @author  Codememory
 */
class ConnectionConfiguration implements ConnectionConfigurationInterface
{

    /**
     * @var DriverInterface|null
     */
    private ?DriverInterface $driver = null;

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
    public function setDriver(DriverInterface $driver): ConnectionConfigurationInterface
    {

        $this->driver = $driver;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setHost(string $host): ConnectionConfigurationInterface
    {

        $this->host = $host;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setPort(int $port): ConnectionConfigurationInterface
    {

        $this->port = $port;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setDbname(?string $dbname): ConnectionConfigurationInterface
    {

        $this->dbname = $dbname;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setUsername(string $username): ConnectionConfigurationInterface
    {

        $this->username = $username;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setPassword(string $password): ConnectionConfigurationInterface
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function setCharset(string $charset): ConnectionConfigurationInterface
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