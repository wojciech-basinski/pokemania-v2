<?php
namespace AppBundle\Repository;

use AppBundle\Entity\MarketPokemon;
use Doctrine\ORM\EntityRepository;

class MarketPokemonRepository extends EntityRepository
{
    public function countOfers(
        ?int $id,
        ?int $minLevel,
        ?int $maxLevel,
        ?int $minValue,
        ?int $maxValue,
        bool $own,
        int $userId
    ): ?int {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('COUNT(pokemon.id)');
        $qb->from('AppBundle:MarketPokemon', 'pokemon');
        if ($id !== null) {
            $qb->where('pokemon.idPokemonBase = :id');
            $qb->setParameter(':id', $id);
        } else {
            $qb->where('pokemon.idPokemonBase <> 0');
        }
        if ($minLevel !== null) {
            $qb->andWhere('pokemon.level >= :minLevel');
            $qb->setParameter(':minLevel', $minLevel);
        }
        if ($maxLevel !== null) {
            $qb->andWhere('pokemon.level <= :maxLevel');
            $qb->setParameter(':maxLevel', $maxLevel);
        }
        if ($minValue !== null) {
            $qb->andWhere('pokemon.value >= :minValue');
            $qb->setParameter(':minValue', $minValue);
        }
        if ($maxValue !== null) {
            $qb->andWhere('pokemon.value <= :maxValue');
            $qb->setParameter(':maxValue', $maxValue);
        }
        if (!$own) {
            $qb->andWhere('pokemon.ownerId <> :idUser');
            $qb->setParameter(':idUser', $userId);
        }

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int|null $id
     * @param int|null $minLevel
     * @param int|null $maxLevel
     * @param int|null $minValue
     * @param int|null $maxValue
     * @param bool     $own
     * @param int      $userId
     * @param int      $page
     *
     * @return MarketPokemon|MarketPokemon[]|null
     */
    public function getOferts(
        ?int $id,
        ?int $minLevel,
        ?int $maxLevel,
        ?int $minValue,
        ?int $maxValue,
        bool $own,
        int $userId,
        int $page
    ): array {
        $onPage = 30;

        $qb = $this->_em->createQueryBuilder();
        $qb->select('pokemon');
        $qb->from('AppBundle:MarketPokemon', 'pokemon');
        if ($id !== null) {
            $qb->where('pokemon.idPokemonBase = :id');
            $qb->setParameter(':id', $id);
        } else {
            $qb->where('pokemon.idPokemonBase <> 0');
        }
        if ($minLevel !== null) {
            $qb->andWhere('pokemon.level >= :minLevel');
            $qb->setParameter(':minLevel', $minLevel);
        }
        if ($maxLevel !== null) {
            $qb->andWhere('pokemon.level <= :maxLevel');
            $qb->setParameter(':maxLevel', $maxLevel);
        }
        if ($minValue !== null) {
            $qb->andWhere('pokemon.value >= :minValue');
            $qb->setParameter(':minValue', $minValue);
        }
        if ($maxValue !== null) {
            $qb->andWhere('pokemon.value <= :maxValue');
            $qb->setParameter(':maxValue', $maxValue);
        }
        if (!$own) {
            $qb->andWhere('pokemon.ownerId <> :userId');
            $qb->setParameter(':userId', $userId);
        }
        $qb->orderBy('pokemon.id', 'ASC');
        $qb->setMaxResults($onPage);
        $qb->setFirstResult($page * $onPage);

        return $qb->getQuery()->getResult();
    }

    public function pokemonsAddedToSell(int $userId): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('pokemon');
        $qb->from('AppBundle:MarketPokemon', 'pokemon');
        $qb->where('pokemon.ownerId = :id');
        $qb->setParameter(':id', $userId);

        return $qb->getQuery()->getResult();
    }
}
