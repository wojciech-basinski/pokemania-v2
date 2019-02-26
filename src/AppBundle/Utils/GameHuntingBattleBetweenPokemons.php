<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameHuntingBattleBetweenPokemons
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Pokemon
     */
    private $userPokemon;
    /**
     * @var Pokemon
     */
    private $realUserPokemon;
    /**
     * @var Pokemon
     */
    private $pokemonInPlace;
    /**
     * @var PokemonStatsInBattle
     */
    private $userPokemonStats;
    /**
     * @var PokemonStatsInBattle
     */
    private $pokemonInPlaceStats;
    /**
     * @var GameBattle
     */
    private $battle;
    /**
     * @var AuthenticationService
     */
    private $auth;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, GameBattle $battle, AuthenticationService $auth)
    {
        $this->em = $em;
        $this->session = $session;
        $this->battle = $battle;
        $this->auth = $auth;

        $this->generateEmptyStatsUserPokemon();
        $this->generateEmptyStatsPlacePokemon();
    }

    public function getUserPokemon()
    {
        return $this->battle->getPokemonUser();
    }

    public function getTrainerPokemon()
    {
        return $this->battle->getPokemonInPlace();
    }

    public function trainerBattle(
        Pokemon $userPokemon,
        Pokemon $trainerPokemon,
        User $user,
        PokemonStatsInBattle $userPokemonStats,
        PokemonStatsInBattle $trainerPokemonStats,
        string $presentation
    ) {
        $this->realUserPokemon = $userPokemon;
        $this->userPokemon = clone $this->realUserPokemon;
        $this->userPokemon->setTraining(clone $this->realUserPokemon->getTraining());
        $this->em->detach($this->userPokemon);

        $this->pokemonInPlace = $trainerPokemon;
        $begginingHp = $this->userPokemon->getActualHp();

        $this->userPokemonStats = $userPokemonStats;
        $this->pokemonInPlaceStats = $trainerPokemonStats;
        $battle = $this->beforeBattle();

        $this->battle->setPokemons(
            $battle['pokemonUser'],
            $battle['pokemonInPlace']
        );
        $this->battle->setStats(
            $this->userPokemonStats,
            $this->pokemonInPlaceStats
        );

        $this->battle->battleBetweenPokemons($presentation);

        $this->userPokemonStats = $this->battle->getUserPokemonStats();
        $this->pokemonInPlaceStats = $this->battle->getPlacePokemonStats();

        $score = $this->battle->getScore();

        $battle['score'] = $score;
        $battle['text'] = $this->battle->getBattleText();
        $battle['begginingHp'] = $begginingHp;

        return $battle;
    }

    public function battle(?int $pokemonId, User $user)
    {
        $this->realUserPokemon = $this->getOnePokemonInTeam($pokemonId, $user->getId());
        $this->pokemonInPlace = $this->session->get('pokemonHunting');
        if (!$this->realUserPokemon || !$this->pokemonInPlace) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return false;
        }
        $this->userPokemon = clone $this->realUserPokemon;
        $this->userPokemon->setTraining(clone $this->realUserPokemon->getTraining());
        $this->em->detach($this->userPokemon);

        $begginingHp = $this->userPokemon->getActualHp();

        $battle = $this->beforeBattle();

        $this->battle->setPokemons(
            $battle['pokemonUser'],
            $battle['pokemonInPlace']
        );
        $this->battle->setStats(
            $this->userPokemonStats,
            $this->pokemonInPlaceStats
        );

        $this->battle->battleBetweenPokemons();

        $score = $this->battle->getScore();

        $this->realUserPokemon->setActualHp($this->battle->getUserPokemonHp());
        $this->setHpOnePokemonInSession($this->realUserPokemon->getId(), $this->battle->getUserPokemonHp());

        if ($score === 1) {
            $battle = array_merge($battle, $this->win($user));
            $this->addWinToAchievements($user);
        } elseif ($score === 0) {
            $this->lost($user);
        } else {
            $this->tie($user);
        }

        $battle['score'] = $score;
        $battle['text'] = $this->battle->getBattleText();
        $battle['begginingHp'] = $begginingHp;

        $this->saveBattleToFile($battle['text'], $user->getId());

        $this->em->persist($this->realUserPokemon);
        $this->em->flush();
        $battle['pokemonUser'] = $this->realUserPokemon;
        return $battle;
    }

    public function showBattle(int $userId, bool $trainer = false)
    {
        try {
            $place = $trainer ? 'trainer' : 'inplace';
            $file = fopen(__DIR__ . "/../../../var/files/battles/$place/$userId.txt", 'r');
            $fileText = fread($file, filesize(__DIR__ . "/../../../var/files/battles/$place/$userId.txt"));
            fclose($file);
        } catch (\Exception $exc) {
            return null;
        }
        return $fileText;
    }

    private function getOnePokemonInTeam(?int $pokemonId, int $userId): ?Pokemon
    {
        return $this->em->getRepository('AppBundle:Pokemon')->findOneBy([
            'owner' => $userId,
            'id' => $pokemonId,
            'team' => 1
        ]);
    }

    private function beforeBattle(): array
    {
        //TODO
        //jakieś tam zmiany statów przed walką itp.
        $pokemons = $this->pokemonsInPlacePrepare();

        return [
            'pokemonInPlace' => $pokemons['place'],
            'pokemonUser' => $pokemons['user'],
        ];
    }

    private function generateEmptyStatsUserPokemon()
    {
        $this->userPokemonStats = $this->getEmptyStats();
    }

    private function generateEmptyStatsPlacePokemon()
    {
        $this->pokemonInPlaceStats = $this->getEmptyStats();
    }

    private function getEmptyStats(): PokemonStatsInBattle
    {
        return new PokemonStatsInBattle();
    }

    private function tie(User $user)
    {
        $user->setExperience($user->getExperience() + 3);
        $this->realUserPokemon->setExp($this->userPokemon->getExp() + 5);
        $this->session->remove('pokemonHunting');
    }

    private function lost(User $user)
    {
        $user->setExperience($user->getExperience() + 1);
        $this->realUserPokemon->setExp($this->userPokemon->getExp() + 2);
        $attachment = (rand() % 5) + 3;
        $this->realUserPokemon->setAttachment($this->userPokemon->getAttachment() - $attachment);
        $this->session->remove('pokemonHunting');
    }

    private function win(User $user)
    {
        $pokemonExp = $this->calculateExperienceForWinBattle();
        $trainerExp = (rand() % 3) + 3;
        if ($this->pokemonInPlace->getInfo()['trudnosc'] === 10) {
            $pokemonExp *= 2;
            $trainerExp *= 2;
        }
        //TODO
        /*if (Session::_isset('karta')) {
            $karta = explode('|', Session::_get('karta'));
            if ($karta['0'] === '2') {
                $exp *= 1.25;
                $exp = round($exp);
            }
        }*/
        $attachment = (rand() % 5) + 3;
        $user->setExperience($user->getExperience() + $trainerExp);
        $this->realUserPokemon->setExp($this->userPokemon->getExp() + $pokemonExp);
        $this->realUserPokemon->setAttachment($this->userPokemon->getAttachment() + $attachment);
        return [
            'userExp' => $trainerExp,
            'pokemonExp' => $pokemonExp
        ];
    }

    private function calculateExperienceForWinBattle()
    {
        $st = $this->pokemonInPlace->getLevel() / $this->realUserPokemon->getLevel();
        if ($st <= 0.06) {
            $exp = 3;
        } elseif ($st > 0.06 && $st <= 0.1) {
            $exp = 5;
        } elseif ($st > 0.1 && $st <= 0.15) {
            $exp = 7;
        } elseif ($st > 0.15 && $st <= 0.20) {
            $exp = 8;
        } elseif ($st > 0.2 && $st <= 0.25) {
            $exp = 10;
        } elseif ($st > 0.25 && $st <= 0.3) {
            $exp = 13;
        } elseif ($st > 0.3 && $st <= 0.4) {
            $exp = 14;
        } elseif ($st > 0.4 && $st <= 0.5) {
            $exp = 17;
        } elseif ($st > 0.5 && $st <= 0.6) {
            $exp = 18;
        } elseif ($st > 0.6 && $st <= 0.7) {
            $exp = 20;
        } elseif ($st > 0.7 && $st <= 0.9) {
            $exp = 22;
        } elseif ($st > 0.9 && $st <= 1) {
            $exp = 24;
        } elseif ($st > 1 && $st <= 1.15) {
            $exp = 28;
        } elseif ($st > 1.15 && $st <= 1.35) {
            $exp = 35;
        } else {
            $exp = 40;
        }

        return $exp;
    }

    private function saveBattleToFile(string $text, int $userId)
    {
        $file = fopen(__DIR__ . '/../../../var/files/battles/inplace/' . $userId . '.txt', 'w');
        fwrite($file, $text);
        fclose($file);
    }

    /**
     * @return PokemonStatsInBattle
     */
    public function getUserPokemonStats(): PokemonStatsInBattle
    {
        return $this->userPokemonStats;
    }

    /**
     * @return PokemonStatsInBattle
     */
    public function getPokemonInPlaceStats(): PokemonStatsInBattle
    {
        return $this->pokemonInPlaceStats;
    }

    private function addWinToAchievements(User $user)
    {
        $this->em->getRepository('AppBundle:Achievement')
            ->addWinWithPokemon($user->getId());
    }

    private function pokemonsInPlacePrepare(): array
    {
        if (!$this->userPokemonStats->isPrepared()) {
            $this->userPokemonStats->setPrepared(1);
            $userLuck = 1 + ($this->userPokemonStats->getLucky() / 100);
            $attachment = $this->userPokemon->getCountedAttachment();

            if ($attachment > 70) {
                $plus = $attachment - 70;
                $plus = round(($plus/2), 2);
                $userLuck += ($plus/100);
            }

            if ($this->userPokemon->getShiny()) {
                $shinyBonus = mt_rand(899, 1101)/100;
                $this->userPokemonStats->setShinyBonus($shinyBonus);
                $userLuck += $shinyBonus/100;
            }

            $this->userPokemon->setAttack(round($userLuck * $this->userPokemon->getAttackToTable()));
            $this->userPokemon->setAttack(round($userLuck * $this->userPokemon->getAttackToTable()));
            $this->userPokemon->setSpAttack(round($userLuck * $this->userPokemon->getSpAttackToTable()));
            $this->userPokemon->setDefence(round($userLuck * $this->userPokemon->getDefenceToTable()));
            $this->userPokemon->setSpDefence(round($userLuck * $this->userPokemon->getSpDefenceToTable()));
            $this->userPokemon->setSpeed(round($userLuck * $this->userPokemon->getSpeedToTable()));
            $this->userPokemon->setHp($this->userPokemon->getHpToTable());
            $this->userPokemon->getTraining()->setTr1(0);
            $this->userPokemon->getTraining()->setTr2(0);
            $this->userPokemon->getTraining()->setTr3(0);
            $this->userPokemon->getTraining()->setTr4(0);
            $this->userPokemon->getTraining()->setTr5(0);
            $this->userPokemon->getTraining()->setBerryAttack(0);
            $this->userPokemon->getTraining()->setBerrySpAttack(0);
            $this->userPokemon->getTraining()->setBerryDefence(0);
            $this->userPokemon->getTraining()->setBerrySpDefence(0);
            $this->userPokemon->getTraining()->setBerrySpeed(0);
            $this->userPokemon->setBerrysHp(0);
            $this->userPokemon->setTr6(0);
        }

        if (!$this->pokemonInPlaceStats->isPrepared()) {
            $this->pokemonInPlaceStats->setPrepared(1);
            $placeLuck = 1 + ($this->pokemonInPlaceStats->getLucky() / 100);

            if ($this->pokemonInPlace->getShiny()) {
                $shinyBonus = mt_rand(899, 1101)/1000;
                $this->pokemonInPlaceStats->setShinyBonus($shinyBonus);
                $placeLuck += $shinyBonus;
            }

            $this->pokemonInPlace->setAttack(round($placeLuck * $this->pokemonInPlace->getAttackToTable()));
            $this->pokemonInPlace->setSpAttack(round($placeLuck * $this->pokemonInPlace->getSpAttackToTable()));
            $this->pokemonInPlace->setDefence(round($placeLuck * $this->pokemonInPlace->getDefenceToTable()));
            $this->pokemonInPlace->setSpDefence(round($placeLuck * $this->pokemonInPlace->getSpDefenceToTable()));
            $this->pokemonInPlace->setSpeed(round($placeLuck * $this->pokemonInPlace->getSpeedToTable()));
        }

        return [
            'place' => $this->pokemonInPlace,
            'user' => $this->userPokemon
        ];
    }

    private function setHpOnePokemonInSession(int $id, int $hp): void
    {
        for ($i = 0; $i < 5; $i++) {
            if ($this->session->get('pokemon'.$i) && $this->session->get('pokemon'.$i)->getId() === $id) {
                $this->session->get('pokemon'.$i)->setActualHp($hp);
                return;
            }
        }
    }
}
