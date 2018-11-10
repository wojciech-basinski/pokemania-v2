<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achievements
 *
 * @ORM\Table(name="achievements")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AchievementRepository")
 */
class Achievement
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
     * @ORM\Column(name="polana", type="integer")
     */
    private $polana;

    /**
     * @var int
     *
     * @ORM\Column(name="wyspa", type="integer")
     */
    private $wyspa;

    /**
     * @var int
     *
     * @ORM\Column(name="grota", type="integer")
     */
    private $grota;

    /**
     * @var int
     *
     * @ORM\Column(name="dom_strachow", type="integer")
     */
    private $domStrachow;

    /**
     * @var int
     *
     * @ORM\Column(name="gory", type="integer")
     */
    private $gory;

    /**
     * @var int
     *
     * @ORM\Column(name="wodospad", type="integer")
     */
    private $wodospad;

    /**
     * @var int
     *
     * @ORM\Column(name="safari", type="integer")
     */
    private $safari;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_pokemons", type="integer")
     */
    private $catchedPokemons;

    /**
     * @var int
     *
     * @ORM\Column(name="wins_with_trainers", type="integer")
     */
    private $winsWithTrainers;

    /**
     * @var int
     *
     * @ORM\Column(name="wins_with_pokemons", type="integer")
     */
    private $winsWithPokemons;

    /**
     * @var int
     *
     * @ORM\Column(name="begged_berrys", type="integer")
     */
    private $beggedBerrys;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_pokeball", type="integer")
     */
    private $catchedPokeball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_nestball", type="integer")
     */
    private $catchedNestball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_greatball", type="integer")
     */
    private $catchedGreatball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_ultraball", type="integer")
     */
    private $catchedUltraball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_duskball", type="integer")
     */
    private $catchedDuskball;

    /**
     * @var string
     *
     * @ORM\Column(name="catched_lureball", type="integer")
     */
    private $catchedLureball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_cherishball", type="integer")
     */
    private $catchedCherishball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_repeatball", type="integer")
     */
    private $catchedRepeatball;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_safariball", type="integer")
     */
    private $catchedSafariball;

    /**
     * @var int
     *
     * @ORM\Column(name="snacks", type="integer")
     */
    private $snacks;

    /**
     * @var int
     *
     * @ORM\Column(name="logged_in", type="integer")
     */
    private $loggedIn;

    /**
     * @var int
     *
     * @ORM\Column(name="trainings_with_pokemons", type="integer")
     */
    private $trainingsWithPokemons;

    /**
     * @var int
     *
     * @ORM\Column(name="catched_shiny", type="smallint")
     */
    private $catchedShiny;

    /**
     * @var int
     *
     * @ORM\Column(name="wulkan", type="integer")
     */
    private $wulkan;

    /**
     * @var int
     *
     * @ORM\Column(name="laka", type="integer")
     */
    private $laka;

    /**
     * @var int
     *
     * @ORM\Column(name="lodowiec", type="integer")
     */
    private $lodowiec;

    /**
     * @var int
     *
     * @ORM\Column(name="mokradla", type="integer")
     */
    private $mokradla;

    /**
     * @var int
     *
     * @ORM\Column(name="johto5", type="integer")
     */
    private $johto5;

    /**
     * @var int
     *
     * @ORM\Column(name="jezioro", type="integer")
     */
    private $jezioro;

    /**
     * @var int
     *
     * @ORM\Column(name="mroczny_las", type="integer")
     */
    private $mrocznyLas;


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
     * Set polana
     *
     * @param integer $polana
     *
     * @return Achievements
     */
    public function setPolana($polana)
    {
        $this->polana = $polana;

        return $this;
    }

    /**
     * Get polana
     *
     * @return int
     */
    public function getPolana()
    {
        return $this->polana;
    }

    /**
     * Set wyspa
     *
     * @param integer $wyspa
     *
     * @return Achievements
     */
    public function setWyspa($wyspa)
    {
        $this->wyspa = $wyspa;

        return $this;
    }

    /**
     * Get wyspa
     *
     * @return int
     */
    public function getWyspa()
    {
        return $this->wyspa;
    }

    /**
     * Set grota
     *
     * @param integer $grota
     *
     * @return Achievements
     */
    public function setGrota($grota)
    {
        $this->grota = $grota;

        return $this;
    }

    /**
     * Get grota
     *
     * @return int
     */
    public function getGrota()
    {
        return $this->grota;
    }

    /**
     * Set domStrachow
     *
     * @param integer $domStrachow
     *
     * @return Achievements
     */
    public function setDomStrachow($domStrachow)
    {
        $this->domStrachow = $domStrachow;

        return $this;
    }

    /**
     * Get domStrachow
     *
     * @return int
     */
    public function getDomStrachow()
    {
        return $this->domStrachow;
    }

    /**
     * Set gory
     *
     * @param integer $gory
     *
     * @return Achievements
     */
    public function setGory($gory)
    {
        $this->gory = $gory;

        return $this;
    }

    /**
     * Get gory
     *
     * @return int
     */
    public function getGory()
    {
        return $this->gory;
    }

    /**
     * Set wodospad
     *
     * @param integer $wodospad
     *
     * @return Achievements
     */
    public function setWodospad($wodospad)
    {
        $this->wodospad = $wodospad;

        return $this;
    }

    /**
     * Get wodospad
     *
     * @return int
     */
    public function getWodospad()
    {
        return $this->wodospad;
    }

    /**
     * Set safari
     *
     * @param integer $safari
     *
     * @return Achievements
     */
    public function setSafari($safari)
    {
        $this->safari = $safari;

        return $this;
    }

    /**
     * Get safari
     *
     * @return int
     */
    public function getSafari()
    {
        return $this->safari;
    }

    /**
     * Set catchedPokemons
     *
     * @param integer $catchedPokemons
     *
     * @return Achievements
     */
    public function setCatchedPokemons($catchedPokemons)
    {
        $this->catchedPokemons = $catchedPokemons;

        return $this;
    }

    /**
     * Get catchedPokemons
     *
     * @return int
     */
    public function getCatchedPokemons()
    {
        return $this->catchedPokemons;
    }

    /**
     * Set winsWithTrainers
     *
     * @param integer $winsWithTrainers
     *
     * @return Achievements
     */
    public function setWinsWithTrainers($winsWithTrainers)
    {
        $this->winsWithTrainers = $winsWithTrainers;

        return $this;
    }

    /**
     * Get winsWithTrainers
     *
     * @return int
     */
    public function getWinsWithTrainers()
    {
        return $this->winsWithTrainers;
    }

    /**
     * Set winsWithPokemons
     *
     * @param integer $winsWithPokemons
     *
     * @return Achievements
     */
    public function setWinsWithPokemons($winsWithPokemons)
    {
        $this->winsWithPokemons = $winsWithPokemons;

        return $this;
    }

    /**
     * Get winsWithPokemons
     *
     * @return int
     */
    public function getWinsWithPokemons()
    {
        return $this->winsWithPokemons;
    }

    /**
     * Set beggedBerrys
     *
     * @param integer $beggedBerrys
     *
     * @return Achievements
     */
    public function setBeggedBerrys($beggedBerrys)
    {
        $this->beggedBerrys = $beggedBerrys;

        return $this;
    }

    /**
     * Get beggedBerrys
     *
     * @return int
     */
    public function getBeggedBerrys()
    {
        return $this->beggedBerrys;
    }

    /**
     * Set catchedPokeball
     *
     * @param integer $catchedPokeball
     *
     * @return Achievements
     */
    public function setCatchedPokeball($catchedPokeball)
    {
        $this->catchedPokeball = $catchedPokeball;

        return $this;
    }

    /**
     * Get catchedPokeball
     *
     * @return int
     */
    public function getCatchedPokeball()
    {
        return $this->catchedPokeball;
    }

    /**
     * Set catchedNestball
     *
     * @param integer $catchedNestball
     *
     * @return Achievements
     */
    public function setCatchedNestball($catchedNestball)
    {
        $this->catchedNestball = $catchedNestball;

        return $this;
    }

    /**
     * Get catchedNestball
     *
     * @return int
     */
    public function getCatchedNestball()
    {
        return $this->catchedNestball;
    }

    /**
     * Set catchedGreatball
     *
     * @param integer $catchedGreatball
     *
     * @return Achievements
     */
    public function setCatchedGreatball($catchedGreatball)
    {
        $this->catchedGreatball = $catchedGreatball;

        return $this;
    }

    /**
     * Get catchedGreatball
     *
     * @return int
     */
    public function getCatchedGreatball()
    {
        return $this->catchedGreatball;
    }

    /**
     * Set catchedUltraball
     *
     * @param integer $catchedUltraball
     *
     * @return Achievements
     */
    public function setCatchedUltraball($catchedUltraball)
    {
        $this->catchedUltraball = $catchedUltraball;

        return $this;
    }

    /**
     * Get catchedUltraball
     *
     * @return int
     */
    public function getCatchedUltraball()
    {
        return $this->catchedUltraball;
    }

    /**
     * Set catchedDuskball
     *
     * @param integer $catchedDuskball
     *
     * @return Achievements
     */
    public function setCatchedDuskball($catchedDuskball)
    {
        $this->catchedDuskball = $catchedDuskball;

        return $this;
    }

    /**
     * Get catchedDuskball
     *
     * @return int
     */
    public function getCatchedDuskball()
    {
        return $this->catchedDuskball;
    }

    /**
     * Set catchedLureball
     *
     * @param string $catchedLureball
     *
     * @return Achievements
     */
    public function setCatchedLureball($catchedLureball)
    {
        $this->catchedLureball = $catchedLureball;

        return $this;
    }

    /**
     * Get catchedLureball
     *
     * @return string
     */
    public function getCatchedLureball()
    {
        return $this->catchedLureball;
    }

    /**
     * Set catchedCherishball
     *
     * @param integer $catchedCherishball
     *
     * @return Achievements
     */
    public function setCatchedCherishball($catchedCherishball)
    {
        $this->catchedCherishball = $catchedCherishball;

        return $this;
    }

    /**
     * Get catchedCherishball
     *
     * @return int
     */
    public function getCatchedCherishball()
    {
        return $this->catchedCherishball;
    }

    /**
     * Set catchedRepeatball
     *
     * @param integer $catchedRepeatball
     *
     * @return Achievements
     */
    public function setCatchedRepeatball($catchedRepeatball)
    {
        $this->catchedRepeatball = $catchedRepeatball;

        return $this;
    }

    /**
     * Get catchedRepeatball
     *
     * @return int
     */
    public function getCatchedRepeatball()
    {
        return $this->catchedRepeatball;
    }

    /**
     * Set catchedSafariball
     *
     * @param integer $catchedSafariball
     *
     * @return Achievements
     */
    public function setCatchedSafariball($catchedSafariball)
    {
        $this->catchedSafariball = $catchedSafariball;

        return $this;
    }

    /**
     * Get catchedSafariball
     *
     * @return int
     */
    public function getCatchedSafariball()
    {
        return $this->catchedSafariball;
    }

    /**
     * Set snacks
     *
     * @param integer $snacks
     *
     * @return Achievements
     */
    public function setSnacks($snacks)
    {
        $this->snacks = $snacks;

        return $this;
    }

    /**
     * Get snacks
     *
     * @return int
     */
    public function getSnacks()
    {
        return $this->snacks;
    }

    /**
     * Set loggedIn
     *
     * @param integer $loggedIn
     *
     * @return Achievements
     */
    public function setLoggedIn($loggedIn)
    {
        $this->loggedIn = $loggedIn;

        return $this;
    }

    /**
     * Get loggedIn
     *
     * @return int
     */
    public function getLoggedIn()
    {
        return $this->loggedIn;
    }

    /**
     * Set trainingsWithPokemons
     *
     * @param integer $trainingsWithPokemons
     *
     * @return Achievements
     */
    public function setTrainingsWithPokemons($trainingsWithPokemons)
    {
        $this->trainingsWithPokemons = $trainingsWithPokemons;

        return $this;
    }

    /**
     * Get trainingsWithPokemons
     *
     * @return int
     */
    public function getTrainingsWithPokemons()
    {
        return $this->trainingsWithPokemons;
    }

    /**
     * Set catchedShiny
     *
     * @param integer $catchedShiny
     *
     * @return Achievements
     */
    public function setCatchedShiny($catchedShiny)
    {
        $this->catchedShiny = $catchedShiny;

        return $this;
    }

    /**
     * Get catchedShiny
     *
     * @return int
     */
    public function getCatchedShiny()
    {
        return $this->catchedShiny;
    }

    /**
     * Set wulkan
     *
     * @param integer $wulkan
     *
     * @return Achievements
     */
    public function setWulkan($wulkan)
    {
        $this->wulkan = $wulkan;

        return $this;
    }

    /**
     * Get wulkan
     *
     * @return int
     */
    public function getWulkan()
    {
        return $this->wulkan;
    }

    /**
     * Set laka
     *
     * @param integer $laka
     *
     * @return Achievements
     */
    public function setLaka($laka)
    {
        $this->laka = $laka;

        return $this;
    }

    /**
     * Get laka
     *
     * @return int
     */
    public function getLaka()
    {
        return $this->laka;
    }

    /**
     * Set lodowiec
     *
     * @param integer $lodowiec
     *
     * @return Achievements
     */
    public function setLodowiec($lodowiec)
    {
        $this->lodowiec = $lodowiec;

        return $this;
    }

    /**
     * Get lodowiec
     *
     * @return int
     */
    public function getLodowiec()
    {
        return $this->lodowiec;
    }

    /**
     * Set mokradla
     *
     * @param integer $mokradla
     *
     * @return Achievements
     */
    public function setMokradla($mokradla)
    {
        $this->mokradla = $mokradla;

        return $this;
    }

    /**
     * Get mokradla
     *
     * @return int
     */
    public function getMokradla()
    {
        return $this->mokradla;
    }

    /**
     * Set johto5
     *
     * @param integer $johto5
     *
     * @return Achievements
     */
    public function setJohto5($johto5)
    {
        $this->johto5 = $johto5;

        return $this;
    }

    /**
     * Get johto5
     *
     * @return int
     */
    public function getJohto5()
    {
        return $this->johto5;
    }

    /**
     * Set jezioro
     *
     * @param integer $jezioro
     *
     * @return Achievements
     */
    public function setJezioro($jezioro)
    {
        $this->jezioro = $jezioro;

        return $this;
    }

    /**
     * Get jezioro
     *
     * @return int
     */
    public function getJezioro()
    {
        return $this->jezioro;
    }

    /**
     * Set mrocznyLas
     *
     * @param integer $mrocznyLas
     *
     * @return Achievements
     */
    public function setMrocznyLas($mrocznyLas)
    {
        $this->mrocznyLas = $mrocznyLas;

        return $this;
    }

    /**
     * Get mrocznyLas
     *
     * @return int
     */
    public function getMrocznyLas()
    {
        return $this->mrocznyLas;
    }
}
