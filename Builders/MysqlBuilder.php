<?php

namespace Codememory\Components\Database\Builders;

use Codememory\Components\Database\Builders\Compilers\Configs\DatabaseConfig;
use Codememory\Components\Database\Builders\Compilers\Configs\TableConfig;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use PDO;

/**
 * Class MysqlBuilder
 *
 * @package Codememory\Components\Database\Builders
 *
 * @author  Codememory
 */
class MysqlBuilder extends AbstractBuilder
{

    /**
     * @var array
     */
    private array $databases;

    /**
     * @var array
     */
    private array $tables = [];

    /**
     * @inheritDoc
     */
    public function __construct(ConnectionInterface $connection)
    {

        parent::__construct($connection);

        $this->databases = $this->connected->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN);

        if($connection->isFullConnection()) {
            $this->tables = $this->connected->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        }

    }

    /**
     * @inheritDoc
     */
    public function createDatabase(string $dbname, ?DatabaseConfig $config = null): AbstractBuilder
    {

        $this->connected->exec($this->compiler->compileCreateDatabase($dbname, $config));

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function dropDatabase(string $dbname): AbstractBuilder
    {

        $this->connected->exec($this->compiler->compileDropDatabase($dbname));

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function createTable(string $tableName, ?TableConfig $config = null): AbstractBuilder
    {

        $this->connected->exec($this->compiler->compileCreateTable($tableName, $config));

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function dropTable(string $tableName): AbstractBuilder
    {

        $this->connected->exec($this->compiler->compileDropTable($tableName));

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function databaseExist(string $dbname): bool
    {

        return in_array($dbname, $this->databases);

    }

    /**
     * @inheritDoc
     */
    public function tableExist(string $tableName): bool
    {

        return in_array($tableName, $this->tables);

    }

}