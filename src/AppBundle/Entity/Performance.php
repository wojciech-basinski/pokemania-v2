<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Performance
 *
 * @ORM\Table(name="performance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerformanceRepository")
 */
class Performance
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
     * @ORM\Column(name="lapanie", type="smallint")
     */
    private $lapanie;

    /**
     * @var int
     *
     * @ORM\Column(name="pokonane", type="smallint")
     */
    private $pokonane;

    /**
     * @var int
     *
     * @ORM\Column(name="trenerzy", type="smallint")
     */
    private $trenerzy;

    /**
     * @var int
     *
     * @ORM\Column(name="zbieranie", type="smallint")
     */
    private $zbieranie;

    /**
     * @var int
     *
     * @ORM\Column(name="hazardzista", type="smallint")
     */
    private $hazardzista;

    /**
     * @var int
     *
     * @ORM\Column(name="szkolenie", type="smallint")
     */
    private $szkolenie;

    /**
     * @var int
     *
     * @ORM\Column(name="trener", type="smallint")
     */
    private $trener;

    /**
     * @var int
     *
     * @ORM\Column(name="nolife", type="smallint")
     */
    private $nolife;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto", type="smallint")
     */
    private $znawcaKanto;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto1", type="smallint")
     */
    private $znawcaKanto1;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto2", type="smallint")
     */
    private $znawcaKanto2;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto3", type="smallint")
     */
    private $znawcaKanto3;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto4", type="smallint")
     */
    private $znawcaKanto4;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto5", type="smallint")
     */
    private $znawcaKanto5;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto6", type="smallint")
     */
    private $znawcaKanto6;

    /**
     * @var int
     *
     * @ORM\Column(name="znawca_kanto7", type="smallint")
     */
    private $znawcaKanto7;


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
     * Set lapanie
     *
     * @param integer $lapanie
     *
     * @return Performance
     */
    public function setLapanie($lapanie)
    {
        $this->lapanie = $lapanie;

        return $this;
    }

    /**
     * Get lapanie
     *
     * @return int
     */
    public function getLapanie()
    {
        return $this->lapanie;
    }

    /**
     * Set pokonane
     *
     * @param integer $pokonane
     *
     * @return Performance
     */
    public function setPokonane($pokonane)
    {
        $this->pokonane = $pokonane;

        return $this;
    }

    /**
     * Get pokonane
     *
     * @return int
     */
    public function getPokonane()
    {
        return $this->pokonane;
    }

    /**
     * Set trenerzy
     *
     * @param integer $trenerzy
     *
     * @return Performance
     */
    public function setTrenerzy($trenerzy)
    {
        $this->trenerzy = $trenerzy;

        return $this;
    }

    /**
     * Get trenerzy
     *
     * @return int
     */
    public function getTrenerzy()
    {
        return $this->trenerzy;
    }

    /**
     * Set zbieranie
     *
     * @param integer $zbieranie
     *
     * @return Performance
     */
    public function setZbieranie($zbieranie)
    {
        $this->zbieranie = $zbieranie;

        return $this;
    }

    /**
     * Get zbieranie
     *
     * @return int
     */
    public function getZbieranie()
    {
        return $this->zbieranie;
    }

    /**
     * Set hazardzista
     *
     * @param integer $hazardzista
     *
     * @return Performance
     */
    public function setHazardzista($hazardzista)
    {
        $this->hazardzista = $hazardzista;

        return $this;
    }

    /**
     * Get hazardzista
     *
     * @return int
     */
    public function getHazardzista()
    {
        return $this->hazardzista;
    }

    /**
     * Set szkolenie
     *
     * @param integer $szkolenie
     *
     * @return Performance
     */
    public function setSzkolenie($szkolenie)
    {
        $this->szkolenie = $szkolenie;

        return $this;
    }

    /**
     * Get szkolenie
     *
     * @return int
     */
    public function getSzkolenie()
    {
        return $this->szkolenie;
    }

    /**
     * Set trener
     *
     * @param integer $trener
     *
     * @return Performance
     */
    public function setTrener($trener)
    {
        $this->trener = $trener;

        return $this;
    }

    /**
     * Get trener
     *
     * @return int
     */
    public function getTrener()
    {
        return $this->trener;
    }

    /**
     * Set nolife
     *
     * @param integer $nolife
     *
     * @return Performance
     */
    public function setNolife($nolife)
    {
        $this->nolife = $nolife;

        return $this;
    }

    /**
     * Get nolife
     *
     * @return int
     */
    public function getNolife()
    {
        return $this->nolife;
    }

    /**
     * Set znawcaKanto
     *
     * @param integer $znawcaKanto
     *
     * @return Performance
     */
    public function setZnawcaKanto($znawcaKanto)
    {
        $this->znawcaKanto = $znawcaKanto;

        return $this;
    }

    /**
     * Get znawcaKanto
     *
     * @return int
     */
    public function getZnawcaKanto()
    {
        return $this->znawcaKanto;
    }

    /**
     * Set znawcaKanto1
     *
     * @param integer $znawcaKanto1
     *
     * @return Performance
     */
    public function setZnawcaKanto1($znawcaKanto1)
    {
        $this->znawcaKanto1 = $znawcaKanto1;

        return $this;
    }

    /**
     * Get znawcaKanto1
     *
     * @return int
     */
    public function getZnawcaKanto1()
    {
        return $this->znawcaKanto1;
    }

    /**
     * Set znawcaKanto2
     *
     * @param integer $znawcaKanto2
     *
     * @return Performance
     */
    public function setZnawcaKanto2($znawcaKanto2)
    {
        $this->znawcaKanto2 = $znawcaKanto2;

        return $this;
    }

    /**
     * Get znawcaKanto2
     *
     * @return int
     */
    public function getZnawcaKanto2()
    {
        return $this->znawcaKanto2;
    }

    /**
     * Set znawcaKanto3
     *
     * @param integer $znawcaKanto3
     *
     * @return Performance
     */
    public function setZnawcaKanto3($znawcaKanto3)
    {
        $this->znawcaKanto3 = $znawcaKanto3;

        return $this;
    }

    /**
     * Get znawcaKanto3
     *
     * @return int
     */
    public function getZnawcaKanto3()
    {
        return $this->znawcaKanto3;
    }

    /**
     * Set znawcaKanto4
     *
     * @param integer $znawcaKanto4
     *
     * @return Performance
     */
    public function setZnawcaKanto4($znawcaKanto4)
    {
        $this->znawcaKanto4 = $znawcaKanto4;

        return $this;
    }

    /**
     * Get znawcaKanto4
     *
     * @return int
     */
    public function getZnawcaKanto4()
    {
        return $this->znawcaKanto4;
    }

    /**
     * Set znawcaKanto5
     *
     * @param integer $znawcaKanto5
     *
     * @return Performance
     */
    public function setZnawcaKanto5($znawcaKanto5)
    {
        $this->znawcaKanto5 = $znawcaKanto5;

        return $this;
    }

    /**
     * Get znawcaKanto5
     *
     * @return int
     */
    public function getZnawcaKanto5()
    {
        return $this->znawcaKanto5;
    }

    /**
     * Set znawcaKanto6
     *
     * @param integer $znawcaKanto6
     *
     * @return Performance
     */
    public function setZnawcaKanto6($znawcaKanto6)
    {
        $this->znawcaKanto6 = $znawcaKanto6;

        return $this;
    }

    /**
     * Get znawcaKanto6
     *
     * @return int
     */
    public function getZnawcaKanto6()
    {
        return $this->znawcaKanto6;
    }

    /**
     * Set znawcaKanto7
     *
     * @param integer $znawcaKanto7
     *
     * @return Performance
     */
    public function setZnawcaKanto7($znawcaKanto7)
    {
        $this->znawcaKanto7 = $znawcaKanto7;

        return $this;
    }

    /**
     * Get znawcaKanto7
     *
     * @return int
     */
    public function getZnawcaKanto7()
    {
        return $this->znawcaKanto7;
    }
}
