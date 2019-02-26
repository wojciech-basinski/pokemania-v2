<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameHospital
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
     * @var int
     */
    private $cost = 0;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function getPokemonsToView(User $user): array
    {
        $pokemons = [];
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                $pokemons[] = [
                    'cost' => $this->generateCostOfHealing($user, $this->session->get('pokemon'.$i)),
                    'i' => $i
                ];
            }
        }
        return $pokemons;
    }

    public function healOnePokemon(User $user, int $i, bool $allFlashAsOne = false): bool
    {
        if ($this->session->get('pokemon'.$i)) {
            $pokemon = $this->session->get('pokemon'.$i);

            if ($pokemon->getActualHp() === $pokemon->getHpToTable()) {
                if (!$allFlashAsOne) {
                    $this->session->getFlashBag()->add('success', 'Pokemon nie wymaga leczenia');
                }
                return 1;
            } else {
                $pokemon = $this->em->merge($pokemon);
                $cost = $this->generateCostOfHealing($user, $pokemon);
                if ($user->getCash() >= $cost) {
                    $user->setCash($user->getCash() - $cost);
                    $this->em->persist($user);
                    $pokemon->setActualHp($pokemon->getHpToTable());
                    $this->em->persist($pokemon);
                    if (!$allFlashAsOne) {
                        $this->session->getFlashBag()->add('success', 'Pokemon wyleczony. Koszt '.$cost.' ¥');
                    }
                    $this->cost += $cost;
                    $this->session->set('pokemon'.$i, $pokemon);
                    return 1;
                } else {
                    if (!$allFlashAsOne) {
                        $this->session->getFlashBag()->add('error', 'Nie stać Cię na leczenie Pokemonów');
                    }
                    return 0;
                }
            }
        }
        return 1;
    }

    public function healAllPokemons(User $user)
    {
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                if (!$this->healOnePokemon($user, $i, 1)) {
                    if (!$i) {
                        $this->session->getFlashBag()->add('error', 'Nie stać Cię na leczenie Pokemonów.');
                    } else {
                        $this->session->getFlashBag()->add('success', 'Wyleczono nie wszystkie Pokemony. Łączny koszt '. $this->cost . ' ¥');
                    }
                    $this->em->flush();
                    return;
                }
            }
        }
        if ($this->cost) {
            $this->session->getFlashBag()->add('success', 'Pokemony wyleczone. Łączny koszt '. $this->cost . ' ¥');
        } else {
            $this->session->getFlashBag()->add('success', 'Pokemony nie wymagają leczenia.');
        }
        $this->em->flush();
    }

    public function healPokemon(User $user, int $i)
    {
        $this->healOnePokemon($user, $i);
        $this->em->flush();
    }

    private function generateCostOfHealing(User $user, Pokemon $pokemon): int
    {
        if ($pokemon->getActualHp() === $pokemon->getHpToTable() || $user->getTrainerLevel() <= 10) {
            $cost = 0;
        } else {
            $cost = ceil(
                ((900 * $pokemon->getLevel()) * 0.35)
                * (1 - ($pokemon->getHpToTable() / $pokemon->getHp()))
                * ($pokemon->getLevel() / 90)
            );

            if ($this->session->get('userSession')->getUserItems()->getKit() > 0) {
                $cost *= (1 - ($this->session->get('userSession')->getUserItems()->getKit() / 10));
                $cost = floor($cost);
            }
            /*if (User::$odznaki->kanto[5]) {
                $cost *= 0.9;
                $cost = floor($cost);
            }*/
            if ($user->getTrainerLevel() > 10 && $user->getTrainerLevel() <= 20) {
                $cost = ceil($cost / 2);
            }
        }

        return $cost;
    }
}
