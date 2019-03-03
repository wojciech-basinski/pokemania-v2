<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $polana;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $wyspa;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $grota;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $domStrachow;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $gory;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $wodospad;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $safari;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedPokemons;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $winsWithTrainers;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $winsWithPokemons;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $beggedBerrys;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedPokeball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedNestball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedGreatball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedUltraball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedDuskball;

    /**
     * @var string
     *
     * @ORM\Column(type="integer")
     */
    private $catchedLureball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedCherishball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedRepeatball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $catchedSafariball;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $snacks;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $loggedIn;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingsWithPokemons;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $catchedShiny;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $wulkan;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $laka;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lodowiec;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $mokradla;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $johto5;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $jezioro;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $mrocznyLas;


    public function getId(): int
    {
        return $this->id;
    }

    public function setPolana(int $polana): self
    {
        $this->polana = $polana;

        return $this;
    }

    public function getPolana(): int
    {
        return $this->polana;
    }

    public function setWyspa(int $wyspa): self
    {
        $this->wyspa = $wyspa;

        return $this;
    }

    public function getWyspa(): int
    {
        return $this->wyspa;
    }

    public function setGrota(int $grota): self
    {
        $this->grota = $grota;

        return $this;
    }

    public function getGrota(): int
    {
        return $this->grota;
    }

    public function setDomStrachow(int $domStrachow): self
    {
        $this->domStrachow = $domStrachow;

        return $this;
    }

    public function getDomStrachow(): int
    {
        return $this->domStrachow;
    }

    public function setGory(int $gory): self
    {
        $this->gory = $gory;

        return $this;
    }

    public function getGory(): int
    {
        return $this->gory;
    }

    public function setWodospad(int $wodospad): self
    {
        $this->wodospad = $wodospad;

        return $this;
    }

    public function getWodospad(): int
    {
        return $this->wodospad;
    }

    public function setSafari(int $safari): self
    {
        $this->safari = $safari;

        return $this;
    }

    public function getSafari(): int
    {
        return $this->safari;
    }

    public function setCatchedPokemons(int $catchedPokemons): self
    {
        $this->catchedPokemons = $catchedPokemons;

        return $this;
    }

    public function getCatchedPokemons(): int
    {
        return $this->catchedPokemons;
    }

    public function setWinsWithTrainers(int $winsWithTrainers): self
    {
        $this->winsWithTrainers = $winsWithTrainers;

        return $this;
    }

    public function getWinsWithTrainers(): int
    {
        return $this->winsWithTrainers;
    }

    public function setWinsWithPokemons(int $winsWithPokemons): self
    {
        $this->winsWithPokemons = $winsWithPokemons;

        return $this;
    }

    public function getWinsWithPokemons(): int
    {
        return $this->winsWithPokemons;
    }

    public function setBeggedBerrys(int $beggedBerrys): self
    {
        $this->beggedBerrys = $beggedBerrys;

        return $this;
    }

    public function getBeggedBerrys(): int
    {
        return $this->beggedBerrys;
    }

    public function setCatchedPokeball(int $catchedPokeball): self
    {
        $this->catchedPokeball = $catchedPokeball;

        return $this;
    }

    public function getCatchedPokeball(): int
    {
        return $this->catchedPokeball;
    }

    public function setCatchedNestball(int $catchedNestball): self
    {
        $this->catchedNestball = $catchedNestball;

        return $this;
    }

    public function getCatchedNestball(): int
    {
        return $this->catchedNestball;
    }

    public function setCatchedGreatball(int $catchedGreatball): self
    {
        $this->catchedGreatball = $catchedGreatball;

        return $this;
    }

    public function getCatchedGreatball(): int
    {
        return $this->catchedGreatball;
    }

    public function setCatchedUltraball(int $catchedUltraball): self
    {
        $this->catchedUltraball = $catchedUltraball;

        return $this;
    }

    public function getCatchedUltraball(): int
    {
        return $this->catchedUltraball;
    }

    public function setCatchedDuskball(int $catchedDuskball): self
    {
        $this->catchedDuskball = $catchedDuskball;

        return $this;
    }

    public function getCatchedDuskball(): int
    {
        return $this->catchedDuskball;
    }

    public function setCatchedLureball(int $catchedLureball): self
    {
        $this->catchedLureball = $catchedLureball;

        return $this;
    }

    public function getCatchedLureball(): int
    {
        return $this->catchedLureball;
    }

    public function setCatchedCherishball(int $catchedCherishball): self
    {
        $this->catchedCherishball = $catchedCherishball;

        return $this;
    }

    public function getCatchedCherishball(): int
    {
        return $this->catchedCherishball;
    }

    public function setCatchedRepeatball(int $catchedRepeatball): self
    {
        $this->catchedRepeatball = $catchedRepeatball;

        return $this;
    }

    public function getCatchedRepeatball(): int
    {
        return $this->catchedRepeatball;
    }

    public function setCatchedSafariball(int $catchedSafariball): self
    {
        $this->catchedSafariball = $catchedSafariball;

        return $this;
    }

    public function getCatchedSafariball(): int
    {
        return $this->catchedSafariball;
    }

    public function setSnacks(int $snacks): self
    {
        $this->snacks = $snacks;

        return $this;
    }

    public function getSnacks(): int
    {
        return $this->snacks;
    }

    public function setLoggedIn(int $loggedIn): self
    {
        $this->loggedIn = $loggedIn;

        return $this;
    }

    public function getLoggedIn(): int
    {
        return $this->loggedIn;
    }

    public function setTrainingsWithPokemons(int $trainingsWithPokemons): self
    {
        $this->trainingsWithPokemons = $trainingsWithPokemons;

        return $this;
    }

    public function getTrainingsWithPokemons(): int
    {
        return $this->trainingsWithPokemons;
    }

    public function setCatchedShiny(int $catchedShiny): self
    {
        $this->catchedShiny = $catchedShiny;

        return $this;
    }

    public function getCatchedShiny(): int
    {
        return $this->catchedShiny;
    }

    public function setWulkan(int $wulkan): self
    {
        $this->wulkan = $wulkan;

        return $this;
    }

    public function getWulkan(): int
    {
        return $this->wulkan;
    }

    public function setLaka(int $laka): self
    {
        $this->laka = $laka;

        return $this;
    }

    public function getLaka(): int
    {
        return $this->laka;
    }

    public function setLodowiec(int $lodowiec): self
    {
        $this->lodowiec = $lodowiec;

        return $this;
    }

    public function getLodowiec(): int
    {
        return $this->lodowiec;
    }

    public function setMokradla(int $mokradla): self
    {
        $this->mokradla = $mokradla;

        return $this;
    }

    public function getMokradla(): int
    {
        return $this->mokradla;
    }

    public function setJohto5(int $johto5): self
    {
        $this->johto5 = $johto5;

        return $this;
    }

    public function getJohto5(): int
    {
        return $this->johto5;
    }

    public function setJezioro(int $jezioro): self
    {
        $this->jezioro = $jezioro;

        return $this;
    }

    public function getJezioro(): int
    {
        return $this->jezioro;
    }

    public function setMrocznyLas(int $mrocznyLas): self
    {
        $this->mrocznyLas = $mrocznyLas;

        return $this;
    }

    public function getMrocznyLas(): int
    {
        return $this->mrocznyLas;
    }
}
