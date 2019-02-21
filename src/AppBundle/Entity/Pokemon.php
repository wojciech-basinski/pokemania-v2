<?php

namespace AppBundle\Entity;

use AppBundle\Utils\PokemonHelper;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Pokemons
 *
 * @ORM\Table(name="pokemons")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PokemonRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Pokemon
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
     * @ORM\Column(name="id_pokemon", type="smallint")
     * @Gedmo\Versioned
     */
    private $idPokemon;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40)
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     * @Gedmo\Versioned
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="exp", type="integer")
     */
    private $exp;

    /**
     * @var bool
     *
     * @ORM\Column(name="shiny", type="boolean")
     */
    private $shiny;

    /**
     * @var int
     *
     * @ORM\Column(name="owner", type="integer")
     * @Gedmo\Versioned
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(name="attack", type="smallint")
     */
    private $attack;

    /**
     * @var int
     *
     * @ORM\Column(name="defence", type="smallint")
     */
    private $defence;

    /**
     * @var int
     *
     * @ORM\Column(name="sp_attack", type="smallint")
     */
    private $spAttack;

    /**
     * @var int
     *
     * @ORM\Column(name="sp_defence", type="smallint")
     */
    private $spDefence;

    /**
     * @var int
     *
     * @ORM\Column(name="speed", type="smallint")
     */
    private $speed;

    /**
     * @var int
     *
     * @ORM\Column(name="hp", type="smallint")
     */
    private $hp;

    /**
     * @var int
     *
     * @ORM\Column(name="accuracy", type="smallint")
     */
    private $accuracy;

    /**
     * @var bool
     *
     * @ORM\Column(name="team", type="boolean")
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Column(name="actual_hp", type="smallint")
     */
    private $actualHp;

    /**
     * @var int
     *
     * @ORM\Column(name="attack0", type="smallint")
     */
    private $attack0;

    /**
     * @var int
     *
     * @ORM\Column(name="attack1", type="smallint")
     */
    private $attack1;

    /**
     * @var int
     *
     * @ORM\Column(name="attack2", type="smallint")
     */
    private $attack2;

    /**
     * @var string
     *
     * @ORM\Column(name="attack3", type="smallint")
     */
    private $attack3;

    /**
     * @var bool
     *
     * @ORM\Column(name="ewolution", type="boolean")
     */
    private $ewolution;

    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="smallint")
     */
    private $gender;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="attachment", type="smallint")
     */
    private $attachment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_catch", type="datetime")
     */
    private $dateOfCatch;

    /**
     * @var bool
     *
     * @ORM\Column(name="block", type="boolean")
     */
    private $block;

    /**
     * @var bool
     *
     * @ORM\Column(name="lottery", type="boolean")
     */
    private $lottery;

    /**
     * @var int
     *
     * @ORM\Column(name="berrys_hp", type="smallint")
     */
    private $berrysHp;

    /**
     * @var int
     *
     * @ORM\Column(name="snacks", type="smallint")
     */
    private $snacks;

    /**
     * @var bool
     *
     * @ORM\Column(name="market", type="boolean")
     */
    private $market;

    /**
     * @var bool
     *
     * @ORM\Column(name="block_view", type="boolean")
     */
    private $blockView;

    /**
     * @var float
     *
     * @ORM\Column(name="hunger", type="float")
     */
    private $hunger;

    /**
     * @var int
     *
     * @ORM\Column(name="training_6", type="smallint")
     */
    private $tr6;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="first_owner", type="integer")
     */
    private $firstOwner;

    /**
     * @var bool
     *
     * @ORM\Column(name="exchange", type="boolean")
     */
    private $exchange;

    /**
     * @var string
     *
     * @ORM\Column(name="catched", type="string", length=255)
     */
    private $catched;

    /**
     * @var int
     *
     * @ORM\Column(name="quality", type="smallint")
     */
    private $quality;

    /**
     * @var int
     */
    private $expOnLevel;

    /**
     * @var PokemonTraining
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\PokemonTraining", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $training;

    /**
     * @var null|\DateTimeInterface
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var array
     */
    private $effectiveness = null;

    /**
     * @var array
     */
    private $info = null;

    /**
     * @return PokemonTraining
     */
    public function getTraining(): PokemonTraining
    {
        return $this->training;
    }

    /**
     * @param PokemonTraining $training
     */
    public function setTraining(PokemonTraining $training)
    {
        $this->training = $training;
    }

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
     * Set idPokemon
     *
     * @param integer $idPokemon
     *
     * @return Pokemon
     */
    public function setIdPokemon($idPokemon)
    {
        $this->idPokemon = $idPokemon;

        return $this;
    }

    /**
     * Get idPokemon
     *
     * @return int
     */
    public function getIdPokemon()
    {
        return $this->idPokemon;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Pokemon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Pokemon
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set exp
     *
     * @param integer $exp
     *
     * @return Pokemon
     */
    public function setExp($exp)
    {
        $this->exp = $exp;

        return $this;
    }

    /**
     * Get exp
     *
     * @return int
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * Set shiny
     *
     * @param boolean $shiny
     *
     * @return Pokemon
     */
    public function setShiny($shiny)
    {
        $this->shiny = $shiny;

        return $this;
    }

    /**
     * Get shiny
     *
     * @return bool
     */
    public function getShiny()
    {
        return $this->shiny;
    }

    /**
     * Set owner
     *
     * @param integer $owner
     *
     * @return Pokemon
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set attack
     *
     * @param integer $attack
     *
     * @return Pokemon
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * Get attack
     *
     * @return int
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * Set defence
     *
     * @param integer $defence
     *
     * @return Pokemon
     */
    public function setDefence($defence)
    {
        $this->defence = $defence;

        return $this;
    }

    /**
     * Get defence
     *
     * @return int
     */
    public function getDefence()
    {
        return $this->defence;
    }

    /**
     * Set spAttack
     *
     * @param integer $spAttack
     *
     * @return Pokemon
     */
    public function setSpAttack($spAttack)
    {
        $this->spAttack = $spAttack;

        return $this;
    }

    /**
     * Get spAttack
     *
     * @return int
     */
    public function getSpAttack()
    {
        return $this->spAttack;
    }

    /**
     * Set spDefence
     *
     * @param integer $spDefence
     *
     * @return Pokemon
     */
    public function setSpDefence($spDefence)
    {
        $this->spDefence = $spDefence;

        return $this;
    }

    /**
     * Get spDefence
     *
     * @return int
     */
    public function getSpDefence()
    {
        return $this->spDefence;
    }

    /**
     * Set speed
     *
     * @param integer $speed
     *
     * @return Pokemon
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set hp
     *
     * @param integer $hp
     *
     * @return Pokemon
     */
    public function setHp($hp)
    {
        $this->hp = $hp;

        return $this;
    }

    /**
     * Get hp
     *
     * @return int
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * Set accuracy
     *
     * @param integer $accuracy
     *
     * @return Pokemon
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    /**
     * Get accuracy
     *
     * @return int
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set team
     *
     * @param boolean $team
     *
     * @return Pokemon
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return bool
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set actualHp
     *
     * @param integer $actualHp
     *
     * @return Pokemon
     */
    public function setActualHp($actualHp)
    {
        $this->actualHp = $actualHp;

        return $this;
    }

    /**
     * Get actualHp
     *
     * @return int
     */
    public function getActualHp()
    {
        return $this->actualHp;
    }

    /**
     * Set attack1
     *
     * @param integer $attack0
     *
     * @return Pokemon
     */
    public function setAttack0($attack0)
    {
        $this->attack0 = $attack0;

        return $this;
    }

    /**
     * Get attack0
     *
     * @return int
     */
    public function getAttack0()
    {
        return $this->attack0;
    }

    /**
     * Set attack2
     *
     * @param integer $attack1
     *
     * @return Pokemon
     */
    public function setAttack1($attack1)
    {
        $this->attack1 = $attack1;

        return $this;
    }

    /**
     * Get attack1
     *
     * @return int
     */
    public function getAttack1()
    {
        return $this->attack1;
    }

    /**
     * Set attack2
     *
     * @param integer $attack2
     *
     * @return Pokemon
     */
    public function setAttack2($attack2)
    {
        $this->attack2 = $attack2;

        return $this;
    }

    /**
     * Get attack2
     *
     * @return int
     */
    public function getAttack2()
    {
        return $this->attack2;
    }

    /**
     * Set attack3
     *
     * @param string $attack3
     *
     * @return Pokemon
     */
    public function setAttack3($attack3)
    {
        $this->attack3 = $attack3;

        return $this;
    }

    /**
     * Get attack3
     *
     * @return string
     */
    public function getAttack3()
    {
        return $this->attack3;
    }

    /**
     * Set ewolution
     *
     * @param boolean $ewolution
     *
     * @return Pokemon
     */
    public function setEwolution($ewolution)
    {
        $this->ewolution = $ewolution;

        return $this;
    }

    /**
     * Get ewolution
     *
     * @return bool
     */
    public function getEwolution()
    {
        return $this->ewolution;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Pokemon
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Pokemon
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set attachment
     *
     * @param integer $attachment
     *
     * @return Pokemon
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return int
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set dateOfCatch
     *
     * @param \DateTime $dateOfCatch
     *
     * @return Pokemon
     */
    public function setDateOfCatch($dateOfCatch)
    {
        $this->dateOfCatch = $dateOfCatch;

        return $this;
    }

    /**
     * Get dateOfCatch
     *
     * @return \DateTime
     */
    public function getDateOfCatch()
    {
        return $this->dateOfCatch;
    }

    /**
     * Set block
     *
     * @param boolean $block
     *
     * @return Pokemon
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return bool
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set lottery
     *
     * @param boolean $lottery
     *
     * @return Pokemon
     */
    public function setLottery($lottery)
    {
        $this->lottery = $lottery;

        return $this;
    }

    /**
     * Get lottery
     *
     * @return bool
     */
    public function getLottery()
    {
        return $this->lottery;
    }

    /**
     * Set berrysHp
     *
     * @param integer $berrysHp
     *
     * @return Pokemon
     */
    public function setBerrysHp($berrysHp)
    {
        $this->berrysHp = $berrysHp;

        return $this;
    }

    /**
     * Get berrysHp
     *
     * @return int
     */
    public function getBerrysHp()
    {
        return $this->berrysHp;
    }

    /**
     * Set snacks
     *
     * @param integer $snacks
     *
     * @return Pokemon
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
     * Set market
     *
     * @param boolean $market
     *
     * @return Pokemon
     */
    public function setMarket($market)
    {
        $this->market = $market;

        return $this;
    }

    /**
     * Get market
     *
     * @return bool
     */
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * Set blockView
     *
     * @param boolean $blockView
     *
     * @return Pokemon
     */
    public function setBlockView($blockView)
    {
        $this->blockView = $blockView;

        return $this;
    }

    /**
     * Get blockView
     *
     * @return bool
     */
    public function getBlockView()
    {
        return $this->blockView;
    }

    /**
     * Set hunger
     *
     * @param float $hunger
     *
     * @return Pokemon
     */
    public function setHunger($hunger)
    {
        $this->hunger = $hunger;

        return $this;
    }

    /**
     * Get hunger
     *
     * @return float
     */
    public function getHunger()
    {
        return $this->hunger;
    }

    /**
     * Set training6
     *
     * @param int $tr6
     *
     * @return Pokemon
     */
    public function setTr6(int $tr6)
    {
        $this->tr6 = $tr6;

        return $this;
    }

    /**
     * Get training6
     *
     * @return int
     */
    public function getTr6()
    {
        return $this->tr6;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Pokemon
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set firstOwner
     *
     * @param integer $firstOwner
     *
     * @return Pokemon
     */
    public function setFirstOwner($firstOwner)
    {
        $this->firstOwner = $firstOwner;

        return $this;
    }

    /**
     * Get firstOwner
     *
     * @return int
     */
    public function getFirstOwner()
    {
        return $this->firstOwner;
    }

    /**
     * Set exchange
     *
     * @param boolean $exchange
     *
     * @return Pokemon
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Get exchange
     *
     * @return bool
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * Set catched
     *
     * @param string $catched
     *
     * @return Pokemon
     */
    public function setCatched($catched)
    {
        $this->catched = $catched;

        return $this;
    }

    /**
     * Get catched
     *
     * @return string
     */
    public function getCatched()
    {
        return $this->catched;
    }

    /**
     * Set quality
     *
     * @param integer $quality
     *
     * @return Pokemon
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @return int
     */
    public function getExpOnLevel()
    {
        return $this->expOnLevel;
    }

    /**
     * @param int $expOnLevel
     *
     * @return Pokemon
     */
    public function setExpOnLevel($expOnLevel)
    {
        $this->expOnLevel = $expOnLevel;

        return $this;
    }

    public function getHpToTable(): int
    {
        return (round($this->quality * $this->hp / 100) + $this->berrysHp + $this->tr6 * 5);
    }

    public function getAttackToTable(): int
    {
        return (round(
            $this->quality * $this->attack / 100) +
            floor($this->training->getBerryAttack() / 5) +
            $this->training->getTr1()
        );
    }

    public function getSpAttackToTable(): int
    {
        return (round(
            $this->quality * $this->spAttack / 100) +
            floor($this->training->getBerrySpAttack() / 5) +
            $this->training->getTr2()
        );
    }

    public function getDefenceToTable(): int
    {
        return (round(
            $this->quality * $this->defence / 100) +
            floor($this->training->getBerryDefence() / 5) +
            $this->training->getTr3()
        );
    }

    public function getSpDefenceToTable(): int
    {
        return (round(
            $this->quality * $this->spDefence / 100) +
            floor($this->training->getBerrySpDefence() / 5) +
            $this->training->getTr4()
        );
    }

    public function getSpeedToTable(): int
    {
        return (round(
            $this->quality * $this->speed / 100) +
            floor($this->training->getBerrySpeed() / 5) +
            $this->training->getTr5()
        );
    }

    public function getCountedAttachment()
    {
        $attachment = 0;
        if ($this->attachment < 6000) {
            $attachment += $this->attachment * 0.002843333;
        } else {
            $attachment = 17.06;
            $attachment += ($this->attachment - 6000) * 0.00864818182;
        }
        $attachment = -200 / ($attachment + 1.98984) + 100.50054;
        if ($this->attachment == 0) {
            $attachment = 0;
        }
        $attachment = round($attachment, 2);
        if ($attachment > 100) {
            return 100;
        }
        return $attachment;
    }

    public function setInfo(array $info)
    {
        $this->info = $info;

        return $this;
    }

    public function getInfo(): array
    {
        if ($this->info === null) {
            $this->info = PokemonHelper::getInfo($this->idPokemon);
        }
        return $this->info;
    }

    public function getEffectiveness()
    {
        if ($this->effectiveness === null) {
            $this->effectiveness = PokemonHelper::getEffectiveness($this->getInfo()['typ1'], $this->getInfo()['typ2']);
        }
        return $this->effectiveness;
    }

    public function getOneEffectiveness(int $i)
    {
        return $this->getEffectiveness()[$i];
    }

    public function setEffectivenessFromArray(array $effectiveness)
    {
        $this->effectiveness = $effectiveness;
    }

    public function setEffectiveness(int $key, int $value)
    {
        $this->effectiveness[$key] = $value;
    }

    public function hasAttack(int $id)
    {
        return in_array($id, [$this->attack0, $this->attack1, $this->attack2, $this->attack3]);
    }
}
