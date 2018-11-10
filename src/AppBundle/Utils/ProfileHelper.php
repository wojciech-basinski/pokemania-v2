<?php

namespace AppBundle\Utils;

class ProfileHelper
{
    private $skills = [
        0 => [
            'name' => 'Łapanie Pokemonów',
            'max' => 7,
            'description' => 'Szansa na złapanie pokemona zwiększona o ',
            'need' => 'Achievement;catchedPokemons',
            'need_description' => ' złapanych Pokemonów',
            1 => 3,
            '1_need' => 20,
            2 => 5,
            '2_need' => 100,
            3 => 8,
            '3_need' => 450,
            4 => 12,
            '4_need' => 1800,
            5 => 16,
            '5_need' => 4000,
            6 => 20,
            '6_need' => 12000,
            7 => 25,
            '7_need' => 25000,
        ],
    ];

    public function getSkills()
    {
        return $this->skills;
    }

    public function getSkill(int $i)
    {
        return $this->skills[$i] ?? null;
    }
}
