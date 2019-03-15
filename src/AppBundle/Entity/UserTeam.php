<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserTeamRepository")
 */
class UserTeam
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pokemon1;


    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pokemon2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pokemon3;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pokemon4;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pokemon5;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pokemon6;

    public function getId(): int
    {
        return $this->id;
    }

    public function setPokemon1(int $pokemon1): self
    {
        $this->pokemon1 = $pokemon1;

        return $this;
    }

    public function getPokemon1(): int
    {
        return $this->pokemon1;
    }

    public function setPokemon2(int $pokemon2): self
    {
        $this->pokemon2 = $pokemon2;

        return $this;
    }

    public function getPokemon2(): int
    {
        return $this->pokemon2;
    }

    public function setPokemon3(int $pokemon3): self
    {
        $this->pokemon3 = $pokemon3;

        return $this;
    }

    public function getPokemon3(): int
    {
        return $this->pokemon3;
    }

    public function setPokemon4(int $pokemon4): self
    {
        $this->pokemon4 = $pokemon4;

        return $this;
    }

    public function getPokemon4(): int
    {
        return $this->pokemon4;
    }

    public function setPokemon5(int $pokemon5): self
    {
        $this->pokemon5 = $pokemon5;

        return $this;
    }

    public function getPokemon5(): int
    {
        return $this->pokemon5;
    }

    public function setPokemon6(int $pokemon6): self
    {
        $this->pokemon6 = $pokemon6;

        return $this;
    }

    public function getPokemon6(): int
    {
        return $this->pokemon6;
    }
}
