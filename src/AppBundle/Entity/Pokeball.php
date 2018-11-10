<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pokeball
 *
 * @ORM\Table(name="pokeball")
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
     * @ORM\Column(name="pokeballs", type="integer")
     */
    private $pokeballs;

    /**
     * @var int
     *
     * @ORM\Column(name="nestballs", type="integer")
     */
    private $nestballs;

    /**
     * @var int
     *
     * @ORM\Column(name="greatballs", type="integer")
     */
    private $greatballs;

    /**
     * @var int
     *
     * @ORM\Column(name="ultraballs", type="integer")
     */
    private $ultraballs;

    /**
     * @var int
     *
     * @ORM\Column(name="duskballs", type="integer")
     */
    private $duskballs;

    /**
     * @var int
     *
     * @ORM\Column(name="lureballs", type="integer")
     */
    private $lureballs;

    /**
     * @var int
     *
     * @ORM\Column(name="cherishballs", type="integer")
     */
    private $cherishballs;

    /**
     * @var int
     *
     * @ORM\Column(name="masterballs", type="smallint")
     */
    private $masterballs;

    /**
     * @var int
     *
     * @ORM\Column(name="repeatballs", type="integer")
     */
    private $repeatballs;

    /**
     * @var int
     *
     * @ORM\Column(name="safariballs", type="smallint")
     */
    private $safariballs;


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
     * Set pokeballs
     *
     * @param integer $pokeballs
     *
     * @return Pokeball
     */
    public function setPokeballs($pokeballs)
    {
        $this->pokeballs = $pokeballs;

        return $this;
    }

    /**
     * Get pokeballs
     *
     * @return int
     */
    public function getPokeballs()
    {
        return $this->pokeballs;
    }

    /**
     * Set nestballs
     *
     * @param integer $nestballs
     *
     * @return Pokeball
     */
    public function setNestballs($nestballs)
    {
        $this->nestballs = $nestballs;

        return $this;
    }

    /**
     * Get nestballs
     *
     * @return int
     */
    public function getNestballs()
    {
        return $this->nestballs;
    }

    /**
     * Set greatballs
     *
     * @param integer $greatballs
     *
     * @return Pokeball
     */
    public function setGreatballs($greatballs)
    {
        $this->greatballs = $greatballs;

        return $this;
    }

    /**
     * Get greatballs
     *
     * @return int
     */
    public function getGreatballs()
    {
        return $this->greatballs;
    }

    /**
     * Set ultraballs
     *
     * @param integer $ultraballs
     *
     * @return Pokeball
     */
    public function setUltraballs($ultraballs)
    {
        $this->ultraballs = $ultraballs;

        return $this;
    }

    /**
     * Get ultraballs
     *
     * @return int
     */
    public function getUltraballs()
    {
        return $this->ultraballs;
    }

    /**
     * Set duskballs
     *
     * @param integer $duskballs
     *
     * @return Pokeball
     */
    public function setDuskballs($duskballs)
    {
        $this->duskballs = $duskballs;

        return $this;
    }

    /**
     * Get duskballs
     *
     * @return int
     */
    public function getDuskballs()
    {
        return $this->duskballs;
    }

    /**
     * Set lureballs
     *
     * @param integer $lureballs
     *
     * @return Pokeball
     */
    public function setLureballs($lureballs)
    {
        $this->lureballs = $lureballs;

        return $this;
    }

    /**
     * Get lureballs
     *
     * @return int
     */
    public function getLureballs()
    {
        return $this->lureballs;
    }

    /**
     * Set cherishballs
     *
     * @param integer $cherishballs
     *
     * @return Pokeball
     */
    public function setCherishballs($cherishballs)
    {
        $this->cherishballs = $cherishballs;

        return $this;
    }

    /**
     * Get cherishballs
     *
     * @return int
     */
    public function getCherishballs()
    {
        return $this->cherishballs;
    }

    /**
     * Set masterballs
     *
     * @param integer $masterballs
     *
     * @return Pokeball
     */
    public function setMasterballs($masterballs)
    {
        $this->masterballs = $masterballs;

        return $this;
    }

    /**
     * Get masterballs
     *
     * @return int
     */
    public function getMasterballs()
    {
        return $this->masterballs;
    }

    /**
     * Set repeatballs
     *
     * @param integer $repeatballs
     *
     * @return Pokeball
     */
    public function setRepeatballs($repeatballs)
    {
        $this->repeatballs = $repeatballs;

        return $this;
    }

    /**
     * Get repeatballs
     *
     * @return int
     */
    public function getRepeatballs()
    {
        return $this->repeatballs;
    }

    /**
     * Set saferiballs
     *
     * @param integer $safariballs
     *
     * @return Pokeball
     */
    public function setSafariballs($safariballs)
    {
        $this->safariballs = $safariballs;

        return $this;
    }

    /**
     * Get safariballs
     *
     * @return int
     */
    public function getSafariballs()
    {
        return $this->safariballs;
    }
}
