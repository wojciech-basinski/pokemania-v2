<?php
namespace AppBundle\Utils\User;

class UserItems
{
    private $heals;
    private $kit;
    private $pokedex;
    private $shovel;

    public function __construct($u)
    {
        $this->heals = $u[0];
        $this->kit = $u[1];
        $this->pokedex = $u[2];
        $this->shovel = $u[3];
    }

    public function getHeals(): int
    {
        return $this->heals;
    }

    public function setHeals(int $heals): self
    {
        $this->heals = $heals;

        return $this;
    }

    public function getKit(): int
    {
        return $this->kit;
    }

    public function setKit(int $kit): self
    {
        $this->kit = $kit;

        return $this;
    }

    public function getPokedex(): int
    {
        return $this->pokedex;
    }

    public function setPokedex(int $pokedex): self
    {
        $this->pokedex = $pokedex;

        return $this;
    }

    public function getShovel(): bool
    {
        return $this->shovel;
    }

    public function setShovel(bool $shovel): self
    {
        $this->shovel = $shovel;

        return $this;
    }

    public function getAll(): string
    {
        return $this->heals . '|' . $this->kit . '|' . $this->pokedex . '|' . $this->shovel;
    }
}
