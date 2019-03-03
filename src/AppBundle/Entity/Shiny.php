<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="smallint")
     */
    private $region;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $pokemonId;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $caught;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $place;

    /**
     * @var double
     *
     * @ORM\Column(type="float")
     */
    private $chance;

    public function getId(): int
    {
        return $this->id;
    }

    public function setRegion(int $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRegion(): ?int
    {
        return $this->region;
    }

    public function setPokemonId(int $pokemonId): self
    {
        $this->pokemonId = $pokemonId;

        return $this;
    }

    public function getPokemonId(): ?int
    {
        return $this->pokemonId;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setCaught(int $caught): self
    {
        $this->caught = $caught;
        return $this;
    }

    public function getCaught(): ?int
    {
        return $this->caught;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;
        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setChance(float $chance): self
    {
        $this->chance = $chance;
        return $this;
    }

    public function getChance(): ?float
    {
        return $this->chance;
    }
}
