<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Pokemon;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityRepository;

class PokemonRepository extends EntityRepository
{
    private static $userTeam = null;

    public function getUsersPokemonsFromTeam(int $userId, array $team = null): array
    {
        if (self::$userTeam === null) {
            self::$userTeam = $this->_em->find('AppBundle:UserTeam', $userId);
        }
        $userTeam = self::$userTeam;


        $kwer = "SELECT p.* FROM pokemons p WHERE p.id in (";
        $kwer2 = "order by case p.id";
        $aa = 0;
        for ($i = 1; $i < 7; $i++) {
            if ($userTeam->{'getPokemon' . $i}() > 0) {
                //$rez = $rezultat[$i-1];
                $a = $userTeam->{'getPokemon' . $i}();
                if ($i === 1) {
                    $kwer .= "$a";
                } else {
                    $kwer .= ", $a";
                }
                $kwer2 .= " WHEN $a THEN " . $i;
                $aa++;
            }
        }
        $kwer = $kwer . ")" . $kwer2 . " END";

        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('AppBundle:Pokemon', 'p');


        return [
            'pokemons' =>
                $this->_em->createNativeQuery($kwer, $rsm)
                    ->getResult()
        ];
    }

    public function countPokemonsInReserve(int $owner): ?int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(pokemons.id)');
        $qb->from('AppBundle:Pokemon', 'pokemons');
        $qb->where('pokemons.owner = :id');
        $qb->andWhere('pokemons.team = 0');
        $qb->setParameter(':id', $owner);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function feedPokemons(array $pokemons): void
    {
        $kwer = 'UPDATE pokemons SET hunger = (CASE ID ';
        $kwer2 = '';

        $count = count($pokemons);
        for ($i = 0; $i < $count; $i++) {
            $kwer .= " WHEN {$pokemons[$i]['id']} THEN " . $pokemons[$i]['hunger'];
            if ($i) {
                $kwer2 .= ',' . $pokemons[$i]['id'];
            } else {
                $kwer2 .= $pokemons[$i]['id'];
            }
            $i++;
        }
        $kwery = $kwer . ' END ) WHERE ID IN ( ' . $kwer2 . ' ) ';

        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('AppBundle:Pokemon', 'p');

        $this->_em->createNativeQuery($kwery, $rsm)
            ->getResult();
    }

