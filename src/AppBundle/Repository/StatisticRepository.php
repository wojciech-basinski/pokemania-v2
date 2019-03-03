<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StatisticRepository extends EntityRepository
{

    public function addCatchedOnePokemon(int $userId): void
    {
        $this->createQueryBuilder('s')
            ->update()
            ->set('s.catched', '(s.catched + 1)')
            ->where('s.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->execute();
    }
}
