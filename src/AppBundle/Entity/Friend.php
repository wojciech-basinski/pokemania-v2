<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Friends
 *
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
     * @ORM\Column(name="invitation", type="boolean")
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
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param User $userId
     *
     * @return Friend
     */
    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return User
     */
    public function getUserId(): User
    {
        return $this->userId;
    }

    /**
     * Set invitation
     *
     * @param boolean $invitation
     *
     * @return Friend
     */
    public function setInvitation(bool $invitation): self
    {
        $this->invitation = $invitation;

        return $this;
    }

    /**
     * Get invitation
     *
     * @return bool
     */
    public function getInvitation(): bool
    {
        return $this->invitation;
    }

    /**
     * Set whoId
     *
     * @param User $whoId
     *
     * @return Friend
     */
    public function setWhoId(User $whoId): self
    {
        $this->whoId = $whoId;

        return $this;
    }

    /**
     * Get whoId
     *
     * @return User
     */
    public function getWhoId(): User
    {
        return $this->whoId;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Friend
     */
    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return bool
     */
    public function getAccepted(): bool
    {
        return $this->accepted;
    }
}
