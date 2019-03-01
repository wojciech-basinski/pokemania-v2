<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ShinyRepository extends EntityRepository
{
    public function addCaught(int $region): void
    {
        $this->createQueryBuilder('s')
            ->update()
            ->set('s.caught', '(s.caught + 1)')
            ->where('s.region = :region')
            ->setParameter(':region', $region)
            ->getQuery()
            ->execute();
    }
}
