<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Berry
 *
 * @ORM\Table(name="berry")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BerryRepository")
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
     * @ORM\Column(name="cheri_berry", type="integer")
     */
    private $cheriBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="chesto_berry", type="integer")
     */
    private $chestoBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="pecha_berry", type="integer")
     */
    private $pechaBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="rawst_berry", type="integer")
     */
    private $rawstBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="aspear_berry", type="integer")
     */
    private $aspearBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="leppa_berry", type="integer")
     */
    private $leppaBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="oran_berry", type="integer")
     */
    private $oranBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="persim_berry", type="integer")
     */
    private $persimBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="lum_berry", type="integer")
     */
    private $lumBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="sitrus_berry", type="integer")
     */
    private $sitrusBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="figy_berry", type="integer")
     */
    private $figyBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="wiki_berry", type="integer")
     */
    private $wikiBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="mago_berry", type="integer")
     */
    private $magoBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="aguav_berry", type="integer")
     */
    private $aguavBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="lapapa_berry", type="integer")
     */
    private $lapapaBerry;

    /**
     * @var int
     *
     * @ORM\Column(name="razz_berry", type="integer")
     */
    private $razzBerry;


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
     * Set cheriBerry
     *
     * @param integer $cheriBerry
     *
     * @return Berry
     */
    public function setCheriBerry($cheriBerry)
    {
        $this->cheriBerry = $cheriBerry;

        return $this;
    }

    /**
     * Get cheriBerry
     *
     * @return int
     */
    public function getCheriBerry()
    {
        return $this->cheriBerry;
    }

    /**
     * Set chestoBerry
     *
     * @param integer $chestoBerry
     *
     * @return Berry
     */
    public function setChestoBerry($chestoBerry)
    {
        $this->chestoBerry = $chestoBerry;

        return $this;
    }

    /**
     * Get chestoBerry
     *
     * @return int
     */
    public function getChestoBerry()
    {
        return $this->chestoBerry;
    }

    /**
     * Set pechaBerry
     *
     * @param integer $pechaBerry
     *
     * @return Berry
     */
    public function setPechaBerry($pechaBerry)
    {
        $this->pechaBerry = $pechaBerry;

        return $this;
    }

    /**
     * Get pechaBerry
     *
     * @return int
     */
    public function getPechaBerry()
    {
        return $this->pechaBerry;
    }

    /**
     * Set rawstBerry
     *
     * @param integer $rawstBerry
     *
     * @return Berry
     */
    public function setRawstBerry($rawstBerry)
    {
        $this->rawstBerry = $rawstBerry;

        return $this;
    }

    /**
     * Get rawstBerry
     *
     * @return int
     */
    public function getRawstBerry()
    {
        return $this->rawstBerry;
    }

    /**
     * Set aspearBerry
     *
     * @param integer $aspearBerry
     *
     * @return Berry
     */
    public function setAspearBerry($aspearBerry)
    {
        $this->aspearBerry = $aspearBerry;

        return $this;
    }

    /**
     * Get aspearBerry
     *
     * @return int
     */
    public function getAspearBerry()
    {
        return $this->aspearBerry;
    }

    /**
     * Set leppaBerry
     *
     * @param integer $leppaBerry
     *
     * @return Berry
     */
    public function setLeppaBerry($leppaBerry)
    {
        $this->leppaBerry = $leppaBerry;

        return $this;
    }

    /**
     * Get leppaBerry
     *
     * @return int
     */
    public function getLeppaBerry()
    {
        return $this->leppaBerry;
    }

    /**
     * Set oranBerry
     *
     * @param integer $oranBerry
     *
     * @return Berry
     */
    public function setOranBerry($oranBerry)
    {
        $this->oranBerry = $oranBerry;

        return $this;
    }

    /**
     * Get oranBerry
     *
     * @return int
     */
    public function getOranBerry()
    {
        return $this->oranBerry;
    }

    /**
     * Set persimBerry
     *
     * @param integer $persimBerry
     *
     * @return Berry
     */
    public function setPersimBerry($persimBerry)
    {
        $this->persimBerry = $persimBerry;

        return $this;
    }

    /**
     * Get persimBerry
     *
     * @return int
     */
    public function getPersimBerry()
    {
        return $this->persimBerry;
    }

    /**
     * Set lumBerry
     *
     * @param integer $lumBerry
     *
     * @return Berry
     */
    public function setLumBerry($lumBerry)
    {
        $this->lumBerry = $lumBerry;

        return $this;
    }

    /**
     * Get lumBerry
     *
     * @return int
     */
    public function getLumBerry()
    {
        return $this->lumBerry;
    }

    /**
     * Set sitrusBerry
     *
     * @param integer $sitrusBerry
     *
     * @return Berry
     */
    public function setSitrusBerry($sitrusBerry)
    {
        $this->sitrusBerry = $sitrusBerry;

        return $this;
    }

    /**
     * Get sitrusBerry
     *
     * @return int
     */
    public function getSitrusBerry()
    {
        return $this->sitrusBerry;
    }

    /**
     * Set figyBerry
     *
     * @param integer $figyBerry
     *
     * @return Berry
     */
    public function setFigyBerry($figyBerry)
    {
        $this->figyBerry = $figyBerry;

        return $this;
    }

    /**
     * Get figyBerry
     *
     * @return int
     */
    public function getFigyBerry()
    {
        return $this->figyBerry;
    }

    /**
     * Set wikiBerry
     *
     * @param integer $wikiBerry
     *
     * @return Berry
     */
    public function setWikiBerry($wikiBerry)
    {
        $this->wikiBerry = $wikiBerry;

        return $this;
    }

    /**
     * Get wikiBerry
     *
     * @return int
     */
    public function getWikiBerry()
    {
        return $this->wikiBerry;
    }

    /**
     * Set magoBerry
     *
     * @param integer $magoBerry
     *
     * @return Berry
     */
    public function setMagoBerry($magoBerry)
    {
        $this->magoBerry = $magoBerry;

        return $this;
    }

    /**
     * Get magoBerry
     *
     * @return int
     */
    public function getMagoBerry()
    {
        return $this->magoBerry;
    }

    /**
     * Set aguavBerry
     *
     * @param integer $aguavBerry
     *
     * @return Berry
     */
    public function setAguavBerry($aguavBerry)
    {
        $this->aguavBerry = $aguavBerry;

        return $this;
    }

    /**
     * Get aguavBerry
     *
     * @return int
     */
    public function getAguavBerry()
    {
        return $this->aguavBerry;
    }

    /**
     * Set lapapaBerry
     *
     * @param integer $lapapaBerry
     *
     * @return Berry
     */
    public function setLapapaBerry($lapapaBerry)
    {
        $this->lapapaBerry = $lapapaBerry;

        return $this;
    }

    /**
     * Get lapapaBerry
     *
     * @return int
     */
    public function getLapapaBerry()
    {
        return $this->lapapaBerry;
    }

    /**
     * Set razzBerry
     *
     * @param integer $razzBerry
     *
     * @return Berry
     */
    public function setRazzBerry($razzBerry)
    {
        $this->razzBerry = $razzBerry;

        return $this;
    }

    /**
     * Get razzBerry
     *
     * @return int
     */
    public function getRazzBerry()
    {
        return $this->razzBerry;
    }
}
