<?php

namespace Codememory\Components\Database\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class RepositoryNotExistException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
class RepositoryNotExistException extends EntityException
{

    /**
     * RepositoryNotExistException constructor.
     *
     * @param string $repository
     */
    #[Pure]
    public function __construct(string $repository)
    {

        parent::__construct(sprintf('The %s repository does not exist', $repository));

    }

}