<?php

namespace Codememory\Components\Database\ORM;

use Codememory\Components\Database\Exceptions\EntityRepositoryNotSpecifiedException;
use Codememory\Components\Database\Exceptions\RepositoryNotExistException;
use Codememory\Components\Database\Interfaces\ConnectionInterface;
use Codememory\Components\Database\Interfaces\EntityDataInterface;
use Codememory\Components\Database\Interfaces\EntityRepositoryInterface;
use Codememory\Components\Database\Interfaces\QueryBuilderInterface;
use Codememory\Components\Database\QueryBuilder\QueryBuilder;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

/**
 * Class EntityManager
 *
 * @package Codememory\Components\Database\ORM
 *
 * @author  Codememory
 */
class EntityManager implements EntityRepositoryInterface
{

    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $connection;

    /**
     * @var QueryBuilderInterface
     */
    private QueryBuilderInterface $queryBuilder;

    /**
     * @var array
     */
    private array $entities = [];

    /**
     * @var Reflector|null
     */
    private ?Reflector $reflector = null;

    /**
     * @var EntityDataInterface|null
     */
    private ?EntityDataInterface $entityData = null;

    /**
     * EntityManager constructor.
     *
     * @param ConnectionInterface $connection
     */
    #[Pure]
    public function __construct(ConnectionInterface $connection)
    {

        $this->connection = $connection;
        $this->queryBuilder = new QueryBuilder($this->connection);

    }

    /**
     * @param object $entity
     *
     * @return EntityManager
     */
    public function commit(object $entity): EntityManager
    {

        $this->entities[] = $entity;

        if (null === $this->getEntityData($entity)->getTableName()) {
            throw new RuntimeException(sprintf(
                'In entity %s is not specified the name of the table with which the entity should work',
                $this->getReflector($entity)->getNamespace()
            ));
        }

        return $this;

    }

    /**
     * @param object $entity
     *
     * @return EntityDataInterface
     */
    public function getEntityData(object $entity): EntityDataInterface
    {

        if ($this->entityData instanceof EntityDataInterface) {
            return $this->entityData;
        }

        return $this->entityData = new EntityData($this->getReflector($entity));

    }

    /**
     * @param object $entity
     *
     * @return Reflector
     */
    public function getReflector(object $entity): Reflector
    {

        if ($this->reflector instanceof Reflector) {
            return $this->reflector;
        }

        return $this->reflector = new Reflector($entity);

    }

    /**
     * @return void
     */
    public function flush(): void
    {

        foreach ($this->entities as $entity) {
            $columns = [];
            $parameters = [];
            $values = [];

            $properties = $this->getReflector($entity)->getReflection()->getProperties();
            $tableName = $this->getEntityData($entity)->getTableName();

            foreach ($properties as $property) {
                $property->setAccessible(true);

                $name = $property->getName();
                $value = $property->getValue($entity);

                $columns[] = sprintf('`%s`', $name);
                $values[$name] = $value;
                $parameters[] = sprintf(':%s', $name);

            }

            $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $tableName, implode(',', $columns), implode(',', $parameters));

            $this->connection->getConnected()->prepare($sql)->execute($values);
        }

        $this->clearCommit();

    }

    /**
     * @return void
     */
    public function clearCommit(): void
    {

        $this->entities = [];

    }

    /**
     * @param object $entity
     *
     * @return AbstractEntityRepository
     * @throws EntityRepositoryNotSpecifiedException
     * @throws RepositoryNotExistException
     */
    public function getRepository(object $entity): AbstractEntityRepository
    {

        $repositoryNamespace = $this->getEntityData($entity)->getNamespaceRepository();

        if(null === $repositoryNamespace) {
            throw new EntityRepositoryNotSpecifiedException($this->getReflector($entity)->getNamespace());
        }

        if(!class_exists($repositoryNamespace)) {
            throw new RepositoryNotExistException($repositoryNamespace);
        }

        return new $repositoryNamespace($this, $entity);

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function createQueryBuilder(): QueryBuilderInterface
    {

        return clone $this->queryBuilder;

    }

}