<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PokeballRepository")
 */
class Pokeball
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
    private $pokeballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $nestballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $greatballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $ultraballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $duskballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lureballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $cherishballs;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $masterballs;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $repeatballs;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $safariballs;

    public function getId(): int
    {
        return $this->id;
    }

    public function setPokeballs(int $pokeballs): self
    {
        $this->pokeballs = $pokeballs;

        return $this;
    }

    public function getPokeballs(): int
    {
        return $this->pokeballs;
    }

    public function setNestballs(int $nestballs): self
    {
        $this->nestballs = $nestballs;

        return $this;
    }

    public function getNestballs(): int
    {
        return $this->nestballs;
    }

    public function setGreatballs(int $greatballs): self
    {
        $this->greatballs = $greatballs;

        return $this;
    }

    public function getGreatballs(): int
    {
        return $this->greatballs;
    }

    public function setUltraballs(int $ultraballs): self
    {
        $this->ultraballs = $ultraballs;

        return $this;
    }

    public function getUltraballs(): int
    {
        return $this->ultraballs;
    }

    public function setDuskballs(int $duskballs): self
    {
        $this->duskballs = $duskballs;

        return $this;
    }

    public function getDuskballs(): int
    {
        return $this->duskballs;
    }

    public function setLureballs(int $lureballs): self
    {
        $this->lureballs = $lureballs;

        return $this;
    }

    public function getLureballs(): int
    {
        return $this->lureballs;
    }

    public function setCherishballs(int $cherishballs): self
    {
        $this->cherishballs = $cherishballs;

        return $this;
    }

    public function getCherishballs(): int
    {
        return $this->cherishballs;
    }

    public function setMasterballs(int $masterballs): self
    {
        $this->masterballs = $masterballs;

        return $this;
    }

    public function getMasterballs(): int
    {
        return $this->masterballs;
    }

    public function setRepeatballs(int $repeatballs): self
    {
        $this->repeatballs = $repeatballs;

        return $this;
    }

    public function getRepeatballs(): int
    {
        return $this->repeatballs;
    }

    public function setSafariballs(int $safariballs): self
    {
        $this->safariballs = $safariballs;

        return $this;
    }

    public function getSafariballs(): int
    {
        return $this->safariballs;
    }
}
