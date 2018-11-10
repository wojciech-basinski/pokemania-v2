<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="your_id", type="integer")
     */
    private $yourId;

    /**
     * @var int
     *
     * @ORM\Column(name="sender_id", type="integer")
     */
    private $senderId;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_date", type="datetime")
     */
    private $lastDate;

    /**
     * @var int
     *
     * @ORM\Column(name="second_id", type="integer")
     */
    private $secondId;

    /**
     * @var int
     *
     * @ORM\Column(name="is_read", type="boolean")
     */
    private $isRead;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    private $userInfo;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set yourId
     *
     * @param integer $yourId
     *
     * @return Messages
     */
    public function setYourId($yourId)
    {
        $this->yourId = $yourId;

        return $this;
    }

    /**
     * Get yourId
     *
     * @return int
     */
    public function getYourId()
    {
        return $this->yourId;
    }

    /**
     * Set senderId
     *
     * @param integer $senderId
     *
     * @return Messages
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * Get senderId
     *
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Messages
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set lastDate
     *
     * @param \DateTime $lastDate
     *
     * @return Messages
     */
    public function setLastDate($lastDate)
    {
        $this->lastDate = $lastDate;

        return $this;
    }

    /**
     * Get lastDate
     *
     * @return \DateTime
     */
    public function getLastDate()
    {
        return $this->lastDate;
    }

    /**
     * Set secondId
     *
     * @param integer $secondId
     *
     * @return Messages
     */
    public function setSecondId($secondId)
    {
        $this->secondId = $secondId;

        return $this;
    }

    /**
     * Get secondId
     *
     * @return int
     */
    public function getSecondId()
    {
        return $this->secondId;
    }

    /**
     * @return int
     */
    public function getIsRead(): int
    {
        return $this->isRead;
    }

    /**
     * @param int $isRead
     */
    public function setIsRead(int $isRead)
    {
        $this->isRead = $isRead;
    }

    /**
     * @return User
     */
    public function getUserInfo(): User
    {
        return $this->userInfo;
    }
}
