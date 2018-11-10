<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTeam
 *
 * @ORM\Table(name="user_team")
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
     * @ORM\Column(name="pokemon1", type="integer", nullable=true)
     *
     */
    private $pokemon1;


    /**
     * @var int
     *
     * @ORM\Column(name="pokemon2", type="integer", nullable=true)
     */
    private $pokemon2;

    /**
     * @var int
     *
     * @ORM\Column(name="pokemon3", type="integer", nullable=true)
     */
    private $pokemon3;

    /**
     * @var int
     *
     * @ORM\Column(name="pokemon4", type="integer", nullable=true)
     */
    private $pokemon4;

    /**
     * @var int
     *
     * @ORM\Column(name="pokemon5", type="integer", nullable=true)
     */
    private $pokemon5;

    /**
     * @var int
     *
     * @ORM\Column(name="pokemon6", type="integer", nullable=true)
     */
    private $pokemon6;

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
     * Set pokemon1
     *
     * @param integer $pokemon1
     *
     * @return UserTeam
     */
    public function setPokemon1($pokemon1)
    {
        $this->pokemon1 = $pokemon1;

        return $this;
    }

    /**
     * Get pokemon1
     *
     * @return int
     */
    public function getPokemon1()
    {
        return $this->pokemon1;
    }

    /**
     * Set pokemon2
     *
     * @param integer $pokemon2
     *
     * @return UserTeam
     */
    public function setPokemon2($pokemon2)
    {
        $this->pokemon2 = $pokemon2;

        return $this;
    }

    /**
     * Get pokemon2
     *
     * @return int
     */
    public function getPokemon2()
    {
        return $this->pokemon2;
    }

    /**
     * Set pokemon3
     *
     * @param integer $pokemon3
     *
     * @return UserTeam
     */
    public function setPokemon3($pokemon3)
    {
        $this->pokemon3 = $pokemon3;

        return $this;
    }

    /**
     * Get pokemon3
     *
     * @return int
     */
    public function getPokemon3()
    {
        return $this->pokemon3;
    }

    /**
     * Set pokemon4
     *
     * @param integer $pokemon4
     *
     * @return UserTeam
     */
    public function setPokemon4($pokemon4)
    {
        $this->pokemon4 = $pokemon4;

        return $this;
    }

    /**
     * Get pokemon4
     *
     * @return int
     */
    public function getPokemon4()
    {
        return $this->pokemon4;
    }

    /**
     * Set pokemon5
     *
     * @param integer $pokemon5
     *
     * @return UserTeam
     */
    public function setPokemon5($pokemon5)
    {
        $this->pokemon5 = $pokemon5;

        return $this;
    }

    /**
     * Get pokemon5
     *
     * @return int
     */
    public function getPokemon5()
    {
        return $this->pokemon5;
    }

    /**
     * Set pokemon6
     *
     * @param integer $pokemon6
     *
     * @return UserTeam
     */
    public function setPokemon6($pokemon6)
    {
        $this->pokemon6 = $pokemon6;

        return $this;
    }

    /**
     * Get pokemon6
     *
     * @return int
     */
    public function getPokemon6()
    {
        return $this->pokemon6;
    }
}
