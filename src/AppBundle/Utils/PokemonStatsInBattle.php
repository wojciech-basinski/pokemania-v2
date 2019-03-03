<?php
namespace AppBundle\Utils;

class PokemonStatsInBattle
{
    /**
     * @var bool
     */
    private $luckyGiven;
    /**
     * @var float
     */
    private $lucky;
    /**
     * @var int
     */
    private $attack;
    /**
     * @var bool
     */
    private $seeded;
    /**
     * @var int
     */
    private $statePhysical;
    /**
     * @var int
     */
    private $roundStatePhysical;
    /**
     * @var array
     */
    private $statePokemon;
    /**
     * @var int
     */
    private $attackRound;
    /**
     * @var int
     */
    private $attackRoundOne;
    /**
     * @var int
     */
    private $fury;
    /**
     * @var int
     */
    private $furyHit;
    /**
     * @var int
     */
    private $begginingHp;
    /**
     * @var bool
     */
    private $immune;
    /**
     * @var bool
     */
    private $prepared;
    /**
     * @var bool
     */
    private $attachmentGiven;
    /**
     * @var bool
     */
    private $shinyBonusGiven;
    /**
     * @var float
     */
    private $shinyBonus;

    public function __construct()
    {
        $this->luckyGiven = 0;
        $this->attachmentGiven = 0;
        $this->shinyBonusGiven = 0;
        $this->lucky = rand(-100, 100) / 10;
        $this->attack = 0;
        $this->seeded = 0;
        $this->statePhysical = 0;
        $this->roundStatePhysical = 0;
        $this->statePokemon = [];
        $this->attackRound = 0;
        $this->attackRoundOne = 0;
        $this->fury = 0;
        $this->furyHit = 0;
        $this->immune = 0;
        $this->prepared = 0;
        $this->shinyBonus = 0.0;
    }

    /**
     * @return bool
     */
    public function isLuckyGiven(): bool
    {
        return $this->luckyGiven;
    }

    /**
     * @param bool $luckyGiven
*/
    public function setLuckyGiven(bool $luckyGiven): void
    {
        $this->luckyGiven = $luckyGiven;
    }

    /**
     * @return float
     */
    public function getLucky(): float
    {
        return $this->lucky;
    }

    /**
     * @param float $lucky
     */
    public function setLucky(float $lucky): void
    {
        $this->lucky = $lucky;
    }

    /**
     * @return int
     */
    public function getAttack(): int
    {
        return $this->attack;
    }

    /**
     * @param int $attack
     */
    public function setAttack(int $attack): void
    {
        $this->attack = $attack;
    }

    /**
     * @return bool
     */
    public function isSeeded(): bool
    {
        return $this->seeded;
    }

    /**
     * @param bool $seeded
     */
    public function setSeeded(bool $seeded): void
    {
        $this->seeded = $seeded;
    }

    /**
     * @return int
     */
    public function getStatePhysical(): int
    {
        return $this->statePhysical;
    }

    /**
     * @param int $statePhysical
     */
    public function setStatePhysical(int $statePhysical): void
    {
        $this->statePhysical = $statePhysical;
    }

    /**
     * @return int
     */
    public function getRoundStatePhysical(): int
    {
        return $this->roundStatePhysical;
    }

    /**
     * @param int $roundStatePhysical
     */
    public function setRoundStatePhysical(int $roundStatePhysical): void
    {
        $this->roundStatePhysical = $roundStatePhysical;
    }

    /**
     * @return array
     */
    public function getStatePokemon(): array
    {
        return $this->statePokemon;
    }

    /**
     * @param array $statePokemon
     */
    public function setStatePokemon(array $statePokemon): void
    {
        $this->statePokemon = $statePokemon;
    }

    /**
     * @return int
     */
    public function getAttackRound(): int
    {
        return $this->attackRound;
    }

    /**
     * @param int $attackRound
     */
    public function setAttackRound(int $attackRound): void
    {
        $this->attackRound = $attackRound;
    }

    /**
     * @return int
     */
    public function getAttackRoundOne(): int
    {
        return $this->attackRoundOne;
    }

    /**
     * @param int $attackRoundOne
     */
    public function setAttackRoundOne(int $attackRoundOne): void
    {
        $this->attackRoundOne = $attackRoundOne;
    }

    /**
     * @return int
     */
    public function getFury(): int
    {
        return $this->fury;
    }

    /**
     * @param int $fury
     */
    public function setFury(int $fury): void
    {
        $this->fury = $fury;
    }

    /**
     * @return int
     */
    public function getFuryHit(): int
    {
        return $this->furyHit;
    }

    /**
     * @param int $furyHit
     */
    public function setFuryHit(int $furyHit): void
    {
        $this->furyHit = $furyHit;
    }

    /**
     * @return int
     */
    public function getBegginingHp(): int
    {
        return $this->begginingHp;
    }

    /**
     * @param int $begginingHp
     */
    public function setBegginingHp(int $begginingHp): void
    {
        $this->begginingHp = $begginingHp;
    }

    /**
     * @return bool
     */
    public function isImmune(): bool
    {
        return $this->immune;
    }

    /**
     * @param bool $immune
     */
    public function setImmune(bool $immune): void
    {
        $this->immune = $immune;
    }

    /**
     * @return bool
     */
    public function isPrepared(): bool
    {
        return $this->prepared;
    }

    /**
     * @param bool $prepared
     */
    public function setPrepared(bool $prepared): void
    {
        $this->prepared = $prepared;
    }

    /**
     * @return bool
     */
    public function isAttachmentGiven(): bool
    {
        return $this->attachmentGiven;
    }

    /**
     * @param bool $attachmentGiven
     */
    public function setAttachmentGiven(bool $attachmentGiven): void
    {
        $this->attachmentGiven = $attachmentGiven;
    }

    /**
     * @return bool
     */
    public function isShinyBonusGiven(): bool
    {
        return $this->shinyBonusGiven;
    }

    /**
     * @param bool $shinyBonusGiven
     */
    public function setShinyBonusGiven(bool $shinyBonusGiven): void
    {
        $this->shinyBonusGiven = $shinyBonusGiven;
    }

    /**
     * @return float
     */
    public function getShinyBonus(): float
    {
        return $this->shinyBonus;
    }

    /**
     * @param float $shinyBonus
     */
    public function setShinyBonus(float $shinyBonus): void
    {
        $this->shinyBonus = $shinyBonus;
    }
}
