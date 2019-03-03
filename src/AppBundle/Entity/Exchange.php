<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $userId;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
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
}
