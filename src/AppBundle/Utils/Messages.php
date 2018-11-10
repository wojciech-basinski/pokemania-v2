<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;

class Messages
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllUserMessages(int $userId)
    {
        return $this->em->getRepository('AppBundle:Message')->getAllUserMessages($userId);
    }

    public function markMessagesAsRead(int $userId)
    {
        $this->em->getRepository('AppBundle:Message')->markMessagesAsRead($userId);
    }
}
