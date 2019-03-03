<?php
namespace AppBundle\Utils\User;

class UserSettings
{
    private $team;
    private $market;
    private $clock;
    private $tooltip;
    private $heal;
    private $soda;
    private $water;
    private $lemonade;
    private $cheri;
    private $wiki;
    private $hints;
    private $panels;
    private $background;
    private $table;
    private $feed;
    private $style;

    public function __construct($u)
    {
        $this->team = $u[0];
        $this->market = $u[1];
        $this->clock = $u[2];
        $this->tooltip = $u[3];
        $this->heal = $u[4];
        $this->soda = $u[5];
        $this->water = $u[6];
        $this->lemonade = $u[7];
        $this->cheri = $u[8];
        $this->wiki = $u[9];
        $this->hints = $u[10];
        $this->panels = $u[11];
        $this->feed = $u[12];
        $this->background = $u[13];
        $this->table = $u[14];
        $this->style = $u[15];
    }


    public function getAll()
    {
        $get = $this->team . '|' . $this->market . '|' . $this->clock . '|' . $this->tooltip . '|' . $this->heal . '|' .
            $this->soda . '|' . $this->water . '|' . $this->lemonade . '|' . $this->cheri . '|' . $this->wiki . '|' .
            $this->hints . '|' . $this->panels . '|' . $this->feed .'|' . $this->background . '|' . $this->table . '|'
            .$this->style;
        return $get;
    }

    public function getLemonade(): int
    {
        return $this->lemonade;
    }

    public function setLemonade(int $lemonade): self
    {
        $this->lemonade = $lemonade;

        return $this;
    }

    public function getWiki(): int
    {
        return $this->wiki;
    }


    public function setWiki(int $wiki): self
    {
        $this->wiki = $wiki;

        return $this;
    }

    public function getHints(): int
    {
        return $this->hints;
    }

    public function setHints(int $hints): self
    {
        $this->hints = $hints;

        return $this;
    }

    public function getPanels(): int
    {
        return $this->panels;
    }

    public function setPanels(int $panels): self
    {
        $this->panels = $panels;

        return $this;
    }

    public function getBackground(): string
    {
        return $this->background;
    }

    public function setBackground(string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getTable(): int
    {
        return $this->table;
    }

    public function setTable(int $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function getFeed(): int
    {
        return $this->feed;
    }

    public function setFeed(int $feed): self
    {
        $this->feed = $feed;

        return $this;
    }

    public function getTeam(): int
    {
        return $this->team;
    }

    public function setTeam(int $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getCheri(): int
    {
        return $this->cheri;
    }

    public function setCheri(int $cheri): self
    {
        $this->cheri = $cheri;

        return $this;
    }

    public function getMarket(): int
    {
        return $this->market;
    }

    public function setMarket(int $market): self
    {
        $this->market = $market;

        return $this;
    }

    public function getClock(): int
    {
        return $this->clock;
    }

    public function setClock(int $clock): self
    {
        $this->clock = $clock;

        return $this;
    }

    public function getTooltip(): int
    {
        return $this->tooltip;
    }

    public function setTooltip(int $tooltip): self
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function getHeal(): int
    {
        return $this->heal;
    }

    public function setHeal(int $heal): self
    {
        $this->heal = $heal;

        return $this;
    }

    public function getSoda(): int
    {
        return $this->soda;
    }

    public function setSoda(int $soda): self
    {
        $this->soda = $soda;

        return $this;
    }

    public function getWater(): int
    {
        return $this->water;
    }

    public function setWater(int $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getStyle(): int
    {
        return $this->style;
    }

    public function setStyle(int $style): self
    {
        $this->style = $style;

        return $this;
    }
}
