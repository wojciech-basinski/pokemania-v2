<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="friends")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FriendRepository")
 */
class Friend
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", fetch="EAGER")
     */
    private $userId;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $invitation;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", fetch="EAGER")
     */
    private $whoId;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $accepted;

    public function getId(): int
    {
        return $this->id;
    }

    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): User
    {
        return $this->userId;
    }

    public function setInvitation(bool $invitation): self
    {
        $this->invitation = $invitation;

        return $this;
    }

    public function getInvitation(): bool
    {
        return $this->invitation;
    }

    public function setWhoId(User $whoId): self
    {
        $this->whoId = $whoId;

        return $this;
    }

    public function getWhoId(): User
    {
        return $this->whoId;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getAccepted(): bool
    {
        return $this->accepted;
    }
}
