<?php

namespace Codememory\Components\Database\Commands;

use Codememory\Components\Console\Command;
use Codememory\Components\Database\Builders\Compilers\Configs\DatabaseConfig;
use Codememory\Components\Database\Interfaces\ConnectionConfigurationInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateDatabaseCommand
 *
 * @package Codememory\Components\Database\Commands
 *
 * @author  Codememory
 */
class CreateDatabaseCommand extends AbstractCommand
{

    /**
     * @inheritdoc
     */
    protected ?string $command = 'db:create-db';

    /**
     * @inheritdoc
     */
    protected ?string $description = 'Create database if it doesn\'t exist';

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        $reconnect = $this->reconnect(function (ConnectionConfigurationInterface $connectionConfiguration) {
            return $connectionConfiguration->setDbname(null);
        });

        $this->throwConnectionError($reconnect);

        $builder = $reconnect->getBuilder();

        $databaseConfig = new DatabaseConfig();
        $firstConnectionData = $this->connection->getConnectionData();

        if (null !== $firstConnectionData->getCharset()) {
            $databaseConfig->setCollate($firstConnectionData->getCharset());
        }

        if ($builder->databaseExist($firstConnectionData->getDbname())) {
            $this->io->error(sprintf('The %s database has already been created - creation is not possible', $firstConnectionData->getDbname()));

            return Command::FAILURE;
        }

        $builder->createDatabase($firstConnectionData->getDbname(), $databaseConfig);

        $this->io->success(sprintf('Database %s created successfully', $firstConnectionData->getDbname()));

        return Command::SUCCESS;

    }

}