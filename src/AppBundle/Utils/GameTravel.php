<?php

namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GameTravel
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Session
     */
    private $session;

    public function __construct(EntityManagerInterface $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function changeRegion(User $user, $region)
    {
        if (!in_array($region, [1, 2])) {
            $this->session->getFlashBag()->add('error', 'Błędny region');
            return;
        }

        if ($region === $user->getRegion()) {
            $this->session->getFlashBag()->add('error', 'Nie możesz podóżować do tego regionu');
            return;
        }

        if ($user->getCash() < 250000) {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na podróż statkiem');
            return;
        }

        $user->setCash($user->getCash() - 250000);
        $user->setRegion($region);
        $this->em->flush();
        $regionName = $this->getRegionName($region);
        $this->session->getFlashBag()->add('success', "Kupiono bilet do {$regionName}");
    }

    private function getRegionName(int $region):string
    {
        switch ($region) {
            case 1:
                return 'Kanto';
            case 2:
                return 'Johto';
        }
        return '';
    }
}
