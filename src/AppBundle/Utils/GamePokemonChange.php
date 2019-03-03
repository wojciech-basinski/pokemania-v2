<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GamePokemonChange
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
     * @var AuthenticationService
     */
    private $auth;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, AuthenticationService $auth)
    {
        $this->em = $em;
        $this->session = $session;
        $this->auth = $auth;
    }

    public function changeCheck(?string $what, ?string $value, ?int $id, User $user): void
    {
        if (method_exists($this, 'change'.$what)) {
            $this->{'change'.$what}($value, $id, $user);
            $this->em->flush();
        } else {
            $this->session->getFlashBag()->add('error', 'Błędny atrybut');
            return;
        }
    }

    private function changeBlock(?string $value, ?int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')
                ->findOneBy(['id' => $id, 'owner' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        if (!$this->checkValueBool($value)) {
            $this->session->getFlashBag()->add('error', 'Błędna wartość');
            return;
        }
        $pokemon->setBlockView($value);

        $content = $value ? 'Zablokowano możliwość podglądu Pokemona' : 'Odblokowano możliwość podglądu Pokemona';
        $this->session->getFlashBag()->add('success', $content);
    }

    private function changeEwolution(?string $value, ?int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')
            ->findOneBy(['id' => $id, 'owner' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        if (!$this->checkValueBool($value)) {
            $this->session->getFlashBag()->add('error', 'Błędna wartość');
            return;
        }
        $pokemon->setEwolution($value);

        $content = $value ? 'Zablokowano możliwość ewolucji Pokemona' : 'Odblokowano możliwość ewolucji Pokemona';
        $this->session->getFlashBag()->add('success', $content);
        $this->clearPokemonsInSession();
        $this->auth->pokemonsToTeam($user->getId());
    }

    private function changeName(?string $value, ?int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')
            ->findOneBy(['id' => $id, 'owner' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        if (!$this->checkName($value)) {
            return;
        }
        $this->session->getFlashBag()->add('success', 'Zmieniono imię Pokemona');
        $pokemon->setName($value);
        $this->clearPokemonsInSession();
        $this->auth->pokemonsToTeam($user->getId());
    }

    private function changeUp(?string $value, ?int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')
            ->findOneBy(['id' => $id, 'owner' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        if (!$this->checkAttackUp($value)) {
            $this->session->getFlashBag()->add('error', 'Błędna wartość');
            return;
        }
        $this->session->getFlashBag()->add('success', 'Ustawiono priorytet ataku na wyższy');
        $tempDown = $pokemon->{'getAttack'.($value-1)}();
        $tempUp = $pokemon->{'getAttack'.($value)}();
        $pokemon->{'setAttack'.($value-1)}($tempUp);
        $pokemon->{'setAttack'.($value)}($tempDown);
    }

    private function changeDown(?string $value, ?int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')
            ->findOneBy(['id' => $id, 'owner' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        if (!$this->checkAttackDown($value)) {
            $this->session->getFlashBag()->add('error', 'Błędna wartość');
            return;
        }
        $this->session->getFlashBag()->add('success', 'Ustawiono priorytet ataku na niższy');
        $tempDown = $pokemon->{'getAttack'.($value)}();
        $tempUp = $pokemon->{'getAttack'.($value+1)}();
        $pokemon->{'setAttack'.($value)}($tempUp);
        $pokemon->{'setAttack'.($value+1)}($tempDown);
    }

    private function changeDescription(?string $value, ?int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')
            ->findOneBy(['id' => $id, 'owner' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        $this->session->getFlashBag()->add('success', 'Zmieniono opis');
        $pokemon->setDescription($value);
    }

    private function checkValueNotNull(?string $value): bool
    {
        if ($value === null || $value === '') {
            return false;
        }
        return true;
    }

    private function checkValueBool(?string $value): bool
    {
        return in_array($value, [0,1, false, true]);
    }

    private function clearPokemonsInSession()
    {
        for ($i = 0; $i < 6; $i++) {
            $this->session->remove('pokemon'.$i);
        }
    }

    private function checkName($value): bool
    {
        if ((mb_strlen($value)<3) || (mb_strlen($value)>15)) {
            $this->session->getFlashBag()->add('error', 'Imię Pokemona musi zawierać od 3 do 15 znaków.');
            return false;
        }
        $sprawdz = '/^[0-9A-Za-z]*$/';
        if (!preg_match($sprawdz, $value)) {
            $this->session->getFlashBag()->add('error', 'Imię Pokemona zawiera niedozwolone znaki.');
            return false;
        }
        return true;
    }

    private function checkAttackUp(?string $value): bool
    {
        if (!is_numeric($value) || $value < 1 || $value > 4) {
            return false;
        }
        return true;
    }

    private function checkAttackDown(?string $value): bool
    {
        if (!is_numeric($value) || $value > 2 || $value < 0) {
            return false;
        }
        return true;
    }
}
