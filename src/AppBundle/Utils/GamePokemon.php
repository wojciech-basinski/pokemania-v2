<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    /**
     * @var Session
     */
    private $session;

    public function __construct(EntityManagerInterface $em, PokemonHelper $pokemonHelper, SessionInterface $session)
    {
        $this->em = $em;
        $this->pokemonHelper = $pokemonHelper;
        $this->session = $session;
    }

    public function feedPokemon(int $id, ?User $user, string $ip): void
    {
        $pokemon = $this->findPokemon($id);

        if ($pokemon === null) {
            $this->session->getFlashBag()->add('error', 'Pokemon nie znaleziony.');
            return;
        }
        if ($user && $pokemon->getOwner() === $user->getId()) {
            $this->session->getFlashBag()->add('error', 'Nie możesz nakarmić własnego Pokemona.');
            return;
        }

        $owner = $this->em->getRepository(User::class)->find($pokemon->getOwner());
        if ($this->checkIfFeededToday($owner, $ip)) {
            $this->session->getFlashBag()->add('error', 'Karmiłeś już dzisiaj Pokemony tego gracza.');
            return;
        }

        if ($this->getCountOfFeeders($owner) > 50) {
            $this->session->getFlashBag()->add('error', 'Pokemon jest już najedzony i nie może przyjąć kolejnego posiłku.');
            return;
        }
        $feeded = $owner->getPokemonFeededIp() . '|' . $ip;
        $owner->setPokemonFeededIp($feeded);
        $owner->setPokemonFeeded(true);
        $this->em->getRepository(Pokemon::class)->feedPokemonByOtherUser($owner->getId());
        $this->em->persist($owner);
        $this->em->flush();
        $this->session->getFlashBag()->add('success', 'Pokemon z chęcią zjada zaoferowany posiłek.');
    }

    public function getPokemonInfo(int $pokemonId, ?User $user, bool $modal = false): array
    {
        $pokemon[0] = $this->findPokemon($pokemonId);

        if (!$pokemon[0]) {
            return ['pokemon' => 0, 'isInTeam' => 0, 'isOwner' => 0, 'owner' => 0];
        }

        $isYourPokemon = $this->isYourPokemon($user, $pokemon);
        if ($modal) {
            $isYourPokemon = 0;
        }
        if (!$isYourPokemon && $pokemon[0]->getBlockView()) {
            return ['pokemon' => -1, 'isInTeam' => 0, 'isOwner' => 0, 'owner' => 0];
        }

        $isInTeam = $pokemon[0]->getTeam();

        if ($isYourPokemon && $isInTeam) {
            $pokemon = $this->getPokemonsFromTeam($user->getId())['pokemons'];
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

    private function findPokemon(int $id): ?Pokemon
    {
        return $this->em->getRepository(Pokemon::class)->find($id);
    }

    private function checkIfFeededToday(User $owner, string $ip): bool
    {
        $feedingIps = explode('|', $owner->getPokemonFeededIp());
        $count = count($feedingIps);
        for($i = 0 ; $i < $count ; $i++) {
            if($feedingIps[$i] === $ip) {
                return true;
            }
        }
        return false;
    }

    private function getCountOfFeeders(User $owner): int
    {
        return count(explode('|', $owner->getPokemonFeededIp()));
    }

    private function isYourPokemon(?User $user, array $pokemon): bool
    {
        if ($user === null) {
            return false;
        }
        return ($user->getId() === $pokemon[0]->getOwner()) ? 1 : 0;
    }
}
