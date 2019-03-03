<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GameTraining
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
    private $id;
    /**
     * @var int
     */
    private $i;
    /**
     * @var array
     */
    private $pokemonsAndTrainings;

    public function __construct(EntityManagerInterface $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function checkId(int $id): bool
    {
        $this->id = $id;
        $this->i = $this->checkIdInSession($id);
        if ($this->i === null) {
            return false;
        }
        return true;
    }

    public function train(int $pokemonId, int $training, int $value, User $user): void
    {
        if (!$this->checkId($pokemonId)) {
            return;
        }
        $pokemon = $this->session->get('pokemon'.$this->i);
        /** @var Pokemon $pokemon */
        $pokemon = $this->em->merge($pokemon);

        $allTrainingValue = $this->getAllTrainings($pokemon);
        $attachment = $pokemon->getCountedAttachment();
        if ($training < 6) {
            $ValueOfTrainingToCalculate = $pokemon->getTraining()->{'getTr'.$training}();
        } else {
            $ValueOfTrainingToCalculate = $pokemon->getTr6();
        }
        $previouslyCost = $this->calculateTraining($allTrainingValue, $ValueOfTrainingToCalculate -1, $attachment);
        //koszt bez jednego
        $zm = 0;
        $allCost = 0;
        $wyt = 0;
        while ($zm < $value) {
            $attachment = $pokemon->getCountedAttachment();
            $factor = 1;
            if ($attachment > 75) {
                $factor = round((1 - (($attachment - 75) / 100)), 2);
            }
            //TODO
            //if (User::$odznaki->kanto[8]) $factor -= 0.05;
            ////////przywiązanie koniec ///////////////////////////////////

            $newCost = $factor * 500;
            if (($allTrainingValue + $zm) <= 320) {
                $newCost = 40 * $factor * (0.05 * $ValueOfTrainingToCalculate);
            } else {
                $newCost = 40 * $factor * ((0.06 * $ValueOfTrainingToCalculate) + (0.02 * ($allTrainingValue - 320)));
            }
            $newCost = ceil($newCost);
            $previouslyCost += $newCost;
            if ($user->getCash() >= $allCost + $previouslyCost) {
                $pokemon->setAttachment($pokemon->getAttachment() + 1);
                $allCost += $previouslyCost;
                $wyt++;
                $zm++;
                $ValueOfTrainingToCalculate++;
                $allTrainingValue++;
            } else {
                break;
            }
        }
        //echo $allCost;return;
        if ($wyt) {
            $user->setCash($user->getCash() - $allCost);
            $valueAddToPokemon = floor(0.4 * $allCost);
            $pokemon->setValue($pokemon->getValue() + $valueAddToPokemon);
            $exp = 5 * $wyt;
            $pokemon->setExp($pokemon->getExp() + $exp);
            if ($training < 6) {
                $pokemon->getTraining()->{'setTr'.$training}($pokemon->getTraining()->{'getTr'.$training}() + $wyt);
            } else {
                $pokemon->setTr6($pokemon->getTr6() + $wyt);
                $pokemon->setActualHp($pokemon->getActualHp() + $wyt * 5);
            }
            $this->addTreningsToStatistics($wyt, $user);
            $this->em->persist($pokemon);
            $this->em->flush();
            $this->session->set('pokemon'.$this->i, $pokemon);
            //$this->view->info = '<div class="alert alert-success"><span>Wytrenowano ' . $wyt . ' ' . $opis['o' . $this->co] . ' Koszt: <span class="pogrubienie">' . number_format($l_koszt, 0, '', '.') . ' &yen;</span><br />Pokemon otrzymuje ' . $exp . ' pkt. doświadczenia.</span></div>';
        } else {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na trening');
        }//$this->view->blad = '<div class="alert alert-danger"><span>!</span></div>';
    }

    public function getPokemons(int $userId): array
    {
        $this->pokemonsAndTrainings = $this->em->getRepository('AppBundle:Pokemon')->getUsersPokemonsFromTeam($userId);
        return $this->pokemonsAndTrainings;
    }

    public function calculateTrainings(array $pokemons): array
    {
        $trainings = [];
        foreach ($this->pokemonsAndTrainings['pokemons'] as $pokemon) {
            $allTrainingsValue = $this->getAllTrainings($pokemon);
            $attachment = $pokemon->getCountedAttachment();
            $trainings[] = [
                'tr1' => [
                    'value' => $pokemon->getTraining()->getTr1(),
                    'all' => $pokemon->getTraining()->getTr1() + $pokemon->getTraining()->getBerryAttack() +
                        round($pokemon->getAttack() * $pokemon->getQuality() / 100),
                    'description' => 'Atak',
                    'cost' => $this->calculateTraining($allTrainingsValue, $pokemon->getTraining()->getTr1(), $attachment)
                ],
                'tr2' => [
                    'value' => $pokemon->getTraining()->getTr2(),
                    'all' => $pokemon->getTraining()->getTr2() + $pokemon->getTraining()->getBerrySpAttack() +
                        round($pokemon->getSpAttack() * $pokemon->getQuality() / 100),
                    'description' => 'Sp. Atak',
                    'cost' => $this->calculateTraining($allTrainingsValue, $pokemon->getTraining()->getTr2(), $attachment)
                ],
                'tr3' => [
                    'value' => $pokemon->getTraining()->getTr3(),
                    'all' => $pokemon->getTraining()->getTr3() + $pokemon->getTraining()->getBerryDefence() +
                        round($pokemon->getDefence() * $pokemon->getQuality() / 100),
                    'description' => 'Obrona',
                    'cost' => $this->calculateTraining($allTrainingsValue, $pokemon->getTraining()->getTr3(), $attachment)
                ],
                'tr4' => [
                    'value' => $pokemon->getTraining()->getTr4(),
                    'all' => $pokemon->getTraining()->getTr4() + $pokemon->getTraining()->getBerrySpDefence() +
                        round($pokemon->getSpDefence() * $pokemon->getQuality() / 100),
                    'description' => 'Sp. Obrona',
                    'cost' => $this->calculateTraining($allTrainingsValue, $pokemon->getTraining()->getTr4(), $attachment)
                ],
                'tr5' => [
                    'value' => $pokemon->getTraining()->getTr5(),
                    'all' => $pokemon->getTraining()->getTr5() + $pokemon->getTraining()->getBerrySpeed() +
                        round($pokemon->getSpeed() * $pokemon->getQuality() / 100),
                    'description' => 'Szybkość',
                    'cost' => $this->calculateTraining($allTrainingsValue, $pokemon->getTraining()->getTr5(), $attachment)
                ],
                'tr6' => [
                    'value' => $pokemon->getTr6() * 5,
                    'all' => $pokemon->getHpToTable(),
                    'description' => 'HP',
                    'cost' => $this->calculateTraining($allTrainingsValue, $pokemon->getTr6(), $attachment)
                ],

            ];
        }
        return $trainings;
    }

    public function changeAttack(int $id, int $attackId, int $whichChange): void
    {
        if (!$this->checkId($id)) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return;
        }
        /** @var Pokemon $pokemon */
        $pokemon = $this->session->get('pokemon'.$this->i);
        $pokemon = $this->em->merge($pokemon);

        $attackArray = $pokemon->getInfo()['attackArray'];
        $attackI = $this->checkAttack($attackId, $attackArray);

        if ($attackI < 0) {
            $this->session->getFlashBag()->add('error', 'Błędny ID ataku');
            return;
        }
        if ($pokemon->hasAttack($attackId)) {
            $this->session->getFlashBag()->add('error', 'Pokemon umie już ten atak');
            return;
        }
        if (!$this->checkLevelPokemonToChangeAttack($attackArray[$attackI], $pokemon->getLevel())) {
            $this->session->getFlashBag()->add('error', 'Zbyt niski poziom Pokemona, aby nauczyć go tego ataku');
            return;
        }
        if ($whichChange < 0 || $whichChange > 3) {
            $this->session->getFlashBag()->add('error', 'Wybrano zły priorytet ataku');
            return;
        }
        $this->session->getFlashBag()->add('success', 'Pokemon nauczył się nowego ataku');
        $pokemon->{'setAttack'.$whichChange}($attackId);
        $this->session->set('pokemon'.$this->i, $pokemon);
        $this->em->persist($pokemon);
        $this->em->flush();
    }

    private function checkIdInSession(int $id): ?int
    {
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i) && $this->session->get('pokemon'.$i)->getId() === $id) {
                return $i;
            }
        }
        return null;
    }

    private function calculateTraining(int $all, int $training, float $attachment): int
    {
        $factor = 1;
        if ($attachment > 75) {
            $factor = round((1 - (($attachment - 75) / 100)), 2);
        }
        //TODO
        //if (User::$odznaki->kanto[8]) $factor -= 0.05;
        $cost = $factor * 500;
        $all -= $training;
        for ($k = 0; $k <= $training; $k++) {
            if (($all + $k) <= 320) {
                $newCost = 40 * $factor * (0.05 * $k);
            } else {
                $newCost = 40 * $factor * ((0.06 * $k) + (0.02 * ($all - 320)));
            }
            $newCost = ceil($newCost);
            $cost += $newCost;
        }
        return $cost;
    }

    private function getAllTrainings(Pokemon $pokemon): int
    {
        return $pokemon->getTraining()->getTr1() + $pokemon->getTraining()->getTr2() + $pokemon->getTraining()->getTr3() +
            $pokemon->getTraining()->getTr4() + $pokemon->getTraining()->getTr5() + $pokemon->getTr6();
    }

    private function checkAttack(int $attackId, array $attackArray): int
    {
        $count = count($attackArray);
        for ($i = 0; $i < $count; $i++) {
            if ($attackId === (int)$attackArray[$i]['id']) {
                return $i;
            }
        }
        return -1;
    }

    private function checkLevelPokemonToChangeAttack(array $attackArray, int $level): bool
    {
        return $attackArray['level'] <= $level;
    }

    private function addTreningsToStatistics(int $wyt, User $user): void
    {
        $stats = $this->em->find('AppBundle:Achievement', $user->getId());
        $stats->setTrainingsWithPokemons($stats->getTrainingsWithPokemons() + $wyt);
    }
}
