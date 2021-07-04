<?php

namespace Codememory\Components\Database\Connectors;

use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use Codememory\Components\Database\Interfaces\DriverInterface;

/**
 * Class ConnectionData
 *
 * @package Codememory\Components\Database\Connectors
 *
 * @author  Codememory
 */
class ConnectionData implements ConnectionDataInterface
{

    /**
     * @var DriverInterface
     */
    private DriverInterface $driver;

    /**
     * @var string|null
     */
    private ?string $host;

    /**
     * @var int|null
     */
    private ?int $port;

    /**
     * @var string|null
     */
    private ?string $dbname;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var string|null
     */
    private ?string $password;

    /**
     * @var string|null
     */
    private ?string $charset;

    /**
     * ConnectionData constructor.
     *
     * @param DriverInterface $driver
     * @param string|null     $host
     * @param int|null        $port
     * @param string|null     $dbname
     * @param string|null     $username
     * @param string|null     $password
     * @param string|null     $charset
     */
    public function __construct(DriverInterface $driver, ?string $host, ?int $port, ?string $dbname, ?string $username, ?string $password, ?string $charset)
    {

        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;

    }

    /**
     * @inheritDoc
     */
    public function getDriver(): DriverInterface
    {

        return $this->driver;

    }

    /**
     * @inheritDoc
     */
    public function getHost(): ?string
    {

        return $this->host;

    }

    /**
     * @inheritDoc
     */
    public function getPort(): ?int
    {

        return $this->port;

    }

    /**
     * @inheritDoc
     */
    public function getDbname(): ?string
    {

        return $this->dbname;

    }

    /**
     * @inheritDoc
     */
    public function getUsername(): ?string
    {

        return $this->username;

    }

    /**
     * @inheritDoc
     */
    public function getPassword(): ?string
    {

        return $this->password;

    }

    /**
     * @inheritDoc
     */
    public function getCharset(): ?string
    {

        return $this->charset;

    }

}