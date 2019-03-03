<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Shiny;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Cron as CronEntity;

class Cron
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addPa(): void
    {
        //add hunger to pokemons
        $this->em->getRepository('AppBundle:User')->addPa();
        $this->addCronMessage('Executed AddPa');
    }

    public function removeInactive(): void
    {
        $this->em->getRepository('AppBundle:User')->removeInactive();
        $this->addCronMessage('Executed RemoveInactive');
    }

    public function dailyReset(): void
    {
        $users = $this->findAllUsers();
        foreach ($users as $user) {
            $statistics = $this->em->find('AppBundle:Statistic', $user->getId());
            if (!$user->getLoggedToday()) {
                $user->setLoggedInRow(0);
            } else {
                $user->setLoggedToday(0);
            }
            $user->setOnlineToday(0)
                ->setPokemonFeededIp('');
            $statistics->setCatched(0)
                ->setTravels(0)
                ->setCupons($statistics->getCupons() + 15);
            if ($this->userCheckBadgeLottery($user)) {
                $statistics->setLottery($statistics->getLottery() + 3);
            } else {
                $statistics->setLottery($statistics->getLottery() + 2);
            }
            $this->em->persist($user);
            $this->em->persist($statistics);
        }
        $this->em->getRepository('AppBundle:Pokemon')->setSnackTo0();
        $this->em->flush();
    }

    public function shiny(): void
    {
        $this->shinyKanto();
    }

    private function addCronMessage(string $message): void
    {
        $cron = new CronEntity();
        $cron->setDate(new \DateTime())
            ->setLog($message);
        $this->em->persist($cron);
        $this->em->flush();
    }

    /**
     * @return array|User[]
     */
    private function findAllUsers(): array
    {
        return $this->em->getRepository('AppBundle:User')->findAll();
    }

    private function userCheckBadgeLottery(User $user): bool
    {
        $badges = explode(';', $user->getBadges());
        $dateZero = \DateTime::createFromFormat('Y-m-d H:i', '0000-01-01 00:00');
        return new \DateTime($badges[1]) > $dateZero;
    }

    private function shinyKanto(): void
    {
        $shinyKanto = $this->em->getRepository('AppBundle:Shiny')->findOneBy(['region' => 1]);
        if ($shinyKanto === null) {
            $shinyKanto = new Shiny();
            $shinyKanto->setRegion(1);
        }

        $rand = $this->getRandFromShinyQuantity($shinyKanto);
        if ($rand === 3) {
            $shiny = $this->randShinyKanto();
            $shinyKanto->setCaught(0)
                ->setPlace($shiny['place'])
                ->setQuantity($shiny['quantity'])
                ->setPokemonId($shiny['id'])
                ->setChance($shiny['chance']);
            $this->em->persist($shinyKanto);
            $this->em->getRepository('AppBundle:User')
                ->setShinyNotCaught(1);
            $this->em->flush();
            $this->addCronMessage("executed Shiny, id: {$shiny['id']}, quantity: {$shiny['quantity']}");
            return;
        }
        $this->addCronMessage("executed Shiny, no new shiny");
    }

    private function getRandFromShinyQuantity(Shiny $shiny): int
    {
        if ($shiny->getQuantity() === 0) {
            return mt_rand(1, 3);
        }
        return mt_rand(1, 4);
    }

    private function randShinyKanto(): array
    {
        $rand = mt_rand(1,50);
        if($rand <= 24) {
            $quantity = rand(2, 5);
            $chance = 3;
            $rand = rand(1, 6);
            switch ($rand) {
                case 1:
                    $id = 10;
                    $place = 1;
                    break;
                case 2:
                    $id = 13;
                    $place = 1;
                    break;
                case 3:
                    $id = 46;
                    $place = 2;
                    break;
                case 4:
                    $id = 52;
                    $place = 2;
                    break;
                case 5:
                    $id = 88;
                    $place = 3;
                    break;
                case 6:
                    $id = 118;
                    $place = 6;
                    break;
            }
        } elseif($rand <= 38) {
            $quantity = rand(2, 4);
            if (($quantity == 4) && (mt_rand() & 1)) {
                $quantity = 5;
            }
            $chance = 2.55;
            $rand = rand(1, 10);
            switch ($rand) {
                case 1:
                    $id = 16;
                    $place = 1;
                    break;
                case 2:
                    $id = 19;
                    $place = 2;
                    break;
                case 3:
                    $id = 21;
                    $place = 5;
                    break;
                case 4:
                    $id = 23;
                    $place = 2;
                    break;
                case 5:
                    $id = 54;
                    $place = 6;
                    break;
                case 6:
                    $id = 56;
                    $place = 5;
                    break;
                case 7:
                    $id = 74;
                    $place = 5;
                    break;
                case 8:
                    $id = 96;
                    $place = 4;
                    break;
                case 9:
                    $id = 98;
                    $place = 2;
                    break;
                case 10:
                    $id = 109;
                    $place = 3;
                    break;
            }
        } elseif($rand <= 45) {
            $quantity = rand(2,3);
            if(($quantity == 3 )&& (rand() & 1)) {
                $quantity = 4;
            }
            $chance = 2;
            $rand = rand(1,18);
            switch($rand) {
                case 1:
                    $id = 25;
                    $place = 1;
                    break;
                case 2:
                    $id = 41;
                    $place = 3;
                    break;
                case 3:
                    $id = 43;
                    $place = 1;
                    break;
                case 4:
                    $id = 48;
                    $place = 2;
                    break;
                case 5:
                    $id = 50;
                    $place = 3;
                    break;
                case 6:
                    $id = 60;
                    $place = 6;
                    break;
                case 7:
                    $id = 69;
                    $place = 1;
                    break;
                case 8:
                    $id = 77;
                    $place = 5;
                    break;
                case 9:
                    $id = 84;
                    $place = 1;
                    break;
                case 10:
                    $id = 86;
                    $place = 6;
                    break;
                case 11:
                    $id = 90;
                    $place = 6;
                    break;
                case 12:
                    $id = 100;
                    $place = 2;
                    break;
                case 13:
                    $id = 104;
                    $place = 4;
                    break;
                case 14:
                    $id = 106;
                    $place = 4;
                    break;
                case 15:
                    $id = 107;
                    $place = 4;
                    break;
                case 16:
                    $id = 108;
                    $place = 1;
                    break;
                case 17:
                    $id = 120;
                    $place = 6;
                    break;
                case 18:
                    $id = 122;
                    $place = 4;
                    break;
            }
        } elseif($rand <= 49) {
            $quantity = rand(2,3);
            $chance = 1.6;
            $rand = rand(1,17);
            switch($rand) {
                case 1:
                    $id = 27;
                    $place = 3;
                    break;
                case 2:
                    $id = 29;
                    $place = 2;
                    break;
                case 3:
                    $id = 32;
                    $place = 2;
                    break;
                case 4:
                    $id = 37;
                    $place = 1;
                    break;
                case 5:
                    $id = 63;
                    $place = 4;
                    break;
                case 6:
                    $id = 66;
                    $place = 5;
                    break;
                case 7:
                    $id = 79;
                    $place = 6;
                    break;
                case 8:
                    $id = 83;
                    $place = 3;
                    break;
                case 9:
                    $id = 92;
                    $place = 3;
                    break;
                case 10:
                    $id = 95;
                    $place = 3;
                    break;
                case 11:
                    $id = 102;
                    $place = 1;
                    break;
                case 12:
                    $id = 111;
                    $place = 5;
                    break;
                case 13:
                    $id = 114;
                    $place = 1;
                    break;
                case 14:
                    $id = 116;
                    $place = 6;
                    break;
                case 15:
                    $id = 129;
                    $place = 6;
                    break;
                case 16:
                    $id = 58;
                    $place = 2;
                    break;
                case 17:
                    $id = 72;
                    $place = 6;
                    break;
            }
        } else {
            $quantity = 1;
            if(rand()% 100 > 89 ){
                $quantity = 2;
            }
            $chance = 0.9;
            $rand = rand(1,15);
            switch($rand) {
                case 1:
                    $id = 1;
                    $place = 1;
                    break;
                case 2:
                    $id = 4;
                    $place = 5;
                    break;
                case 3:
                    $id = 7;
                    $place = 6;
                    break;
                case 4:
                    $id = 35;
                    $place = 3;
                    break;
                case 5:
                    $id = 113;
                    $place = 4;
                    break;
                case 6:
                    $id = 115;
                    $place = 4;
                    break;
                case 7:
                    $id = 123;
                    $place = 3;
                    break;
                case 8:
                    $id = 124;
                    $place = 2;
                    break;
                case 9:
                    $id = 125;
                    $place = 5;
                    break;
                case 10:
                    $id = 131;
                    $place = 6;
                    break;
                case 11:
                    $id = 126;
                    $place = 5;
                    break;
                case 12:
                    $id = 127;
                    $place = 4;
                    break;
                case 13:
                    $id = 128;
                    $place = 4;
                    break;
                case 14:
                    $id = 39;
                    $place = 3;
                    break;
                case 15:
                    $id = 81;
                    $place = 5;
                    break;
            }
        }
        return [
            'quantity' => $quantity,
            'id' => $id,
            'place' => $place,
            'chance' => $chance
        ];
    }
}