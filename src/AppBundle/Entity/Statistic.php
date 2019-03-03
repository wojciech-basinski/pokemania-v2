<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $catched;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $lottery;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $cupons;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $travels;

    public function getId(): int
    {
        return $this->id;
    }

    public function setCatched(int $catched): self
    {
        $this->catched = $catched;

        return $this;
    }

    public function getCatched(): int
    {
        return $this->catched;
    }

    public function setLottery(int $lottery): self
    {
        $this->lottery = $lottery;

        return $this;
    }

    public function getLottery(): int
    {
        return $this->lottery;
    }

    public function setCupons(int $cupons): self
    {
        $this->cupons = $cupons;

        return $this;
    }

    public function getCupons(): int
    {
        return $this->cupons;
    }

    public function setTravels(int $travels): self
    {
        $this->travels = $travels;

        return $this;
    }

    public function getTravels(): int
    {
        return $this->travels;
    }
}
