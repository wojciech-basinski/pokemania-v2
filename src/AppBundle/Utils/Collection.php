<?php
namespace AppBundle\Utils;

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

    public function getUserCollection(int $userId): array
    {
        $collection = $this->em->getRepository('AppBundle:Collection')
                        ->find($userId)
                        ->getCollectionAsArray();

        $kanto = $this->createArrayWithKanto($collection);
        $johto = $this->createArrayWithJohto($collection);

        return [
            'kanto' => $kanto['kanto'],
            'johto' => $johto['johto'],
            'metKanto' => $kanto['met'],
            'caughtKanto' => $kanto['caught'],
            'metJohto' => $johto['met'],
            'caughtJohto' => $johto['caught']
        ];
    }

    public function addOneToPokemonMetAndReturnIfMetAndCaught(int $id, int $userId): array
    {
        $collection = $this->em->getRepository('AppBundle:Collection')
                        ->find($userId);

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $metAndCaughtBefore = $newCollection;
        $newCollection[0]++;
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        $this->em->persist($collection);
        return $metAndCaughtBefore;
    }

    private function createArrayWithKanto(array $collection): array
    {
        $metPokemons = 0;
        $caughtPokemons = 0;
        $array = [];
        for ($i = 0; $i < 151; $i++) {
            $exploded = explode(',', $collection[$i]);
            $array['kanto'][] = [
                'id' => $i+1,
                'name' => $this->pokemonHelper->getInfo($i+1)['nazwa'],
                'meet' => $exploded[0],
                'caught' => $exploded[1]
            ];
            if ($exploded[0]) {
                $metPokemons++;
            }
            if ($exploded[1]) {
                $caughtPokemons++;
            }
        }

        return array_merge($array, ['met' => $metPokemons, 'caught' => $caughtPokemons]);
    }

    private function createArrayWithJohto(array $collection): array
    {
        $metPokemons = 0;
        $caughtPokemons = 0;
        $array = [];
        for ($i = 151; $i < 251; $i++) {
            $exploded = explode(',', $collection[$i]);
            $array['johto'][] = [
                'id' => $i+1,
                'name' => $this->pokemonHelper->getInfo($i+1)['nazwa'],
                'meet' => $exploded[0],
                'caught' => $exploded[1]
            ];
            if ($exploded[0]) {
                $metPokemons++;
            }
            if ($exploded[1]) {
                $caughtPokemons++;
            }
        }

        return array_merge($array, ['met' => $metPokemons, 'caught' => $caughtPokemons]);
    }

    public function addOneToPokemonCatchAndReturnIfMetAndCaught(int $id, int $userId): array
    {
        $collection = $this->em->getRepository('AppBundle:Collection')
            ->find($userId);

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $metAndCaughtBefore = $newCollection;
        if (!$newCollection[1]) {
            $this->session->getFlashBag()->add('success', 'Pierwszy raz łapiesz takiego Pokemona');
        }
        $newCollection[1]++;
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        $this->em->persist($collection);
        return $metAndCaughtBefore;
    }

    public function addOneToPokemonCatchAndMet(int $id, int $userId): void
    {
        $collection = $this->em->getRepository('AppBundle:Collection')
            ->find($userId);

        $collectionArray = $collection->getCollectionAsArray();
        $newCollection = explode(',', $collectionArray[$id-1]);
        $newCollection[0]++;
        $newCollection[1]++;
        $collectionArray[$id-1] = implode(',', $newCollection);

        $collection->setCollection(implode(';', $collectionArray));
        $this->em->persist($collection);
    }
}
