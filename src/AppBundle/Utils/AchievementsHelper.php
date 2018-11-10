<?php
namespace AppBundle\Utils;

class AchievementsHelper
{
    private $main = [
            0 => [
                'name' => 'Trener Pokemon',
                'table' => 'users;TrainerLevel',
                'inDb' => 'trener',
                'echo' => 'Poziom trenera',
                1 => 20,
                2 => 40,
                3 => 60,
                4 => 80,
                5 => 100,
                ],
            1 => [
                'name' => 'No life',
                'table' => 'users;Online',
                'inDb' => 'nolife',
                'echo' => 'Sekund online',
                1 => 36000,
                2 => 72000,
                3 => 144000,
                4 => 288000,
                5 => 576000,
                6 => 1000000,
                ],
    ];

    private $secondary = [
        0 => [
            'name' => 'Łapacz Pokemonów',
            'table' => 'achievements;CatchedPokemons',
            'inDb' => 'Lapanie',
            'echo' => 'Złapane Pokemony',
            1 => 25,
            2 => 100,
            3 => 400,
            4 => 1600,
            5 => 6400,
            6 => 25600,
            7 => 102400,
            8 => 409600,
            ],
        1 => [
            'name' => 'Nauczyciel',
            'table' => 'achievements;WinsWithPokemons',
            'inDb' => 'Pokonane',
            'echo' => 'Pokonane Pokemony w dziczy',
            1 => 50,
            2 => 200,
            3 => 800,
            4 => 3200,
            5 => 12800,
            6 => 51200,
            7 => 204800,
            8 => 819200,
            ],
        2 => [
            'name' => 'Pogromca trenerów',
            'table' => 'achievements;WinsWithTrainers',
            'inDb' => 'Trenerzy',
            'echo' => 'Pokonani trenerzy',
            '1' => 25,
            '2' => 250,
            '3' => 2500,
            '4' => 25000,
            ]
    ];

    private $kanto = [
        0 => [
            'name' => 'Znawca Polany',
            'table' => 'achievements;Polana',
            'inDb' => 'znawcaKanto1',
            'echo' => 'Wypraw na Polanę',
            1 => 250,
            2 => 2000,
            3 => 8000,
            4 => 24000,
            5 => 50000,
            ],
        1 => [
            'name' => 'Znawca Wyspy',
            'table' => 'achievements;Wyspa',
            'inDb' => 'znawcaKanto2',
            'echo' => 'Wypraw na Wyspę',
            1 => 250,
            2 => 2000,
            3 => 8000,
            4 => 24000,
            5 => 50000,
            ],
        2 => [
            'name' => 'Znawca Groty',
            'table' => 'achievements;Grota',
            'inDb' => 'znawcaKanto3',
            'echo' => 'Wypraw do Groty',
            1 => 250,
            2 => 2000,
            3 => 8000,
            4 => 24000,
            5 => 50000,
            ],
        3 => [
            'name' => 'Znawca Domu strachów',
            'table' => 'achievements;DomStrachow',
            'inDb' => 'znawcaKanto4',
            'echo' => 'Wypraw do Domu strachów',
            1 => 250,
            2 => 2000,
            3 => 8000,
            4 => 24000,
            5 => 50000,
            ],
        4 => [
            'name' => 'Znawca Gór',
            'table' => 'achievements;Gory',
            'inDb' => 'znawcaKanto5',
            'echo' => 'Wypraw w Góry',
            1 => 250,
            2 => 2000,
            3 => 8000,
            4 => 24000,
            5 => 50000,
            ],
        5 => [
            'name' => 'Znawca Wodospadu',
            'table' => 'achievements;Wodospad',
            'inDb' => 'znawcaKanto6',
            'echo' => 'Wypraw na Wodospad',
            1 => 250,
            2 => 2000,
            3 => 8000,
            4 => 24000,
            5 => 50000,
            ],
        6 => [
            'name' => 'Znawca Safari',
            'table' => 'achievements;Safari',
            'inDb' => 'znawcaKanto7',
            'echo' => 'Wypraw na Safari',
            1 => 250,
            2 => 1200,
            3 => 5000,
            4 => 16000,
            5 => 28000,
            ],
    ];

    private $kantoMaster = [
            'name' => 'Znawca regionu Kanto',
            'table' => '',
            'inDb' => 'znawcaKanto',
            'echo' => ' poziom znawcy dziczy w Kanto',
    ];

    public function getMain(): array
    {
        return $this->main;
    }

    public function getSecondary(): array
    {
        return $this->secondary;
    }

    public function getKanto(): array
    {
        return $this->kanto;
    }

    public function getKantoMaster(): array
    {
        return $this->kantoMaster;
    }
}
