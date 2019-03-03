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
     * @return array
     */
    public function getPokemonsAvailableToSell(int $userId): array
    {
        return $this->em->getRepository('AppBundle:Pokemon')->getPokemonsAvailableToSell($userId);
    }

    public function sellPokemons(bool $all, User $user, ?array $selected, $confirm): void
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

    private function sellAllPokemons(User $user, $confirm): void
    {
        $pokemonsAvailableToSell = $this->getPokemonsAvailableToSell($user->getId());
        $pokemonsToSell = [];
        $valueOfPokemons = 0;

        foreach ($pokemonsAvailableToSell as $pokemon) {
            $pokemonsToSell[] = $pokemon;
            $valueOfPokemons += $pokemon->getValue();
        }

        if ($confirm) {
            $this->sellPokemonsFromArray($pokemonsToSell, $valueOfPokemons, $user);
        } else {
            $this->session->getFlashBag()
                ->add('success', 'Czy na pewno chcesz sprzedać wszystkie Pokemony za ' .
                number_format($valueOfPokemons, 0, '', '.') . ' &yen;?
                <br /><button class="potwierdz btn btn-info">Potwierdź</button>');
            return;
        }
    }

    private function sellSelectedPokemons(User $user, ?array $selected): void
    {
        $pokemonsAvailableToSell = $this->getPokemonsAvailableToSell($user->getId());

        $pokemonsToSell = [];
        $valueOfPokemons = 0;
        foreach ($pokemonsAvailableToSell as $pokemon) {
            if (in_array($pokemon->getId(), $selected)) {
                $pokemonsToSell[] = $pokemon;
                $valueOfPokemons += $pokemon->getValue();
            }
        }
        $this->sellPokemonsFromArray($pokemonsToSell, $valueOfPokemons, $user);
    }

    public function sellPokemonsFromArray(array $pokemons, int $value, User $user): void
    {
        $count = count($pokemons);
        $this->em->getRepository('AppBundle:Pokemon')->deletePokemons($pokemons);
        $user->setCash($user->getCash() + $value);
        $this->session->get('userSession')->setPokemonInReserve(
            $this->session->get('userSession')->getPokemonInReserve() - $count
        );
        $this->session->getFlashBag()->add('success', 'Sprzedano ' . $count .
            ' Pokemonów za cenę ' . number_format($value, 0, '', '.') . ' &yen;');
    }
}
