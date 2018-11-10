<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stones
 *
 * @ORM\Table(name="stones")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StonesRepository")
 */
class Stones
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
     * @ORM\Column(name="fire_stone", type="smallint")
     */
    private $fireStone;

    /**
     * @var int
     *
     * @ORM\Column(name="water_stone", type="smallint")
     */
    private $waterStone;

    /**
     * @var int
     *
     * @ORM\Column(name="leaf_stone", type="smallint")
     */
    private $leafStone;

    /**
     * @var int
     *
     * @ORM\Column(name="thunder_stone", type="smallint")
     */
    private $thunderStone;

    /**
     * @var int
     *
     * @ORM\Column(name="moon_stone", type="smallint")
     */
    private $moonStone;

    /**
     * @var int
     *
     * @ORM\Column(name="sun_stone", type="smallint")
     */
    private $sunStone;

    /**
     * @var int
     *
     * @ORM\Column(name="runes", type="smallint")
     */
    private $runes;

    /**
     * @var int
     *
     * @ORM\Column(name="obsydian", type="smallint")
     */
    private $obsydian;

    /**
     * @var int
     *
     * @ORM\Column(name="belt", type="smallint")
     */
    private $belt;

    /**
     * @var int
     *
     * @ORM\Column(name="ectoplasm", type="smallint")
     */
    private $ectoplasm;

    /**
     * @var int
     *
     * @ORM\Column(name="philosophical_stone", type="smallint")
     */
    private $philosophicalStone;


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
     * Set fireStone
     *
     * @param integer $fireStone
     *
     * @return Stones
     */
    public function setFireStone($fireStone)
    {
        $this->fireStone = $fireStone;

        return $this;
    }

    /**
     * Get fireStone
     *
     * @return int
     */
    public function getFireStone()
    {
        return $this->fireStone;
    }

    /**
     * Set waterStone
     *
     * @param integer $waterStone
     *
     * @return Stones
     */
    public function setWaterStone($waterStone)
    {
        $this->waterStone = $waterStone;

        return $this;
    }

    /**
     * Get waterStone
     *
     * @return int
     */
    public function getWaterStone()
    {
        return $this->waterStone;
    }

    /**
     * Set leafStone
     *
     * @param integer $leafStone
     *
     * @return Stones
     */
    public function setLeafStone($leafStone)
    {
        $this->leafStone = $leafStone;

        return $this;
    }

    /**
     * Get leafStone
     *
     * @return int
     */
    public function getLeafStone()
    {
        return $this->leafStone;
    }

    /**
     * Set thunderStone
     *
     * @param integer $thunderStone
     *
     * @return Stones
     */
    public function setThunderStone($thunderStone)
    {
        $this->thunderStone = $thunderStone;

        return $this;
    }

    /**
     * Get thunderStone
     *
     * @return int
     */
    public function getThunderStone()
    {
        return $this->thunderStone;
    }

    /**
     * Set moonStone
     *
     * @param integer $moonStone
     *
     * @return Stones
     */
    public function setMoonStone($moonStone)
    {
        $this->moonStone = $moonStone;

        return $this;
    }

    /**
     * Get moonStone
     *
     * @return int
     */
    public function getMoonStone()
    {
        return $this->moonStone;
    }

    /**
     * Set sunStone
     *
     * @param integer $sunStone
     *
     * @return Stones
     */
    public function setSunStone($sunStone)
    {
        $this->sunStone = $sunStone;

        return $this;
    }

    /**
     * Get sunStone
     *
     * @return int
     */
    public function getSunStone()
    {
        return $this->sunStone;
    }

    /**
     * Set runes
     *
     * @param integer $runes
     *
     * @return Stones
     */
    public function setRunes($runes)
    {
        $this->runes = $runes;

        return $this;
    }

    /**
     * Get runes
     *
     * @return int
     */
    public function getRunes()
    {
        return $this->runes;
    }

    /**
     * Set obsydian
     *
     * @param integer $obsydian
     *
     * @return Stones
     */
    public function setObsydian($obsydian)
    {
        $this->obsydian = $obsydian;

        return $this;
    }

    /**
     * Get obsydian
     *
     * @return int
     */
    public function getObsydian()
    {
        return $this->obsydian;
    }

    /**
     * Set belt
     *
     * @param integer $belt
     *
     * @return Stones
     */
    public function setBelt($belt)
    {
        $this->belt = $belt;

        return $this;
    }

    /**
     * Get belt
     *
     * @return int
     */
    public function getBelt()
    {
        return $this->belt;
    }

    /**
     * Set ectoplasm
     *
     * @param integer $ectoplasm
     *
     * @return Stones
     */
    public function setEctoplasm($ectoplasm)
    {
        $this->ectoplasm = $ectoplasm;

        return $this;
    }

    /**
     * Get ectoplasm
     *
     * @return int
     */
    public function getEctoplasm()
    {
        return $this->ectoplasm;
    }

    /**
     * Set philosophicalStone
     *
     * @param integer $philosophicalStone
     *
     * @return Stones
     */
    public function setPhilosophicalStone($philosophicalStone)
    {
        $this->philosophicalStone = $philosophicalStone;

        return $this;
    }

    /**
     * Get philosophicalStone
     *
     * @return int
     */
    public function getPhilosophicalStone()
    {
        return $this->philosophicalStone;
    }
}
