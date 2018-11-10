<?php

namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GamePokemon
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    public function __construct(EntityManagerInterface $em, PokemonHelper $pokemonHelper)
    {
        $this->em = $em;
        $this->pokemonHelper = $pokemonHelper;
    }

    public function getPokemonInfo(int $pokemonId, User $user, bool $modal = false): array
    {
        $pokemon[0] = $this->em->getRepository('AppBundle:Pokemon')->find($pokemonId);

        if (!$pokemon[0]) {
            return ['pokemon' => 0, 'isInTeam' => 0, 'isOwner' => 0];
        }

        $isYourPokemon = ($user->getId() == $pokemon[0]->getOwner()) ? 1 : 0;
        if ($modal) {
            $isYourPokemon = 0;
        }

        $isInTeam = $pokemon[0]->getTeam();

        if ($isYourPokemon && $isInTeam) {
            $pokemon = $this->getPokemonsFromTeam($user->getId())['pokemons'];
        }

        foreach ($pokemon as $pokemonn) {
            $pokemonn->setInfo($this->pokemonHelper->getInfo($pokemonn->getIdPokemon()));
        }

        $owner = $this->em->getRepository('AppBundle:User')->find($pokemon[0]->getOwner())->getLogin();

        return [
            'pokemon' => $pokemon,
            'isOwner' => $isYourPokemon,
            'isInTeam' => $isInTeam,
            'owner' => $owner
        ];
    }

    private function getPokemonsFromTeam(int $userId)
    {
        return $this->em->getRepository('AppBundle:Pokemon')->getUsersPokemonsFromTeam($userId);
    }
}
