<?php

namespace Codememory\Components\Database\ORM;

use Codememory\Components\Database\Interfaces\EntityRepositoryInterface;

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
    private object $entity;

    /**
     * AbstractEntityRepository constructor.
     *
     * @param EntityRepositoryInterface $entityRepository
     * @param object                    $entity
     */
    public function __construct(EntityManager $entityRepository, object $entity)
    {

        $this->entityManager = $entityRepository;
        $this->entity = $entity;

    }

    /**
     * @return object[]
     */
    public function findAll(): array
    {

        $this->entityManager->createQueryBuilder()
            ->select()
            ->from($this->entityManager->getEntityData($this->entity)->getTableName())
            ->generateQuery()
            ->getResult();

    }

    public function find()
    {



    }

}