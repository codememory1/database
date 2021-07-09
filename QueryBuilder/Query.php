<?php

namespace Codememory\Components\Database\QueryBuilder;

use Codememory\Components\Attributes\AttributeAssistant;
use Codememory\Components\Attributes\Targets\ClassTarget;
use Codememory\Components\Attributes\Targets\PropertyTarget;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use Codememory\Components\Database\ORM\Construction\Entity;
use Codememory\Components\Database\ORM\Construction\Join as ORMJoin;
use Codememory\Support\Arr;
use Generator;
use LogicException;
use PDO;
use PDOStatement;
use ReflectionClass;
use ReflectionException;

/**
 * Class Query
 *
 * @package Codememory\Components\Database\QueryBuilder
 *
 * @author  Codememory
 */
class Query
{

    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $connection;

    /**
     * @var string
     */
    private string $query;

    /**
     * @var object
     */
    private object $entity;

    /**
     * @var array
     */
    private array $parameters;

    /**
     * Query constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {

        $this->connection = $connection;

        return $this;

    }

    /**
     * @param string $query
     *
     * @return $this
     */
    public function setQuery(string $query): Query
    {

        $this->query = $query;

        return $this;

    }

    /**
     * @param object $entity
     *
     * @return $this
     * @throws ReflectionException
     */
    public function setEntity(object $entity): Query
    {

        $classTarget = new ClassTarget(new AttributeAssistant($entity));

        if (!$classTarget->existAttribute(Entity::class, $classTarget->getAttributes())) {
            throw new LogicException(sprintf('The %s object is not an entity', $entity::class));
        }

        $this->entity = $entity;

        return $this;

    }

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function setParameters(array $parameters): Query
    {

        $this->parameters = $parameters;

        return $this;

    }

    /**
     * @return bool|PDOStatement
     */
    public function execute(): bool|PDOStatement
    {

        Arr::map($this->parameters, function (mixed $key, mixed $value) {
            return [':' . $key, $value];
        });

        $sth = $this->connection->getConnected()->prepare($this->query);

        $sth->execute($this->parameters);

        return $sth;

    }

    /**
     * @throws ReflectionException
     */
    public function toArray(): array
    {

        $data = [];
        $attributeAssistant = new AttributeAssistant($this->entity);
        $propertyTarget = new PropertyTarget($attributeAssistant);

        $statement = $this->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        $propertiesWithJoin = $propertyTarget->getPropertiesIfAttributesExist(ORMJoin::class);

        foreach ($propertiesWithJoin as $property) {
            $joinAttribute = $propertyTarget->getAttributeIfExist(ORMJoin::class, $property);
            $joinArguments = $joinAttribute->getArguments();

            foreach ($joinArguments['columns'] as $columnName) {
                foreach ($this->iterationRecords($records) as $recordIndex => $record) {
                    if (array_key_exists($columnName, $record)) {
                        $data[$recordIndex][$property->getName()][$columnName] = $record[$columnName];
                    }

                    $data[$recordIndex] += array_diff_key($record, array_flip($joinArguments['columns']));
                }
            }
        }

        return $data;

    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function toObject(): array
    {

        $data = [];
        $attributeAssistant = new AttributeAssistant($this->entity);
        $propertyTarget = new PropertyTarget($attributeAssistant);
        $records = $this->toArray();

        foreach ($records as &$record) {
            foreach ($record as $columnName => &$recordValue) {
                if (is_array($recordValue)) {
                    $attributes = $propertyTarget->getAttributesByPropertyName($columnName);
                    $arguments = $propertyTarget->getAttributeArguments($attributes[0]);

                    $recordValue = $this->setValueToProperty(new $arguments['entity'](), $recordValue);
                }
            }
        }

        unset($record);

        foreach ($records as $record) {
            $data[] = $this->setValueToProperty(clone $this->entity, $record);
        }

        return $data;

    }

    /**
     * @param object $entity
     * @param array  $columnsWithValue
     *
     * @return object
     * @throws ReflectionException
     */
    private function setValueToProperty(object $entity, array $columnsWithValue): object
    {

        $reflection = new ReflectionClass($entity);

        foreach ($columnsWithValue as $name => $value) {
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($entity, $value);
        }

        return $entity;

    }

    /**
     * @param array $records
     *
     * @return Generator
     */
    private function iterationRecords(array $records): Generator
    {

        foreach ($records as $record) {
            yield $record;
        }

    }

}