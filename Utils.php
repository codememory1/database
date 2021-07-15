<?php

namespace Codememory\Components\Database;

use Codememory\Components\Configuration\Config;
use Codememory\Components\Configuration\Exceptions\ConfigNotFoundException;
use Codememory\Components\Configuration\Interfaces\ConfigInterface;
use Codememory\Components\Environment\Exceptions\EnvironmentVariableNotFoundException;
use Codememory\Components\Environment\Exceptions\IncorrectPathToEnviException;
use Codememory\Components\Environment\Exceptions\ParsingErrorException;
use Codememory\Components\Environment\Exceptions\VariableParsingErrorException;
use Codememory\Components\GlobalConfig\GlobalConfig;
use Codememory\FileSystem\File;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class Utils
 *
 * @package Codememory\Components\Database
 *
 * @author  Codememory
 */
class Utils
{

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Utils constructor.
     *
     * @throws ConfigNotFoundException
     * @throws EnvironmentVariableNotFoundException
     * @throws IncorrectPathToEnviException
     * @throws ParsingErrorException
     * @throws VariableParsingErrorException
     */
    public function __construct()
    {

        $config = new Config(new File());

        $this->config = $config->open(GlobalConfig::get('database.configName'));

    }

    /**
     * @return array
     */
    public function getConnections(): array
    {

        return $this->config->get('connections') ?: [];

    }

    /**
     * @param string $connectionName
     *
     * @return array
     */
    #[ArrayShape([
        'host'     => "\mixed|string",
        'port'     => "\mixed|null",
        'dbname'   => "\mixed|null",
        'username' => "\mixed|null",
        'password' => "\mixed|null",
        'charset'  => "mixed|null"
    ])]
    public function getDataConnection(string $connectionName): array
    {

        if ($this->existConnection($connectionName)) {
            return $this->structureConnection($this->getConnections()[$connectionName]);
        }

        return $this->structureConnection([]);

    }

    /**
     * @param string $connectionName
     *
     * @return bool
     */
    public function existConnection(string $connectionName): bool
    {

        return array_key_exists($connectionName, $this->getConnections());

    }

    /**
     * @param array $connection
     *
     * @return array
     */
    #[ArrayShape([
        'host'     => "mixed|string",
        'port'     => "mixed|null",
        'dbname'   => "mixed|null",
        'username' => "mixed|null",
        'password' => "mixed|null",
        'charset'  => "mixed|null"
    ])]
    private function structureConnection(array $connection): array
    {

        return [
            'host'     => $connection['host'] ?? 'localhost',
            'port'     => $connection['port'] ?? null,
            'dbname'   => $connection['dbname'] ?? null,
            'username' => $connection['username'] ?? null,
            'password' => $connection['password'] ?? null,
            'charset'  => $connection['charset'] ?? null
        ];

    }

}