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

    public function deleteFriendship(int $id, int $userId, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneFriendship($id, $userId);
        if (!$friendship) {
            return 0;
        }

        $secondUserId = $friendship->getUserId()->getId();
        if ($secondUserId === $userId) {
            $secondUserId = $friendship->getWhoId()->getId();
        }
        $this->em->remove($friendship);

        $this->insertMessageAboutDelete($secondUserId, $userName);

        return 1;
    }

    public function acceptFriendship(int $id, int $userId, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneInvitation($id, $userId);
        if (!$friendship) {
            return 0;
        }

        $secondUserId = $friendship->getUserId()->getId();
        if ($secondUserId === $userId) {
            $secondUserId = $friendship->getWhoId()->getId();
        }
        $friendship->setInvitation(0);
        $friendship->setAccepted(1);

        $this->em->persist($friendship);
        $this->em->flush();

        $this->insertMessageAboutAccept($secondUserId, $userName);

        return 1;
    }

    public function rejectFriendship(int $id, int $userId, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneInvitation($id, $userId);
        if (!$friendship) {
            return 0;
        }

        $secondUserId = $friendship->getUserId()->getId();
        if ($secondUserId === $userId) {
            $secondUserId = $friendship->getWhoId()->getId();
        }

        $this->em->remove($friendship);

        $this->insertMessageAboutReject($secondUserId, $userName);

        return 1;
    }

    public function cancelInvitation(int $id, int $userId, string $userName): bool
    {
        $friendship = $this->em->getRepository('AppBundle:Friend')->getOneSentInvitation($id, $userId);
        if (!$friendship) {
            return 0;
        }

        $secondUserId = $friendship->getUserId()->getId();
        if ($secondUserId === $userId) {
            $secondUserId = $friendship->getWhoId()->getId();
        }

        $this->em->remove($friendship);

        $this->insertMessageAboutCancelInvitation($secondUserId, $userName);

        return 1;
    }

    public function addFriend(int $id, User $user): bool
    {
        if (!$this->checkId($id, $user->getId())) {
            return 0;
        }
        if ($this->em->getRepository('AppBundle:Friend')->getOneFriendship($id, $user->getId())) {
            return 0;
        }
        if ($this->em->getRepository('AppBundle:Friend')->checkIfUserReceivedInvitation($id, $user->getId())) {
            return 0;
        }
        if ($this->em->getRepository('AppBundle:Friend')->checkIfUserSentInvitation($id, $user->getId())) {
            return 0;
        }
        $this->insertMessageAboutInvitation($user->getUsername(), $id);
        $this->insertInvitation($id, $user);
        return 1;
    }

    private function insertMessageAboutCancelInvitation(int $userId, string $userName)
    {
        $report = new Report();
        $report->setContent(
            '<div class="text-center">Gracz ' . $userName . ' cofnął prośbę o dodanie do znajomych.</div>'
        );
        $report->setTitle($userName . ' cofnął zaproszenie.');

        $this->insertMessage($userId, $report);
    }

    private function insertMessageAboutReject(int $userId, string $userName)
    {
        $report = new Report();
        $report->setContent(
            '<div class="text-center">Gracz ' . $userName . ' odrzucił Twoje zaproszenie do znajomych.</div>'
        );
        $report->setTitle($userName . ' odrzucił zaproszenie.');

        $this->insertMessage($userId, $report);
    }

    private function insertMessageAboutDelete(int $userId, string $userName)
    {
        $report = new Report();
        $report->setContent('<div class="text-center">Gracz ' . $userName . ' usunął Cię ze znajomych.</div>');
        $report->setTitle($userName . ' usunął Cię ze znajomych.');

        $this->insertMessage($userId, $report);
    }

    private function insertMessageAboutAccept(int $userId, string $userName)
    {
        $report = new Report();
        $report->setContent(
            '<div class="text-center">Gracz ' . $userName . ' zaakceptował Twoje zaproszenie do znajomych.</div>'
        );
        $report->setTitle($userName . ' zaakceptował zaproszenie.');

        $this->insertMessage($userId, $report);
    }

    private function insertMessage(int $userId, Report $report)
    {
        $report->setTime(new \DateTime);
        $report->setUserId($userId);
        $report->setIsRead(0);
        $this->em->persist($report);
        $this->em->flush();
    }

    private function insertMessageAboutInvitation(string $name, int $id)
    {
        $report = new Report();
        $report->setContent('Użytkownik '.$name.' zaprasza Cię do znajomych.');
        $report->setTitle('Nowe zaproszenie do znajomych');
        $this->insertMessage($id, $report);
    }

    private function insertInvitation(int $id, User $user)
    {
        $userToSent = $this->em->find('AppBundle:User', $id);
        $friendship = new Friend();
        $friendship->setInvitation(1);
        $friendship->setAccepted(0);
        $friendship->setUserId($user);
        $friendship->setWhoId($userToSent);

        $this->em->persist($friendship);
        $this->em->flush();
    }

    private function checkId(int $id, int $userId)
    {
        if ($id === 0) {
            return 0;
        }
        if ($id === $userId) {
            return 0;
        }
        return 1;
    }
}
