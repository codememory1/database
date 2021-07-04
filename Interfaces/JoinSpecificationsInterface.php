<?php

namespace Codememory\Components\Database\Interfaces;

/**
 * Interface JoinSpecificationsInterface
 *
 * @package Codememory\Components\Database\Interfaces
 *
 * @author  Codememory
 */
interface JoinSpecificationsInterface
{

    /**
     * @param string $expressions
     *
     * @return string
     */
    public function on(string $expressions): string;

    /**
     * @param array $columns
     *
     * @return string
     */
    public function using(array $columns): string;

}