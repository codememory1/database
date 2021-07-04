<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class Join
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Join
{

    public function __construct()
    {
    }

}