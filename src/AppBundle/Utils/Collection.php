<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Collection
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(EntityManagerInterface $em, PokemonHelper $pokemonHelper, SessionInterface $session)
    {
        $this->em = $em;
        $this->pokemonHelper = $pokemonHelper;
        $this->session = $session;
    }

    public function getUserCollection(User $user): array
    {
        $collection = $user->getCollection()->getCollectionAsArray();

        $kanto = $this->createArrayWithKanto($collection);
        $johto = $this->createArrayWithJohto($collection);

        return [
            'kanto' => $kanto['kanto'],
            'johto' => $johto['johto'],
            'metKanto' => $kanto['met'],
            'caughtKanto' => $kanto['caught'],
            'metShinyKanto' => $kanto['metShiny'],
            'caughtShinyKanto' => $kanto['caughtShiny'],
            'metJohto' => $johto['met'],
            'caughtJohto' => $johto['caught'],
            'metShinyJohto' => $johto['metShiny'],
            'caughtShinyJohto' => $johto['caughtShiny'],
        ];
    }

    public function addOneToPokemonMetAndReturnIfMetAndCaught(int $id, User $user, bool $shiny): array
    {
        $collection = $user->getCollection();

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $metAndCaughtBefore = $newCollection;
        $newCollection[0]++;
        if ($shiny) {
            $newCollection[2]++;
        }
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        return $metAndCaughtBefore;
    }

    private function createArrayWithKanto(array $collection): array
    {
        $metPokemons = 0;
        $caughtPokemons = 0;
        $metShiny = 0;
        $caughtShiny = 0;
        $array = [];
        for ($i = 0; $i < 151; $i++) {
            $exploded = explode(',', $collection[$i]);
            $array['kanto'][] = [
                'id' => $i+1,
                'name' => $this->pokemonHelper->getInfo($i+1)['name'],
                'meet' => $exploded[0],
                'caught' => $exploded[1],
                'meetShiny' => $exploded[2],
                'caughtShiny' => $exploded[3]
            ];
            if ($exploded[0]) {
                $metPokemons++;
            }
            if ($exploded[1]) {
                $caughtPokemons++;
            }
            if ($exploded[2]) {
                $metShiny++;
            }
            if ($exploded[3]) {
                $caughtShiny++;
            }
        }

        return array_merge(
            $array,
            [
                'met' => $metPokemons,
                'caught' => $caughtPokemons,
                'metShiny' => $metShiny,
                'caughtShiny' => $caughtShiny
            ]
        );
    }

    private function createArrayWithJohto(array $collection): array
    {
        $metPokemons = 0;
        $caughtPokemons = 0;
        $metShiny = 0;
        $caughtShiny = 0;
        $array = [];
        for ($i = 151; $i < 251; $i++) {
            $exploded = explode(',', $collection[$i]);
            $array['johto'][] = [
                'id' => $i+1,
                'name' => $this->pokemonHelper->getInfo($i+1)['name'],
                'meet' => $exploded[0],
                'caught' => $exploded[1],
                'meetShiny' => $exploded[2],
                'caughtShiny' => $exploded[3]
            ];
            if ($exploded[0]) {
                $metPokemons++;
            }
            if ($exploded[1]) {
                $caughtPokemons++;
            }
            if ($exploded[2]) {
                $metShiny++;
            }
            if ($exploded[3]) {
                $caughtShiny++;
            }
        }

        return array_merge(
            $array,
            [
                'met' => $metPokemons,
                'caught' => $caughtPokemons,
                'metShiny' => $metShiny,
                'caughtShiny' => $caughtShiny
            ]
        );
    }

    public function addOneToPokemonCatchAndReturnIfMetAndCaught(int $id, User $user, bool $shiny): array
    {
        $collection = $user->getCollection();

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $metAndCaughtBefore = $newCollection;
        if (!$newCollection[1]) {
            $this->session->getFlashBag()->add('success', 'Pierwszy raz łapiesz takiego Pokemona');
        }
        $newCollection[1]++;
        if ($shiny) {
            $newCollection[3]++;
        }
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        return $metAndCaughtBefore;
    }

    public function addOneToPokemonCatchAndMet(int $id, User $user, bool $shiny): void
    {
        $collection = $user->getCollection();

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $newCollection[0]++;
        $newCollection[1]++;
        if ($shiny) {
            $newCollection[2]++;
            $newCollection[3]++;
        }
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        $this->em->persist($collection);
    }

    public function addCatchAndMetToShiny(int $id, User $user)
    {
        $collection = $user->getCollection();

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $newCollection[2]++;
        $newCollection[3]++;
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        $this->em->persist($collection);
    }
}
