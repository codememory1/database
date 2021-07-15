<?php

namespace Codememory\Components\Database\ORM;

use ArrayIterator;
use Codememory\Components\Database\QueryBuilder\Expressions\Operators;
use Generator;
use ReflectionException;

/**
 * Class AbstractEntityRepository
 *
 * @package Codememory\Components\Database\ORM
 *
 * @author  Codememory
 */
abstract class AbstractEntityRepository
{

    /**
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @var object
     */
    protected object $entity;

    /**
     * AbstractEntityRepository constructor.
     *
     * @param EntityManager $entityRepository
     * @param object        $entity
     */
    public function __construct(EntityManager $entityRepository, object $entity)
    {

        $this->entityManager = $entityRepository;
        $this->entity = $entity;

    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function findAll(): array
    {

        return $this->entityManager->createQueryBuilder()
            ->select()
            ->from($this->getEntityTableName())
            ->generateQuery()
            ->getResult($this->entity)
            ->toObject();

    }

    /**
     * @param array $where
     *
     * @return array
     * @throws ReflectionException
     */
    public function findBy(array $where): array
    {

        $conditionals = [];
        $qb = $this->entityManager->createQueryBuilder();

        foreach ($where as $key => $value) {
            $conditionals[] = $qb->expression()->conditional($key, Operators::EQUALLY, $value);
        }

        return $qb
            ->select()
            ->from($this->getEntityTableName())
            ->where(
                $qb->expression()->exprAnd(...$conditionals)
            )
            ->generateQuery()
            ->getResult($this->entity)
            ->toObject();

    }

    /**
     * @return ArrayIterator
     * @throws ReflectionException
     */
    public function findIterator(): ArrayIterator
    {

        return new ArrayIterator($this->findAll());

    }

    /**
     * @param array $entities
     *
     * @return Generator
     */
    public function generator(array $entities): Generator
    {

        foreach ($entities as $entity) {
            yield $entity;
        }

    }

    /**
     * @return string
     */
    protected function getEntityTableName(): string
    {

        return $this->entityManager->getEntityData($this->entity)->getTableName();

    }

}