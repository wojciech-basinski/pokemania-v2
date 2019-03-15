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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
    /**
     * @var Request
     */
    private $request;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        UserExperience $userExperience,
        PokemonHelper $pokemonHelper,
        RequestStack $request
    ) {
        $this->session = $session;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->userExperience = $userExperience;
        $this->pokemonHelper = $pokemonHelper;
        $this->request = $request->getCurrentRequest();
    }

    public function registerUser(User $user, int $starterId): bool
    {
        try {
            $this->em->beginTransaction();
            $this->prepareUserToRegister($user);
            $this->createUserTables($user);
            $this->em->persist($user);
            $this->em->flush();

            $this->createUserStarter($user, $starterId);
            $this->em->commit();
        } catch (\Throwable $e) {
            $this->em->rollback();
            dump($e);
            echo 'błąd';
            die;
        }

        return 1;
    }

    public function loginUser(): void
    {
        $this->setSession();
    }

    public function pokemonsToTeam(User $user): void
    {
        $pokemonRepository = $this->em->getRepository('AppBundle:Pokemon');

        $pokemonsAndTrainings = $pokemonRepository->getUsersPokemonsFromTeam($user);
        $pokemonCounts = count($pokemonsAndTrainings['pokemons']);

        for ($i = 0; $i < $pokemonCounts; $i++) {
            $pokemonsAndTrainings['pokemons'][$i]->setExpOnLevel(
                $this->pokemonHelper->getExperienceOnLevel($pokemonsAndTrainings['pokemons'][$i]->getLevel())
            );
            $this->session->set('pokemon'.$i, $pokemonsAndTrainings['pokemons'][$i]);
        }
    }

    private function setSession(): void
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $this->setSessionInDb($user);
        $this->setOnlineTimeInDb($user);
        if ($user->getPa() > $user->getMpa()) {
            $user->setPa($user->getMpa());
        }
        $user->setIp($this->request->server->get('REMOTE_ADDR'));
        $this->em->flush();
        $this->pokemonsToTeam($user);
        $this->createUserInSession($user);
        $this->createUserSettings($user->getSettings());
        $this->createUserItemsInSession($user);
        $this->createUserSkillsInSession($user);
    }

    private function createUserInSession(User $user): void
    {
        $userItems = $this->createUserItemsInSession($user);
        $userSkills = $this->createUserSkillsInSession($user);
        $userSettings = $this->createUserSettings($user->getSettings());
        $pokemonInReserve = $this->setUserPokemonsInReserve($user->getId());
        $reports = $this->setUserReports($user->getId());
        $messages = $this->setUserMessages($user->getId());
        $expOnNextLevel = $this->setUserExpToNextLevel($user->getTrainerLevel());

        $this->session->set(
            'userSession',
            new UserSession(
                $pokemonInReserve,
                $reports,
                $messages,
                $expOnNextLevel,
                $userItems,
                $userSkills,
                $userSettings
            )
        );
    }

    private function createUserItemsInSession(User $user): UserItems
    {
        $items = $user->getItems();

        $u = [
            0,//karty darmowego leczenia
            $items->getKit(),
            $items->getPokedex(),
            $items->getShovel()
        ];
        return new UserItems($u);
    }

    private function createUserSkillsInSession(User $user): UserSkills
    {
        $skills = $user->getSkills();

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

    private function prepareUserToRegister(User $user): void
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
        $user->setBadges(
            '00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000;00-00-0000'
        );

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

    private function createUserStarter(User $user, int $starterId): void
    {
        $starter = new Pokemon();

        $pokemonInfo = $this->pokemonHelper->getInfo($starterId);

        $randValue = rand(90, 110)/100;
        $pokemonValue = floor(18450 * $randValue);

        $gender0 = $pokemonInfo['genderMale'];
        $p = rand()%1000;
        ($p < $gender0) ? $starter->setGender(0) : $starter->setGender(1);
        $starter->setName($pokemonInfo['name']);
        $starter->setIdPokemon($starterId);
        $starter->setValue($pokemonValue);
        $starter->setOwner($user->getId());
        $starter->setFirstOwner($user->getId());
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
        $starter->setTr6(0);
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
        $userTeam->setPokemon1($starter->getId())
            ->setPokemon2(0)
            ->setPokemon3(0)
            ->setPokemon4(0)
            ->setPokemon5(0)
            ->setPokemon6(0);

        $user->setUserTeam($userTeam);
        $this->em->flush();
    }

    private function bulbasaur(Pokemon $pokemon): void
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

    private function charmander(Pokemon $pokemon): void
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

    private function squirtle(Pokemon $pokemon): void
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

    private function createUserTables(User $user): void
    {
        $this->createUserBerrys($user);//done
        $this->createUserPokeballs($user);//done
        $this->createUserStatistics($user);//done
        $this->createUserAchievements($user);//done
        $this->createUserCollection($user);//done
        $this->createUserItems($user);//done
        $this->createUserStones($user);//done
        $this->createUserPerformance($user);//done
        $this->createUserSkills($user);//done
    }

    private function createUserStones(User $user): void
    {
        $stones = new Stones();
        $stones->setFireStone(0)
            ->setWaterStone(0)
            ->setLeafStone(0)
            ->setThunderStone(0)
            ->setMoonStone(0)
            ->setSunStone(0)
            ->setRunes(0)
            ->setObsydian(0)
            ->setBelt(0)
            ->setEctoplasm(0)
            ->setPhilosophicalStone(0);

        $user->setStones($stones);
    }

    private function createUserSkills(User $user): void
    {
        $skills = new Skill();
        $skills->setSkill1(0);

        $user->setSkills($skills);
    }

    private function createUserItems(User $user): void
    {
        $items = new Items();
        $items->setMpa(0)
            ->setLemonade(10)
            ->setSoda(20)
            ->setWater(30)
            ->setFlashlight(0)
            ->setBattery(0)
            ->setBox(1)
            ->setPokedex(0)
            ->setCookie(20)
            ->setBar(20)
            ->setKit(0)
            ->setPokemonFood(200)
            ->setParts(0)
            ->setCandy(0)
            ->setShovel(0)
            ->setCoins(0);

        $user->setItems($items);
    }

    private function createUserPokeballs(User $user): void
    {
        $pokeball = new Pokeball();
        $pokeball->setPokeballs(15)
            ->setNestballs(15)
            ->setGreatballs(15)
            ->setUltraballs(5)
            ->setDuskballs(15)
            ->setLureballs(15)
            ->setCherishballs(10)
            ->setMasterballs(0)
            ->setRepeatballs(5)
            ->setSafariballs(20);

        $user->setPokeballs($pokeball);
    }

    private function createUserBerrys(User $user): void
    {
        $berrys = new Berry();
        $berrys->setCheriBerry(30)
            ->setChestoBerry(15)
            ->setPechaBerry(5)
            ->setRawstBerry(5)
            ->setAspearBerry(5)
            ->setLeppaBerry(0)
            ->setOranBerry(0)
            ->setPersimBerry(0)
            ->setLumBerry(0)
            ->setSitrusBerry(0)
            ->setFigyBerry(0)
            ->setWikiBerry(5)
            ->setMagoBerry(3)
            ->setAguavBerry(1)
            ->setLapapaBerry(1)
            ->setRazzBerry(1);

        $user->setBerrys($berrys);
    }

    private function createUserCollection(User $user): void
    {
        $collection = new Collection();
        $collection->setCollection(
            '0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;
            0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;0,0;'
        );

        $user->setCollection($collection);
    }

    private function createUserStatistics(User $user): void
    {
        $statistics = new Statistic();
        $statistics->setCatched(0)
            ->setCupons(0)
            ->setLottery(2)
            ->setTravels(0);

        $user->setStatistics($statistics);
    }

    private function createUserAchievements(User $user): void
    {
        $achievements = new Achievement();
        $achievements->setPolana(0)
            ->setWyspa(0)
            ->setGrota(0)
            ->setDomStrachow(0)
            ->setGory(0)
            ->setWodospad(0)
            ->setSafari(0)
            ->setCatchedPokemons(0)
            ->setWinsWithTrainers(0)
            ->setWinsWithPokemons(0)
            ->setBeggedBerrys(0)
            ->setCatchedPokeball(0)
            ->setCatchedNestball(0)
            ->setCatchedGreatball(0)
            ->setCatchedUltraball(0)
            ->setCatchedDuskball(0)
            ->setCatchedLureball(0)
            ->setCatchedCherishball(0)
            ->setCatchedRepeatball(0)
            ->setCatchedSafariball(0)
            ->setSnacks(0)
            ->setLoggedIn(0)
            ->setTrainingsWithPokemons(0)
            ->setCatchedShiny(0)
            ->setWulkan(0)
            ->setLaka(0)
            ->setLodowiec(0)
            ->setMokradla(0)
            ->setJohto5(0)
            ->setJezioro(0)
            ->setMrocznyLas(0);

        $user->setAchievements($achievements);
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

    private function setSessionInDb(User $user): void
    {
        $user->setSessionId($this->session->getId());
    }

    private function setOnlineTimeInDb(User $user): void
    {
        $user->setLastActive(time());
    }

    private function createUserPerformance(User $user): void
    {
        $performance = new Performance();
        $performance->setHazardzista(0)
            ->setLapanie(0)
            ->setNolife(0)
            ->setPokonane(0)
            ->setSzkolenie(0)
            ->setTrener(0)
            ->setTrenerzy(0)
            ->setZbieranie(0)
            ->setZnawcaKanto(0)
            ->setZnawcaKanto1(0)
            ->setZnawcaKanto2(0)
            ->setZnawcaKanto3(0)
            ->setZnawcaKanto4(0)
            ->setZnawcaKanto5(0)
            ->setZnawcaKanto6(0)
            ->setZnawcaKanto7(0);

        $user->setPerformance($performance);
    }
}
