<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $idPokemon;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $idPokemonBase;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $ownerId;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $shiny;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $type1;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $type2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Pokemon", fetch="EAGER")
     * @ORM\JoinColumn(name="id_pokemon", referencedColumnName="id")
     */
    private $pokemonInfo;

    public function getId(): int
    {
        return $this->id;
    }

    public function setIdPokemon(int $idPokemon): self
    {
        $this->idPokemon = $idPokemon;

        return $this;
    }

    public function getIdPokemon(): int
    {
        return $this->idPokemon;
    }

    public function setIdPokemonBase(int $idPokemonBase): self
    {
        $this->idPokemonBase = $idPokemonBase;

        return $this;
    }

    public function getIdPokemonBase(): int
    {
        return $this->idPokemonBase;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setOwnerId(int $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setShiny(bool $shiny): self
    {
        $this->shiny = $shiny;

        return $this;
    }

    public function getShiny(): bool
    {
        return $this->shiny;
    }

    public function setType1(int $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType1(): int
    {
        return $this->type1;
    }

    public function setType2(int $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getType2(): int
    {
        return $this->type2;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getGender(): int
    {
        return $this->gender;
    }

    public function getPokemonInfo(): Pokemon
    {
        return $this->pokemonInfo;
    }

    public function setPokemonInfo(Pokemon $pokemonInfo): self
    {
        $this->pokemonInfo = $pokemonInfo;

        return $this;
    }
}
