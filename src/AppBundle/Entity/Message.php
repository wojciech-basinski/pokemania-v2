<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $yourId;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $senderId;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $lastDate;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $secondId;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    private $userInfo;

    public function getId(): int
    {
        return $this->id;
    }

    public function setYourId(int $yourId): self
    {
        $this->yourId = $yourId;

        return $this;
    }

    public function getYourId(): int
    {
        return $this->yourId;
    }

    public function setSenderId(int $senderId): self
    {
        $this->senderId = $senderId;

        return $this;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setLastDate(\DateTime $lastDate): self
    {
        $this->lastDate = $lastDate;

        return $this;
    }

    public function getLastDate(): \DateTime
    {
        return $this->lastDate;
    }

    public function setSecondId(int $secondId): self
    {
        $this->secondId = $secondId;

        return $this;
    }

    public function getSecondId(): ?int
    {
        return $this->secondId;
    }

    public function getIsRead(): bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead)
    {
        $this->isRead = $isRead;
    }

    public function getUserInfo(): User
    {
        return $this->userInfo;
    }
}
