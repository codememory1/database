<?php

namespace Codememory\Components\Database\Builders;

use Codememory\Components\Database\Builders\Compilers\Configs\DatabaseConfig;
use Codememory\Components\Database\Connectors2\Connector;
use Codememory\FileSystem\File;

/**
 * Class SqliteBuilder
 *
 * @package Codememory\Components\Database\Builders
 *
 * @author  Codememory
 */
class SqliteBuilder extends AbstractBuilder
{

    /**
     * @var File
     */
    private File $filesystem;

    /**
     * @inheritDoc
     */
    public function __construct(Connector $connector, string $connectionName)
    {

        $this->filesystem = new File();

        parent::__construct($connector, $connectionName);

    }

    /**
     * @inheritDoc
     */
    public function createDatabase(string $dbname, ?DatabaseConfig $config = null): AbstractBuilder
    {

        if(!$this->filesystem->exist($dbname)) {
            file_put_contents($this->filesystem->getRealPath($dbname), null);
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function dropDatabase(string $dbname): AbstractBuilder
    {

        if(':memory:' === $dbname) {
            file_put_contents($dbname, null);
        } else if($this->filesystem->exist($dbname)) {
            $this->filesystem->remove($dbname);
        }

        return $this;

    }

}