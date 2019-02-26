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

    /**
     * @return mixed
     */
    public function getLemonade()
    {
        return $this->lemonade;
    }

    /**
     * @param mixed $lemonade
     */
    public function setLemonade($lemonade)
    {
        $this->lemonade = $lemonade;
    }

    /**
     * @return mixed
     */
    public function getWiki()
    {
        return $this->wiki;
    }

    /**
     * @param mixed $wiki
     */
    public function setWiki($wiki)
    {
        $this->wiki = $wiki;
    }

    /**
     * @return mixed
     */
    public function getHints()
    {
        return $this->hints;
    }

    /**
     * @param mixed $hints
     */
    public function setHints($hints)
    {
        $this->hints = $hints;
    }

    /**
     * @return mixed
     */
    public function getPanels()
    {
        return $this->panels;
    }

    /**
     * @param mixed $panels
     */
    public function setPanels($panels)
    {
        $this->panels = $panels;
    }

    /**
     * @return mixed
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param mixed $background
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @param mixed $feed
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return mixed
     */
    public function getCheri()
    {
        return $this->cheri;
    }

    /**
     * @param mixed $cheri
     */
    public function setCheri($cheri)
    {
        $this->cheri = $cheri;
    }

    /**
     * @return mixed
     */
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * @param mixed $market
     */
    public function setMarket($market)
    {
        $this->market = $market;
    }

    /**
     * @return mixed
     */
    public function getClock()
    {
        return $this->clock;
    }

    /**
     * @param mixed $clock
     */
    public function setClock($clock)
    {
        $this->clock = $clock;
    }

    /**
     * @return mixed
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * @param mixed $tooltip
     */
    public function setTooltip($tooltip)
    {
        $this->tooltip = $tooltip;
    }

    /**
     * @return mixed
     */
    public function getHeal()
    {
        return $this->heal;
    }

    /**
     * @param mixed $heal
     */
    public function setHeal($heal)
    {
        $this->heal = $heal;
    }

    /**
     * @return mixed
     */
    public function getSoda()
    {
        return $this->soda;
    }

    /**
     * @param mixed $soda
     */
    public function setSoda($soda)
    {
        $this->soda = $soda;
    }

    /**
     * @return mixed
     */
    public function getWater()
    {
        return $this->water;
    }

    /**
     * @param mixed $water
     */
    public function setWater($water)
    {
        $this->water = $water;
    }

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param mixed $style
     */
    public function setStyle($style): void
    {
        $this->style = $style;
    }
}
