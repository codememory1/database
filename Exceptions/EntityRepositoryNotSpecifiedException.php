<?php

namespace Codememory\Components\Database\Exceptions;

use JetBrains\PhpStorm\Pure;

/**
 * Class EntityRepositoryNotSpecifiedException
 *
 * @package Codememory\Components\Database\Exceptions
 *
 * @author  Codememory
 */
class EntityRepositoryNotSpecifiedException extends EntityException
{

    /**
     * EntityRepositoryNotSpecifiedException constructor.
     *
     * @param string $entity
     */
    #[Pure]
    public function __construct(string $entity)
    {

        parent::__construct(sprintf('No repository namespace specified for entity %s', $entity));

    }

}