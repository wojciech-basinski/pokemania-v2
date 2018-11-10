<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PokemonTraining
 *
 * @ORM\Table(name="pokemon_training")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PokemonTrainingRepository")
 */
class PokemonTraining
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
     * @ORM\Column(name="berry_limit", type="smallint")
     */
    private $berryLimit;

    /**
     * @var int
     *
     * @ORM\Column(name="berry_attack", type="smallint")
     */
    private $berryAttack;

    /**
     * @var int
     *
     * @ORM\Column(name="berry_defence", type="smallint")
     */
    private $berryDefence;

    /**
     * @var int
     *
     * @ORM\Column(name="berry_sp_attack", type="smallint")
     */
    private $berrySpAttack;

    /**
     * @var int
     *
     * @ORM\Column(name="berry_sp_defence", type="smallint")
     */
    private $berrySpDefence;

    /**
     * @var int
     *
     * @ORM\Column(name="berry_speed", type="smallint")
     */
    private $berrySpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_1", type="integer")
     */
    private $tr1;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_2", type="integer")
     */
    private $tr2;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_3", type="integer")
     */
    private $tr3;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_4", type="integer")
     */
    private $tr4;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_5", type="integer")
     */
    private $tr5;


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
     * Set berryLimit
     *
     * @param integer $berryLimit
     *
     * @return PokemonTraining
     */
    public function setBerryLimit($berryLimit)
    {
        $this->berryLimit = $berryLimit;

        return $this;
    }

    /**
     * Get berryLimit
     *
     * @return int
     */
    public function getBerryLimit()
    {
        return $this->berryLimit;
    }

    /**
     * Set berryAttack
     *
     * @param integer $berryAttack
     *
     * @return PokemonTraining
     */
    public function setBerryAttack($berryAttack)
    {
        $this->berryAttack = $berryAttack;

        return $this;
    }

    /**
     * Get berryAttack
     *
     * @return int
     */
    public function getBerryAttack()
    {
        return $this->berryAttack;
    }

    /**
     * Set berryDefence
     *
     * @param integer $berryDefence
     *
     * @return PokemonTraining
     */
    public function setBerryDefence($berryDefence)
    {
        $this->berryDefence = $berryDefence;

        return $this;
    }

    /**
     * Get berryDefence
     *
     * @return int
     */
    public function getBerryDefence()
    {
        return $this->berryDefence;
    }

    /**
     * Set berrySpAttack
     *
     * @param integer $berrySpAttack
     *
     * @return PokemonTraining
     */
    public function setBerrySpAttack($berrySpAttack)
    {
        $this->berrySpAttack = $berrySpAttack;

        return $this;
    }

    /**
     * Get berrySpAttack
     *
     * @return int
     */
    public function getBerrySpAttack()
    {
        return $this->berrySpAttack;
    }

    /**
     * Set berrySpDefence
     *
     * @param integer $berrySpDefence
     *
     * @return PokemonTraining
     */
    public function setBerrySpDefence($berrySpDefence)
    {
        $this->berrySpDefence = $berrySpDefence;

        return $this;
    }

    /**
     * Get berrySpDefence
     *
     * @return int
     */
    public function getBerrySpDefence()
    {
        return $this->berrySpDefence;
    }

    /**
     * Set berrySpeed
     *
     * @param integer $berrySpeed
     *
     * @return PokemonTraining
     */
    public function setBerrySpeed($berrySpeed)
    {
        $this->berrySpeed = $berrySpeed;

        return $this;
    }

    /**
     * Get berrySpeed
     *
     * @return int
     */
    public function getBerrySpeed()
    {
        return $this->berrySpeed;
    }

    /**
     * Set tr1
     *
     * @param integer $tr1
     *
     * @return PokemonTraining
     */
    public function setTr1($tr1)
    {
        $this->tr1 = $tr1;

        return $this;
    }

    /**
     * Get tr1
     *
     * @return int
     */
    public function getTr1()
    {
        return $this->tr1;
    }

    /**
     * Set tr2
     *
     * @param integer $tr2
     *
     * @return PokemonTraining
     */
    public function setTr2($tr2)
    {
        $this->tr2 = $tr2;

        return $this;
    }

    /**
     * Get tr2
     *
     * @return int
     */
    public function getTr2()
    {
        return $this->tr2;
    }

    /**
     * Set tr3
     *
     * @param integer $tr3
     *
     * @return PokemonTraining
     */
    public function setTr3($tr3)
    {
        $this->tr3 = $tr3;

        return $this;
    }

    /**
     * Get tr3
     *
     * @return int
     */
    public function getTr3()
    {
        return $this->tr3;
    }

    /**
     * Set tr4
     *
     * @param integer $tr4
     *
     * @return PokemonTraining
     */
    public function setTr4($tr4)
    {
        $this->tr4 = $tr4;

        return $this;
    }

    /**
     * Get tr4
     *
     * @return int
     */
    public function getTr4()
    {
        return $this->tr4;
    }

    /**
     * Set tr5
     *
     * @param integer $tr5
     *
     * @return PokemonTraining
     */
    public function setTr5($tr5)
    {
        $this->tr5 = $tr5;

        return $this;
    }

    /**
     * Get tr5
     *
     * @return int
     */
    public function getTr5()
    {
        return $this->tr5;
    }
}
