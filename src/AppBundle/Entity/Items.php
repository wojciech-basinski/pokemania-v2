<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="smallint")
     */
    private $mpa;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $lemonade;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $soda;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $water;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $flashlight;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $battery;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $box;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $pokedex;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $cookie;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $bar;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $kit;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $pokemonFood;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $parts;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $candy;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $shovel;

    /**
     * @var string
     *
     * @ORM\Column(type="smallint")
     */
    private $coins;

    public function getId(): int
    {
        return $this->id;
    }

    public function setMpa(int $mpa): self
    {
        $this->mpa = $mpa;

        return $this;
    }

    public function getMpa(): int
    {
        return $this->mpa;
    }

    public function setLemonade(int $lemonade): self
    {
        $this->lemonade = $lemonade;

        return $this;
    }

    public function getLemonade(): int
    {
        return $this->lemonade;
    }

    public function setSoda(int $soda): self
    {
        $this->soda = $soda;

        return $this;
    }

    public function getSoda(): int
    {
        return $this->soda;
    }

    public function setWater(int $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getWater(): int
    {
        return $this->water;
    }

    public function setFlashlight(bool $flashlight): self
    {
        $this->flashlight = $flashlight;

        return $this;
    }

    public function getFlashlight(): bool
    {
        return $this->flashlight;
    }

    public function setBattery(int $battery): self
    {
        $this->battery = $battery;

        return $this;
    }

    public function getBattery(): int
    {
        return $this->battery;
    }

    public function setBox(int $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getBox(): int
    {
        return $this->box;
    }

    public function setPokedex(int $pokedex): self
    {
        $this->pokedex = $pokedex;

        return $this;
    }

    public function getPokedex(): int
    {
        return $this->pokedex;
    }

    public function setCookie(int $cookie): self
    {
        $this->cookie = $cookie;

        return $this;
    }

    public function getCookie(): int
    {
        return $this->cookie;
    }

    public function setBar(int $bar): self
    {
        $this->bar = $bar;

        return $this;
    }

    public function getBar(): int
    {
        return $this->bar;
    }

    public function setKit(int $kit): self
    {
        $this->kit = $kit;

        return $this;
    }

    public function getKit(): int
    {
        return $this->kit;
    }

    public function setPokemonFood(int $pokemonFood): self
    {
        $this->pokemonFood = $pokemonFood;

        return $this;
    }

    public function getPokemonFood(): int
    {
        return $this->pokemonFood;
    }

    public function setParts(int $parts): self
    {
        $this->parts = $parts;

        return $this;
    }

    public function getParts(): int
    {
        return $this->parts;
    }

    public function setCandy(int $candy): self
    {
        $this->candy = $candy;

        return $this;
    }

    public function getCandy(): int
    {
        return $this->candy;
    }

    public function setShovel(bool $shovel): self
    {
        $this->shovel = $shovel;

        return $this;
    }

    public function getShovel(): bool
    {
        return $this->shovel;
    }

    public function setCoins(int $coins): self
    {
        $this->coins = $coins;

        return $this;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }
}
