<?php

namespace Codememory\Components\Database\ORM\Construction;

use Attribute;

/**
 * Class References
 *
 * @package Codememory\Components\Database\ORM\Construction
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class References
{

    public const ON_UPDATE = 'UPDATE';
    public const ON_DELETE = 'DELETE';

    public const OPTION_RESTRICT = 'RESTRICT';
    public const OPTION_CASCADE = 'CASCADE';
    public const OPTION_SET_NULL = 'SET NULL';
    public const OPTION_NO_ACTION = 'NO ACTION';
    public const OPTION_SET_DEFAULT = 'SET DEFAULT';

    /**
     * References constructor.
     *
     * @param string $tableName
     * @param string $column
     * @param string $on
     * @param string $option
     */
    public function __construct(
        private string $tableName,
        private string $column,
        private string $on,
        private string $option
    )
    {
    }

}