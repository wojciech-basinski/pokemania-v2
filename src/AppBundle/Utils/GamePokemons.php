<?php

namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GamePokemons
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var AuthenticationService
     */
    private $auth;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, AuthenticationService $auth)
    {
        $this->em = $em;
        $this->session = $session;
        $this->auth = $auth;
    }

    public function getPokemonsFromReserveOrdered(User $user)
    {
        return $this->em->getRepository('AppBundle:Pokemon')->getOrderedPokemonsFromReserve($user->getId());
    }

    public function getPokemonsFromWaitingOrdered(User $user)
    {
        return $this->em->getRepository('AppBundle:Pokemon')->getOrderedPokemonsFromWaiting($user->getId());
    }

    public function getPokemonsFromMarketOrdered(User $user)
    {
        return $this->em->getRepository('AppBundle:Pokemon')->getOrderedPokemonsFromMarket($user->getId());
    }

    public function getNumberOfPokemonsInTeam(): int
    {
        $count = 1;
        for ($i = 1; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                $count++;
            }
        }
        return $count;
    }

    public function sendPokemonFromTeamToReserve(int $id, User $user)
    {
        if ($this->getNumberOfPokemonsInTeam() < 2) {
            $this->session->getFlashBag()->add('error', 'W drużynie musi być co najmniej 1 Pokemon.');
            return;
        }
        if ($id < 0 || $id > 5 || !$this->session->get('pokemon'.$id)) {
            $this->session->getFlashBag()->add('error', 'Błędny numer Pokemona');
            return;
        }

        $pokemonId = $this->session->get('pokemon'.$id)->getId();

        $this->em->getRepository('AppBundle:Pokemon')->deletePokemonFromTeam($pokemonId);
        $this->em->getRepository('AppBundle:UserTeam')->deletePokemonFromTeam($id, $user->getId());

        $this->addPokemonsToSessionTeam($user->getId());
        $this->session->getFlashBag()->add('success', 'Poprawnie usunięto Pokemona z drużyny.');
    }

    /**
     * @param array|null $pokemons
     * @param User           $user
     */
    public function sendPokemonsToTeam(?array $pokemons, User $user)
    {
        $pokemonsInTeam = $this->getNumberOfPokemonsInTeam();
        if (!$this->checkPokemonsToTeam($pokemons, $user, $pokemonsInTeam)) {
            return;
        }
        $possibleToTeam = 6 - $pokemonsInTeam;

        if (count($pokemons) > $possibleToTeam) {
            $pokemonsPossibleToTeam = $this->checkWhichPokemonGoToTeam($pokemons, $possibleToTeam);
        } else {
            $pokemonsPossibleToTeam = $pokemons;
        }

        $this->em->getRepository('AppBundle:Pokemon')->addPokemonsToTeam($pokemonsPossibleToTeam);
        $this->em->getRepository('AppBundle:UserTeam')->addPokemonsToTeam(
            $pokemonsPossibleToTeam,
            $pokemonsInTeam,
            $user->getId()
        );

        $this->addPokemonsToSessionTeam($user->getId());
        $this->session->getFlashBag()->add(
            'success',
            'Poprawnie dodano '. count($pokemonsPossibleToTeam) .' Pokemonów do drużyny.'
        );
    }

    public function sendPokemonFromWaitinigToReserve(?array $pokemons, User $user)
    {
        if (!$this->checkPokemonsIfTheyAreUsers($pokemons, $user)) {
            return;
        }
        $this->em->getRepository('AppBundle:Pokemon')->movePokemonsToReserve($pokemons);

        $this->session->getFlashBag()->add(
            'success',
            'Pomyślnie przeniesiono '. count($pokemons) . ' do rezerwy.'
        );
    }

    public function sendPokemonsToWaiting(?array $pokemons, User $user)
    {
        if (!$this->checkPokemonsIfTheyAreUsers($pokemons, $user)) {
            return;
        }
        $this->em->getRepository('AppBundle:Pokemon')->movePokemonsToWaiting($pokemons);

        $this->session->getFlashBag()->add(
            'success',
            'Pomyślnie przeniesiono '. count($pokemons) . ' do poczekalni.'
        );
    }

    public function getOrderUp(int $i, int $userId)
    {
        if ($i < 1 || $i > 5 || !$this->session->get('pokemon'.$i)) {
            $this->session->getFlashBag()->add('error', 'Błędny numer Pokemona');
            return;
        }
        $order = [
          $i => $this->session->get('pokemon'.$i)->getId(),
          $i+1 => $this->session->get('pokemon'.($i-1))->getId()
        ];
        $this->em->getRepository('AppBundle:UserTeam')->changeOrder($order, $userId);
        $this->addPokemonsToSessionTeam($userId);
    }

    public function getOrderDown(int $i, int $userId)
    {
        if ($i < 0 || $i > 4 || !$this->session->get('pokemon'.$i)) {
            $this->session->getFlashBag()->add('error', 'Błędny numer Pokemona');
            return;
        }
        if ($i === ($this->getNumberOfPokemonsInTeam()) - 1) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może mieć mniejszego priorytetu.');
            return;
        }
        $order = [
            $i+1 => $this->session->get('pokemon'.($i+1))->getId(),
            $i+2 => $this->session->get('pokemon'.$i)->getId()
        ];
        $this->em->getRepository('AppBundle:UserTeam')->changeOrder($order, $userId);
        $this->addPokemonsToSessionTeam($userId);
    }

    private function checkWhichPokemonGoToTeam(array $pokemons, int $possibleToTeam)
    {
        $array = [];
        for ($i = 0; $i < $possibleToTeam; $i++) {
            $array[] = $pokemons[$i];
        }
        return $array;
    }

    private function checkPokemons(array $pokemons, User $user): bool
    {
        $reserve = $this->getPokemonsFromReserveAsArrayOfId($user);
        $waiting = $this->getPokemonsFromWaitingAsArrayOfId($user);

        foreach ($pokemons as $pokemon) {
            if (!in_array($pokemon, $reserve) &&
                !in_array($pokemon, $waiting)
            ) {
                return false;
            }
        }
        return true;
    }

    private function getPokemonsFromReserveAsArrayOfId(User $user)
    {
        $array = [];
        foreach ($this->getPokemonsFromReserveOrdered($user) as $pokemon) {
            $array[] = $pokemon->getId();
        }
        return $array;
    }

    private function getPokemonsFromWaitingAsArrayOfId(User $user)
    {
        $array = [];
        foreach ($this->getPokemonsFromWaitingOrdered($user) as $pokemon) {
            $array[] = $pokemon->getId();
        }
        return $array;
    }

    private function checkPokemonsToTeam(?array $pokemons, User $user, int $pokemonsInTeam)
    {
        if ($pokemonsInTeam === 6) {
            $this->session->getFlashBag()->add('error', 'W drużynie może być maksymalnie 6 Pokemonów.');
            return false;
        }
        return $this->checkPokemonsIfTheyAreUsers($pokemons, $user);
    }

    private function addPokemonsToSessionTeam(int $userId)
    {
        $this->clearPokemonsInSession();
        $this->auth->pokemonsToTeam($userId);
    }

    private function clearPokemonsInSession()
    {
        for ($i = 0; $i < 6; $i++) {
            $this->session->remove('pokemon'.$i);
        }
    }

    private function checkPokemonsIfTheyAreUsers(array $pokemons, User $user)
    {
        if ($pokemons === null) {
            $this->session->getFlashBag()->add('error', 'Nie zaznaczono żadnych Pokemonów.');
            return false;
        }
        if (!$this->checkPokemons($pokemons, $user)) {
            $this->session->getFlashBag()->add('error', 'Zaznaczono błędne Pokemony');
            return false;
        }
        return true;
    }
}
