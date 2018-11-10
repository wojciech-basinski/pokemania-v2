<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistic
 *
 * @ORM\Table(name="statistics")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatisticRepository")
 */
class Statistic
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
     * @ORM\Column(name="catched", type="integer")
     */
    private $catched;

    /**
     * @var int
     *
     * @ORM\Column(name="lottery", type="smallint")
     */
    private $lottery;

    /**
     * @var int
     *
     * @ORM\Column(name="cupons", type="smallint")
     */
    private $cupons;

    /**
     * @var int
     *
     * @ORM\Column(name="travels", type="smallint")
     */
    private $travels;


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
     * Set catched
     *
     * @param integer $catched
     *
     * @return Statistic
     */
    public function setCatched($catched)
    {
        $this->catched = $catched;

        return $this;
    }

    /**
     * Get catched
     *
     * @return int
     */
    public function getCatched()
    {
        return $this->catched;
    }

    /**
     * Set lottery
     *
     * @param integer $lottery
     *
     * @return Statistic
     */
    public function setLottery($lottery)
    {
        $this->lottery = $lottery;

        return $this;
    }

    /**
     * Get lottery
     *
     * @return int
     */
    public function getLottery()
    {
        return $this->lottery;
    }

    /**
     * Set cupons
     *
     * @param integer $cupons
     *
     * @return Statistic
     */
    public function setCupons($cupons)
    {
        $this->cupons = $cupons;

        return $this;
    }

    /**
     * Get cupons
     *
     * @return int
     */
    public function getCupons()
    {
        return $this->cupons;
    }

    /**
     * Set travels
     *
     * @param integer $travels
     *
     * @return Statistic
     */
    public function setTravels($travels)
    {
        $this->travels = $travels;

        return $this;
    }

    /**
     * Get travels
     *
     * @return int
     */
    public function getTravels()
    {
        return $this->travels;
    }
}
