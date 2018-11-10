<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Achievement;
use AppBundle\Entity\Berry;
use AppBundle\Entity\Items;
use AppBundle\Entity\Performance;
use AppBundle\Entity\Pokeball;
use AppBundle\Entity\PokemonTraining;
use AppBundle\Entity\Skill;
use AppBundle\Entity\Statistic;
use AppBundle\Entity\Stones;
use AppBundle\Entity\User;
use AppBundle\Entity\UserTeam;
use AppBundle\Entity\Pokemon;
use AppBundle\Entity\Collection;
use AppBundle\Utils\User\UserItems;
use AppBundle\Utils\User\UserSession;
use AppBundle\Utils\User\UserSettings;
use AppBundle\Utils\User\UserSkills;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthenticationService
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var UserExperience
     */
    private $userExperience;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        UserExperience $userExperience,
        PokemonHelper $pokemonHelper
    ) {
        $this->session = $session;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->userExperience = $userExperience;
        $this->pokemonHelper = $pokemonHelper;
    }

    public function registerUser(User $user, int $starterId): bool
    {
        try {
            $this->em->beginTransaction();
            $user = $this->prepareUserToRegister($user);
            $this->em->persist($user);
            $this->em->flush();

            $this->createUserStarter($user->getId(), $starterId);
            $this->createUserTables();
            $this->em->commit();
        } catch (\Throwable $e) {
            $this->em->rollback();
            echo 'błąd';
            die;
        }

        return 1;
    }

    public function loginUser(int $userId)
    {
        $this->setSession();
    }

    public function pokemonsToTeam(int $userId)
    {
        $pokemonRepository = $this->em->getRepository('AppBundle:Pokemon');

        $pokemonsAndTrainings = $pokemonRepository->getUsersPokemonsFromTeam($userId);
        $pokemonCounts = count($pokemonsAndTrainings['pokemons']);

        for ($i = 0; $i < $pokemonCounts; $i++) {
            $pokemonsAndTrainings['pokemons'][$i]->setExpOnLevel($this->pokemonHelper->getExperienceOnLevel($pokemonsAndTrainings['pokemons'][$i]->getLevel()));
            $this->session->set('pokemon'.$i, $pokemonsAndTrainings['pokemons'][$i]);
        }
    }

    private function setSession()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $this->setSessionInDb($user);
        $this->setOnlineTimeInDb($user);
        if ($user->getPa() > $user->getMpa()) {
            $user->setPa($user->getMpa());
        }
        $this->em->flush();
        $this->pokemonsToTeam($user->getId());
        $this->createUserInSession($user);
        $this->createUserSettings($user->getSettings());
        $this->createUserItemsInSession($user->getId());
        $this->createUserSkillsInSession($user->getId());
    }

    private function createUserInSession(User $user)
    {
        $userItems = $this->createUserItemsInSession($user->getId());
        $userSkills = $this->createUserSkillsInSession($user->getId());
        $userSettings = $this->createUserSettings($user->getSettings());
        $pokemonInReserve = $this->setUserPokemonsInReserve($user->getId());
        $reports = $this->setUserReports($user->getId());
        $messages = $this->setUserMessages($user->getId());
        $expOnNextLevel = $this->setUserExpToNextLevel($user->getTrainerLevel());

        $this->session->set('userSession', new UserSession($pokemonInReserve, $reports, $messages, $expOnNextLevel, $userItems, $userSkills, $userSettings));
    }

    private function createUserItemsInSession(int $userId): UserItems
    {
        $items = $this->em->getRepository('AppBundle:Items')->find($userId);

        $u = [
            0,//karty darmowego leczenia
            $items->getKit(),
            $items->getPokedex(),
            $items->getShovel()
        ];
        return new UserItems($u);
    }

    private function createUserSkillsInSession(int $userId): UserSkills
    {
        $skills = $this->em->getRepository('AppBundle:Skill')->find($userId);

        $u = [
            $skills->getSkill1()
        ];
        return new UserSkills($u);
    }

    private function createUserSettings(string $settings): UserSettings
    {
        return new UserSettings(explode('|', $settings));
    }

    private function setUserPokemonsInReserve(int $userId): int
    {
        return $this->em->getRepository('AppBundle:Pokemon')->countPokemonsInReserve($userId);
    }

    public function setUserReports(int $userId): int
    {
        return $this->em->getRepository('AppBundle:Report')->countReports($userId);
    }

    public function setUserMessages(int $userId): int
    {
        return $this->em->getRepository('AppBundle:Message')->countMessages($userId);
    }

    private function setUserExpToNextLevel(int $userLevel): int
    {
        return $this->userExperience->getExperienceOnLevel($userLevel);
    }

    private function prepareUserToRegister(User $user): User
    {
        $user->setCash(500000000);
        $user->setTrainerLevel(1);
        $user->setExperience(0);
        $user->setPoints(0);
        $user->setMpa(32000);
        $user->setPa(32000);
        $user->setRegion(1);
        $user->setAdmin(0);
        $user->setMagazine(30);
        $user->setLastActive(0);
        $user->setLastActiveSec(0);
        $user->setLoggedToday(0);
        $user->setLoggedInRow(0);
        $user->setSettings('1|0|1|1|1|0|0|0|0|0|1|0|1|0|0|1');
        $user->setAnnouncements(0);
        $user->setClub(0);
        $user->setOnline(0);
        $user->setOnlineToday(0);
        $user->setBerryPa(0);
        $user->setShinyCatched(0);
        $user->setTravelledToday(0);
        $user->setDescription('');
        $user->setPokemonFeeded(0);
        $user->setPokemonFeededIp('');
        $user->setTutorial(0);
        $user->setBadges('00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000');

        return $user;

        //TODO:
        /*
        $this->db->insert('INSERT INTO logowanie VALUES (NULL, ?, ?, ?, \'rejestracja\', \'\')', [$id, $godzina, $ip]);
        $this->db->insert('INSERT INTO punkty (id_gracza)  VALUES ( ? )', [$id]);
        $this->db->insert('INSERT INTO tmy (id_gracza)  VALUES ( ? )', [$id]);
        $this->db->insert('INSERT INTO osiagniecia (id_gracza)  VALUES ( ? )', [$id]);
        $this->db->insert('INSERT INTO aktywnosc (id_gracza, aktywnosc) VALUES ( ?, \'\')', [$id]);
        $this->db->insert('INSERT INTO achievementy (id_gracza) VALUES ( ? )', [$id]);
        $this->db->insert('INSERT INTO karty (id_gracza, brazowa_1, brazowa_2, brazowa_3, brazowa_4) VALUES (?, 3, 3, 3, 3)', [$id]);
        $this->db->insert('INSERT INTO sale_pokemon (id_gracza) VALUES ( ? )', [$id]);
        */
    }

    private function createUserStarter(int $userId, int $starterId)
    {
        $starter = new Pokemon();

        $pokemonInfo = $this->pokemonHelper->getInfo($starterId);

        $randValue = rand(90, 110)/100;
        $pokemonValue = floor(18450 * $randValue);

        $gender0 = $pokemonInfo['plec_m'];
        $p = rand()%1000;
        ($p < $gender0) ? $starter->setGender(0) : $starter->setGender(1);
        $starter->setName($pokemonInfo['nazwa']);
        $starter->setIdPokemon($starterId);
        $starter->setValue($pokemonValue);
        $starter->setOwner($userId);
        $starter->setFirstOwner($userId);
        $starter->setCatched('starter');
        $starter->setLevel(5);
        $starter->setQuality(100);
        $starter->setAccuracy(72);
        $starter->setDateOfCatch(new \DateTime());
        $starter->setShiny(0);
        $starter->setAttachment(900);
        $starter->setExp(0);
        $starter->setTeam(1);
        $starter->setEwolution(0);
        $starter->setBlock(0);
        $starter->setLottery(0);
        $starter->setBerrysHp(0);
        $starter->setSnacks(0);
        $starter->setMarket(0);
        $starter->setBlockView(0);
        $starter->setHunger(0.0);
        $starter->setTr_6(0);
        $starter->setDescription('');
        $starter->setExchange(0);
        $starter->setTraining($this->pokemonTraining());
        $starter->setHp(125);
        $starter->setActualHp(125);

        switch ($starterId) {
            case 1:
                $this->bulbasaur($starter);
                break;
            case 4:
                $this->charmander($starter);
                break;
            case 7:
                $this->squirtle($starter);
                break;
        }
        $this->em->persist($starter);
        $this->em->flush();

        $userTeam = new UserTeam();
        $userTeam->setPokemon1($starter->getId());
        $userTeam->setPokemon2(0);
        $userTeam->setPokemon3(0);
        $userTeam->setPokemon4(0);
        $userTeam->setPokemon5(0);
        $userTeam->setPokemon6(0);

        $this->em->persist($userTeam);
        $this->em->flush();
    }

    private function bulbasaur(Pokemon &$pokemon)
    {
        $pokemon->setAttack(25);
        $pokemon->setSpAttack(30);
        $pokemon->setDefence(25);
        $pokemon->setSpDefence(30);
        $pokemon->setSpeed(25);
        $pokemon->setAttack0(541);
        $pokemon->setAttack1(215);
        $pokemon->setAttack2(0);
        $pokemon->setAttack3(0);
    }

    private function charmander(Pokemon &$pokemon)
    {
        $pokemon->setAttack(25);
        $pokemon->setSpAttack(30);
        $pokemon->setDefence(25);
        $pokemon->setSpDefence(25);
        $pokemon->setSpeed(30);
        $pokemon->setAttack0(451);
        $pokemon->setAttack1(215);
        $pokemon->setAttack2(0);
        $pokemon->setAttack3(0);
    }

    private function squirtle(Pokemon &$pokemon)
    {
        $pokemon->setAttack(25);
        $pokemon->setSpAttack(25);
        $pokemon->setDefence(30);
        $pokemon->setSpDefence(30);
        $pokemon->setSpeed(25);
        $pokemon->setAttack0(541);
        $pokemon->setAttack1(544);
        $pokemon->setAttack2(0);
        $pokemon->setAttack3(0);
    }

    private function createUserTables()
    {
        $this->createUserStatistics();
        $this->createUserAchievements();
        $this->createUserCollection();
        $this->createUserBerrys();
        $this->createUserPokeballs();
        $this->createUserItems();
        $this->createUserStones();
        $this->createUserPerformance();
        $this->createUserSkills();

        $this->em->flush();
    }

    private function createUserStones()
    {
        $stones = new Stones();
        $stones->setFireStone(0);
        $stones->setWaterStone(0);
        $stones->setLeafStone(0);
        $stones->setThunderStone(0);
        $stones->setMoonStone(0);
        $stones->setSunStone(0);
        $stones->setRunes(0);
        $stones->setObsydian(0);
        $stones->setBelt(0);
        $stones->setEctoplasm(0);
        $stones->setPhilosophicalStone(0);

        $this->em->persist($stones);
    }

    private function createUserSkills()
    {
        $skills = new Skill();
        $skills->setSkill1(0);

        $this->em->persist($skills);
    }

    private function createUserItems()
    {
        $items = new Items();
        $items->setMpa(0);
        $items->setLemonade(10);
        $items->setSoda(20);
        $items->setWater(30);
        $items->setFlashlight(0);
        $items->setBattery(0);
        $items->setBox(1);
        $items->setPokedex(0);
        $items->setCookie(20);
        $items->setBar(20);
        $items->setKit(0);
        $items->setPokemonFood(200);
        $items->setParts(0);
        $items->setCandy(0);
        $items->setShovel(0);
        $items->setCoins(0);

        $this->em->persist($items);
    }

    private function createUserPokeballs()
    {
        $pokeball = new Pokeball();
        $pokeball->setPokeballs(15);
        $pokeball->setNestballs(15);
        $pokeball->setGreatballs(15);
        $pokeball->setUltraballs(5);
        $pokeball->setDuskballs(15);
        $pokeball->setLureballs(15);
        $pokeball->setCherishballs(10);
        $pokeball->setMasterballs(0);
        $pokeball->setRepeatballs(5);
        $pokeball->setSafariballs(20);

        $this->em->persist($pokeball);
    }

    private function createUserBerrys()
    {
        $berrys = new Berry();
        $berrys->setCheriBerry(30);
        $berrys->setChestoBerry(15);
        $berrys->setPechaBerry(5);
        $berrys->setRawstBerry(5);
        $berrys->setAspearBerry(5);
        $berrys->setLeppaBerry(0);
        $berrys->setOranBerry(0);
        $berrys->setPersimBerry(0);
        $berrys->setLumBerry(0);
        $berrys->setSitrusBerry(0);
        $berrys->setFigyBerry(0);
        $berrys->setWikiBerry(5);
        $berrys->setMagoBerry(3);
        $berrys->setAguavBerry(1);
        $berrys->setLapapaBerry(1);
        $berrys->setRazzBerry(1);

        $this->em->persist($berrys);
    }

    private function createUserCollection()
    {
        $collection = new Collection();
        $collection->setCollection('0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;');

        $this->em->persist($collection);
    }

    private function createUserStatistics()
    {
        $statistics = new Statistic();
        $statistics->setCatched(0);
        $statistics->setCupons(0);
        $statistics->setLottery(2);
        $statistics->setTravels(0);

        $this->em->persist($statistics);
    }

    private function createUserAchievements()
    {
        $achievements = new Achievement();
        $achievements->setPolana(0);
        $achievements->setWyspa(0);
        $achievements->setGrota(0);
        $achievements->setDomStrachow(0);
        $achievements->setGory(0);
        $achievements->setWodospad(0);
        $achievements->setSafari(0);
        $achievements->setCatchedPokemons(0);
        $achievements->setWinsWithTrainers(0);
        $achievements->setWinsWithPokemons(0);
        $achievements->setBeggedBerrys(0);
        $achievements->setCatchedPokeball(0);
        $achievements->setCatchedNestball(0);
        $achievements->setCatchedGreatball(0);
        $achievements->setCatchedUltraball(0);
        $achievements->setCatchedDuskball(0);
        $achievements->setCatchedLureball(0);
        $achievements->setCatchedCherishball(0);
        $achievements->setCatchedRepeatball(0);
        $achievements->setCatchedSafariball(0);
        $achievements->setSnacks(0);
        $achievements->setLoggedIn(0);
        $achievements->setTrainingsWithPokemons(0);
        $achievements->setCatchedShiny(0);
        $achievements->setWulkan(0);
        $achievements->setLaka(0);
        $achievements->setLodowiec(0);
        $achievements->setMokradla(0);
        $achievements->setJohto5(0);
        $achievements->setJezioro(0);
        $achievements->setMrocznyLas(0);

        $this->em->persist($achievements);
    }

    private function pokemonTraining(): PokemonTraining
    {
        $training = new PokemonTraining();
        $training->setTr1(0);
        $training->setTr2(0);
        $training->setTr3(0);
        $training->setTr4(0);
        $training->setTr5(0);
        $training->setBerrySpAttack(0);
        $training->setBerryAttack(0);
        $training->setBerryDefence(0);
        $training->setBerrySpDefence(0);
        $training->setBerrySpeed(0);
        $training->setBerryLimit(rand(50, 75) * 5);

        $this->em->persist($training);

        return $training;
    }

    private function setSessionInDb(User &$user)
    {
        $user->setSessionId($this->session->getId());
    }

    private function setOnlineTimeInDb(User &$user)
    {
        $user->setLastActive(time());
    }

    private function createUserPerformance()
    {
        $performance = new Performance();
        $performance->setHazardzista(0);
        $performance->setLapanie(0);
        $performance->setNolife(0);
        $performance->setPokonane(0);
        $performance->setSzkolenie(0);
        $performance->setTrener(0);
        $performance->setTrenerzy(0);
        $performance->setZbieranie(0);
        $performance->setZnawcaKanto(0);
        $performance->setZnawcaKanto1(0);
        $performance->setZnawcaKanto2(0);
        $performance->setZnawcaKanto3(0);
        $performance->setZnawcaKanto4(0);
        $performance->setZnawcaKanto5(0);
        $performance->setZnawcaKanto6(0);
        $performance->setZnawcaKanto7(0);

        $this->em->persist($performance);
    }
}
