<?php

namespace Codememory\Components\Database\Commands;

use Codememory\Components\Console\Command;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 *
 * @package Codememory\Components\Database\Commands
 *
 * @author  Codememory
 */
abstract class AbstractCommand extends Command
{

    /**
     * @var ConnectionInterface
     */
    protected ConnectionInterface $connection;

    /**
     * AbstractCommand constructor.
     *
     * @param ConnectionInterface $connection
     * @param string|null         $name
     */
    public function __construct(ConnectionInterface $connection, ?string $name = null)
    {

        $this->connection = $connection;

        parent::__construct($name);

    }

    /**
     * @inheritDoc
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        $this->throwConnectionError($this->connection);

        return Command::SUCCESS;

    }

    /**
     * @param callable $callback
     *
     * @return ConnectionInterface
     */
    protected function reconnect(callable $callback): ConnectionInterface
    {

        $reconnect = $this->connection->reconnect($callback);

        $this->throwConnectionError($reconnect);

        return $reconnect;

    }

    /**
     * @param ConnectionInterface $connection
     *
     * @return void
     */
    protected function throwConnectionError(ConnectionInterface $connection): void
    {

        if (!$connection->isConnection()) {
            throw new RuntimeException('Incorrect database connection, check the correctness of the data in the connection configuration');
        }

    }

}