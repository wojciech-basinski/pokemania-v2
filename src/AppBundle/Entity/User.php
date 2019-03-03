<?php
namespace AppBundle\Entity;

use AppBundle\Utils\GameTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Gedmo\Loggable
 */
class User implements UserInterface
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
     * @var string
     *
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=15, scale=0)
     */
    private $cash;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Gedmo\Versioned
     */
    private $trainerLevel;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $experience;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $points;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $mpa;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $pa;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ban;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $banDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $banReason;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $region;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $magazine;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lastActive;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lastActiveSec;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $loggedToday;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $loggedInRow;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     */
    private $settings;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $announcements;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $club;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $online;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $onlineToday;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $berryPa;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $shinyCatched;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $travelledToday;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $pokemonFeeded;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $pokemonFeededIp;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $tutorial;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200)
     */
    private $badges;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Gedmo\Versioned
     */
    private $sessionId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $activity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $activityTime;

    /**
     * @var string
     *
     * @ORM\Column( length=15, nullable=true)
     * @Gedmo\Versioned
     */
    private $ip;

    public function getId(): int
    {
        return $this->id;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setCash(int $cash): self
    {
        $this->cash = $cash;

        return $this;
    }

    public function getCash(): int
    {
        return $this->cash;
    }

    public function setTrainerLevel(int $trainerLevel): self
    {
        $this->trainerLevel = $trainerLevel;

        return $this;
    }

    public function getTrainerLevel(): int
    {
        return $this->trainerLevel;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setMpa(int $mpa): self
    {
        $this->mpa = $mpa;

        return $this;
    }

    public function getMpa(): int
    {
        return $this->mpa;
    }

    public function setPa(int $pa): self
    {
        $this->pa = $pa;

        return $this;
    }

    public function getPa(): int
    {
        return $this->pa;
    }

    public function setBan(bool $ban): self
    {
        $this->ban = $ban;

        return $this;
    }

    public function getBan(): bool
    {
        return $this->ban;
    }

    public function setBanDate(?\DateTime $banDate): self
    {
        $this->banDate = $banDate;

        return $this;
    }

    public function getBanDate(): ?\DateTime
    {
        return $this->banDate;
    }

    public function setBanReason(?string $banReason): self
    {
        $this->banReason = $banReason;

        return $this;
    }

    public function getBanReason(): ?string
    {
        return $this->banReason;
    }

    public function setRegion(int $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRegion(): int
    {
        return $this->region;
    }

    public function setMagazine(int $magazine): self
    {
        $this->magazine = $magazine;

        return $this;
    }

    public function getMagazine(): int
    {
        return $this->magazine;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setLastActive(int $lastActive): self
    {
        $this->lastActive = $lastActive;

        return $this;
    }

    public function getLastActive(): int
    {
        return $this->lastActive;
    }

    public function setLastActiveSec(int $lastActiveSec): self
    {
        $this->lastActiveSec = $lastActiveSec;

        return $this;
    }

    public function getLastActiveSec(): int
    {
        return $this->lastActiveSec;
    }

    public function setLoggedToday(bool $loggedToday): self
    {
        $this->loggedToday = $loggedToday;

        return $this;
    }

    public function getLoggedToday(): bool
    {
        return $this->loggedToday;
    }

    public function setLoggedInRow(int $loggedInRow): self
    {
        $this->loggedInRow = $loggedInRow;

        return $this;
    }

    public function getLoggedInRow(): int
    {
        return $this->loggedInRow;
    }

    public function setSettings(string $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function getSettings(): string
    {
        return $this->settings;
    }

    public function setAnnouncements(bool $announcements): self
    {
        $this->announcements = $announcements;

        return $this;
    }

    public function getAnnouncements(): bool
    {
        return $this->announcements;
    }

    public function setClub(int $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getClub(): int
    {
        return $this->club;
    }

    public function setOnline(int $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getOnline(): int
    {
        return $this->online;
    }

    public function setOnlineToday(int $onlineToday): self
    {
        $this->onlineToday = $onlineToday;

        return $this;
    }

    public function getOnlineToday(): int
    {
        return $this->onlineToday;
    }

    public function setBerryPa(int $berryPa): self
    {
        $this->berryPa = $berryPa;

        return $this;
    }

    public function getBerryPa(): int
    {
        return $this->berryPa;
    }

    public function setShinyCatched(bool $shinyCatched): self
    {
        $this->shinyCatched = $shinyCatched;

        return $this;
    }

    public function getShinyCatched(): bool
    {
        return $this->shinyCatched;
    }

    public function setTravelledToday(bool $travelledToday): self
    {
        $this->travelledToday = $travelledToday;

        return $this;
    }

    public function getTravelledToday(): bool
    {
        return $this->travelledToday;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setPokemonFeeded(bool $pokemonFeeded): self
    {
        $this->pokemonFeeded = $pokemonFeeded;

        return $this;
    }

    public function getPokemonFeeded(): bool
    {
        return $this->pokemonFeeded;
    }

    public function setPokemonFeededIp(string $pokemonFeededIp): self
    {
        $this->pokemonFeededIp = $pokemonFeededIp;

        return $this;
    }

    public function getPokemonFeededIp(): string
    {
        return $this->pokemonFeededIp;
    }

    public function setTutorial(int $tutorial): self
    {
        $this->tutorial = $tutorial;

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getTutorial(): int
    {
        return $this->tutorial;
    }

    public function getRoles(): array
    {
        return $this->admin ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getUsername(): string
    {
        return $this->login;
    }

    public function eraseCredentials(): bool
    {
        return false;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getBadges(): string
    {
        return $this->badges;
    }

    public function setBadges(string $badges): self
    {
        $this->badges = $badges;

        return $this;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getOnlineTimeAsText(bool $today = false): string
    {
        if ($today) {
            return GameTime::time2string($this->onlineToday);
        }
        return GameTime::time2string($this->online);
    }

    public function getActivityTime(): ?int
    {
        return $this->activityTime;
    }

    public function setActivityTime(?int $activityTime): self
    {
        $this->activityTime = $activityTime;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(?string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }
}
