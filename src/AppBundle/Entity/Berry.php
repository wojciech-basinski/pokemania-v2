<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Berry
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
    private $cheriBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $chestoBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $pechaBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $rawstBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $aspearBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $leppaBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $oranBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $persimBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lumBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $sitrusBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $figyBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $wikiBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $magoBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $aguavBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lapapaBerry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $razzBerry;


    public function getId(): int
    {
        return $this->id;
    }

    public function setCheriBerry(int $cheriBerry): self
    {
        $this->cheriBerry = $cheriBerry;

        return $this;
    }

    public function getCheriBerry(): int
    {
        return $this->cheriBerry;
    }

    public function setChestoBerry(int $chestoBerry): self
    {
        $this->chestoBerry = $chestoBerry;

        return $this;
    }

    public function getChestoBerry(): int
    {
        return $this->chestoBerry;
    }

    public function setPechaBerry(int $pechaBerry): self
    {
        $this->pechaBerry = $pechaBerry;

        return $this;
    }

    public function getPechaBerry(): int
    {
        return $this->pechaBerry;
    }

    public function setRawstBerry(int $rawstBerry): self
    {
        $this->rawstBerry = $rawstBerry;

        return $this;
    }

    public function getRawstBerry(): int
    {
        return $this->rawstBerry;
    }

    public function setAspearBerry(int $aspearBerry): self
    {
        $this->aspearBerry = $aspearBerry;

        return $this;
    }

    public function getAspearBerry(): int
    {
        return $this->aspearBerry;
    }

    public function setLeppaBerry(int $leppaBerry): self
    {
        $this->leppaBerry = $leppaBerry;

        return $this;
    }

    public function getLeppaBerry(): int
    {
        return $this->leppaBerry;
    }

    public function setOranBerry(int $oranBerry): self
    {
        $this->oranBerry = $oranBerry;

        return $this;
    }

    public function getOranBerry(): int
    {
        return $this->oranBerry;
    }

    public function setPersimBerry(int $persimBerry): self
    {
        $this->persimBerry = $persimBerry;

        return $this;
    }

    public function getPersimBerry(): int
    {
        return $this->persimBerry;
    }

    public function setLumBerry(int $lumBerry): self
    {
        $this->lumBerry = $lumBerry;

        return $this;
    }

    public function getLumBerry(): int
    {
        return $this->lumBerry;
    }

    public function setSitrusBerry(int $sitrusBerry): self
    {
        $this->sitrusBerry = $sitrusBerry;

        return $this;
    }

    public function getSitrusBerry(): int
    {
        return $this->sitrusBerry;
    }

    public function setFigyBerry(int $figyBerry): self
    {
        $this->figyBerry = $figyBerry;

        return $this;
    }

    public function getFigyBerry(): int
    {
        return $this->figyBerry;
    }

    public function setWikiBerry(int $wikiBerry): self
    {
        $this->wikiBerry = $wikiBerry;

        return $this;
    }

    public function getWikiBerry(): int
    {
        return $this->wikiBerry;
    }

    public function setMagoBerry(int $magoBerry): self
    {
        $this->magoBerry = $magoBerry;

        return $this;
    }

    public function getMagoBerry(): int
    {
        return $this->magoBerry;
    }

    public function setAguavBerry(int $aguavBerry): self
    {
        $this->aguavBerry = $aguavBerry;

        return $this;
    }

    public function getAguavBerry(): int
    {
        return $this->aguavBerry;
    }

    public function setLapapaBerry(int $lapapaBerry): self
    {
        $this->lapapaBerry = $lapapaBerry;

        return $this;
    }

    public function getLapapaBerry(): int
    {
        return $this->lapapaBerry;
    }

    public function setRazzBerry(int $razzBerry): self
    {
        $this->razzBerry = $razzBerry;

        return $this;
    }

    public function getRazzBerry(): int
    {
        return $this->razzBerry;
    }
}
