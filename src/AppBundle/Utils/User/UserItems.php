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

    /**
     * @return int
     */
    public function getHeals(): int
    {
        return $this->heals;
    }

    /**
     * @param int $heals
     */
    public function setHeals($heals)
    {
        $this->heals = $heals;
    }

    /**
     * @return int
     */
    public function getKit(): int
    {
        return $this->kit;
    }

    /**
     * @param int $kit
     */
    public function setKit($kit)
    {
        $this->kit = $kit;
    }

    /**
     * @return int
     */
    public function getPokedex(): int
    {
        return $this->pokedex;
    }

    /**
     * @param int $pokedex
     */
    public function setPokedex($pokedex)
    {
        $this->pokedex = $pokedex;
    }

    /**
     * @return int
     */
    public function getShovel(): int
    {
        return $this->shovel;
    }

    /**
     * @param bool $shovel
     */
    public function setShovel($shovel)
    {
        $this->shovel = $shovel;
    }

    /**
     * @return string
     */
    public function getAll(): string
    {
        return $this->heals . '|' . $this->kit . '|' . $this->pokedex . '|' . $this->shovel;
    }
}
