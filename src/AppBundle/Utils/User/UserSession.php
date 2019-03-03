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

    public function getUserSkills(): UserSkills
    {
        return $this->userSkills;
    }

    public function getUserItems(): UserItems
    {
        return $this->userItems;
    }

    public function getUserSettings(): UserSettings
    {
        return $this->userSettings;
    }

    public function getPokemonInReserve(): int
    {
        return $this->pokemonInReserve;
    }

    public function setPokemonInReserve(int $pokemonInReserve): self
    {
        $this->pokemonInReserve = $pokemonInReserve;

        return $this;
    }

    public function getReports(): int
    {
        return $this->reports;
    }

    public function setReports(int $reports): self
    {
        $this->reports = $reports;

        return $this;
    }

    public function getMessages(): int
    {
        return $this->messages;
    }

    public function setMessages(int $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    public function getExpOnNextLevel(): int
    {
        return $this->expOnNextLevel;
    }

    public function setExpOnNextLevel(int $expOnNextLevel): self
    {
        $this->expOnNextLevel = $expOnNextLevel;

        return $this;
    }


    public function setUserSettings(UserSettings $userSettings): self
    {
        $this->userSettings = $userSettings;

        return $this;
    }
}
