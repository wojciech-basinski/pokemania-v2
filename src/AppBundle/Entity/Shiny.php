<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shiny
 *
 * @ORM\Table(name="shiny")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShinyRepository")
 */
class Shiny
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
     * @var integer
     *
     * @ORM\Column(name="region", type="smallint")
     */
    private $region;

    /**
     * @var int
     *
     * @ORM\Column(name="pokemon_id", type="smallint")
     */
    private $pokemonId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="caught", type="smallint")
     */
    private $caught;

    /**
     * @var int
     *
     * @ORM\Column(name="place", type="smallint")
     */
    private $place;

    /**
     * @var double
     *
     * @ORM\Column(name="chance", type="float")
     */
    private $chance;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set region.
     *
     * @param int $region
     *
     * @return Shiny
     */
    public function setRegion(int $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region.
     *
     * @return int
     */
    public function getRegion(): int
    {
        return $this->region;
    }

    /**
     * Set pokemonId.
     *
     * @param int $pokemonId
     *
     * @return Shiny
     */
    public function setPokemonId(int $pokemonId): self
    {
        $this->pokemonId = $pokemonId;

        return $this;
    }

    /**
     * Get pokemonId.
     *
     * @return int
     */
    public function getPokemonId(): int
    {
        return $this->pokemonId;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return Shiny
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $caught
     *
     * @return Shiny
     */
    public function setCaught(int $caught): Shiny
    {
        $this->caught = $caught;
        return $this;
}

    /**
     * @return int
     */
    public function getCaught(): int
    {
        return $this->caught;
    }

    /**
     * @param int $place
     *
     * @return Shiny
     */
    public function setPlace(int $place): self
    {
        $this->place = $place;
        return $this;
}

    /**
     * @return int
     */
    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * @param float $chance
     *
     * @return Shiny
     */
    public function setChance(float $chance): self
    {
        $this->chance = $chance;
        return $this;
}

    /**
     * @return float
     */
    public function getChance(): float
    {
        return $this->chance;
    }
}
