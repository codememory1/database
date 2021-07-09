<?php

namespace App\Respository;

use App\Entity\TestEntity;
use Codememory\Components\Database\ORM\AbstractEntityRepository;
use ReflectionException;

/**
 * Class TestRepository
 *
 * @package App\Respository
 *
 * @author  Codememory
 */
class TestRepository extends AbstractEntityRepository
{

    /**
     * @return array
     * @throws ReflectionException
     */
    public function tests(): array
    {

        $qb = $this->entityManager->createQueryBuilder();

        return $qb
            ->select(['t2.*', 't.*', 't2id' => 't2.id'])
            ->from('test', 't')
            ->innerJoin(['test2'], ['t2'],
                $qb->joinSpecification()->on(
                    $qb->expression()->exprAnd(
                        $qb->expression()->conditional('t.id', '=', 't2.id')
                    )
                )
            )
            ->generateQuery()
            ->getResult($this->entity)
            ->toObject();

    }

}