<?php

namespace Codememory\Components\Database\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class ConnectionNamedExist
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
class ConnectionNamedExist extends ConnectorException
{

    /**
     * ConnectionNamedExist constructor.
     *
     * @param string $connectionName
     */
    #[Pure]
    public function __construct(string $connectionName)
    {

        parent::__construct(sprintf('Unable to create with a connection named %s because a connection with the given name already exists', $connectionName));

    }

}