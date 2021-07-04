<?php

namespace Codememory\Components\Database\ORM;

use Codememory\Components\Database\Interfaces\EntityDataInterface;
use Codememory\Components\Database\ORM\Construction\AI;
use Codememory\Components\Database\ORM\Construction\Column;
use Codememory\Components\Database\ORM\Construction\DefaultValue;
use Codememory\Components\Database\ORM\Construction\Entity;
use Codememory\Components\Database\ORM\Construction\Table;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

/**
 * Class EntityData
 *
 * @package Codememory\Components\Database\ORM
 *
 * @author  Codememory
 */
class EntityData implements EntityDataInterface
{

    /**
     * @var Reflector
     */
    private Reflector $reflector;

    /**
     * EntityData constructor.
     *
     * @param Reflector $reflector
     */
    public function __construct(Reflector $reflector)
    {

        $this->reflector = $reflector;

        $this->entityValidation();

    }

    /**
     * @return string|null
     */
    #[Pure]
    public function getNamespaceRepository(): ?string
    {

        return $this->classAttributeParameters(Entity::class)['repository'] ?? null;

    }

    /**
     * @return string|null
     */
    #[Pure]
    public function getTableName(): ?string
    {

        return $this->classAttributeParameters(Table::class)['name'] ?? null;

    }

    /**
     * @return array
     */
    #[Pure]
    public function getColumns(): array
    {

        $columns = [];

        foreach ($this->reflector->propertyAttributes() as $property) {
            $columns[] = $this->composeColumn($property);
        }

        return $columns;

    }

    /**
     * @param array $propertyData
     *
     * @return array
     */
    #[Pure]
    private function composeColumn(array $propertyData): array
    {

        $column = [];
        $propertyAttributes = $propertyData['attributes'];
        $columnAttributeParameters = $this->reflector->getAttributeParameters($propertyAttributes, Column::class);
        $defaultValueAttributeParameters = $this->reflector->getAttributeParameters($propertyAttributes, DefaultValue::class);

        if ([] !== $columnAttributeParameters) {
            $columnAttributeParameters['ai'] = $this->reflector->existAttributeInClass(AI::class, $propertyAttributes);
            $columnAttributeParameters['default'] = $defaultValueAttributeParameters['defaultValue'] ?? null;
            $columnAttributeParameters['charset'] = $columnAttributeParameters['charset'] ?? null;
            $column = $columnAttributeParameters;
        }

        return $column;

    }

    /**
     * @return void
     */
    private function entityValidation(): void
    {

        if (false === $this->reflector->existAttributeInClass(Entity::class)) {
            throw new RuntimeException(sprintf('The %s class is not an entity', $this->reflector->getNamespace()));
        }

    }

    /**
     * @param string $attributeName
     *
     * @return array
     */
    #[Pure]
    private function classAttributeParameters(string $attributeName): array
    {

        return $this->reflector->getAttributeParameters($this->reflector->getClassAttributes(), $attributeName);

    }

}