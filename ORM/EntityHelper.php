<?php

namespace Codememory\Components\Database\ORM;

use Codememory\Components\Database\ORM\Construction\Join;

/**
 * Class EntityHelper
 *
 * @package Codememory\Components\Database\ORM
 *
 * @author  Codememory
 */
class EntityHelper
{

    /**
     * @var Reflector
     */
    private Reflector $reflector;

    /**
     * EntityHelper constructor.
     *
     * @param object $entity
     */
    public function __construct(object $entity)
    {

        $this->reflector = new Reflector($entity);

    }

    /**
     * @param array $attributeNames
     *
     * @return array
     */
    public function findPropertiesByAttributeName(array $attributeNames): array
    {

        $foundProperties = [];
        $properties = $this->reflector->propertyAttributes();

        foreach ($properties as $propertyData) {
            $property = $propertyData['property'];
            $attributes = $propertyData['attributes'];
            $propertyAttributeNames = [];

            foreach ($attributes as $attribute) {
                $propertyAttributeNames[] = $attribute->getName();
            }

            if ([] !== array_intersect($propertyAttributeNames, $attributeNames)) {
                $foundProperties[] = $property;
            }
        }

        return $foundProperties;

    }

    /**
     * @param array $columns
     *
     * @return array
     */
    public function identifyJoinPropertyByColumnNames(array $columns): array
    {

        $data = [];
        $joinProperties = $this->findPropertiesByAttributeName([Join::class]);

        foreach ($joinProperties as $joinProperty) {
            $attributes = $joinProperty->getAttributes();
            $joinArguments = $this->reflector->getAttributeByName($attributes, Join::class)->getArguments();

            if (array_intersect($joinArguments['columns'], $columns)) {
                $data['propertyName'] = $joinProperty->getName();
                $data['join'] = $joinArguments;
            }
        }

        return $data;

    }

}