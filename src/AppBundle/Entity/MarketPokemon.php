<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Market_Pokemon
 *
 * @ORM\Table(name="market_pokemon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarketPokemonRepository")
 */
class MarketPokemon
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
     * @ORM\Column(name="id_pokemon", type="integer")
     */
    private $idPokemon;

    /**
     * @var int
     *
     * @ORM\Column(name="id_pokemon_base", type="smallint")
     */
    private $idPokemonBase;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="owner_id", type="integer")
     */
    private $ownerId;

    /**
     * @var bool
     *
     * @ORM\Column(name="shiny", type="boolean")
     */
    private $shiny;

    /**
     * @var int
     *
     * @ORM\Column(name="type1", type="smallint")
     */
    private $type1;

    /**
     * @var int
     *
     * @ORM\Column(name="type2", type="smallint")
     */
    private $type2;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="smallint")
     */
    private $gender;
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Pokemon", fetch="EAGER")
     * @ORM\JoinColumn(name="id_pokemon", referencedColumnName="id")
     */
    private $pokemonInfo;


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
     * Set idPokemon
     *
     * @param integer $idPokemon
     *
     * @return Market_Pokemon
     */
    public function setIdPokemon($idPokemon)
    {
        $this->idPokemon = $idPokemon;

        return $this;
    }

    /**
     * Get idPokemon
     *
     * @return int
     */
    public function getIdPokemon()
    {
        return $this->idPokemon;
    }

    /**
     * Set idPokemonBase
     *
     * @param integer $idPokemonBase
     *
     * @return Market_Pokemon
     */
    public function setIdPokemonBase($idPokemonBase)
    {
        $this->idPokemonBase = $idPokemonBase;

        return $this;
    }

    /**
     * Get idPokemonBase
     *
     * @return int
     */
    public function getIdPokemonBase()
    {
        return $this->idPokemonBase;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Market_Pokemon
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Market_Pokemon
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set ownerId
     *
     * @param integer $ownerId
     *
     * @return Market_Pokemon
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    /**
     * Get ownerId
     *
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Set shiny
     *
     * @param boolean $shiny
     *
     * @return Market_Pokemon
     */
    public function setShiny($shiny)
    {
        $this->shiny = $shiny;

        return $this;
    }

    /**
     * Get shiny
     *
     * @return bool
     */
    public function getShiny()
    {
        return $this->shiny;
    }

    /**
     * Set type1
     *
     * @param integer $type1
     *
     * @return Market_Pokemon
     */
    public function setType1($type1)
    {
        $this->type1 = $type1;

        return $this;
    }

    /**
     * Get type1
     *
     * @return int
     */
    public function getType1()
    {
        return $this->type1;
    }

    /**
     * Set type2
     *
     * @param integer $type2
     *
     * @return Market_Pokemon
     */
    public function setType2($type2)
    {
        $this->type2 = $type2;

        return $this;
    }

    /**
     * Get type2
     *
     * @return int
     */
    public function getType2()
    {
        return $this->type2;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Market_Pokemon
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Market_Pokemon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Market_Pokemon
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getPokemonInfo()
    {
        return $this->pokemonInfo;
    }

    /**
     * @param mixed $pokemonInfo
     */
    public function setPokemonInfo($pokemonInfo): void
    {
        $this->pokemonInfo = $pokemonInfo;
    }
}
