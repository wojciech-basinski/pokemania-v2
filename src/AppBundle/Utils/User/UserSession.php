<?php

namespace AppBundle\Utils\User;

class UserSession
{
    /**
     * @var UserItems
     */
    private $userItems;

    /**
     * @var UserSkills
     */
    private $userSkills;

    /**
     * @var UserSettings
     */
    private $userSettings;

    /**
     * @var int
     */
    private $pokemonInReserve;
    /**
     * @var int
     */
    private $reports;
    /**
     * @var int
     */
    private $messages;
    /**
     * @var int
     */
    private $expOnNextLevel;

    public function __construct(
        int $pokemonInReserve,
        int $reports,
        int $messages,
        int $expOnNextLevel,
        UserItems $userItems,
        UserSkills $userSkills,
        UserSettings $userSettings
    ) {
        $this->userItems = $userItems;
        $this->userSkills = $userSkills;
        $this->userSettings = $userSettings;
        $this->pokemonInReserve = $pokemonInReserve;
        $this->reports = $reports;
        $this->messages = $messages;
        $this->expOnNextLevel = $expOnNextLevel;
    }

    /**
     * @return UserSkills
     */
    public function getUserSkills(): UserSkills
    {
        return $this->userSkills;
    }

    /**
     * @return UserItems
     */
    public function getUserItems(): UserItems
    {
        return $this->userItems;
    }

    /**
     * @return UserSettings
     */
    public function getUserSettings(): UserSettings
    {
        return $this->userSettings;
    }

    /**
     * @return int
     */
    public function getPokemonInReserve(): int
    {
        return $this->pokemonInReserve;
    }

    /**
     * @param int $pokemonInReserve
     */
    public function setPokemonInReserve(int $pokemonInReserve)
    {
        $this->pokemonInReserve = $pokemonInReserve;
    }

    /**
     * @return int
     */
    public function getReports(): int
    {
        return $this->reports;
    }

    /**
     * @param int $reports
     */
    public function setReports(int $reports)
    {
        $this->reports = $reports;
    }

    /**
     * @return int
     */
    public function getMessages(): int
    {
        return $this->messages;
    }

    /**
     * @param int $messages
     */
    public function setMessages(int $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return int
     */
    public function getExpOnNextLevel(): int
    {
        return $this->expOnNextLevel;
    }

    /**
     * @param int $expOnNextLevel
     */
    public function setExpOnNextLevel(int $expOnNextLevel)
    {
        $this->expOnNextLevel = $expOnNextLevel;
    }

    /**
     * @param UserSettings $userSettings
     */
    public function setUserSettings(UserSettings $userSettings)
    {
        $this->userSettings = $userSettings;
    }
}
