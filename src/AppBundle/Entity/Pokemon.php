<?php
namespace AppBundle\Entity;

use AppBundle\Utils\PokemonHelper;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
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
     * @ORM\Column(type="smallint")
     * @Gedmo\Versioned
     */
    private $idPokemon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40)
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Gedmo\Versioned
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $exp;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $shiny;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Gedmo\Versioned
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $attack;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $defence;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $spAttack;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $spDefence;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $speed;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $hp;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $accuracy;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $actualHp;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $attack0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $attack1;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $attack2;

    /**
     * @var string
     *
     * @ORM\Column(type="smallint")
     */
    private $attack3;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $ewolution;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $gender;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $attachment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $dateOfCatch;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $block;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $lottery;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berrysHp;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $snacks;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $market;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $blockView;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
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
     * @ORM\Column()
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $firstOwner;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $exchange;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $catched;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
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

    public function getTraining(): PokemonTraining
    {
        return $this->training;
    }

    public function setTraining(PokemonTraining $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdPokemon(int $idPokemon): self
    {
        $this->idPokemon = $idPokemon;

        return $this;
    }

    public function getIdPokemon(): ?int
    {
        return $this->idPokemon;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setExp(int $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getExp(): ?int
    {
        return $this->exp;
    }

    public function setShiny(bool $shiny): self
    {
        $this->shiny = $shiny;

        return $this;
    }

    public function getShiny(): ?bool
    {
        return $this->shiny;
    }

    public function setOwner(int $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setDefence(int $defence): self
    {
        $this->defence = $defence;

        return $this;
    }

    public function getDefence(): ?int
    {
        return $this->defence;
    }

    public function setSpAttack(int $spAttack): self
    {
        $this->spAttack = $spAttack;

        return $this;
    }

    public function getSpAttack(): ?int
    {
        return $this->spAttack;
    }

    public function setSpDefence(int $spDefence): self
    {
        $this->spDefence = $spDefence;

        return $this;
    }

    public function getSpDefence(): ?int
    {
        return $this->spDefence;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setAccuracy(int $accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getAccuracy(): ?int
    {
        return $this->accuracy;
    }

    public function setTeam(bool $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getTeam(): ?bool
    {
        return $this->team;
    }

    public function setActualHp(int $actualHp): self
    {
        $this->actualHp = $actualHp;

        return $this;
    }

    public function getActualHp(): ?int
    {
        return $this->actualHp;
    }

    public function setAttack0(int $attack0): self
    {
        $this->attack0 = $attack0;

        return $this;
    }

    public function getAttack0(): ?int
    {
        return $this->attack0;
    }

    public function setAttack1(int $attack1): self
    {
        $this->attack1 = $attack1;

        return $this;
    }

    public function getAttack1(): ?int
    {
        return $this->attack1;
    }

    public function setAttack2(int $attack2): self
    {
        $this->attack2 = $attack2;

        return $this;
    }

    public function getAttack2(): ?int
    {
        return $this->attack2;
    }

    public function setAttack3(int $attack3): self
    {
        $this->attack3 = $attack3;

        return $this;
    }

    public function getAttack3(): ?int
    {
        return $this->attack3;
    }

    public function setEwolution(bool $ewolution): self
    {
        $this->ewolution = $ewolution;

        return $this;
    }

    public function getEwolution(): ?bool
    {
        return $this->ewolution;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setAttachment(int $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getAttachment(): ?int
    {
        return $this->attachment;
    }

    public function setDateOfCatch(\DateTime $dateOfCatch): self
    {
        $this->dateOfCatch = $dateOfCatch;

        return $this;
    }

    public function getDateOfCatch(): ?\DateTime
    {
        return $this->dateOfCatch;
    }

    public function setBlock(bool $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getBlock(): ?bool
    {
        return $this->block;
    }

    public function setLottery(bool $lottery): self
    {
        $this->lottery = $lottery;

        return $this;
    }

    public function getLottery(): ?bool
    {
        return $this->lottery;
    }

    public function setBerrysHp(int $berrysHp): self
    {
        $this->berrysHp = $berrysHp;

        return $this;
    }

    public function getBerrysHp(): ?int
    {
        return $this->berrysHp;
    }

    public function setSnacks(int $snacks): self
    {
        $this->snacks = $snacks;

        return $this;
    }

    public function getSnacks(): ?int
    {
        return $this->snacks;
    }

    public function setMarket(bool $market): self
    {
        $this->market = $market;

        return $this;
    }

    public function getMarket(): ?bool
    {
        return $this->market;
    }

    public function setBlockView(bool $blockView): self
    {
        $this->blockView = $blockView;

        return $this;
    }

    public function getBlockView(): ?bool
    {
        return $this->blockView;
    }

    public function setHunger(float $hunger): self
    {
        $this->hunger = $hunger;

        return $this;
    }

    public function getHunger(): ?float
    {
        return $this->hunger;
    }

    public function setTr6(int $tr6): self
    {
        $this->tr6 = $tr6;

        return $this;
    }

    public function getTr6(): ?int
    {
        return $this->tr6;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setFirstOwner(int $firstOwner): self
    {
        $this->firstOwner = $firstOwner;

        return $this;
    }

    public function getFirstOwner(): ?int
    {
        return $this->firstOwner;
    }

    public function setExchange(bool $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    public function getExchange(): ?bool
    {
        return $this->exchange;
    }

    public function setCatched(string $catched): self
    {
        $this->catched = $catched;

        return $this;
    }

    public function getCatched(): ?string
    {
        return $this->catched;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function getExpOnLevel(): int
    {
        return $this->expOnLevel;
    }

    public function setExpOnLevel(int $expOnLevel): self
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

    public function getCountedAttachment(): float
    {
        $attachment = 0;
        if ($this->attachment < 6000) {
            $attachment += $this->attachment * 0.002843333;
        } else {
            $attachment = 17.06;
            $attachment += ($this->attachment - 6000) * 0.00864818182;
        }
        $attachment = -200 / ($attachment + 1.98984) + 100.50054;
        if ($this->attachment === 0) {
            $attachment = 0;
        }
        $attachment = round($attachment, 2);
        if ($attachment > 100) {
            return 100;
        }
        return $attachment;
    }

    public function getInfo(): array
    {
        return PokemonHelper::getInfo($this->idPokemon);
    }

    public function getEffectiveness(): array
    {
        if ($this->effectiveness === null) {
            $this->effectiveness = PokemonHelper::getEffectiveness($this->getInfo()['type1'], $this->getInfo()['type2']);
        }
        return $this->effectiveness;
    }

    public function getOneEffectiveness(int $i): int
    {
        return $this->getEffectiveness()[$i];
    }

    public function setEffectivenessFromArray(array $effectiveness): self
    {
        $this->effectiveness = $effectiveness;

        return $this;
    }

    public function setEffectiveness(int $key, int $value): self
    {
        $this->effectiveness[$key] = $value;

        return $this;
    }

    public function hasAttack(int $id): bool
    {
        return in_array($id, [$this->attack0, $this->attack1, $this->attack2, $this->attack3]);
    }
}
