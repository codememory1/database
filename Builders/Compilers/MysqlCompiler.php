<?php

namespace Codememory\Components\Database\Builders\Compilers;

use Codememory\Components\Database\Builders\Compilers\Configs\DatabaseConfig;
use Codememory\Components\Database\Builders\Compilers\Configs\TableConfig;
use Codememory\Support\Str;

/**
 * Class MysqlCompiler
 *
 * @package Codememory\Components\Database\Builders\Compilers
 *
 * @author  Codemmeory
 */
class MysqlCompiler extends AbstractCompiler
{

    /**
     * @inheritDoc
     */
    public function compileCreateDatabase(string $dbname, ?DatabaseConfig $config = null): string
    {

        $character = null !== $config?->getCharsetName() ? "DEFAULT CHARACTER {$config->getCharsetName()}" : null;
        $collation = null !== $config?->getCollationName() ? "DEFAULT COLLATE {$config->getCollationName()}" : null;

        return $this->returnSql("CREATE DATABASE IF NOT EXISTS `$dbname` $character $collation");

    }

    /**
     * @inheritDoc
     */
    public function compileDropDatabase(string $dbname): string
    {

        return "DROP DATABASE IF EXISTS `$dbname`";

    }

    /**
     * @inheritDoc
     */
    public function compileCreateTable(string $tableName, ?TableConfig $config = null): string
    {

        $definition = null;
        $tableCollation = null !== $config?->getCharset() ? "DEFAULT COLLATE {$config->getCharset()}" : null;

        if (null !== $config) {
            $definition .= '(%s)';
            $columns = [];

            foreach ($config->getColumns() as $column) {
                $name = $column['name'];
                $type = sprintf('%s', Str::toUppercase($column['type']));
                $type .= null !== $column['length'] ? "({$column['length']})" : null;
                $ai = null;
                $nullable = $column['nullable'] ? 'NULL' : 'NOT NULL';
                $default = null !== $column['default'] ? sprintf('DEFAULT \'%s\'', $column['default']) : null;
                $collation = null !== $column['collation'] ? "COLLATE {$column['collation']}" : null;

                if ($column['ai']) {
                    $ai = 'PRIMARY KEY AUTO_INCREMENT';
                }

                $columns[] = $this->returnSql(sprintf('`%s` %s %s %s %s %s', $name, $type, $ai, $nullable, $default, $collation));
            }

            $definition = sprintf($definition, implode(',', $columns));
        }

        $engine = null !== $config?->getEngine() ? "ENGINE `{$config->getEngine()}`" : null;

        return $this->returnSql("CREATE TABLE IF NOT EXISTS `$tableName` $definition {$engine} $tableCollation");

    }

    /**
     * @inheritDoc
     */
    public function compileDropTable(string $tableName): string
    {

        return "DROP TABLE IF EXISTS `$tableName`";

    }

}