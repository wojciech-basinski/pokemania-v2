<?php

namespace AppBundle\Repository;

/**
 * AchievementsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AchievementRepository extends \Doctrine\ORM\EntityRepository
{
    public function addCatchedOnePokemon(int $userId, string $pokeball)
    {
        $this->createQueryBuilder('a')
            ->update()
            ->set('a.catchedPokemons', '(a.catchedPokemons + 1)')
            ->set('a.catched'.$pokeball, '(a.catched'.$pokeball.' + 1)')
            ->where('a.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->execute();
    }

    public function addWinWithPokemon(int $userId)
    {
        $this->createQueryBuilder('a')
            ->update()
            ->set('a.winsWithPokemons', '(a.winsWithPokemons + 1)')
            ->where('a.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->execute();
    }

    public function addWinWithTrainer(int $userId)
    {
        $this->createQueryBuilder('a')
            ->update()
            ->set('a.winsWithTrainers', '(a.winsWithTrainers + 1)')
            ->where('a.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->execute();
    }
}