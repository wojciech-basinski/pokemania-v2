<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Achievement;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameProfile
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
     * @var int
     */
    private $id;
    /**
     * @var ProfileHelper
     */
    private $helper;
    /**
     * @var Achievement|null
     */
    private $achievements = null;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, ProfileHelper $helper)
    {
        $this->em = $em;
        $this->session = $session;
        $this->helper = $helper;
    }

    public function getUserProfile(int $userId, int $yourId): ?User
    {
        $this->user = $this->em->getRepository('AppBundle:User')->find($userId);
        if (! $this->user instanceof User) {
            $this->session->getFlashBag()->add('error', 'Użytkownik nie  znaleziony');
            return null;
        }
        $this->id = $yourId;
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->id = $user->getId();
    }

    public function getUsersTeam(): ?array
    {
        if ($this->checkIfUserBlockedTeamView()) {
            return null;
        }
        return $this->em->getRepository('AppBundle:Pokemon')
                    ->getUsersPokemonsFromTeam($this->user->getId())['pokemons'];
    }

    public function getUserSkills()
    {
        $userSkills = [];
        $skills = $this->helper->getSkills();
        $count = count($skills);
        $userGetSkills = $this->em->find('AppBundle:Skill', $this->id);
        for ($i = 0; $i < $count; $i++) {
            $need = explode(';', $skills[$i]['need']);
            $needInfo = $this->getFromDb($need[0]);
            $quantity = $needInfo->{'get'.$need[1]}();

            $userSkills[] = [
                'skillInfo' => $skills[$i],
                'level' => $userGetSkills->{'getSkill'.($i+1)}(),
                'userQuantity' => $quantity
            ];
        }
        return $userSkills;
    }

    public function usePoints(int $i, User $user)
    {
        $skills = $this->helper->getSkill($i);
        if (!$skills) {
            $this->session->getFlashBag()->add('error', 'Błędne ID umiejętności');
            return;
        }
        $this->id = $user->getId();
        $userGetSkills = $this->em->find('AppBundle:Skill', $this->id);
        $need = explode(';', $skills['need']);
        $needInfo = $this->getFromDb($need[0]);
        $quantity = $needInfo->{'get'.$need[1]}();
        if (($userGetSkills->{'getSkill'.($i+1)}() + 1) > $skills['max']) {
            $this->session->getFlashBag()->add('error', 'Już osiągnięto maksymalny poziom');
            return;
        }
        if ($skills[($userGetSkills->{'getSkill'.($i+1)}()+1).'_need'] > $quantity) {
            $this->session->getFlashBag()->add('error', 'Nie spełniono wymagań');
            return;
        }
        if ($user->getPoints() < $skills[($userGetSkills->{'getSkill'.($i+1)}()+1)]) {
            $this->session->getFlashBag()->add('error', 'Masz za mało punktów umiejętności');
            return;
        }
        $user->setPoints($user->getPoints() - $skills[($userGetSkills->{'getSkill'.($i+1)}()+1)]);
        $userGetSkills->{'setSkill'.($i+1)}($userGetSkills->{'getSkill'.($i+1)}() + 1);
        $this->session->getFlashBag()->add('success', 'Zwiększono umiejętność '.$skills['name']);
        $this->em->flush();
    }

    public function getBadges()
    {
        return explode(';', $this->user->getBadges());
    }

    public function getBattle(): bool
    {
        return ($this->id == $this->user->getId());
    }

    public function getFriend()
    {
        if ($this->id == $this->user->getId()) {
            return 0;
        }
        $friend = $this->em->getRepository('AppBundle:Friend')->getOneFriendship($this->id, $this->user->getId());
        if ($friend) {
            return 1;
        }
        $invite = $this->em->getRepository('AppBundle:Friend')->getOneInvitation($this->id, $this->user->getId());
        if ($invite) {
            return 2;
        }
        return 3;
    }

    public function getUserProfileFromUsername(string $userName): ?User
    {
        return $this->em->getRepository(User::class)
            ->findOneBy(['login' => $userName]);
    }

    private function checkIfUserBlockedTeamView(): bool
    {
        $u = explode("|", $this->user->getSettings());
        return !$u[0];
    }

    private function getFromDb(string $need)
    {
        switch ($need) {
            case 'Achievement':
                return $this->getAchievements();
        }
    }

    private function getAchievements()
    {
        if ($this->achievements === null) {
            $this->achievements = $this->em->find('AppBundle:Achievement', $this->id);
        }
        return $this->achievements;
    }
}
