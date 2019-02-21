<?php

namespace AppBundle\Entity;

use AppBundle\Utils\GameTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
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
     * @ORM\Column(name="login", type="string", length=30, unique=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="cash", type="decimal", precision=15, scale=0)
     */
    private $cash;

    /**
     * @var int
     *
     * @ORM\Column(name="trainer_level", type="integer")
     * @Gedmo\Versioned
     */
    private $trainerLevel;

    /**
     * @var int
     *
     * @ORM\Column(name="experience", type="integer")
     */
    private $experience;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var int
     *
     * @ORM\Column(name="mpa", type="smallint")
     */
    private $mpa;

    /**
     * @var int
     *
     * @ORM\Column(name="pa", type="smallint")
     */
    private $pa;

    /**
     * @var bool
     *
     * @ORM\Column(name="ban", type="boolean", nullable=true)
     */
    private $ban;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ban_date", type="datetime", nullable=true)
     */
    private $banDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ban_reason", type="string", length=80, nullable=true)
     */
    private $banReason;

    /**
     * @var int
     *
     * @ORM\Column(name="region", type="smallint")
     */
    private $region;

    /**
     * @var bool
     *
     * @ORM\Column(name="admin", type="boolean")
     */
    private $admin;

    /**
     * @var int
     *
     * @ORM\Column(name="magazine", type="smallint")
     */
    private $magazine;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var int
     *
     * @ORM\Column(name="last_active", type="integer")
     */
    private $lastActive;

    /**
     * @var int
     *
     * @ORM\Column(name="last_active_sec", type="integer")
     */
    private $lastActiveSec;

    /**
     * @var bool
     *
     * @ORM\Column(name="logged_today", type="boolean")
     */
    private $loggedToday;

    /**
     * @var int
     *
     * @ORM\Column(name="logged_in_row", type="smallint")
     */
    private $loggedInRow;

    /**
     * @var string
     *
     * @ORM\Column(name="settings", type="string", length=60)
     */
    private $settings;

    /**
     * @var bool
     *
     * @ORM\Column(name="announcements", type="boolean")
     */
    private $announcements;

    /**
     * @var int
     *
     * @ORM\Column(name="club", type="smallint")
     */
    private $club;

    /**
     * @var int
     *
     * @ORM\Column(name="online", type="integer")
     */
    private $online;

    /**
     * @var int
     *
     * @ORM\Column(name="online_today", type="integer")
     */
    private $onlineToday;

    /**
     * @var int
     *
     * @ORM\Column(name="berry_pa", type="smallint")
     */
    private $berryPa;

    /**
     * @var bool
     *
     * @ORM\Column(name="shiny_catched", type="boolean")
     */
    private $shinyCatched;

    /**
     * @var bool
     *
     * @ORM\Column(name="travelled_today", type="boolean")
     */
    private $travelledToday;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="pokemon_feeded", type="boolean")
     */
    private $pokemonFeeded;

    /**
     * @var string
     *
     * @ORM\Column(name="pokemon_feeded_ip", type="string", length=255)
     */
    private $pokemonFeededIp;

    /**
     * @var int
     *
     * @ORM\Column(name="tutorial", type="smallint")
     */
    private $tutorial;

    /**
     * @var string
     *
     * @ORM\Column(name="badges", type="string", length=200)
     */
    private $badges;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=80, nullable=true)
     * @Gedmo\Versioned
     */
    private $sessionId;

    /**
     * @var string
     * @ORM\Column(name="activity", type="string", length=60, nullable=true)
     */
    private $activity;

    /**
     * @var string
     * @ORM\Column(name="activity_time", type="integer", nullable=true)
     */
    private $activityTime;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Gedmo\Versioned
     */
    private $ip;

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
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set cash
     *
     * @param int $cash
     *
     * @return User
     */
    public function setCash($cash)
    {
        $this->cash = $cash;

        return $this;
    }

    /**
     * Get cash
     *
     * @return int
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * Set trainerLevel
     *
     * @param integer $trainerLevel
     *
     * @return User
     */
    public function setTrainerLevel($trainerLevel)
    {
        $this->trainerLevel = $trainerLevel;

        return $this;
    }

    /**
     * Get trainerLevel
     *
     * @return int
     */
    public function getTrainerLevel()
    {
        return $this->trainerLevel;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     *
     * @return User
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set mpa
     *
     * @param integer $mpa
     *
     * @return User
     */
    public function setMpa($mpa)
    {
        $this->mpa = $mpa;

        return $this;
    }

    /**
     * Get mpa
     *
     * @return int
     */
    public function getMpa()
    {
        return $this->mpa;
    }

    /**
     * Set pa
     *
     * @param integer $pa
     *
     * @return User
     */
    public function setPa($pa)
    {
        $this->pa = $pa;

        return $this;
    }

    /**
     * Get pa
     *
     * @return int
     */
    public function getPa()
    {
        return $this->pa;
    }

    /**
     * Set ban
     *
     * @param boolean $ban
     *
     * @return User
     */
    public function setBan($ban)
    {
        $this->ban = $ban;

        return $this;
    }

    /**
     * Get ban
     *
     * @return bool
     */
    public function getBan()
    {
        return $this->ban;
    }

    /**
     * Set banDate
     *
     * @param \DateTime $banDate
     *
     * @return User
     */
    public function setBanDate($banDate)
    {
        $this->banDate = $banDate;

        return $this;
    }

    /**
     * Get banDate
     *
     * @return \DateTime
     */
    public function getBanDate()
    {
        return $this->banDate;
    }

    /**
     * Set banReason
     *
     * @param string $banReason
     *
     * @return User
     */
    public function setBanReason($banReason)
    {
        $this->banReason = $banReason;

        return $this;
    }

    /**
     * Get banReason
     *
     * @return string
     */
    public function getBanReason()
    {
        return $this->banReason;
    }

    /**
     * Set region
     *
     * @param integer $region
     *
     * @return User
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return int
     */
    public function getRegion()
    {
        return $this->region;
    }


    /**
     * Set magazine
     *
     * @param integer $magazine
     *
     * @return User
     */
    public function setMagazine($magazine)
    {
        $this->magazine = $magazine;

        return $this;
    }

    /**
     * Get magazine
     *
     * @return int
     */
    public function getMagazine()
    {
        return $this->magazine;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set lastActive
     *
     * @param integer $lastActive
     *
     * @return User
     */
    public function setLastActive($lastActive)
    {
        $this->lastActive = $lastActive;

        return $this;
    }

    /**
     * Get lastActive
     *
     * @return int
     */
    public function getLastActive()
    {
        return $this->lastActive;
    }

    /**
     * Set lastActiveSec
     *
     * @param integer $lastActiveSec
     *
     * @return User
     */
    public function setLastActiveSec($lastActiveSec)
    {
        $this->lastActiveSec = $lastActiveSec;

        return $this;
    }

    /**
     * Get lastActiveSec
     *
     * @return int
     */
    public function getLastActiveSec()
    {
        return $this->lastActiveSec;
    }

    /**
     * Set loggedToday
     *
     * @param boolean $loggedToday
     *
     * @return User
     */
    public function setLoggedToday($loggedToday)
    {
        $this->loggedToday = $loggedToday;

        return $this;
    }

    /**
     * Get loggedToday
     *
     * @return bool
     */
    public function getLoggedToday()
    {
        return $this->loggedToday;
    }

    /**
     * Set loggedInRow
     *
     * @param integer $loggedInRow
     *
     * @return User
     */
    public function setLoggedInRow($loggedInRow)
    {
        $this->loggedInRow = $loggedInRow;

        return $this;
    }

    /**
     * Get loggedInRow
     *
     * @return int
     */
    public function getLoggedInRow()
    {
        return $this->loggedInRow;
    }

    /**
     * Set settings
     *
     * @param string $settings
     *
     * @return User
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set announcements
     *
     * @param boolean $announcements
     *
     * @return User
     */
    public function setAnnouncements($announcements)
    {
        $this->announcements = $announcements;

        return $this;
    }

    /**
     * Get announcements
     *
     * @return bool
     */
    public function getAnnouncements()
    {
        return $this->announcements;
    }

    /**
     * Set club
     *
     * @param integer $club
     *
     * @return User
     */
    public function setClub($club)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return int
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Set online
     *
     * @param integer $online
     *
     * @return User
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return int
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set onlineToday
     *
     * @param integer $onlineToday
     *
     * @return User
     */
    public function setOnlineToday($onlineToday)
    {
        $this->onlineToday = $onlineToday;

        return $this;
    }

    /**
     * Get onlineToday
     *
     * @return int
     */
    public function getOnlineToday()
    {
        return $this->onlineToday;
    }

    /**
     * Set berryPa
     *
     * @param integer $berryPa
     *
     * @return User
     */
    public function setBerryPa($berryPa)
    {
        $this->berryPa = $berryPa;

        return $this;
    }

    /**
     * Get berryPa
     *
     * @return int
     */
    public function getBerryPa()
    {
        return $this->berryPa;
    }

    /**
     * Set shinyCatched
     *
     * @param boolean $shinyCatched
     *
     * @return User
     */
    public function setShinyCatched($shinyCatched)
    {
        $this->shinyCatched = $shinyCatched;

        return $this;
    }

    /**
     * Get shinyCatched
     *
     * @return bool
     */
    public function getShinyCatched()
    {
        return $this->shinyCatched;
    }

    /**
     * Set travelledToday
     *
     * @param boolean $travelledToday
     *
     * @return User
     */
    public function setTravelledToday($travelledToday)
    {
        $this->travelledToday = $travelledToday;

        return $this;
    }

    /**
     * Get travelledToday
     *
     * @return bool
     */
    public function getTravelledToday()
    {
        return $this->travelledToday;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
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
     * Set pokemonFeeded
     *
     * @param boolean $pokemonFeeded
     *
     * @return User
     */
    public function setPokemonFeeded($pokemonFeeded)
    {
        $this->pokemonFeeded = $pokemonFeeded;

        return $this;
    }

    /**
     * Get pokemonFeeded
     *
     * @return bool
     */
    public function getPokemonFeeded()
    {
        return $this->pokemonFeeded;
    }

    /**
     * Set pokemonFeededIp
     *
     * @param string $pokemonFeededIp
     *
     * @return User
     */
    public function setPokemonFeededIp($pokemonFeededIp)
    {
        $this->pokemonFeededIp = $pokemonFeededIp;

        return $this;
    }

    /**
     * Get pokemonFeededIp
     *
     * @return string
     */
    public function getPokemonFeededIp()
    {
        return $this->pokemonFeededIp;
    }

    /**
     * Set tutorial
     *
     * @param integer $tutorial
     *
     * @return User
     */
    public function setTutorial($tutorial)
    {
        $this->tutorial = $tutorial;

        return $this;
    }
    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    /**
     * @param bool $admin
     */
    public function setAdmin(bool $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get tutorial
     *
     * @return int
     */
    public function getTutorial()
    {
        return $this->tutorial;
    }

    public function getRoles()
    {
        return $this->admin ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        return false;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getBadges(): string
    {
        return $this->badges;
    }

    /**
     * @param string $badges
     */
    public function setBadges(string $badges)
    {
        $this->badges = $badges;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getOnlineTimeAsText(bool $today = false)
    {
        if ($today) {
            $time = GameTime::time2string($this->onlineToday);
        } else {
            $time = GameTime::time2string($this->online);
        }
        return $time;
    }

    /**
     * @return string
     */
    public function getActivityTime(): string
    {
        return $this->activityTime;
    }

    /**
     * @param string $activityTime
     */
    public function setActivityTime(string $activityTime)
    {
        $this->activityTime = $activityTime;
    }

    /**
     * @return string
     */
    public function getActivity(): ?string
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     */
    public function setActivity(string $activity)
    {
        $this->activity = $activity;
    }

    /**
     * @param string $ip
     *
     * @return User
     */
    public function setIp(string $ip): User
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }
}