    public function feedPokemon(int $id, int $newHunger): void
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:Pokemon', 'p')
            ->set('p.hunger', ':hunger')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->setParameter(':hunger', $newHunger);
    }

    public function getPokemonsAvailableToSell(int $userId): array
    {
        return $this->findBy([
            'owner' => $userId,
            'team' => 0,
            'market' => 0,
            'block' => 0,
            'exchange' => 0
        ], [
            'id' => 'DESC'
        ]);
    }

    public function deletePokemons(array $pokemons): void
    {
        foreach ($pokemons as $pokemon) {
            $this->_em->remove($pokemon);
        }
        $this->_em->flush();
    }

    public function getOrderedPokemonsFromReserve(int $userId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.owner = :owner')
            ->andWhere('p.exchange = 0')
            ->andWhere('p.team = 0')
            ->andWhere('p.block = 1')
            ->andWhere('p.market = 0')
            ->setParameter('owner', $userId)
            ->orderBy('p.id', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function getOrderedPokemonsFromWaiting(int $userId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.owner = :owner')
            ->andWhere('p.exchange = 0')
            ->andWhere('p.team = 0')
            ->andWhere('p.block = 0')
            ->andWhere('p.market = 0')
            ->setParameter('owner', $userId)
            ->orderBy('p.id', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function getOrderedPokemonsFromMarket(int $userId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.owner = :owner')
            ->andWhere('p.exchange = 0')
            ->andWhere('p.team = 0')
            ->andWhere('p.market = 1')
            ->setParameter('owner', $userId)
            ->orderBy('p.id', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function addPokemonsToTeam(array $pokemons):void
    {
        $pokemonsEntities = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id in (:ids)')
            ->setParameter('ids', $pokemons)
            ->getQuery()
            ->getResult();

        foreach ($pokemonsEntities as $pokemon) {
            $pokemon->setTeam(1);
            $this->_em->persist($pokemon);
        }
        $this->_em->flush();
    }

    public function deletePokemonFromTeam(int $id): void
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:Pokemon', 'p')
            ->set('p.team', 0)
            ->set('p.block', 1)
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function movePokemonsToReserve(array $pokemons):void
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:Pokemon', 'p')
            ->set('p.block', 1)
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $pokemons)
            ->getQuery()
            ->getResult();
    }

    public function movePokemonsToWaiting(array $pokemons):void
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:Pokemon', 'p')
            ->set('p.block', 0)
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $pokemons)
            ->getQuery()
            ->getResult();
    }

    public function addExpByTraining(int $exp, int $userId):void
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:Pokemon', 'p')
            ->set('p.exp', 'p.exp + :exp')
            ->where('p.team = 1 AND p.owner = :owner')
            ->setParameter('owner', $userId)
            ->setParameter('exp', $exp)
            ->getQuery()
            ->getResult();
    }

    public function addAtachmentToPokemonsInTeam(int $userId, int $quantity):void
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->update('AppBundle:Pokemon', 'p')
            ->set('p.attachment', 'p.attachment + :quantity')
            ->where('p.team = 1 AND p.owner = :owner')
            ->setParameter('owner', $userId)
            ->setParameter('quantity', $quantity)
            ->getQuery()
            ->getResult();
    }

    public function getLastCaughtIds(): array
    {
        return $this->findBy(['shiny' => 0], ['id' => 'DESC'], 5);
    }

    public function pokemonsThatCanBeSoldOnMarket(int $userId): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('pokemon')
            ->from('AppBundle:Pokemon', 'pokemon')
            ->where('pokemon.owner = :id')
            ->andWhere('pokemon.team = 0')
            ->andWhere('pokemon.market = 0')
            ->andWhere('pokemon.exchange = 0')
            ->andWhere('pokemon.block = 0')
            ->setParameter(':id', $userId);

        return $qb->getQuery()->getResult();
    }

    public function addExpToPokemons(array $pokemons, int $exp): void
    {
        $this->_em->createQueryBuilder()
            ->update(Pokemon::class, 'p')
            ->set('p.exp', '(p.exp + :exp)')
            ->setParameter(':exp', $exp)
            ->where('p.id in (:ids)')
            ->setParameter(':ids', $pokemons)
            ->getQuery()->execute();
    }

    public function feedPokemonByOtherUser(int $id): void
    {
        $this->_em->createQueryBuilder()
            ->update(Pokemon::class, 'p')
            ->set('p.exp', '(p.exp + 2)')
            ->where('p.owner = :owner')
            ->andWhere('p.team = 1')
            ->setParameter(':owner', $id)
            ->getQuery()
            ->getResult();
    }

    public function setSnackTo0(): void
    {
        $this->createQueryBuilder('p')
            ->update()
            ->set('p.snacks', 0)
            ->getQuery()
            ->execute();
    }

    public function addHungerToPokemons(): void
    {
//        $kwer = 'UPDATE pokemons p JOIN users u ON u.id = p.owner SET p.hunger = (p.hunger + 1.04) WHERE p.team = 1 AND p.hunger < 100 AND u.badges like "1|1|1|1|1%" ';
//
//        $rsm = new ResultSetMappingBuilder(
//            $this->_em,
//            ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT
//        );
//        $rsm->addRootEntityFromClassMetadata('AppBundle:Pokemon', 'p');
//        $rsm->addJoinedEntityFromClassMetadata('AppBundle:User', 'u', 'p', 'owner');
//        $this->_em->createNativeQuery($kwer, $rsm)->execute();
//
//       // $this->_em->createNativeQuery($kwer, $rsm)->execute();
//
//        $kwer = 'UPDATE AppBundle:Pokemon p JOIN AppBundle:User u ON u.id = p.owner SET p.hunger = (p.hunger + 2.08) WHERE p.team = 1 AND p.hunger < 100 AND u.badges like "1|1|1|1|0%" ';
//        $this->_em->createQuery($kwer)->execute();
        // $this->_em->createNativeQuery($kwer, $rsm)->execute();


//        $qb = $this->_em->createQueryBuilder();
//        $qb->update('AppBundle:Pokemon', 'p');
//        $qb->join('AppBundle:User', 'u', 'on', 'u.id = p.owner');
//        $qb->set('p.hunger', '(p.hunger + 1.04)');
//        $qb->where('p.team = 1');
//        $qb->andWhere('p.hunger < 100');
//        $qb->andWhere("u.badges like '1|1|1|1|1%'");
//
//        return $qb->getQuery()->getResult();


//        $this->db->update('UPDATE pokemony JOIN sale_pokemon ON sale_pokemon.id_gracza = pokemony.wlasciciel
//                                  SET pokemony.glod = (pokemony.glod + 2.08)
//                                  WHERE pokemony.druzyna = 1 AND pokemony.glod < 100 AND sale_pokemon.Kanto7 = ?', ['0000-00-00']);
//        $this->db->update('UPDATE pokemony JOIN sale_pokemon ON sale_pokemon.id_gracza = pokemony.wlasciciel
//                                  SET pokemony.glod = (pokemony.glod + 1.04)
//                                  WHERE pokemony.druzyna = 1 AND pokemony.glod < 100 AND sale_pokemon.Kanto7 > ?', ['0000-00-00']);
    }
}
