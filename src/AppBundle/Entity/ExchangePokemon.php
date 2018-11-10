<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExchangePokemon
 *
 * @ORM\Table(name="exchange_pokemon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExchangePokemonRepository")
 */
class ExchangePokemon
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
     * @ORM\Column(name="owner", type="integer")
     */
    private $owner;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_in_db", type="integer")
     */
    private $idInDb;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


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
     * Set owner
     *
     * @param integer $owner
     *
     * @return ExchangePokemon
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set pokemonId
     *
     * @param integer $pokemonId
     *
     * @return ExchangePokemon
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
     * @param int $time
     *
     * @return ExchangePokemon
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

    /**
     * @return int
     */
    public function getIdInDb(): int
    {
        return $this->idInDb;
    }

    /**
     * @param int $idInDb
     */
    public function setIdInDb(int $idInDb): void
    {
        $this->idInDb = $idInDb;
    }
}
