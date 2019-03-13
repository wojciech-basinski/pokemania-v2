<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Pokeball;
use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameHuntingCatch
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
     * @var GameShop
     */
    private $shop;
    /**
     * @var Pokemon|null
     */
    private $pokemon;
    /**
     * @var Collection
     */
    private $collection;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    public function __construct(
        EntityManagerInterface $em,
        SessionInterface $session,
        GameShop $shop,
        Collection $collection,
        PokemonHelper $pokemonHelper
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->shop = $shop;
        $this->pokemon = $this->session->get('pokemonHunting');
        $this->collection = $collection;
        $this->pokemonHelper = $pokemonHelper;
    }

    public function getPokeballs(int $userId): Pokeball
    {
        return $this->shop->getPokeballs($userId);
    }

    public function catch(string $pokeball, User $user): void
    {
        if (!$this->pokemon || $this->pokemon->getInfo()['difficulty'] === 10) {
            $this->session->getFlashBag()->add('error', 'Nie możesz złapać tego Pokemona');
            return;
        }
        if (!$this->checkPokeballs($user->getId(), $pokeball)) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz '.$pokeball);
            return;
        }

        $baseRate = $this->calculateBaseRate($this->pokemon->getLevel(), $this->pokemon->getInfo()['difficulty']);

        $rate = $this->calculateOtherThings($baseRate, $pokeball, $user);
        $catched = $this->draw($rate);

        if ($catched) {
            if ($this->catchPokemon($user, $pokeball)) {
                $this->session->getFlashBag()->add('success', 'Udało Ci się złapać <span class="pogrubienie">'.$this->pokemon->getName().'</span>');
            }
            $this->deletePokemonFromSession();
            $this->deleteRepeatballFromSession();
            $this->addStatistics($user->getId(), $pokeball, $this->pokemon->getShiny());
            $this->addExpToUser($user, $this->pokemon->getInfo()['difficulty']);
        } elseif ($pokeball === 'Repeatball') {
            $this->session->getFlashBag()->add('info', 'Repeatball ogłuszył Pokemona, masz szansę rzucić w niego kolejny pokeball');
        } else {
            $this->session->getFlashBag()->add('error', 'Niestety Pokemon uwolnił się i uciekł');
            $this->deleteRepeatballFromSession();
            $this->deletePokemonFromSession();
        }

        $this->em->flush();
    }

    private function calculateBaseRate(int $level, int $difficulty): float
    {
        if ($level === 1 && $difficulty === 1) {
            return 19;
        } elseif ($level === 1) {
            return 19 / ($difficulty * 0.75);
        } elseif ($difficulty === 1) {
            return 19 - ($level * 0.19);
        }
        return (19 - ($level * 0.19)) / ($difficulty * 0.75);
    }

    private function calculateOtherThings(int $rate, string $pokeball, User $user): float
    {
        if ($pokeball === "Repeatball") {
            $change = $this->session->get('huntingChangeRepeatball');
            if ($change) {
                if ($change < 26) {
                    $rate *= (1.70 - 0.05 * $change);
                }
            } else {
                $rate *= 1.70;
            }
            $this->session->set('huntingChangeRepeatball', $change+1);
        } elseif ($pokeball === "Nestball") {
            if ($this->pokemon->getLevel() < 16) {
                if ($this->pokemon->getInfo()['difficulty'] === 1) {
                    $rate = 50 - ($this->pokemon->getLevel() * 0.1);
                } else {
                    $rate = (55 - ($this->pokemon->getLevel() * 0.1)) / ($this->pokemon->getInfo()['difficulty'] * 0.8);
                }
            } else {
                if ($this->pokemon->getInfo()['difficulty'] === 1) {
                    $rate = 30 - ($this->pokemon->getLevel() * 0.4);
                } else {
                    $rate = (25 - ($this->pokemon->getLevel() * 0.4)) / ($this->pokemon->getInfo()['difficulty'] * 0.8);
                }
            }
        } elseif ($pokeball === "Greatball") {
            $rate *= 2;
        } elseif ($pokeball === "Ultraball") {
            $rate *= 4;
        } elseif ($pokeball === "Lureball") {
            /*if ((Session::_get('pokemon')['typ1'] == Session::_get('twojpok')['typ1'] || Session::_get('pokemon')['typ1'] == Session::_get('twojpok')['typ2'])
                || (Session::_get('pokemon')['typ2'] == Session::_get('twojpok')['typ1'] || Session::_get('pokemon')['typ2'] == Session::_get('twojpok')['typ2'])
            )
                $rate *= 4;*/
        } elseif ($pokeball === "Duskball") {
            $hour = date('G');
            if ($hour > 21 || $hour < 6) {
                $rate *= 3;
            }
        } elseif ($pokeball === "Cherishball") {
            $rate *= 7;
        } elseif ($pokeball === "Safariball") {
            $rate *= 1.7;
        }

        if ($this->session->get('userSession')->getUserSkills()->getCatchingSkill()) {
            $rate *= (1 + ($this->session->get('userSession')->getUserSkills()->getCatchingSkill() / 10));
        }

        if ($this->pokemon->getInfo()['difficulty'] > 4) {
            $rate *= 0.75;
        } elseif ($this->pokemon->getLevel() <= 20 && $this->pokemon->getInfo()['difficulty'] === 1 &&
            $this->pokemon->getInfo()['difficulty'] <= 4) {
            $rate *= 1.5;
        } elseif ($this->pokemon->getLevel() <= 20 && $this->pokemon->getInfo()['difficulty'] !== 1 &&
            $this->pokemon->getInfo()['difficulty'] <= 4) {
            $rate *= 1.19;
        }


        if ($this->session->get('userSession')->getUserItems()->getPokedex()) {
            $rate *= (1 + ($this->session->get('userSession')->getUserItems()->getPokedex() / 10));
        }/*
    //TODO
        if (User::$odznaki->kanto[3]) $szansa *= 1.1;
        */

        $rand = rand(90, 105) / 100;
        $rate = $rate * $rand;
        if ($this->pokemon->getLevel() > 50) {
            $rate /= 2;
        }
        if ($rate < 3) {
            $rate = 3;///minimalna szansa zlapania
        }
        if ($rate > 85) {
            $rate = 85;///maksymalna szansa zlapania (nie licząc mastera)
        }

        $rate = round($rate * 100);
        if ($pokeball === "Masterball") {
            $rate = 100 * 100;
        }
        return $rate;
    }

    private function draw(float $rate): bool
    {
        $draw = mt_rand(0, 10000);
        return $draw <= $rate;
    }

    private function catchPokemon(User $user, string $pokeball): bool
    {
        if (!$this->checkMagazine($user, $this->pokemon->getShiny())) {
            return false;
        }
        $this->collection->addOneToPokemonCatchAndReturnIfMetAndCaught($this->pokemon->getIdPokemon(), $user->getId());
        if ($this->pokemon->getShiny()) {
            $pokemon = $this->pokemonHelper->generatePokemon($this->pokemon->getIdPokemon(), 1, true);
            $pokemon->getTraining()->setBerryLimit(rand(50, 75) * 5);
            $pokemon->setOwner($user->getId());
            $pokemon->setFirstOwner($user->getId());
            $pokemon->setDateOfCatch(new \DateTime());
            $pokemon->setDescription('');
            $pokemon->setCatched($pokeball);
            $pokemon->setActualHp(0);

            $user->setShinyCatched(1);
            $this->em->getRepository('AppBundle:Shiny')->addCaught($user->getRegion());
            $this->em->persist($pokemon);
            return true;
        }

        $this->pokemon->getTraining()->setBerryLimit(rand(50, 75) * 5);

        $this->pokemon->setOwner($user->getId());
        $this->pokemon->setFirstOwner($user->getId());
        $this->pokemon->setDateOfCatch(new \DateTime());
        $this->pokemon->setDescription('');
        $this->pokemon->setCatched($pokeball);
        $this->pokemon->setActualHp(0);

        $this->em->persist($this->pokemon);
        return true;
    }

    private function checkMagazine(User $user, bool $shiny = false): bool
    {
        $magazine = $this->session->get('userSession')->getPokemonInReserve();
        $maxMagazine = $user->getMagazine();
        if ($magazine >= $maxMagazine && $shiny === false) {
            $this->session->getFlashBag()->add(
                'success',
                'Udało Ci się złapać <span class="pogrubienie">'.$this->pokemon->getName().'</span>
                <br />Niestety nie posiadasz miejsca w magazynie, więc sprzedajesz Pokemona za '.$this->pokemon->getValue().'&yen;'
            );
            $user->setCash($user->getCash() + $this->pokemon->getValue());
            return false;
        }
        $this->session->get('userSession')->setPokemonInReserve(++$magazine);
        return true;
    }

    private function checkPokeballs(int $userId, string $pokeball): bool
    {
        $pokeballs = $this->em->getRepository('AppBundle:Pokeball')->find($userId);

        if (method_exists($pokeballs, 'get'.$pokeball.'s')) {
            $pokeballQuantity = $pokeballs->{'get'.$pokeball.'s'}();
            if (!$pokeballQuantity) {
                return false;
            }
            $pokeballs->{'set'.$pokeball.'s'}(--$pokeballQuantity);
            return true;
        } else {
            return false;
        }
    }

    private function deleteRepeatballFromSession(): void
    {
        $this->session->remove('huntingChangeRepeatball');
    }

    private function deletePokemonFromSession(): void
    {
        $this->session->remove('pokemonHunting');
    }

    private function addStatistics(int $userId, string $pokeball, bool $shiny): void
    {
        $this->em->getRepository('AppBundle:Statistic')->addCatchedOnePokemon($userId);
        if ($shiny) {
            $this->em->getRepository('AppBundle:Achievement')->addCatchedOneShiny($userId, $pokeball);
            return;
        }
        if ($pokeball !== 'Masterball') {
            $this->em->getRepository('AppBundle:Achievement')->addCatchedOnePokemon($userId, $pokeball);
        }
    }

    private function addExpToUser(User $user, int $difficulty): void
    {
        if ($difficulty < 4) {
            $exp = 1;
        } else {
            $exp = 2;
        }
        $user->setExperience($user->getExperience() + $exp);
        $this->session->getFlashBag()->add('info', 'W nagrodę otrzymujesz '.$exp.' PD trenera');
    }
}
