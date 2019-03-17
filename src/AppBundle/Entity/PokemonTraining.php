<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="smallint")
     */
    private $berryLimit = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berryAttack = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berryDefence = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berrySpAttack = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berrySpDefence = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berrySpeed = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_1", type="smallint")
     */
    private $tr1 = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_2", type="smallint")
     */
    private $tr2 = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_3", type="smallint")
     */
    private $tr3 = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_4", type="smallint")
     */
    private $tr4 = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tr_5", type="smallint")
     */
    private $tr5 = 0;

    public function __construct(int $limit = null)
    {
        if ($limit === null) {
            $this->berryLimit = mt_rand(50, 75) * 5;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setBerryLimit(int $berryLimit): self
    {
        $this->berryLimit = $berryLimit;

        return $this;
    }

    public function getBerryLimit(): int
    {
        return $this->berryLimit;
    }

    public function setBerryAttack(int $berryAttack): self
    {
        $this->berryAttack = $berryAttack;

        return $this;
    }

    public function getBerryAttack(): int
    {
        return $this->berryAttack;
    }

    public function setBerryDefence(int $berryDefence): self
    {
        $this->berryDefence = $berryDefence;

        return $this;
    }

    public function getBerryDefence(): int
    {
        return $this->berryDefence;
    }

    public function setBerrySpAttack(int $berrySpAttack): self
    {
        $this->berrySpAttack = $berrySpAttack;

        return $this;
    }

    public function getBerrySpAttack(): int
    {
        return $this->berrySpAttack;
    }

    public function setBerrySpDefence(int $berrySpDefence): self
    {
        $this->berrySpDefence = $berrySpDefence;

        return $this;
    }

    public function getBerrySpDefence(): int
    {
        return $this->berrySpDefence;
    }

    public function setBerrySpeed(int $berrySpeed): self
    {
        $this->berrySpeed = $berrySpeed;

        return $this;
    }

    public function getBerrySpeed(): int
    {
        return $this->berrySpeed;
    }

    public function setTr1(int $tr1): self
    {
        $this->tr1 = $tr1;

        return $this;
    }

    public function getTr1(): int
    {
        return $this->tr1;
    }

    public function setTr2(int $tr2): self
    {
        $this->tr2 = $tr2;

        return $this;
    }

    public function getTr2(): int
    {
        return $this->tr2;
    }

    public function setTr3(int $tr3): self
    {
        $this->tr3 = $tr3;

        return $this;
    }

    public function getTr3(): int
    {
        return $this->tr3;
    }

    public function setTr4(int $tr4): self
    {
        $this->tr4 = $tr4;

        return $this;
    }

    public function getTr4(): int
    {
        return $this->tr4;
    }

    public function setTr5(int $tr5): self
    {
        $this->tr5 = $tr5;

        return $this;
    }

    public function getTr5(): int
    {
        return $this->tr5;
    }
}
