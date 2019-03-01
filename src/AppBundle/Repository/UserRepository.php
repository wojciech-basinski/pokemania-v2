<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.login = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countOnline()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(user.id)');
        $qb->from('AppBundle:User', 'user');
        $qb->where('user.sessionId <> \'\'');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function addPa()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:User', 'u');
        $qb->set('u.pa', '(u.pa + 0.1 * u.mpa)');
        $qb->where('u.pa <= (0.9 * u.mpa)');
        $qb->getQuery()
            ->execute();

        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:User', 'u');
        $qb->set('u.pa', 'u.mpa');
        $qb->where('u.pa >= (0.9 * u.mpa)');
        $qb->getQuery()
            ->execute();
    }

    public function removeInactive(): void
    {
        $date = (new \DateTime('now - 15 minutes'))->getTimestamp();
        $this->createQueryBuilder('u')
            ->update()
            ->set('u.sessionId', '\'\'')
            ->set('u.lastActive', 0)
            ->where('u.lastActive < :date')
            ->setParameter(':date', $date)
            ->getQuery()
            ->execute();
    }

    public function setShinyNotCaught(int $region): void
    {
        $this->createQueryBuilder('u')
            ->update()
            ->set('u.shinyCatched', 0)
            ->where('u.region = :region')
            ->setParameter(':region', $region)
            ->getQuery()
            ->execute();
    }
}
