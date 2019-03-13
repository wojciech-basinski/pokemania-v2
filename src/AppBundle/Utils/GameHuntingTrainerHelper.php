<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GameHuntingTrainerHelper
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
     * @var User
     */
    private $user;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;
    /**
     * @var int[]
     */
    private $tableWithLevelTrainersPokemons = [];
    /**
     * @var Pokemon[]
     */
    private $trainersPokemons;
    /**
     * @var int[]
     */
    private $userTable = [];
    /**
     * @var GameHuntingBattleBetweenPokemons
     */
    private $battle;

    public function __construct(EntityManagerInterface $em, Session $session, PokemonHelper $pokemonHelper, GameHuntingBattleBetweenPokemons $battle)
    {
        $this->em = $em;
        $this->session = $session;
        $this->pokemonHelper = $pokemonHelper;
        $this->battle = $battle;
    }

    public function getTrainerPokemons()
    {
        return $this->trainersPokemons;
    }

    public function trainer(User $user)
    {
        $this->user = $user;
        $howManyPokemonsTrainer = $this->getHowManyTrainersPokemons($user->getTrainerLevel());
        $usersPokemons = 0;
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon' . $i) && $this->session->get('pokemon' . $i)->getActualHp() > 0
                && $this->session->get('pokemon' . $i)->getHunger() <= 90) {
                $usersPokemons++;
            }
        }
        $this->trainersPokemons = $this->generateTrainerPokemons($user, $howManyPokemonsTrainer);
        $battleInfo = $this->trainerBattle($usersPokemons);

        for ($i = 0; $i < 5; $i++) {
            if (isset($this->userTable[$i]) && $this->userTable[$i]) {
                $pokemon = $this->em->merge($this->session->get('pokemon'.$i));
                $this->em->persist($pokemon);
            }
        }
        $this->em->flush();


        return $battleInfo;
    }

    private function generateTrainerPokemons(User $user, int $howMany): array
    {
        $trainerPokemons = [];
        for ($i = 0; $i < $howMany; $i++) {
            $trainerPokemons[] = $this->generatePokemonTrainer();
        }
        return $trainerPokemons;
    }

    private function getHowManyTrainersPokemons(int $level): int
    {
        if ($level < 10) {
            return 1;
        } elseif ($level < 17) {
            return 2;
        } elseif ($level < 24) {
            return 3;
        } elseif ($level < 31) {
            return 4;
        } elseif ($level < 38) {
            return 5;
        } else {
            return 6;
        }
    }

    private function generatePokemonTrainer()
    {
        $minLevel = 1000000;
        while ($minLevel > ($this->user->getTrainerLevel() + 5)) {
            switch ($this->user->getRegion()) {
                case 1:
                    $pokemonId = mt_rand(1, 151);
                    break;
                case 2:
                    $pokemonId = mt_rand(152, 251);
                    break;
            }
            if (in_array($pokemonId, [132, 144, 145, 146, 150, 151])) {
                continue;
            }
            $pokemonInfo = $this->pokemonHelper->getInfo($pokemonId);
            $minLevel = $pokemonInfo['minLevel'];
        }
        if ($this->user->getTrainerLevel() < 21) {
            $pokemonLevel = mt_rand(1, ($this->user->getTrainerLevel() + 5));
        } elseif ($pokemonInfo['minLevel'] > ($this->user->getTrainerLevel() - 10)) {
            $pokemonLevel = mt_rand($pokemonInfo['minLevel'], $this->user->getTrainerLevel() + 5);
        } else {
            if ($this->user->getTrainerLevel() >= 95) {
                $pokemonLevel = mt_rand(80, 100);
            } else {
                $pokemonLevel = mt_rand(($this->user->getTrainerLevel() - 20), ($this->user->getTrainerLevel() + 5));
            }
        }
        $this->tableWithLevelTrainersPokemons[] = $pokemonLevel;
        $pokemon = $this->pokemonHelper->generatePokemon($pokemonId, $pokemonLevel);
        if (mt_rand(1, 40) >= 38) {
            $pokemon->setShiny(1);
        }

        return $pokemon;
    }

    private function trainerBattle(int $userPokemonCount)
    {
        $lose = 0;
        $userPokemonInSessionId = 0;
        $userUsedPokemons = 0;
        $trainerUsedPokemons = 0;
        $userPokemonInUse = null;
        $trainerPokemonInUse = null;
        while (1) {
            if (!$userPokemonInUse) {
                $i = 0;
                while (1) {
                    if ($this->session->get('pokemon' . $i) &&
                        ($this->session->get('pokemon' . $i)->getActualHp() > 0 &&
                            $this->session->get('pokemon' . $i)->getHunger() <= 90)) {
                        $this->userTable[$i] = 1;
                        break;
                    } elseif ($i >= 6) {
                        break;
                    }
                    $i++;
                }
                $userUsedPokemons++;
//                echo $userUsedPokemons,':',$userPokemonCount,'<br />';
                if ($userUsedPokemons > $userPokemonCount) {
                    $lose = 1;
                    break;
                }
                $stan1 = 0;
                $dos2 = 0;
                $at1 = 1;
                $pok_runda1 = 0;
                $userPokemonInSessionId = $i;
                $userPokemonInUse = $this->em->merge($this->session->get('pokemon' . $userPokemonInSessionId));
                $statsPokemonUser = new PokemonStatsInBattle();
            }
            if (!$trainerPokemonInUse) {
                $trainerUsedPokemons++;
//                echo 'trainer pokemons: ', count($this->trainersPokemons), 'Used: ' . $trainerUsedPokemons, '<br />';
                if ($trainerUsedPokemons > count($this->trainersPokemons)) {
                    break;
                }
                $stan1 = 0;
                $dos2 = 0;
                $at1 = 1;
                $pok11 = 1;
                $pok_runda1 = 0;
                $trainerPokemonInUse = $this->trainersPokemons[$trainerUsedPokemons - 1];
                $statsPokemonTrainer = new PokemonStatsInBattle();
            }


//            echo '<pre>';
//            print_r($userPokemonInUse);die;
            $presentation = $this->presentation($userPokemonInUse, $trainerPokemonInUse);
            $battle = $this->battle->trainerBattle($userPokemonInUse, $trainerPokemonInUse, $this->user, $statsPokemonUser, $statsPokemonTrainer, $presentation);
            $userPokemonInUse = $this->battle->getUserPokemon();
            $statsPokemonUser = $this->battle->getUserPokemonStats();
            $trainerPokemonInUse = $this->battle->getTrainerPokemon();
            $statsPokemonTrainer = $this->battle->getPokemonInPlaceStats();
//            print_r($userPokemonInUse);
            //
//            $this->em->persist($userPokemonInUse->getTraining());
//            $this->em->persist($userPokemonInUse);
            if ($userPokemonInUse->getActualHp() < 0) {
                $userPokemonInUse->setActualHp(0);
            }
            $this->session->get('pokemon' . $userPokemonInSessionId)->setActualHp($userPokemonInUse->getActualHp());


//            $this->em->persist($userPokemonInUse->getTraining());
//            $this->em->persist($userPokemonInUse);
            if ($battle['score'] === 1) {
                $trainerPokemonInUse = null;
            } elseif ($battle['score'] === 0) {
                $userPokemonInUse = null;
            } else {
                $userPokemonInUse = null;
                $trainerPokemonInUse = null;
            }
        }

        $score = $this->score($lose);
        $cash = 0;
        $pokemonsWithExp = [];
        if ($score) {
            $this->addWinWithTrainer();
            $cash = $this->userAddCashForBattle();
            $this->userAddExpForBattle(11);
            $pokemonsWithExp = $this->pokemonAddExpForTrainerBattle();
        }
        $this->saveBattle($battle['text']);
        return [
            'cash' => $cash,
            'score' => $score,
            'text' => $battle['text'] ?? '',
            'pokemonsWithExp' => $pokemonsWithExp,
            'exp' => $this->getExpForBattle()
        ];
    }

    private function score(bool $lose): bool
    {
        return !$lose;
    }

    private function getExpForBattle(): int
    {
        //TODO karta
        return 42;
    }

    private function pokemonAddExpForTrainerBattle(): array
    {
        $expForBattle = $this->getExpForBattle();
//        dump($this->userTable);die;
        $table = [];
        $returnArray = [];
        foreach ($this->userTable as $key => $value) {
            $pokemon = $this->session->get('pokemon'.$key);
            $table[] = $pokemon->getId();
            $returnArray[] = $pokemon->getName();
            $pokemon->setExp($pokemon->getExp() + $expForBattle);
            $this->session->set('pokemon'.$key, $pokemon);
        }
//        dump($table);die;
        $this->em->getRepository('AppBundle:Pokemon')
            ->addExpToPokemons($table, $expForBattle);

        return $returnArray;
    }

    private function userAddExpForBattle(int $exp)
    {
        $this->user->setExperience($this->user->getExperience() + $exp);
    }

    private function userAddCashForBattle(): int
    {
        $averageLevel = 0;
        $count = count($this->getTrainerPokemons());
        for ($a = 0; $a < $count; $a++) {
            $trainerPokemon = $this->getTrainerPokemons()[$a];
            if ($trainerPokemon->getShiny() === 1) {
                $averageLevel += 2 * $trainerPokemon->getLevel();
            } else {
                $averageLevel += $trainerPokemon->getLevel();
            }
        }
        $averageLevel /= $count;
        $rand = mt_rand(90, 115) / 100;
        if ($count < 6) {
            $cash = round(($count / 2) * ((($count / 6) * $averageLevel * 320) * $rand));
        } else {
            $cash = round($count * ((($count / 6) * $averageLevel * 160) * $rand));
        }

        $this->user->setCash($this->user->getCash() + $cash);

        return $cash;
    }

    private function saveBattle(?string $text)
    {
        $file = fopen(__DIR__ . '/../../../var/files/battles/trainer/' . $this->user->getId() . '.txt', 'w');
        fwrite($file, $text);
        fclose($file);
    }

    private function presentation(Pokemon $pokemonUser, Pokemon $pokemonTrainer): string
    {
        $text = '<div class="row">';
        for ($i = 0; $i < 2; $i++) {
            if ($i === 1) {
                $pokemonUser = $pokemonTrainer;
            }
            $text .= '<div class="col-xs-12 col-md-6">';
            $text .= '<div class="row nomargin">';
            $text .= '<div class="col-xs-6 col-md-4 col-lg-3 padding_top">';
            $text .= '<img src = "../../img/poki/srednie/';
            $text .= $pokemonUser->getShiny() ? 's' : '';
            $text .= $pokemonUser->getIdPokemon() . '.png" data-toggle="tooltip" data-title="' . $pokemonUser->getName() .
                '"class="center img-responsive" /></div>';
            $text .= '<div class="col-xs-6 col-md-8 col-lg-9">
            <div class="well well-stan noborder padding_2 margin_2 text-center alert-success"><span >';
            $text .= $pokemonUser->getShiny() ? 'Shiny ' : '';
            $text .= "{$pokemonUser->getName()} ({$pokemonUser->getLevel()})";
            if ($pokemonUser->getGender() === 0) {
                $text .= '<span class="icon-mars text-extra-big" data-original-title="płeć męska" data-toggle="tooltip"></span>';
            } elseif ($pokemonUser->getGender() === 1) {
                $text .= '<span class="icon-venus text-extra-big" data-original-title="płeć żeńska" data-toggle="tooltip"></span>';
            } else {
                $text .= '<span title="Pokemon jest bezpłciowy">!</span>';
            }
            $text .= '</span></div>';
            $text .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">';
            $text .= "A: {$pokemonUser->getAttackToTable()} Sp . A: {$pokemonUser->getSpAttackToTable()} </div>";
            $text .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center" >';
            $text .= "O: {$pokemonUser->getDefenceToTable()} Sp . O: {$pokemonUser->getSpDefenceToTable()}</div>";
            $text .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center" >';
            $text .= "SZ: {$pokemonUser->getSpeedToTable()} C: {$pokemonUser->getAccuracy()}%</div >";
            $text .= '<div class="progress progress-gra prog_HP" data-original-title="Życie pokemona" data-toggle="tooltip" data-placement="top" >';
            $text .= '<div class="progress-bar progress-bar-success progBarHP" role = "progressbar" aria-valuenow ="40"
                        aria-valuemin="0" aria-valuemax="100" style = "width:' . ($pokemonUser->getHp() / $pokemonUser->getHpToTable() * 100) . '%;" >';
            $text .= "<span>{$pokemonUser->getHp()} / {$pokemonUser->getHpToTable()} PŻ </span>";
            $text .= '</div></div></div></div></div>';
        }
        $text .= '</div>';
        return $text;
    }

    private function addWinWithTrainer()
    {
        $this->em->getRepository('AppBundle:Achievement')->addWinWithTrainer($this->user->getId());
    }
}
