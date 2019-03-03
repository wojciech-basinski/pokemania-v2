<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MarketRepository extends EntityRepository
{
    public function countOferts(string $name, string $kind, bool $own, int $userId): ?int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('COUNT(ofert.id)');
        $qb->from('AppBundle:Market', 'ofert');
        $qb->where('ofert.name = :name');
        $qb->andWhere('ofert.kind = :kind');
        if (!$own) {
            $qb->andWhere('ofert.userId <> :idUser');
            $qb->setParameter(':idUser', $userId);
        }
        $qb->setParameter(':name', $name);
        $qb->setParameter(':kind', $kind);
        $qb->orderBy('ofert.id', 'ASC');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getOferts(string $name, string $kind, bool $own, int $userId, int $page): array
    {
        $onPage = 30;

        $qb = $this->_em->createQueryBuilder();
        $qb->select('ofert');
        $qb->from('AppBundle:Market', 'ofert');
        $qb->where('ofert.name = :name');
        $qb->andWhere('ofert.kind = :kind');
        if (!$own) {
            $qb->andWhere('ofert.userId <> :userId');
            $qb->setParameter(':userId', $userId);
        }
        $qb->setParameter(':name', $name);
        $qb->setParameter(':kind', $kind);
        $qb->orderBy('ofert.id', 'ASC');
        $qb->setMaxResults($onPage);
        $qb->setFirstResult($page * $onPage);

        return $qb->getQuery()->getResult();
    }
}
