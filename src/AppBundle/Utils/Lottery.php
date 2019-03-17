<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\PokemonTraining;
use AppBundle\Entity\Statistic;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Lottery
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Statistic
     */
    private $userStatistics;
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, Collection $collection)
    {
        $this->em = $em;
        $this->session = $session;
        $this->collection = $collection;
    }

    public function countUserTickets(User $user): int
    {
        $this->userStatistics =  $user->getStatistics();
        return $this->userStatistics->getLottery();
    }

    public function playTheLottery(User $user): array
    {
        if (!$this->countUserTickets($user)) {
            return ['status' => 0];
        }

        $infoAboutWin = $this->play($user);

        return [
            'status' => 1,
            'tickets' => $this->userStatistics->getLottery(),
            'info' => $infoAboutWin
        ];
    }

    private function play(User $user): string
    {
        $rand = rand(0, 1000);

        if ($rand <= 1) {
            $status = 'Gratulacje, wygrywasz Dratini! Pokemona znajdziesz w swojej rezerwie.';
            $this->winDratini($user);
        } elseif ($rand <= 4) {
            $status = 'Gratulacje, wygrywasz 2 miliony &yen;.';
            $user->setCash($user->getCash() + 2000000);
        } elseif ($rand <= 75) {
            $status = 'Wygrywasz 30 Cheri Berry.';
            $this->winBerry('CheriBerry', 30, $user);
        } elseif ($rand <= 90) {
            $status = 'Wygrywasz 20 Chesto Berry.';
            $this->winBerry('ChestoBerry', 20, $user);
        } elseif ($rand <= 120) {
            $status = 'Wygrywasz 20 Pecha Berry!';
            $this->winBerry('PechaBerry', 20, $user);
        } elseif ($rand <= 150) {
            $status = 'Wygrywasz 20 Rawst Berry.';
            $this->winBerry('RawstBerry', 20, $user);
        } elseif ($rand <= 170) {
            $status = 'Wygrywasz 15 Wiki Berry.';
            $this->winBerry('WikiBerry', 15, $user);
        } elseif ($rand <= 190) {
            $status = 'Wygrywasz 15 Mago Berry.';
            $this->winBerry('MagoBerry', 15, $user);
        } elseif ($rand <= 210) {
            $status = 'Wygrywasz 15 Lapapa Berry.';
            $this->winBerry('LapapaBerry', 15, $user);
        } elseif ($rand <= 230) {
            $status = 'Wygrywasz 15 Aguav Berry.';
            $this->winBerry('AguavBerry', 15, $user);
        } elseif ($rand <= 290) {
            $status = 'Wygrywasz 30 Pokeballi.';
            $this->winPokeball('Pokeballs', 30, $user);
        } elseif ($rand <= 320) {
            $status = 'Wygrywasz 20 Nestballi.';
            $this->winPokeball('Nestballs', 20, $user);
        } elseif ($rand <= 350) {
            $status = 'Wygrywasz 20 Greatballi.';
            $this->winPokeball('Greatballs', 20, $user);
        } elseif ($rand <= 360) {
            $status = 'Wygrywasz 5 Ultraballi.';
            $this->winPokeball('Ultraballs', 5, $user);
        } elseif ($rand <= 370) {
            $status = 'Wygrywasz 3 Cherishballe.';
            $this->winPokeball('Cherishballs', 3, $user);
        } elseif ($rand <= 371) {
            $status = 'Gratulacje, wygrywasz Masterballa.';
            $this->winPokeball('Masterballs', 1, $user);
        } elseif ($rand <= 375) {
            $status = 'Wygrywasz 10 losów do loterii';
            $this->winTenCupons();
        } elseif ($rand <= 377) {
            $status = 'Wygrywasz kamień roślinny.';
            $this->winStone('LeafStone', $user);
        } elseif ($rand <= 379) {
            $status = 'Wygrywasz kamień ognisty.';
            $this->winStone('FireStone', $user);
        } elseif ($rand <= 381) {
            $status = 'Wygrywasz kamień gromu.';
            $this->winStone('ThunderStone', $user);
        } elseif ($rand <= 383) {
            $status = 'Wygrywasz kamień księżycowy.';
            $this->winStone('MoonStone', $user);
        } elseif ($rand <= 385) {
            $status = 'Wygrywasz kamień wodny.';
            $this->winStone('WaterStone', $user);
        } elseif ($rand <= 387) {
            $status = 'Wygrywasz kamień słoneczny.';
            $this->winStone('SunStone', $user);
        } else {
            $rand = rand(9000, 11000) / 10000;
            $kasa = floor($user->getTrainerLevel() * $rand * 1000);
            $status = 'Wygrywasz ' . $kasa . ' &yen;.';
            $user->setCash($user->getCash() + $kasa);
        }
        $this->userStatistics->setLottery($this->userStatistics->getLottery() - 1);
        $this->em->persist($this->userStatistics);

        $this->em->flush();

        return $status;
    }

    private function winTenCupons(): void
    {
        $this->userStatistics->setLottery($this->userStatistics->getLottery() + 10);
    }

    private function winStone(string $name, User $user): void
    {
        $stone = $user->getStones();
        $stone->{'set'.$name}($stone->{'get'.$name}() + 1);

        $this->em->persist($stone);
    }
    private function winPokeball(string $name, int $value, User $user): void
    {
        $pokeball = $user->getPokeballs();
        $pokeball->{'set'.$name}($pokeball->{'get'.$name}() + $value);
    }

    private function winBerry(string $name, int $value, User $user): void
    {
        $berry = $user->getBerrys();
        $berry->{'set'.$name}($berry->{'get'.$name}() + $value);

        $this->em->persist($berry);
    }

    private function winDratini(User $user): void
    {
        $dratini = new Pokemon();
        $training = new PokemonTraining();

        $training->setTr1(0);
        $training->setTr2(0);
        $training->setTr3(0);
        $training->setTr4(0);
        $training->setTr5(0);
        $training->setBerryDefence(0);
        $training->setBerryAttack(0);
        $training->setBerrySpDefence(0);
        $training->setBerrySpAttack(0);
        $training->setBerrySpeed(0);
        $training->setBerryLimit(rand(50, 75) * 5);
        $this->em->persist($training);

        $dratini->setTraining($training);
        $dratini->setGender(rand() % 2);
        $dratini->setName('Dratini');
        $dratini->setIdPokemon(147);
        $dratini->setValue(100000);
        $dratini->setOwner($user);
        $dratini->setFirstOwner($user);
        $dratini->setCatched('lottery');
        $dratini->setLevel(1);
        $dratini->setQuality(90);
        $dratini->setAccuracy(80);
        $dratini->setDateOfCatch(new \DateTime());
        $dratini->setShiny(0);
        if (mt_rand(0, 100) === 1) {
            $dratini->setShiny(1);
        }
        $this->collection->addOneToPokemonCatchAndMet(147, $user, $dratini->getShiny());
        $dratini->setAttachment(750);
        $dratini->setExp(0);
        $dratini->setTeam(0);
        $dratini->setEwolution(0);
        $dratini->setBlock(1);
        $dratini->setLottery(1);
        $dratini->setBerrysHp(0);
        $dratini->setSnacks(0);
        $dratini->setMarket(0);
        $dratini->setBlockView(0);
        $dratini->setHunger(0.0);
        $dratini->setTr6(0);
        $dratini->setDescription('');
        $dratini->setExchange(0);
        $dratini->setAttack(11);
        $dratini->setSpAttack(10);
        $dratini->setDefence(10);
        $dratini->setSpDefence(10);
        $dratini->setSpeed(10);
        $dratini->setHp(55);
        $dratini->setActualHp(50);
        $dratini->setAttack0(603);
        $dratini->setAttack1(291);
        $dratini->setAttack2(0);
        $dratini->setAttack3(0);

        $this->em->persist($dratini);
        $this->session->set('pokemonsInReserve', ($this->session->get('pokemonsInReserve') + 1));
    }
}
