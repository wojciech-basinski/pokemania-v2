<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="smallint")
     */
    private $fireStone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $waterStone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $leafStone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $thunderStone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $moonStone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $sunStone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $runes;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $obsydian;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $belt;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $ectoplasm;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $philosophicalStone;


    public function getId(): int
    {
        return $this->id;
    }

    public function setFireStone(int $fireStone): self
    {
        $this->fireStone = $fireStone;

        return $this;
    }

    public function getFireStone(): int
    {
        return $this->fireStone;
    }

    public function setWaterStone(int $waterStone): self
    {
        $this->waterStone = $waterStone;

        return $this;
    }

    public function getWaterStone(): int
    {
        return $this->waterStone;
    }

    public function setLeafStone(int $leafStone): self
    {
        $this->leafStone = $leafStone;

        return $this;
    }

    public function getLeafStone(): int
    {
        return $this->leafStone;
    }

    public function setThunderStone(int $thunderStone): self
    {
        $this->thunderStone = $thunderStone;

        return $this;
    }

    public function getThunderStone(): int
    {
        return $this->thunderStone;
    }

    public function setMoonStone(int $moonStone): self
    {
        $this->moonStone = $moonStone;

        return $this;
    }

    public function getMoonStone(): int
    {
        return $this->moonStone;
    }

    public function setSunStone(int $sunStone): self
    {
        $this->sunStone = $sunStone;

        return $this;
    }

    public function getSunStone(): int
    {
        return $this->sunStone;
    }

    public function setRunes(int $runes): self
    {
        $this->runes = $runes;

        return $this;
    }

    public function getRunes(): int
    {
        return $this->runes;
    }

    public function setObsydian(int $obsydian): self
    {
        $this->obsydian = $obsydian;

        return $this;
    }

    public function getObsydian(): int
    {
        return $this->obsydian;
    }

    public function setBelt(int $belt): self
    {
        $this->belt = $belt;

        return $this;
    }

    public function getBelt(): int
    {
        return $this->belt;
    }

    public function setEctoplasm(int $ectoplasm): self
    {
        $this->ectoplasm = $ectoplasm;

        return $this;
    }

    public function getEctoplasm(): int
    {
        return $this->ectoplasm;
    }

    public function setPhilosophicalStone(int $philosophicalStone): self
    {
        $this->philosophicalStone = $philosophicalStone;

        return $this;
    }

    public function getPhilosophicalStone(): int
    {
        return $this->philosophicalStone;
    }
}
