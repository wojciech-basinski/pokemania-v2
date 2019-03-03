<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GameTrainingPokemon
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

    public function checkIfInTraining(User $user): array
    {
        if ($user->getActivity() != 'training') {
            return [];
        } else {
            $time = time() - $user->getActivityTime();
            $hours = floor($time / 3600);
            $time -= ($hours * 3600);
            $minutes = floor($time / 60);
            $time -= ($minutes * 60);
            return [
              'hours' => $hours,
              'minutes' => $minutes,
              'seconds' => $time
            ];
        }
    }

    public function calculateTime(User $user): int
    {
        if ($user->getTrainerLevel() > 100) {
            return 600;
        }
        return 5400 - ($user->getTrainerLevel() - 1) * 48;
    }

    public function startTraining(User $user): void
    {
        if ($user->getActivity() === 'training') {
            $this->session->getFlashBag()->add('error', 'Już rozpocząłeś trening z Pokemonami');
            return;
        }
        $this->session->getFlashBag()->add('success', 'Rozpoczęto trening');
        $user->setActivity('training');
        $user->setActivityTime(time());
        $this->em->persist($user);
        $this->em->flush();
    }

    public function stopTraining(User $user): void
    {
        if ($user->getActivity() != 'training') {
            $this->session->getFlashBag()->add('error', 'Nie trenujesz z Pokemonami');
            return;
        }
        $time = time() - $user->getActivityTime();
        $time2string = GameTime::time2string($time);
        $this->session->getFlashBag()->add('info', "Zakończyłeś trening z Pokemonami. <br />Trenowałeś {$time2string}");
        $timeToExp = $this->calculateTime($user);
        if ($time < $timeToExp) {
            $this->session->getFlashBag()->add('error', 'Niestety trenowałeś za krótko, żeby uzyskać jakikolwiek efekt');
        } else {
            $exp = 3 * intval($time / $timeToExp);
            $this->addExp($exp, $user->getId());
        }
        $this->endTraining($user);
        $this->em->flush();
    }

    private function addExp(int $exp, int $userId): void
    {
        $this->session->getFlashBag()->add(
            'success',
            "Trening skutkował zwiększeniem doświadczenia pokemonów.<br />
                Twoje Pokemony otrzymują po {$exp} doświadczenia."
        );
        $this->em->getRepository('AppBundle:Pokemon')->addExpByTraining($exp, $userId);
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                $pokExp = $this->session->get('pokemon'.$i)->getExp();
                $this->session->get('pokemon'.$i)->setExp($pokExp + $exp);
            }
        }
    }

    private function endTraining(User $user): void
    {
        $user->setActivityTime(0);
        $user->setActivity('');
        $this->em->persist($user);
    }
}
