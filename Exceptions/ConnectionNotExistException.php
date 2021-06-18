<?php

namespace Codememory\Components\Database\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class ConnectionNotExistException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
class ConnectionNotExistException extends ConnectorException
{

    /**
     * ConnectionNotExistException constructor.
     *
     * @param string $connectionName
     */
    #[Pure]
    public function __construct(string $connectionName)
    {

        parent::__construct(sprintf('The connection named %s does not exist', $connectionName));

    }

}