<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function countMessages(int $userId): ?int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(messages.id)');
        $qb->from('AppBundle:Message', 'messages');
        $qb->where('messages.yourId = :id');
        $qb->andWhere('messages.isRead = 0');
        $qb->setParameter(':id', $userId);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getAllUserMessages(int $userId): array
    {
        return $this->createQueryBuilder('m')
                    ->where('m.yourId = :id')
                    ->setParameter(':id', $userId)
                    ->getQuery()
                    ->getResult();
    }

    public function markMessagesAsRead(int $userId): void
    {
        $this->createQueryBuilder('m')
            ->update()
            ->set('m.isRead', 1)
            ->where('m.yourId = :id')
            ->andWhere('m.isRead = 0')
            ->setParameter(':id', $userId)
            ->getQuery()
            ->getResult();
    }
}
