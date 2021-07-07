<?php

namespace Codememory\Components\Database\ORM;

use Codememory\Components\Database\ORM\Construction\Column;
use Codememory\Components\Database\ORM\Construction\Entity;
use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;

/**
 * Class Inspector
 *
 * @package Codememory\Components\Database\ORM
 *
 * @author  Codememory
 */
class Inspector
{

    /**
     * @var object
     */
    private object $entity;

    /**
     * @var Reflector
     */
    private Reflector $reflector;

    /**
     * Looking constructor.
     *
     * @param object $entity
     */
    public function __construct(object $entity)
    {

        $this->entity = $entity;
        $this->reflector = new Reflector($entity);

    }

    /**
     * @return bool
     */
    #[Pure]
    public function isEntity(): bool
    {

        return $this->reflector->existAttributeInClass(Entity::class);

    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function strictColumnExist(string $name): bool
    {

        return $this->iterationProperties(function (
            string $propertyName,
            array $attributes,
            ReflectionAttribute $columnAttribute,
            array $columnAttributeArguments) use ($name) {

            if ($name === $propertyName && $name === $columnAttributeArguments['name']) {
                return true;
            }

            return false;
        });

    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function columnExist(string $name): bool
    {

        return $this->iterationProperties(function (
            string $propertyName,
            array $attributes,
            ReflectionAttribute $columnAttribute,
            array $columnAttributeArguments) use ($name) {

            if ($name === $propertyName || $name === $columnAttributeArguments['name']) {
                return true;
            }

            return false;
        });

    }

    /**
     * @param callable $handler
     *
     * @return mixed
     */
    private function iterationProperties(callable $handler): mixed
    {

        $properties = $this->reflector->propertyAttributes();

        foreach ($properties as $property) {
            $propertyName = $property['property']->getName();
            $attributes = $property['attributes'];

            $columnAttribute = $this->reflector->getAttributeByName($attributes, Column::class);
            $columnAttributeArguments = $columnAttribute->getArguments();

            $callHandler = call_user_func_array($handler, [
                $propertyName,
                $attributes,
                $columnAttribute,
                $columnAttributeArguments
            ]);

            if (null !== $callHandler) {
                return $callHandler;
            }
        }

        return null;

    }

}