<?php

namespace Codememory\Components\Database\Builders\Compilers;

use Codememory\Components\Database\Builders\Compilers\Configs\DatabaseConfig;
use Codememory\Components\Database\Builders\Compilers\Configs\TableConfig;
use Codememory\Components\Database\Interfaces\DriverInterface;
use LogicException;

/**
 * Class AbstractCompiler
 *
 * @package Codememory\Components\Database\Builders\Compilers
 *
 * @author  Codememory
 */
abstract class AbstractCompiler
{

    /**
     * @var DriverInterface
     */
    private DriverInterface $driver;

    /**
     * AbstractCompiler constructor.
     *
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {

        $this->driver = $driver;

    }

    /**
     * @param string              $dbname
     * @param DatabaseConfig|null $config
     *
     * @return string
     */
    public function compileCreateDatabase(string $dbname, ?DatabaseConfig $config = null): string
    {

        throw new LogicException(sprintf('The %s driver does not support creating databases', $this->driver->getDriverName()));

    }

    /**
     * @param string $dbname
     *
     * @return string
     */
    public function compileDropDatabase(string $dbname): string
    {

        throw new LogicException(sprintf('The %s driver does not support dropping a database', $this->driver->getDriverName()));

    }

    /**
     * @param string           $tableName
     * @param TableConfig|null $config
     *
     * @return string
     */
    public function compileCreateTable(string $tableName, ?TableConfig $config = null): string
    {

        throw new LogicException(sprintf('The %s driver does not support creating tables', $this->driver->getDriverName()));

    }

    /**
     * @param string $tableName
     *
     * @return string
     */
    public function compileDropTable(string $tableName): string
    {

        throw new LogicException(sprintf('The %s driver does not support dropping tables', $this->driver->getDriverName()));

    }

    /**
     * @param string $sql
     *
     * @return string
     */
    protected function returnSql(string $sql): string
    {

        $sql = trim($sql);

        return preg_replace('/\s{2,}/', ' ', $sql);

    }

}