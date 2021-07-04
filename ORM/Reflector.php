<?php


namespace Codememory\Components\Database\ORM;

use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;
use ReflectionClass;

/**
 * Class Reflector
 *
 * @package Codememory\Components\Database\ORM
 *
 * @author  Codememory
 */
class Reflector
{

    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflection;

    /**
     * Reflector constructor.
     *
     * @param object $entity
     */
    public function __construct(object $entity)
    {

        $this->reflection = new ReflectionClass($entity);

    }

    /**
     * @return ReflectionAttribute[]
     */
    #[Pure]
    public function getClassAttributes(): array
    {

        return $this->getReflection()->getAttributes();

    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return bool
     */
    #[Pure]
    public function existAttributeInClass(string $name, array $attributes = []): bool
    {

        foreach ([] === $attributes ? $this->getClassAttributes() : $attributes as $classAttribute) {
            if ($classAttribute->getName() === $name) {
                return true;
            }
        }

        return false;

    }

    /**
     * @return ReflectionClass
     */
    public function getReflection(): ReflectionClass
    {

        return $this->reflection;

    }

    /**
     * @return array
     */
    #[Pure]
    public function propertyAttributes(): array
    {

        $properties = [];

        foreach ($this->getReflection()->getProperties() as $property) {
            $properties[] = [
                'property'   => $property,
                'attributes' => $property->getAttributes()
            ];
        }

        return $properties;

    }

    /**
     * @param ReflectionAttribute[] $attributes
     * @param string                $attributeName
     *
     * @return ReflectionAttribute|null
     */
    #[Pure]
    public function getAttributeByName(array $attributes, string $attributeName): ?ReflectionAttribute
    {

        foreach ($attributes as $attribute) {
            if ($attribute->getName() === $attributeName) {
                return $attribute;
            }
        }

        return null;

    }

    /**
     * @param ReflectionAttribute[] $attributes
     * @param string                $attributeName
     *
     * @return array
     */
    #[Pure]
    public function getAttributeParameters(array $attributes, string $attributeName): array
    {

        $attribute = $this->getAttributeByName($attributes, $attributeName);

        if (null !== $attribute) {
            return $attribute->getArguments();
        }

        return [];

    }

    /**
     * @return string
     */
    #[Pure]
    public function getNamespace(): string
    {

        return $this->getReflection()->getName();

    }

}