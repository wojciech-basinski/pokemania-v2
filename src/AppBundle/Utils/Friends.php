<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Friend;
use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Friends
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

    public function deleteFriendship(int $id, User $user, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->find($id);
        if (!$friendship) {
            return 0;
        }
        if (!$friendship->getUser() === $user && !$friendship->getWho() === $user) {
            return 0;
        }

        $secondUser = $friendship->getUser();
        if ($secondUser === $user) {
            $secondUser = $friendship->getWho();
        }
        $this->em->remove($friendship);

        $this->insertMessageAboutDelete($secondUser, $userName);

        return 1;
    }

    public function acceptFriendship(int $id, User $user, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneInvitation($id, $user);
        if (!$friendship) {
            return 0;
        }

        $secondUser = $friendship->getUser();
        if ($secondUser === $user) {
            $secondUser = $friendship->getWho();
        }
        $friendship->setInvitation(0);
        $friendship->setAccepted(1);

        $this->em->persist($friendship);

        $this->insertMessageAboutAccept($secondUser, $userName);

        return 1;
    }

    public function rejectFriendship(int $id, User $user, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneInvitation($id, $user);
        if (!$friendship) {
            return 0;
        }

        $secondUser = $friendship->getUser();
        if ($secondUser === $user) {
            $secondUser = $friendship->getWho();
        }

        $this->em->remove($friendship);

        $this->insertMessageAboutReject($secondUser, $userName);

        return 1;
    }

    public function cancelInvitation(int $id, User $user, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneSentInvitation($id, $user);
        if (!$friendship) {
            return 0;
        }

        $secondUser = $friendship->getUser();
        if ($secondUser === $user) {
            $secondUser = $friendship->getWho();
        }

        $this->em->remove($friendship);

        $this->insertMessageAboutCancelInvitation($secondUser, $userName);

        return 1;
    }

    public function addFriend(int $id, User $user): bool
    {
        if (!$this->checkId($id, $user->getId())) {
            return 0;
        }
        if ($this->em->getRepository('AppBundle:Friend')->getOneFriendship($id, $user)) {
            return 0;
        }
        if ($this->em->getRepository('AppBundle:Friend')->checkIfUserReceivedInvitation($id, $user)) {
            return 0;
        }
        if ($this->em->getRepository('AppBundle:Friend')->checkIfUserSentInvitation($id, $user)) {
            return 0;
        }
        $userToInvite = $this->em->getRepository(User::class)->find($id);
        $this->insertMessageAboutInvitation($user->getUsername(), $userToInvite);
        $this->insertInvitation($userToInvite, $user);
        return 1;
    }

    private function insertMessageAboutCancelInvitation(User $user, string $userName): void
    {
        $report = new Report();
        $report->setContent(
            '<div class="text-center">Gracz ' . $userName . ' cofnął prośbę o dodanie do znajomych.</div>'
        );
        $report->setTitle($userName . ' cofnął zaproszenie.');

        $this->insertMessage($user, $report);
    }

    private function insertMessageAboutReject(User $user, string $userName): void
    {
        $report = new Report();
        $report->setContent(
            '<div class="text-center">Gracz ' . $userName . ' odrzucił Twoje zaproszenie do znajomych.</div>'
        );
        $report->setTitle($userName . ' odrzucił zaproszenie.');

        $this->insertMessage($user, $report);
    }

    private function insertMessageAboutDelete(User $user, string $userName): void
    {
        $report = new Report();
        $report->setContent('<div class="text-center">Gracz ' . $userName . ' usunął Cię ze znajomych.</div>');
        $report->setTitle($userName . ' usunął Cię ze znajomych.');

        $this->insertMessage($user, $report);
    }

    private function insertMessageAboutAccept(User $user, string $userName): void
    {
        $report = new Report();
        $report->setContent(
            '<div class="text-center">Gracz ' . $userName . ' zaakceptował Twoje zaproszenie do znajomych.</div>'
        );
        $report->setTitle($userName . ' zaakceptował zaproszenie.');

        $this->insertMessage($user, $report);
    }

    private function insertMessage(User $user, Report $report): void
    {
        $report->setTime(new \DateTime);
        $report->setUser($user);
        $report->setIsRead(0);
        $this->em->persist($report);
        $this->em->flush();
    }

    private function insertMessageAboutInvitation(string $name, User $user): void
    {
        $report = new Report();
        $report->setContent('Użytkownik '.$name.' zaprasza Cię do znajomych.');
        $report->setTitle('Nowe zaproszenie do znajomych');
        $this->insertMessage($user, $report);
    }

    private function insertInvitation(User $userToSent, User $user): void
    {
        $friendship = new Friend();
        $friendship->setInvitation(1);
        $friendship->setAccepted(0);
        $friendship->setUser($user);
        $friendship->setWho($userToSent);

        $this->em->persist($friendship);
        $this->em->flush();
    }

    private function checkId(int $id, int $userId): bool
    {
        if ($id === 0) {
            return false;
        }
        if ($id === $userId) {
            return false;
        }
        return true;
    }
}
