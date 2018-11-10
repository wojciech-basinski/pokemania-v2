<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameMerchant
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Session
     */
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @param int $userId
     * @return null|array|Pokemon
     */
    public function getPokemonsAvailableToSell(int $userId)
    {
        return $this->em->getRepository('AppBundle:Pokemon')->getPokemonsAvailableToSell($userId);
    }

    public function sellPokemons(bool $all, User $user, ?array $selected, $confirm)
    {
        if ($all) {
            $this->sellAllPokemons($user, $confirm);
        } else {
            if (null === $selected) {
                $this->session->getFlashBag()->add('error', 'Nie zaznaczono żadnych Pokemonów');
                return;
            }
            $this->sellSelectedPokemons($user, $selected);
        }
        $this->em->flush();
    }

    private function sellAllPokemons(User $user, $confirm)
    {
        $pokemonsAvailableToSell = $this->getPokemonsAvailableToSell($user->getId());
        $pokemonsToSell = [];
        $valueOfPokemons = 0;

        foreach ($pokemonsAvailableToSell as $pokemon) {
            $pokemonsToSell[] = $pokemon->getId();
            $valueOfPokemons += $pokemon->getValue();
        }

        if ($confirm) {
            $this->sellPokemonsFromArray($pokemonsToSell, $valueOfPokemons, $user);
        } else {
            $this->session->getFlashBag()->add('success', 'Czy na pewno chcesz sprzedać wszystkie Pokemony za ' .
                number_format($valueOfPokemons, 0, '', '.') . ' &yen;?
                <br /><button class="potwierdz btn btn-info">Potwierdź</button>');
            return;
        }
    }

    private function sellSelectedPokemons(User $user, ?array $selected)
    {
        $pokemonsAvailableToSell = $this->getPokemonsAvailableToSell($user->getId());

        $pokemonsToSell = [];
        $valueOfPokemons = 0;
        foreach ($pokemonsAvailableToSell as $pokemon) {
            if (in_array($pokemon->getId(), $selected)) {
                $pokemonsToSell[] = $pokemon->getId();
                $valueOfPokemons += $pokemon->getValue();
            }
        }
        $this->sellPokemonsFromArray($pokemonsToSell, $valueOfPokemons, $user);
    }

    public function sellPokemonsFromArray(array $pokemons, int $value, User $user)
    {
        $this->em->getRepository('AppBundle:Pokemon')->deletePokemons($pokemons);
        $user->setCash($user->getCash() + $value);
        $this->session->set('pokemonsInReserve', $this->session->get('pokemonsInReserve') - count($pokemons));
        $this->session->getFlashBag()->add('success', 'Sprzedano ' . count($pokemons) .
            ' Pokemonów za cenę ' . number_format($value, 0, '', '.') . ' &yen;');
    }
}
