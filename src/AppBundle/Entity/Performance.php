<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="smallint")
     */
    private $lapanie;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $pokonane;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $trenerzy;

    /**
     * @var int
     *
     * @ORM\Column( type="smallint")
     */
    private $zbieranie;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $hazardzista;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $szkolenie;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $trener;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $nolife;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto1;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto2;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto3;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto4;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto5;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto6;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $znawcaKanto7;

    public function getId(): int
    {
        return $this->id;
    }

    public function setLapanie(int $lapanie): self
    {
        $this->lapanie = $lapanie;

        return $this;
    }

    public function getLapanie(): int
    {
        return $this->lapanie;
    }

    public function setPokonane(int $pokonane): self
    {
        $this->pokonane = $pokonane;

        return $this;
    }

    public function getPokonane(): int
    {
        return $this->pokonane;
    }

    public function setTrenerzy(int $trenerzy): self
    {
        $this->trenerzy = $trenerzy;

        return $this;
    }

    public function getTrenerzy(): int
    {
        return $this->trenerzy;
    }

    public function setZbieranie(int $zbieranie): self
    {
        $this->zbieranie = $zbieranie;

        return $this;
    }

    public function getZbieranie(): int
    {
        return $this->zbieranie;
    }

    public function setHazardzista(int $hazardzista): self
    {
        $this->hazardzista = $hazardzista;

        return $this;
    }

    public function getHazardzista(): int
    {
        return $this->hazardzista;
    }

    public function setSzkolenie(int $szkolenie): self
    {
        $this->szkolenie = $szkolenie;

        return $this;
    }

    public function getSzkolenie(): int
    {
        return $this->szkolenie;
    }

    public function setTrener(int $trener): self
    {
        $this->trener = $trener;

        return $this;
    }

    public function getTrener(): int
    {
        return $this->trener;
    }

    public function setNolife(int $nolife): self
    {
        $this->nolife = $nolife;

        return $this;
    }

    public function getNolife(): int
    {
        return $this->nolife;
    }

    public function setZnawcaKanto(int $znawcaKanto): self
    {
        $this->znawcaKanto = $znawcaKanto;

        return $this;
    }

    public function getZnawcaKanto(): int
    {
        return $this->znawcaKanto;
    }

    public function setZnawcaKanto1(int $znawcaKanto1): self
    {
        $this->znawcaKanto1 = $znawcaKanto1;

        return $this;
    }

    public function getZnawcaKanto1(): int
    {
        return $this->znawcaKanto1;
    }

    public function setZnawcaKanto2(int $znawcaKanto2): self
    {
        $this->znawcaKanto2 = $znawcaKanto2;

        return $this;
    }

    public function getZnawcaKanto2(): int
    {
        return $this->znawcaKanto2;
    }

    public function setZnawcaKanto3(int $znawcaKanto3): self
    {
        $this->znawcaKanto3 = $znawcaKanto3;

        return $this;
    }

    public function getZnawcaKanto3(): int
    {
        return $this->znawcaKanto3;
    }

    public function setZnawcaKanto4(int $znawcaKanto4): self
    {
        $this->znawcaKanto4 = $znawcaKanto4;

        return $this;
    }

    public function getZnawcaKanto4(): int
    {
        return $this->znawcaKanto4;
    }

    public function setZnawcaKanto5(int $znawcaKanto5): self
    {
        $this->znawcaKanto5 = $znawcaKanto5;

        return $this;
    }

    public function getZnawcaKanto5(): int
    {
        return $this->znawcaKanto5;
    }

    public function setZnawcaKanto6(int $znawcaKanto6): self
    {
        $this->znawcaKanto6 = $znawcaKanto6;

        return $this;
    }

    public function getZnawcaKanto6(): int
    {
        return $this->znawcaKanto6;
    }

    public function setZnawcaKanto7(int $znawcaKanto7): self
    {
        $this->znawcaKanto7 = $znawcaKanto7;

        return $this;
    }

    public function getZnawcaKanto7(): int
    {
        return $this->znawcaKanto7;
    }
}
