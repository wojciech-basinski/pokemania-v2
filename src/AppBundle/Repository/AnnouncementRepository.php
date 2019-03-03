<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AnnouncementRepository extends EntityRepository
{
    public function getAnnouncements(int $page): array
    {
        $onPage = 20;

        $qb = $this->_em->createQueryBuilder();
        $qb->select('announcement');
        $qb->from('AppBundle:Announcement', 'announcement');

        $qb->orderBy('announcement.id', 'DESC');
        $qb->setMaxResults($onPage);
        $qb->setFirstResult($page * $onPage);

        return $qb->getQuery()->getResult();
    }

    public function countAnnouncements(): ?int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('COUNT(announcement.id)');
        $qb->from('AppBundle:Announcement', 'announcement');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
