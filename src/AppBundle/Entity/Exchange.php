<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exchange
 *
 * @ORM\Table(name="exchange")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExchangeRepository")
 */
class Exchange
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
     * @var int
     *
     * @ORM\Column(name="pokemon_id", type="integer")
     */
    private $pokemonId;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;


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
     * @return Exchange
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
     * Set pokemonId
     *
     * @param integer $pokemonId
     *
     * @return Exchange
     */
    public function setPokemonId($pokemonId)
    {
        $this->pokemonId = $pokemonId;

        return $this;
    }

    /**
     * Get pokemonId
     *
     * @return int
     */
    public function getPokemonId()
    {
        return $this->pokemonId;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Exchange
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }
}
