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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var bool
     *
     * @ORM\Column(name="invitation", type="boolean")
     */
    private $invitation;

    /**
     * @var int
     *
     * @ORM\Column(name="who_id", type="integer")
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Friend
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
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
    public function setInvitation($invitation)
    {
        $this->invitation = $invitation;

        return $this;
    }

    /**
     * Get invitation
     *
     * @return bool
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * Set whoId
     *
     * @param integer $whoId
     *
     * @return Friend
     */
    public function setWhoId($whoId)
    {
        $this->whoId = $whoId;

        return $this;
    }

    /**
     * Get whoId
     *
     * @return int
     */
    public function getWhoId()
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
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return bool
     */
    public function getAccepted()
    {
        return $this->accepted;
    }
}
