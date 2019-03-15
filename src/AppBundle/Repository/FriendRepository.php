<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Friend;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class FriendRepository extends EntityRepository
{
    public function getAllFriends(User $user): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.user = :id')
            ->orWhere('f.who = :id')
            ->andWhere('f.accepted = 1')
            ->setParameter(':id', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function getAllInvitations(User $user): array
    {
        return $this->createQueryBuilder('f')
            ->Where('f.who = :id')
            ->andWhere('f.invitation = 1')
            ->andWhere('f.accepted = 0')
            ->setParameter(':id', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function getAllSentInvitations(User $user): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.user = :id')
            ->andWhere('f.invitation = 1')
            ->andWhere('f.accepted = 0')
            ->setParameter(':id', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function getOneFriendship(int $id, User $user): ?Friend
    {
        return $this->createQueryBuilder('f')
            ->where('(f.user = :uId OR f.who = :uId)')
            ->andWhere('(f.user = :id OR f.who = :id)')
            ->andWhere('f.accepted = 1')
            ->setParameter(':uId', $user->getId())
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function checkIfUserSentInvitation(int $id, User $user): ?Friend
    {
        return $this->findOneBy([
            'user' => $id,
            'who' => $user->getId(),
            'invitation' => 1
        ]);
    }

    public function checkIfUserReceivedInvitation(int $id, User $user): ?Friend
    {
        return $this->findOneBy([
            'who' => $id,
            'user' => $user->getId(),
            'invitation' => 1
        ]);
    }

    public function getOneInvitation(int $id, User $user): ?Friend
    {
        return $this->findOneBy([
            'id' => $id,
            'who' => $user->getId(),
            'invitation' => 1
        ]);
    }

    public function getOneSentInvitation(int $id, User $user): ?Friend
    {
        return $this->findOneBy([
            'id' => $id,
            'user' => $user->getId(),
            'invitation' => 1
        ]);
    }
}
