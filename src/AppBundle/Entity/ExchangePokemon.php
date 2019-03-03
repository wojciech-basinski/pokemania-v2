<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $pokemonId;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $idInDb;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setOwner(int $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOwner(): int
    {
        return $this->owner;
    }

    public function setPokemonId(int $pokemonId): self
    {
        $this->pokemonId = $pokemonId;

        return $this;
    }

    public function getPokemonId(): int
    {
        return $this->pokemonId;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getIdInDb(): int
    {
        return $this->idInDb;
    }

    public function setIdInDb(int $idInDb): self
    {
        $this->idInDb = $idInDb;

        return $this;
    }
}
