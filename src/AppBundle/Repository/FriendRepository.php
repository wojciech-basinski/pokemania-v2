<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Friend;
use Doctrine\ORM\EntityRepository;

class FriendRepository extends EntityRepository
{
    public function getAllFriends(int $userId): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.userId = :id')
            ->orWhere('f.whoId = :id')
            ->andWhere('f.accepted = 1')
            ->setParameter(':id', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getAllInvitations(int $userId): array
    {
        return $this->createQueryBuilder('f')
            ->Where('f.whoId = :id')
            ->andWhere('f.invitation = 1')
            ->andWhere('f.accepted = 0')
            ->setParameter(':id', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getAllSentInvitations(int $userId): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.userId = :id')
            ->andWhere('f.invitation = 1')
            ->andWhere('f.accepted = 0')
            ->setParameter(':id', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getOneFriendship(int $id, int $userId): ?Friend
    {
        return $this->createQueryBuilder('f')
            ->where('(f.userId = :uId OR f.whoId = :uId)')
            ->andWhere('(f.userId = :id OR f.whoId = :id)')
            ->andWhere('f.accepted = 1')
            ->setParameter(':uId', $userId)
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function checkIfUserSentInvitation(int $id, int $userId): ?Friend
    {
        return $this->findOneBy([
            'userId' => $id,
            'whoId' => $userId,
            'invitation' => 1
        ]);
    }

    public function checkIfUserReceivedInvitation(int $id, int $userId): ?Friend
    {
        return $this->findOneBy([
            'whoId' => $id,
            'userId' => $userId,
            'invitation' => 1
        ]);
    }

    public function getOneInvitation(int $id, int $userId): ?Friend
    {
        return $this->findOneBy([
            'id' => $id,
            'whoId' => $userId,
            'invitation' => 1
        ]);
    }

    public function getOneSentInvitation(int $id, int $userId): ?Friend
    {
        return $this->findOneBy([
            'id' => $id,
            'userId' => $userId,
            'invitation' => 1
        ]);
    }
}
