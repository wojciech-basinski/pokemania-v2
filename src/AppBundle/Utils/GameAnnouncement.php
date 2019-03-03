<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GameAnnouncement
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAnnouncements(int $page, User $user): array
    {
        $user->setAnnouncements(0);
        $this->em->flush();
        return $this->em->getRepository('AppBundle:Announcement')->getAnnouncements($page);
    }

    public function countAnnouncements(): ?int
    {
        return $this->em->getRepository('AppBundle:Announcement')->countAnnouncements();
    }
}
