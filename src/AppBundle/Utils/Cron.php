<?php

namespace AppBundle\Utils;

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

    public function dailyReset()
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
}