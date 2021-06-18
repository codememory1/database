<?php

namespace Codememory\Components\Database\Connectors;

use Codememory\Components\Database\Connectors\Drivers\AbstractDriver;
use Codememory\Components\Database\Interfaces\ConnectionDataInterface;
use Codememory\Components\Database\Interfaces\DriverInterface;
use Codememory\Components\Database\Interfaces\DriverNotImplementedInterfaceException;
use ReflectionClass;
use ReflectionException;

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
     * @var string
     */
    private string $driver;

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
     * @param string      $namespaceDriver
     * @param string|null $host
     * @param int|null    $port
     * @param string|null $dbname
     * @param string|null $username
     * @param string|null $password
     * @param string|null $charset
     */
    public function __construct(string $namespaceDriver, ?string $host, ?int $port, ?string $dbname, ?string $username, ?string $password, ?string $charset)
    {

        $this->driver = $namespaceDriver;
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;

    }

    /**
     * @inheritDoc
     * @throws DriverNotImplementedInterfaceException
     * @throws ReflectionException
     */
    public function getDriver(): AbstractDriver
    {

        $reflection = new ReflectionClass($this->driver);

        if (false === $reflection->implementsInterface(DriverInterface::class)) {
            throw new DriverNotImplementedInterfaceException($this->driver, DriverInterface::class);
        }

        return new $this->driver($this);

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