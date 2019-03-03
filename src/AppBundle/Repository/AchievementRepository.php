<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AchievementRepository extends EntityRepository
{
    public function addCatchedOnePokemon(int $userId, string $pokeball): void
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

    public function addCatchedOneShiny(int $userId, string $pokeball): void
    {
        $qb = $this->createQueryBuilder('a');
        $qb->update()
            ->set('a.catchedPokemons', '(a.catchedPokemons + 1)');
        if ($pokeball !== 'Masterball') {
            $qb->set('a.catched'.$pokeball, '(a.catched'.$pokeball.' + 1)');
        }
        $qb->set('a.catchedShiny', '(a.catchedShiny + 1)')
            ->where('a.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->execute();
    }

    public function addWinWithPokemon(int $userId): void
    {
        $this->createQueryBuilder('a')
            ->update()
            ->set('a.winsWithPokemons', '(a.winsWithPokemons + 1)')
            ->where('a.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->execute();
    }

    public function addWinWithTrainer(int $userId): void
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
