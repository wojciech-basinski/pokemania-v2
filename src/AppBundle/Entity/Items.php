<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items
 *
 * @ORM\Table(name="items")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemsRepository")
 */
class Items
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
     * @ORM\Column(name="mpa", type="smallint")
     */
    private $mpa;

    /**
     * @var int
     *
     * @ORM\Column(name="lemonade", type="smallint")
     */
    private $lemonade;

    /**
     * @var int
     *
     * @ORM\Column(name="soda", type="smallint")
     */
    private $soda;

    /**
     * @var int
     *
     * @ORM\Column(name="water", type="smallint")
     */
    private $water;

    /**
     * @var bool
     *
     * @ORM\Column(name="flashlight", type="boolean")
     */
    private $flashlight;

    /**
     * @var int
     *
     * @ORM\Column(name="battery", type="smallint")
     */
    private $battery;

    /**
     * @var int
     *
     * @ORM\Column(name="box", type="smallint")
     */
    private $box;

    /**
     * @var int
     *
     * @ORM\Column(name="pokedex", type="smallint")
     */
    private $pokedex;

    /**
     * @var int
     *
     * @ORM\Column(name="cookie", type="smallint")
     */
    private $cookie;

    /**
     * @var int
     *
     * @ORM\Column(name="bar", type="smallint")
     */
    private $bar;

    /**
     * @var int
     *
     * @ORM\Column(name="kit", type="smallint")
     */
    private $kit;

    /**
     * @var int
     *
     * @ORM\Column(name="pokemon_food", type="smallint")
     */
    private $pokemonFood;

    /**
     * @var int
     *
     * @ORM\Column(name="parts", type="smallint")
     */
    private $parts;

    /**
     * @var int
     *
     * @ORM\Column(name="candy", type="smallint")
     */
    private $candy;

    /**
     * @var bool
     *
     * @ORM\Column(name="shovel", type="boolean")
     */
    private $shovel;

    /**
     * @var string
     *
     * @ORM\Column(name="coins", type="smallint")
     */
    private $coins;


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
     * Set mpa
     *
     * @param integer $mpa
     *
     * @return Items
     */
    public function setMpa($mpa)
    {
        $this->mpa = $mpa;

        return $this;
    }

    /**
     * Get mpa
     *
     * @return int
     */
    public function getMpa()
    {
        return $this->mpa;
    }

    /**
     * Set lemonade
     *
     * @param integer $lemonade
     *
     * @return Items
     */
    public function setLemonade($lemonade)
    {
        $this->lemonade = $lemonade;

        return $this;
    }

    /**
     * Get lemonade
     *
     * @return int
     */
    public function getLemonade()
    {
        return $this->lemonade;
    }

    /**
     * Set soda
     *
     * @param integer $soda
     *
     * @return Items
     */
    public function setSoda($soda)
    {
        $this->soda = $soda;

        return $this;
    }

    /**
     * Get soda
     *
     * @return int
     */
    public function getSoda()
    {
        return $this->soda;
    }

    /**
     * Set water
     *
     * @param integer $water
     *
     * @return Items
     */
    public function setWater($water)
    {
        $this->water = $water;

        return $this;
    }

    /**
     * Get water
     *
     * @return int
     */
    public function getWater()
    {
        return $this->water;
    }

    /**
     * Set flashlight
     *
     * @param boolean $flashlight
     *
     * @return Items
     */
    public function setFlashlight($flashlight)
    {
        $this->flashlight = $flashlight;

        return $this;
    }

    /**
     * Get flashlight
     *
     * @return bool
     */
    public function getFlashlight()
    {
        return $this->flashlight;
    }

    /**
     * Set battery
     *
     * @param integer $battery
     *
     * @return Items
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;

        return $this;
    }

    /**
     * Get battery
     *
     * @return int
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set box
     *
     * @param integer $box
     *
     * @return Items
     */
    public function setBox($box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get box
     *
     * @return int
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Set pokedex
     *
     * @param integer $pokedex
     *
     * @return Items
     */
    public function setPokedex($pokedex)
    {
        $this->pokedex = $pokedex;

        return $this;
    }

    /**
     * Get pokedex
     *
     * @return int
     */
    public function getPokedex()
    {
        return $this->pokedex;
    }

    /**
     * Set cookie
     *
     * @param integer $cookie
     *
     * @return Items
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    /**
     * Get cookie
     *
     * @return int
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * Set bar
     *
     * @param integer $bar
     *
     * @return Items
     */
    public function setBar($bar)
    {
        $this->bar = $bar;

        return $this;
    }

    /**
     * Get bar
     *
     * @return int
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * Set kit
     *
     * @param integer $kit
     *
     * @return Items
     */
    public function setKit($kit)
    {
        $this->kit = $kit;

        return $this;
    }

    /**
     * Get kit
     *
     * @return int
     */
    public function getKit()
    {
        return $this->kit;
    }

    /**
     * Set pokemonFood
     *
     * @param integer $pokemonFood
     *
     * @return Items
     */
    public function setPokemonFood($pokemonFood)
    {
        $this->pokemonFood = $pokemonFood;

        return $this;
    }

    /**
     * Get pokemonFood
     *
     * @return int
     */
    public function getPokemonFood()
    {
        return $this->pokemonFood;
    }

    /**
     * Set parts
     *
     * @param integer $parts
     *
     * @return Items
     */
    public function setParts($parts)
    {
        $this->parts = $parts;

        return $this;
    }

    /**
     * Get parts
     *
     * @return int
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * Set candy
     *
     * @param integer $candy
     *
     * @return Items
     */
    public function setCandy($candy)
    {
        $this->candy = $candy;

        return $this;
    }

    /**
     * Get candy
     *
     * @return int
     */
    public function getCandy()
    {
        return $this->candy;
    }

    /**
     * Set shovel
     *
     * @param boolean $shovel
     *
     * @return Items
     */
    public function setShovel($shovel)
    {
        $this->shovel = $shovel;

        return $this;
    }

    /**
     * Get shovel
     *
     * @return bool
     */
    public function getShovel()
    {
        return $this->shovel;
    }

    /**
     * Set coins
     *
     * @param string $coins
     *
     * @return Items
     */
    public function setCoins($coins)
    {
        $this->coins = $coins;

        return $this;
    }

    /**
     * Get coins
     *
     * @return string
     */
    public function getCoins()
    {
        return $this->coins;
    }
}
