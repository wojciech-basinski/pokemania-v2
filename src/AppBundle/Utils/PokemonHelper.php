<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\PokemonTraining;

class PokemonHelper
{
    private static $startingStats = [
        1 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 10, 'speed' => 9, 'hp' => 45],
        4 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        7 => ['attack' => 9, 'defence' => 10, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 9, 'hp' => 45],
        10 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        13 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        16 => ['attack' => 9, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        19 => ['attack' => 9, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 10, 'hp' => 45],
        21 => ['attack' => 10, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 10, 'hp' => 45],
        23 => ['attack' => 10, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        25 => ['attack' => 9, 'defence' => 7, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 10, 'hp' => 40],
        27 => ['attack' => 10, 'defence' => 11, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        29 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 50],
        32 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        35 => ['attack' => 8, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 7, 'hp' => 45],
        37 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 10, 'hp' => 45],
        39 => ['attack' => 8, 'defence' => 7, 'spAttack' => 9, 'spDefence' => 8, 'speed' => 7, 'hp' => 55],
        41 => ['attack' => 9, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        43 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 10, 'speed' => 8, 'hp' => 45],
        46 => ['attack' => 10, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        48 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 50],
        50 => ['attack' => 9, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 11, 'hp' => 40],
        52 => ['attack' => 9, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        54 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        56 => ['attack' => 11, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        58 => ['attack' => 10, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 10, 'hp' => 50],
        60 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        63 => ['attack' => 8, 'defence' => 7, 'spAttack' => 12, 'spDefence' => 9, 'speed' => 11, 'hp' => 40],
        66 => ['attack' => 11, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 50],
        69 => ['attack' => 10, 'defence' => 8, 'spAttack' => 10, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        72 => ['attack' => 9, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 12, 'speed' => 10, 'hp' => 45],
        74 => ['attack' => 11, 'defence' => 12, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 45],
        77 => ['attack' => 11, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 10, 'speed' => 11, 'hp' => 45],
        79 => ['attack' => 10, 'defence' => 10, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 7, 'hp' => 55],
        81 => ['attack' => 8, 'defence' => 10, 'spAttack' => 11, 'spDefence' => 9, 'speed' => 9, 'hp' => 40],
        83 => ['attack' => 10, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 10, 'hp' => 50],
        84 => ['attack' => 11, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 10, 'hp' => 45],
        86 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 9, 'hp' => 50],
        88 => ['attack' => 11, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 8, 'hp' => 55],
        90 => ['attack' => 10, 'defence' => 12, 'spAttack' => 9, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        92 => ['attack' => 8, 'defence' => 8, 'spAttack' => 12, 'spDefence' => 8, 'speed' => 11, 'hp' => 45],
        95 => ['attack' => 9, 'defence' => 15, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        96 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 11, 'speed' => 9, 'hp' => 50],
        98 => ['attack' => 12, 'defence' => 11, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        100 => ['attack' => 8, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 12, 'hp' => 45],
        102 => ['attack' => 9, 'defence' => 10, 'spAttack' => 11, 'spDefence' => 9, 'speed' => 9, 'hp' => 50],
        104 => ['attack' => 9, 'defence' => 11, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        106 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 45],
        107 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 45],
        108 => ['attack' => 9, 'defence' => 10, 'spAttack' => 10, 'spDefence' => 10, 'speed' => 8, 'hp' => 55],
        109 => ['attack' => 10, 'defence' => 11, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        111 => ['attack' => 11, 'defence' => 11, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 55],
        113 => ['attack' => 7, 'defence' => 7, 'spAttack' => 7, 'spDefence' => 10, 'speed' => 8, 'hp' => 55],
        114 => ['attack' => 9, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 9, 'speed' => 10, 'hp' => 50],
        115 => ['attack' => 11, 'defence' => 11, 'spAttack' => 9, 'spDefence' => 11, 'speed' => 11, 'hp' => 60],
        116 => ['attack' => 9, 'defence' => 10, 'spAttack' => 10, 'spDefence' => 8, 'speed' => 10, 'hp' => 45],
        118 => ['attack' => 10, 'defence' => 10, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        120 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        122 => ['attack' => 8, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 11, 'speed' => 10, 'hp' => 40],
        123 => ['attack' => 12, 'defence' => 11, 'spAttack' => 9, 'spDefence' => 11, 'speed' => 12, 'hp' => 50],
        124 => ['attack' => 8, 'defence' => 7, 'spAttack' => 11, 'spDefence' => 10, 'speed' => 10, 'hp' => 45],
        125 => ['attack' => 10, 'defence' => 8, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        126 => ['attack' => 10, 'defence' => 8, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        127 => ['attack' => 13, 'defence' => 12, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 11, 'hp' => 50],
        128 => ['attack' => 12, 'defence' => 11, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 10, 'hp' => 50],
        129 => ['attack' => 7, 'defence' => 9, 'spAttack' => 7, 'spDefence' => 8, 'speed' => 11, 'hp' => 40],
        131 => ['attack' => 11, 'defence' => 11, 'spAttack' => 11, 'spDefence' => 11, 'speed' => 10, 'hp' => 65],
        132 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 35],
        133 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 9, 'hp' => 50],
        137 => ['attack' => 10, 'defence' => 10, 'spAttack' => 11, 'spDefence' => 10, 'speed' => 9, 'hp' => 50],
        138 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 40],
        140 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 40],
        142 => ['attack' => 12, 'defence' => 11, 'spAttack' => 7, 'spDefence' => 11, 'speed' => 13, 'hp' => 55],
        143 => ['attack' => 11, 'defence' => 12, 'spAttack' => 7, 'spDefence' => 12, 'speed' => 5, 'hp' => 75],
        144 => ['attack' => 25, 'defence' => 25, 'spAttack' => 25, 'spDefence' => 25, 'speed' => 25, 'hp' => 145],
        145 => ['attack' => 25, 'defence' => 25, 'spAttack' => 25, 'spDefence' => 25, 'speed' => 25, 'hp' => 145],
        146 => ['attack' => 25, 'defence' => 25, 'spAttack' => 25, 'spDefence' => 25, 'speed' => 25, 'hp' => 145],
        147 => ['attack' => 11, 'defence' => 10, 'spAttack' => 10, 'spDefence' => 10, 'speed' => 10, 'hp' => 55],
        150 => ['attack' => 25, 'defence' => 25, 'spAttack' => 25, 'spDefence' => 25, 'speed' => 25, 'hp' => 145],
        151 => ['attack' => 25, 'defence' => 25, 'spAttack' => 25, 'spDefence' => 25, 'speed' => 25, 'hp' => 145],
        152 => ['attack' => 9, 'defence' => 10, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 9, 'hp' => 45],
        155 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        158 => ['attack' => 10, 'defence' => 10, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        161 => ['attack' => 9, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        163 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 9, 'hp' => 50],
        165 => ['attack' => 8, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 11, 'speed' => 9, 'hp' => 45],
        167 => ['attack' => 10, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        170 => ['attack' => 8, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 10, 'hp' => 50],
        172 => ['attack' => 9, 'defence' => 7, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 10, 'hp' => 40],
        173 => ['attack' => 8, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 7, 'hp' => 45],
        174 => ['attack' => 8, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 7, 'hp' => 45],
        175 => ['attack' => 8, 'defence' => 10, 'spAttack' => 9, 'spDefence' => 10, 'speed' => 8, 'hp' => 45],
        177 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        179 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 8, 'hp' => 50],
        183 => ['attack' => 8, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        187 => ['attack' => 8, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        190 => ['attack' => 10, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 11, 'hp' => 50],
        191 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 45],
        193 => ['attack' => 10, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 11, 'hp' => 50],
        194 => ['attack' => 9, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 7, 'hp' => 50],
        198 => ['attack' => 11, 'defence' => 9, 'spAttack' => 11, 'spDefence' => 9, 'speed' => 11, 'hp' => 50],
        200 => ['attack' => 10, 'defence' => 10, 'spAttack' => 11, 'spDefence' => 11, 'speed' => 11, 'hp' => 50],
        201 => ['attack' => 10, 'defence' => 10, 'spAttack' => 10, 'spDefence' => 10, 'speed' => 10, 'hp' => 50],
        202 => ['attack' => 9, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        203 => ['attack' => 9, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        204 => ['attack' => 10, 'defence' => 11, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 7, 'hp' => 45],
        206 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 7, 'hp' => 40],
        207 => ['attack' => 10, 'defence' => 9, 'spAttack' => 7, 'spDefence' => 8, 'speed' => 9, 'hp' => 50],
        209 => ['attack' => 11, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        211 => ['attack' => 10, 'defence' => 8, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 8, 'hp' => 40],
        213 => ['attack' => 6, 'defence' => 15, 'spAttack' => 6, 'spDefence' => 15, 'speed' => 6, 'hp' => 35],
        214 => ['attack' => 10, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 8, 'speed' => 8, 'hp' => 50],
        215 => ['attack' => 11, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 10, 'speed' => 12, 'hp' => 50],
        216 => ['attack' => 11, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 50],
        218 => ['attack' => 9, 'defence' => 9, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 8, 'hp' => 45],
        220 => ['attack' => 9, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        222 => ['attack' => 9, 'defence' => 11, 'spAttack' => 10, 'spDefence' => 11, 'speed' => 8, 'hp' => 50],
        223 => ['attack' => 10, 'defence' => 8, 'spAttack' => 10, 'spDefence' => 8, 'speed' => 10, 'hp' => 45],
        225 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 40],
        226 => ['attack' => 6, 'defence' => 7, 'spAttack' => 8, 'spDefence' => 11, 'speed' => 8, 'hp' => 45],
        227 => ['attack' => 8, 'defence' => 14, 'spAttack' => 7, 'spDefence' => 8, 'speed' => 8, 'hp' => 55],
        228 => ['attack' => 10, 'defence' => 8, 'spAttack' => 11, 'spDefence' => 9, 'speed' => 10, 'hp' => 45],
        231 => ['attack' => 9, 'defence' => 9, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        234 => ['attack' => 9, 'defence' => 8, 'spAttack' => 9, 'spDefence' => 8, 'speed' => 9, 'hp' => 45],
        235 => ['attack' => 7, 'defence' => 7, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 7, 'hp' => 45],
        236 => ['attack' => 8, 'defence' => 8, 'spAttack' => 8, 'spDefence' => 8, 'speed' => 8, 'hp' => 45],
        238 => ['attack' => 8, 'defence' => 7, 'spAttack' => 11, 'spDefence' => 10, 'speed' => 10, 'hp' => 45],
        239 => ['attack' => 10, 'defence' => 8, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        240 => ['attack' => 10, 'defence' => 8, 'spAttack' => 10, 'spDefence' => 9, 'speed' => 11, 'hp' => 45],
        241 => ['attack' => 8, 'defence' => 9, 'spAttack' => 6, 'spDefence' => 8, 'speed' => 9, 'hp' => 50],
        243 => ['attack' => 12, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 12, 'speed' => 12, 'hp' => 60],
        244 => ['attack' => 12, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 12, 'speed' => 12, 'hp' => 60],
        245 => ['attack' => 12, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 12, 'speed' => 12, 'hp' => 60],
        246 => ['attack' => 10, 'defence' => 9, 'spAttack' => 9, 'spDefence' => 9, 'speed' => 9, 'hp' => 45],
        249 => ['attack' => 12, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 12, 'speed' => 12, 'hp' => 60],
        250 => ['attack' => 12, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 12, 'speed' => 12, 'hp' => 60],
        251 => ['attack' => 12, 'defence' => 12, 'spAttack' => 12, 'spDefence' => 12, 'speed' => 12, 'hp' => 60],
        ];

    private static $pokemonInfo = [
    1 => ['idPokemon' => 1, 'name' => 'Bulbasaur', 'minLevel' => 1, 'lvlEvolution' => 2, 'type1' => 4, 'type2' => 8,'attacks' => '541,1;215,3;290,7;580,9;379,13;483,13;546,15;413,19;535,21;216,25;282,27;540,33;456,37;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 125, 'genderMale' => 875],
    2 => ['idPokemon' => 2, 'name' => 'Ivysaur', 'minLevel' => 16, 'lvlEvolution' => 3, 'type1' => 4, 'type2' => 8,'attacks' => '541,1;215,1;290,1;580,9;379,13;483,13;546,15;413,20;535,23;216,28;282,31;540,39;497,44;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 125, 'genderMale' => 875],
    3 => ['idPokemon' => 3, 'name' => 'Venusaur', 'minLevel' => 32, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 8,'attacks' => '541,1;215,1;290,1;580,1;379,13;483,13;546,15;413,20;535,23;216,28;282,31;370,32;540,45;369,50;497,53;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 125, 'genderMale' => 875],
    4 => ['idPokemon' => 4, 'name' => 'Charmander', 'minLevel' => 1, 'lvlEvolution' => 5, 'type1' => 2, 'type2' => 0,'attacks' => '451,1;215,1;145,7;491,10;125,16;450,19;168,25;173,28;482,34;176,37;170,43;270,46;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 125, 'genderMale' => 875],
    5 => ['idPokemon' => 5, 'name' => 'Charmeleon', 'minLevel' => 16, 'lvlEvolution' => 6, 'type1' => 2, 'type2' => 0,'attacks' => '451,1;215,1;145,1;491,10;125,17;450,21;168,28;173,32;482,39;176,43;170,50;270,54;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 125, 'genderMale' => 875],
    6 => ['idPokemon' => 6, 'name' => 'Charizard', 'minLevel' => 36, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 6,'attacks' => '122,1;461,1;12,1;451,1;145,1;491,1;125,17;450,21;168,28;173,32;596,36;482,41;176,47;170,56;270,62;239,71;177,77;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 125, 'genderMale' => 875],
    7 => ['idPokemon' => 7, 'name' => 'Squirtle', 'minLevel' => 1, 'lvlEvolution' => 8, 'type1' => 3, 'type2' => 0,'attacks' => '541,1;544,4;584,7;598,10;57,13;41,16;412,19;393,22;585,25;18,28;476,31;273,34;252,40;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 125, 'genderMale' => 875],
    8 => ['idPokemon' => 8, 'name' => 'Wartortle', 'minLevel' => 16, 'lvlEvolution' => 9, 'type1' => 3, 'type2' => 0,'attacks' => '541,1;544,1;584,1;598,10;57,13;41,16;412,20;393,24;585,28;18,32;476,36;273,40;252,48;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 125, 'genderMale' => 875],
    9 => ['idPokemon' => 9, 'name' => 'Blastoise', 'minLevel' => 36, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '179,1;541,1;544,1;584,1;598,1;57,13;41,16;412,20;393,24;585,28;18,32;476,39;273,46;252,60;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 125, 'genderMale' => 875],
    10 => ['idPokemon' => 10, 'name' => 'Caterpie', 'minLevel' => 1, 'lvlEvolution' => 11, 'type1' => 16, 'type2' => 0,'attacks' => '541,1;521,1;59,15;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    11 => ['idPokemon' => 11, 'name' => 'Metapod', 'minLevel' => 7, 'lvlEvolution' => 12, 'type1' => 16, 'type2' => 0,'attacks' => '226,1;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    12 => ['idPokemon' => 12, 'name' => 'Butterfree', 'minLevel' => 10, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 6,'attacks' => '81,1;379,12;524,12;483,12;222,16;531,18;394,24;471,28;545,30;410,34;67,40;60,42;408,46;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    13 => ['idPokemon' => 13, 'name' => 'Weedle', 'minLevel' => 1, 'lvlEvolution' => 14, 'type1' => 16, 'type2' => 8,'attacks' => '380,1;521,1;59,15;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    14 => ['idPokemon' => 14, 'name' => 'Kakuna', 'minLevel' => 7, 'lvlEvolution' => 15, 'type1' => 16, 'type2' => 8,'attacks' => '226,1;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    15 => ['idPokemon' => 15, 'name' => 'Beedrill', 'minLevel' => 10, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 8,'attacks' => '197,1;185,13;572,16;609,19;404,22;564,25;372,28;10,31;23,34;378,37;147,40;164,45;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    16 => ['idPokemon' => 16, 'name' => 'Pidgey', 'minLevel' => 1, 'lvlEvolution' => 17, 'type1' => 1, 'type2' => 6,'attacks' => '541,1;446,5;222,9;406,13;573,21;161,25;10,29;596,33;440,37;545,41;331,45;12,49;250,53;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    17 => ['idPokemon' => 17, 'name' => 'Pidgeotto', 'minLevel' => 18, 'lvlEvolution' => 18, 'type1' => 1, 'type2' => 6,'attacks' => '541,1;446,1;222,1;406,13;573,22;161,27;10,32;596,37;440,42;545,47;331,52;12,57;250,62;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    18 => ['idPokemon' => 18, 'name' => 'Pidgeot', 'minLevel' => 36, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 6,'attacks' => '541,1;446,1;222,1;406,1;573,22;161,27;10,32;596,38;440,44;545,50;331,56;12,62;250,68;250,68;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    19 => ['idPokemon' => 19, 'name' => 'Rattata', 'minLevel' => 1, 'lvlEvolution' => 20, 'type1' => 1, 'type2' => 0,'attacks' => '541,1;544,1;406,4;185,7;41,10;404,13;254,16;527,19;95,22;23,25;529,28;282,31;147,34;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    20 => ['idPokemon' => 20, 'name' => 'Raticate', 'minLevel' => 20, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '541,1;538,1;544,1;406,1;185,1;41,10;404,13;254,16;527,19;450,20;95,24;23,29;529,34;282,39;147,44;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    21 => ['idPokemon' => 21, 'name' => 'Spearow', 'minLevel' => 1, 'lvlEvolution' => 22, 'type1' => 1, 'type2' => 6,'attacks' => '367,1;215,1;291,5;197,9;404,13;7,17;331,21;10,25;23,29;440,33;131,37;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    22 => ['idPokemon' => 22, 'name' => 'Fearow', 'minLevel' => 20, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 6,'attacks' => '375,1;367,1;215,1;291,1;197,1;404,13;7,17;331,23;10,29;23,35;440,41;131,47;132,53;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    23 => ['idPokemon' => 23, 'name' => 'Ekans', 'minLevel' => 1, 'lvlEvolution' => 24, 'type1' => 8, 'type2' => 0,'attacks' => '603,1;291,1;380,4;41,9;209,12;452,17;2,20;516,25;505,25;4,28;339,33;36,38;227,41;77,44;221,49;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    24 => ['idPokemon' => 24, 'name' => 'Arbok', 'minLevel' => 22, 'lvlEvolution' => 0, 'type1' => 8, 'type2' => 0,'attacks' => '262,1;555,1;168,1;603,1;380,1;41,1;209,12;452,17;2,20;95,22;516,27;505,27;4,32;339,39;36,48;227,51;77,56;221,63;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    25 => ['idPokemon' => 25, 'name' => 'Pikachu', 'minLevel' => 2, 'lvlEvolution' => 26, 'type1' => 5, 'type2' => 0,'attacks' => '557,1;544,1;215,5;373,7;406,10;142,13;558,18;162,21;117,23;500,26;354,29;110,34;481,37;559,42;10,45;594,50;294,53;554,58;', 'requirements' => 3, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    26 => ['idPokemon' => 26, 'name' => 'Raichu', 'minLevel' => 3, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 0,'attacks' => '557,1;559,1;544,1;406,1;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    27 => ['idPokemon' => 27, 'name' => 'Sandshrew', 'minLevel' => 1, 'lvlEvolution' => 28, 'type1' => 12, 'type2' => 0,'attacks' => '451,1;102,1;446,3;380,5;439,7;412,9;198,11;310,14;536,17;199,20;447,23;482,26;107,30;223,34;538,38;136,46;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    28 => ['idPokemon' => 28, 'name' => 'Sandslash', 'minLevel' => 22, 'lvlEvolution' => 0, 'type1' => 12, 'type2' => 0,'attacks' => '451,1;102,1;446,1;380,1;439,7;412,9;198,11;310,14;536,17;199,20;96,22;447,24;482,28;107,33;223,38;538,43;136,53;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    29 => ['idPokemon' => 29, 'name' => 'Nidoran', 'minLevel' => 1, 'lvlEvolution' => 30, 'type1' => 8, 'type2' => 0,'attacks' => '215,1;451,1;544,7;115,9;380,13;199,19;41,21;564,31;180,33;95,37;67,43;376,45;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 1000, 'genderMale' => 0],
    30 => ['idPokemon' => 30, 'name' => 'Nidorina', 'minLevel' => 16, 'lvlEvolution' => 31, 'type1' => 8, 'type2' => 0,'attacks' => '215,1;451,1;544,7;115,9;380,13;199,20;41,23;564,35;180,38;95,43;67,50;376,58;', 'requirements' => 5, 'difficulty' => 3, 'genderFemale' => 1000, 'genderMale' => 0],
    31 => ['idPokemon' => 31, 'name' => 'Nidoqueen', 'minLevel' => 17, 'lvlEvolution' => 0, 'type1' => 8, 'type2' => 12,'attacks' => '451,1;544,1;115,1;380,1;72,23;47,35;135,43;530,58;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 1000, 'genderMale' => 0],
    32 => ['idPokemon' => 32, 'name' => 'Nidoran', 'minLevel' => 1, 'lvlEvolution' => 33, 'type1' => 8, 'type2' => 0,'attacks' => '291,1;367,1;185,7;115,9;380,13;197,19;246,21;564,31;180,33;378,37;67,43;247,45;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 0, 'genderMale' => 1000],
    33 => ['idPokemon' => 33, 'name' => 'Nidorino', 'minLevel' => 16, 'lvlEvolution' => 34, 'type1' => 8, 'type2' => 0,'attacks' => '291,1;367,1;185,7;115,9;380,13;197,20;246,23;564,35;180,38;378,43;67,50;247,58;', 'requirements' => 5, 'difficulty' => 3, 'genderFemale' => 0, 'genderMale' => 1000],
    34 => ['idPokemon' => 34, 'name' => 'Nidoking', 'minLevel' => 17, 'lvlEvolution' => 0, 'type1' => 8, 'type2' => 12,'attacks' => '367,1;185,1;115,1;380,1;72,23;553,25;135,43;318,58;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 100],
    35 => ['idPokemon' => 35, 'name' => 'Clefairy', 'minLevel' => 2, 'lvlEvolution' => 36, 'type1' => 18, 'type2' => 0,'attacks' => '109,1;382,1;215,1;473,7;116,10;102,13;583,22;328,25;519,28;324,31;86,34;47,40;337,43;336,46;323,50;235,55;', 'requirements' => 5, 'difficulty' => 6, 'genderFemale' => 750, 'genderMale' => 250],
    36 => ['idPokemon' => 36, 'name' => 'Clefable', 'minLevel' => 3, 'lvlEvolution' => 0, 'type1' => 18, 'type2' => 0,'attacks' => '109,1;473,1;116,1;328,1;324,1;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 750, 'genderMale' => 250],
    37 => ['idPokemon' => 37, 'name' => 'Vulpix', 'minLevel' => 1, 'lvlEvolution' => 38, 'type1' => 2, 'type2' => 0,'attacks' => '145,1;544,4;31,9;406,10;80,12;170,15;366,18;595,20;163,23;242,26;173,28;153,31;176,36;167,42;67,47;270,50;', 'requirements' => 1, 'difficulty' => 4, 'genderFemale' => 750, 'genderMale' => 250],
    38 => ['idPokemon' => 38, 'name' => 'Ninetales', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '345,1;176,1;406,1;80,1;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 750, 'genderMale' => 250],
    39 => ['idPokemon' => 39, 'name' => 'Jigglypuff', 'minLevel' => 2, 'lvlEvolution' => 40, 'type1' => 1, 'type2' => 18,'attacks' => '473,1;102,3;382,5;373,8;109,11;108,15;116,18;439,21;442,24;583,28;422,32;47,35;326,37;223,40;255,44;282,49;', 'requirements' => 5, 'difficulty' => 6, 'genderFemale' => 750, 'genderMale' => 250],
    40 => ['idPokemon' => 40, 'name' => 'Wigglytuff', 'minLevel' => 3, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 18,'attacks' => '282,1;374,1;473,1;108,1;102,1;116,1;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 750, 'genderMale' => 250],
    41 => ['idPokemon' => 41, 'name' => 'Zubat', 'minLevel' => 1, 'lvlEvolution' => 42, 'type1' => 8, 'type2' => 6,'attacks' => '289,1;531,5;24,7;41,11;596,13;80,17;11,19;536,23;376,25;5,31;227,35;578,37;12,41;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    42 => ['idPokemon' => 42, 'name' => 'Golbat', 'minLevel' => 22, 'lvlEvolution' => 169, 'type1' => 8, 'type2' => 6,'attacks' => '452,1;289,1;531,1;24,1;41,1;596,13;80,17;11,19;536,24;376,27;5,35;227,40;578,43;12,48;', 'requirements' => 998, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    43 => ['idPokemon' => 43, 'name' => 'Oddish', 'minLevel' => 1, 'lvlEvolution' => 44, 'type1' => 4, 'type2' => 8,'attacks' => '1,1;535,5;2,9;379,13;524,14;483,15;315,19;337,27;206,31;563,35;346,39;336,43;370,51;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    44 => ['idPokemon' => 44, 'name' => 'Gloom', 'minLevel' => 21, 'lvlEvolution' => 45000182, 'type1' => 4, 'type2' => 8,'attacks' => '1,1;2,1;535,1;379,13;524,14;483,15;315,19;337,29;206,34;563,39;346,44;369,49;370,59;', 'requirements' => 4, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    45 => ['idPokemon' => 45, 'name' => 'Vileplume', 'minLevel' => 22, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 8,'attacks' => '315,1;20,1;379,1;524,1;369,49;370,59;497,64;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    46 => ['idPokemon' => 46, 'name' => 'Paras', 'minLevel' => 1, 'lvlEvolution' => 47, 'type1' => 16, 'type2' => 4,'attacks' => '451,1;524,6;379,6;289,11;198,17;508,22;482,27;216,33;206,38;20,43;410,49;605,54;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    47 => ['idPokemon' => 47, 'name' => 'Parasect', 'minLevel' => 24, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 4,'attacks' => '94,1;451,1;524,1;379,1;289,1;198,17;508,22;482,29;216,37;206,44;20,51;410,59;605,66;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    48 => ['idPokemon' => 48, 'name' => 'Venonat', 'minLevel' => 1, 'lvlEvolution' => 49, 'type1' => 16, 'type2' => 8,'attacks' => '541,1;108,1;189,1;531,5;81,11;379,13;289,17;524,23;394,25;483,29;470,35;608,37;376,41;396,47;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    49 => ['idPokemon' => 49, 'name' => 'Venomoth', 'minLevel' => 31, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 8,'attacks' => '471,1;541,1;108,1;189,1;531,1;80,5;379,13;289,17;524,23;394,25;483,29;222,31;470,37;608,41;376,47;396,55;60,59;408,63;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    50 => ['idPokemon' => 50, 'name' => 'Diglett', 'minLevel' => 1, 'lvlEvolution' => 51, 'type1' => 12, 'type2' => 0,'attacks' => '451,1;446,1;215,4;24,7;342,12;310,15;62,18;527,23;339,26;135,29;107,34;482,37;136,40;171,45;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    51 => ['idPokemon' => 51, 'name' => 'Dugtrio', 'minLevel' => 26, 'lvlEvolution' => 0, 'type1' => 12, 'type2' => 0,'attacks' => '441,1;351,1;566,1;451,1;446,1;215,1;24,7;342,12;310,15;62,18;527,23;447,26;339,28;135,33;107,40;482,45;136,50;171,57;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    52 => ['idPokemon' => 52, 'name' => 'Meowth', 'minLevel' => 1, 'lvlEvolution' => 53, 'type1' => 1, 'type2' => 0,'attacks' => '451,1;215,1;41,6;158,9;199,14;452,17;163,22;574,25;365,30;482,33;345,38;23,41;67,46;350,49;162,50;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    53 => ['idPokemon' => 53, 'name' => 'Persian', 'minLevel' => 28, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '374,1;451,1;215,1;41,1;158,1;199,14;452,17;163,22;536,28;385,32;482,37;345,44;23,49;67,56;351,61;162,65;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    54 => ['idPokemon' => 54, 'name' => 'Psyduck', 'minLevel' => 1, 'lvlEvolution' => 55, 'type1' => 3, 'type2' => 0,'attacks' => '451,1;544,4;584,8;81,11;199,15;585,18;108,22;452,25;18,29;608,32;395,39;14,43;252,46;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    55 => ['idPokemon' => 55, 'name' => 'Golduck', 'minLevel' => 33, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '16,1;451,1;544,1;584,1;81,11;199,15;585,18;108,22;608,25;452,29;18,32;395,43;14,49;252,54;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    56 => ['idPokemon' => 56, 'name' => 'Mankey', 'minLevel' => 1, 'lvlEvolution' => 57, 'type1' => 10, 'type2' => 0,'attacks' => '90,1;451,1;297,1;291,1;185,1;199,9;278,13;458,17;452,21;23,25;532,33;93,37;553,41;403,45;76,49;166,53;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    57 => ['idPokemon' => 57, 'name' => 'Primeape', 'minLevel' => 28, 'lvlEvolution' => 0, 'type1' => 10, 'type2' => 0,'attacks' => '181,1;451,1;297,1;291,1;185,1;199,9;278,13;458,17;452,21;23,25;609,28;532,35;93,41;553,47;403,53;76,59;166,63;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    58 => ['idPokemon' => 58, 'name' => 'Growlithe', 'minLevel' => 1, 'lvlEvolution' => 59, 'type1' => 2, 'type2' => 0,'attacks' => '41,1;145,6;291,8;357,10;175,17;546,23;173,28;10,30;423,32;176,34;95,39;239,41;360,43;177,45;', 'requirements' => 1, 'difficulty' => 4, 'genderFemale' => 250, 'genderMale' => 750],
    59 => ['idPokemon' => 59, 'name' => 'Arcanine', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '555,1;41,1;357,1;168,1;154,24;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 250, 'genderMale' => 750],
    60 => ['idPokemon' => 60, 'name' => 'Poliwag', 'minLevel' => 1, 'lvlEvolution' => 61, 'type1' => 3, 'type2' => 0,'attacks' => '584,5;258,8;57,11;116,15;47,21;58,25;340,28;37,31;583,25;252,28;339,41;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    61 => ['idPokemon' => 61, 'name' => 'Poliwhirl', 'minLevel' => 25, 'lvlEvolution' => 62000186, 'type1' => 3, 'type2' => 0,'attacks' => '584,1;258,1;57,11;116,15;47,21;58,27;342,32;37,37;583,43;252,48;339,53;', 'requirements' => 2, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    62 => ['idPokemon' => 62, 'name' => 'Poliwrath', 'minLevel' => 26, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 10,'attacks' => '58,1;258,1;116,1;525,1;134,32;73,53;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    63 => ['idPokemon' => 63, 'name' => 'Abra', 'minLevel' => 1, 'lvlEvolution' => 64, 'type1' => 7, 'type2' => 0,'attacks' => '551,1;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 250, 'genderMale' => 750],
    64 => ['idPokemon' => 64, 'name' => 'Kadabra', 'minLevel' => 16, 'lvlEvolution' => 65, 'type1' => 7, 'type2' => 0,'attacks' => '551,1;279,1;81,1;108,18;394,21;398,28;416,31;396,38;202,43;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 250, 'genderMale' => 750],
    65 => ['idPokemon' => 65, 'name' => 'Alakazam', 'minLevel' => 17, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '551,1;279,1;81,1;108,18;394,21;398,28;416,31;396,38;65,41;202,43;', 'requirements' => 1, 'difficulty' => 10, 'genderFemale' => 250, 'genderMale' => 750],
    66 => ['idPokemon' => 66, 'name' => 'Machop', 'minLevel' => 1, 'lvlEvolution' => 67, 'type1' => 10, 'type2' => 0,'attacks' => '297,1;291,1;185,3;278,7;189,9;298,13;458,15;425,19;281,21;581,25;583,27;133,31;525,33;61,37;93,39;450,43;134,45;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 250, 'genderMale' => 750],
    67 => ['idPokemon' => 67, 'name' => 'Machoke', 'minLevel' => 28, 'lvlEvolution' => 68, 'type1' => 10, 'type2' => 0,'attacks' => '297,1;291,1;185,1;278,1;189,9;298,13;458,15;425,19;281,21;581,25;583,27;133,33;525,37;61,43;93,47;450,53;134,57;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 250, 'genderMale' => 750],
    68 => ['idPokemon' => 68, 'name' => 'Machamp', 'minLevel' => 29, 'lvlEvolution' => 0, 'type1' => 10, 'type2' => 0,'attacks' => '297,1;291,1;185,1;278,1;189,9;298,13;458,15;425,19;281,21;581,25;583,27;133,33;525,37;61,43;93,47;450,53;134,57;', 'requirements' => 1, 'difficulty' => 10, 'genderFemale' => 250, 'genderMale' => 750],
    69 => ['idPokemon' => 69, 'name' => 'Bellsprout', 'minLevel' => 1, 'lvlEvolution' => 70, 'type1' => 4, 'type2' => 8,'attacks' => '580,1;216,7;603,11;483,13;379,15;524,17;2,23;281,27;535,29;413,39;481,41;604,47;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    70 => ['idPokemon' => 70, 'name' => 'Weepinbell', 'minLevel' => 21, 'lvlEvolution' => 71, 'type1' => 4, 'type2' => 8,'attacks' => '580,1;216,1;603,1;483,13;379,15;524,17;2,23;281,27;535,29;413,39;481,41;604,47;', 'requirements' => 4, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    71 => ['idPokemon' => 71, 'name' => 'Victreebel', 'minLevel' => 22, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 8,'attacks' => '516,1;505,1;580,1;483,1;535,1;413,1;288,27;287,47;286,47;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    72 => ['idPokemon' => 72, 'name' => 'Tentacool', 'minLevel' => 1, 'lvlEvolution' => 73, 'type1' => 3, 'type2' => 8,'attacks' => '380,1;531,4;82,7;2,10;564,13;585,16;603,19;4,22;58,25;33,28;378,31;56,34;452,37;242,40;487,43;252,46;604,49;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    73 => ['idPokemon' => 73, 'name' => 'Tentacruel', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 8,'attacks' => '380,1;531,1;82,1;2,1;564,13;585,16;603,19;4,22;58,25;33,28;378,32;56,36;452,40;242,44;487,48;252,52;604,56;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    74 => ['idPokemon' => 74, 'name' => 'Geodude', 'minLevel' => 1, 'lvlEvolution' => 75, 'type1' => 13, 'type2' => 12,'attacks' => '541,1;102,1;431,6;439,10;310,12;434,16;488,18;62,22;459,24;429,30;136,34;152,36;282,40;518,42;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    75 => ['idPokemon' => 75, 'name' => 'Graveler', 'minLevel' => 25, 'lvlEvolution' => 76, 'type1' => 13, 'type2' => 12,'attacks' => '541,1;102,1;431,1;439,10;310,12;434,16;488,18;62,22;459,24;429,34;136,40;152,44;282,50;518,54;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    76 => ['idPokemon' => 76, 'name' => 'Golem', 'minLevel' => 26, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 12,'attacks' => '541,1;102,1;431,1;513,10;310,12;434,16;488,18;62,22;459,24;429,34;136,40;152,44;282,50;518,54;240,60;', 'requirements' => 1, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    77 => ['idPokemon' => 77, 'name' => 'Ponyta', 'minLevel' => 1, 'lvlEvolution' => 78, 'type1' => 2, 'type2' => 0,'attacks' => '541,1;215,1;544,4;145,9;175,13;517,17;174,21;170,25;546,29;270,33;10,37;167,41;53,45;177,49;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    78 => ['idPokemon' => 78, 'name' => 'Rapidash', 'minLevel' => 40, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '378,1;318,1;215,1;406,1;544,1;145,1;175,13;517,17;174,21;170,25;546,29;270,33;10,37;197,40;167,41;53,45;177,49;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    79 => ['idPokemon' => 79, 'name' => 'Slowpoke', 'minLevel' => 1, 'lvlEvolution' => 80000199, 'type1' => 3, 'type2' => 7,'attacks' => '98,1;606,1;541,1;215,5;584,9;81,14;108,19;230,23;585,28;608,32;480,36;14,41;396,45;395,54;234,58;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    80 => ['idPokemon' => 80, 'name' => 'Slowbro', 'minLevel' => 37, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 7,'attacks' => '98,1;541,1;606,1;215,1;584,9;81,14;108,19;230,23;585,28;608,32;480,36;598,37;14,43;396,49;395,62;234,68;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    81 => ['idPokemon' => 81, 'name' => 'Magnemite', 'minLevel' => 1, 'lvlEvolution' => 82, 'type1' => 5, 'type2' => 11,'attacks' => '541,1;531,5;557,7;498,11;558,13;307,17;500,19;332,23;322,25;142,29;179,31;452,35;110,37;223,47;607,49;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 0, 'genderMale' => 0],
    82 => ['idPokemon' => 82, 'name' => 'Magneton', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 11,'attacks' => '541,1;531,1;557,1;498,1;558,13;307,17;500,19;332,23;322,25;143,29;566,30;179,33;452,39;110,43;223,59;607,63;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    83 => ['idPokemon' => 83, 'name' => 'Farfetch\'d', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 6,'attacks' => '378,1;367,1;446,1;291,1;198,1;7,9;281,13;482,19;11,21;538,25;10,31;351,33;5,37;162,43;160,45;12,49;54,53;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    84 => ['idPokemon' => 84, 'name' => 'Doduo', 'minLevel' => 1, 'lvlEvolution' => 85, 'type1' => 1, 'type2' => 6,'attacks' => '367,1;215,1;406,5;609,9;197,13;404,17;375,21;114,25;6,29;10,33;131,37;575,41;147,45;553,49;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    85 => ['idPokemon' => 85, 'name' => 'Dodrio', 'minLevel' => 31, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 6,'attacks' => '367,1;215,1;406,1;609,1;197,13;404,17;375,21;566,25;6,29;10,35;131,41;575,47;147,53;553,59;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    86 => ['idPokemon' => 86, 'name' => 'Seel', 'minLevel' => 1, 'lvlEvolution' => 87, 'type1' => 3, 'type2' => 0,'attacks' => '230,1;215,3;267,11;264,17;422,21;17,23;28,27;16,31;56,33;546,37;111,41;18,43;260,47;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    87 => ['idPokemon' => 87, 'name' => 'Dewgong', 'minLevel' => 34, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 14,'attacks' => '230,1;215,1;470,1;267,1;264,17;422,21;16,23;28,27;16,31;56,33;466,34;546,39;111,45;18,49;260,55;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    88 => ['idPokemon' => 88, 'name' => 'Grimer', 'minLevel' => 1, 'lvlEvolution' => 89, 'type1' => 8, 'type2' => 0,'attacks' => '382,1;377,1;226,4;342,7;108,12;485,15;339,18;328,21;181,26;486,29;487,32;452,37;221,40;3,43;36,46;319,48;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    89 => ['idPokemon' => 89, 'name' => 'Muk', 'minLevel' => 38, 'lvlEvolution' => 0, 'type1' => 8, 'type2' => 0,'attacks' => '382,1;377,1;226,1;342,1;108,12;485,15;339,18;328,21;181,26;286,29;487,32;452,37;577,38;221,40;3,46;36,52;319,57;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    90 => ['idPokemon' => 90, 'name' => 'Shellder', 'minLevel' => 1, 'lvlEvolution' => 91, 'type1' => 3, 'type2' => 0,'attacks' => '541,1;598,4;531,8;265,13;393,16;291,20;74,25;264,28;414,32;28,37;591,40;56,44;273,49;260,52;467,56;252,61;', 'requirements' => 2, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    91 => ['idPokemon' => 91, 'name' => 'Cloyster', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 14,'attacks' => '252,1;467,1;564,1;598,1;531,1;393,1;28,1;502,13;503,28;265,50;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    92 => ['idPokemon' => 92, 'name' => 'Gastly', 'minLevel' => 1, 'lvlEvolution' => 93, 'type1' => 9, 'type2' => 8,'attacks' => '258,1;292,1;98,12;350,15;80,19;527,22;366,26;460,29;130,33;99, 36;104,40;242,43;352,47;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    93 => ['idPokemon' => 93, 'name' => 'Haunter', 'minLevel' => 25, 'lvlEvolution' => 94, 'type1' => 9, 'type2' => 8,'attacks' => '258,1;292,1;98,12;350,15;80,19;527,22;463,25;366,28;460,33;130,39;99,44;104,50;242,55;352,61;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    94 => ['idPokemon' => 94, 'name' => 'Gengar', 'minLevel' => 26, 'lvlEvolution' => 0, 'type1' => 9, 'type2' => 8,'attacks' => '258,1;292,1;98,12;350,15;80,19;527,22;463,25;366,28;460,33;130,39;99,44;104,50,242,55;352,61;', 'requirements' => 1, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    95 => ['idPokemon' => 95, 'name' => 'Onix', 'minLevel' => 1, 'lvlEvolution' => 208, 'type1' => 13, 'type2' => 12,'attacks' => '541,1;226,1;40,1;98,4;434,7;435,10;609,13;431,19;223,20;488,22;121,25;481,28;452,31;432,34;447,37;275,40;107,43;518,46;282,49;', 'requirements' => 990, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    96 => ['idPokemon' => 96, 'name' => 'Drowzee', 'minLevel' => 1, 'lvlEvolution' => 97, 'type1' => 7, 'type2' => 0,'attacks' => '382,1;258,1;108,5;81,9;230,13;377,17;314,21;394,25;395,33;539,37;608,41;532,45;396,49;345,53;400,57;202,61;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    97 => ['idPokemon' => 97, 'name' => 'Hypno', 'minLevel' => 26, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '345,1;352,1;382,1;258,1;108,1;81,1;230,13;377,17;314,21;394,25;395,33;539,37;608,41;532,45;396,49;400,57;202,61;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    98 => ['idPokemon' => 98, 'name' => 'Krabby', 'minLevel' => 1, 'lvlEvolution' => 99, 'type1' => 3, 'type2' => 0,'attacks' => '57,1;579,5;291,9;226,11;58,15;340,19;321,21;517,25;393,29;220,21;481,35;56,39;91,41;172,45;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    99 => ['idPokemon' => 99, 'name' => 'Kingler', 'minLevel' => 28, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '57,1;579,1;291,1;226,11;58,15;340,19;321,21;517,25;393,32;220,37;481,44;56,51;91,56;172,63;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    100 => ['idPokemon' => 100, 'name' => 'Voltorb', 'minLevel' => 1, 'lvlEvolution' => 101, 'type1' => 5, 'type2' => 0,'attacks' => '68,1;541,1;498,4;138,6;500,9;439,11;452,13;69,16;536,20;142,22;459,26;294,29;110,37;152,41;223,46;330,48;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 0, 'genderMale' => 0],
    101 => ['idPokemon' => 101, 'name' => 'Electrode', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 0,'attacks' => '309,1;68,1;541,1;498,1;500,1;138,6;439,11;452,13;69,16;536,20;142,22;459,26;294,29;110,41;152,47;223,54;330,58;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 0, 'genderMale' => 0],
    102 => ['idPokemon' => 102, 'name' => 'Exeggcute', 'minLevel' => 1, 'lvlEvolution' => 103, 'type1' => 4, 'type2' => 7,'attacks' => '32,1;575,1;258,1;290,11;64,17;524,19;379,21;483,23;81,27;346,37;497,43;153,47;', 'requirements' => 4, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    103 => ['idPokemon' => 103, 'name' => 'Exeggutor', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 7,'attacks' => '456,1;32,1;258,1;81,1;517,1;400,17;139,27;600,37;287,47;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    104 => ['idPokemon' => 104, 'name' => 'Cubone', 'minLevel' => 1, 'lvlEvolution' => 105, 'type1' => 12, 'type2' => 0,'attacks' => '215,1;544,3;49,7;230,11;291,13;185,17;51,21;609,23;160,27;553,31;181,33;50,37;147,41;282,43;423,47;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    105 => ['idPokemon' => 105, 'name' => 'Marowak', 'minLevel' => 28, 'lvlEvolution' => 0, 'type1' => 12, 'type2' => 0,'attacks' => '215,1;544,1;49,1;230,1;291,13;185,17;51,21;609,23;160,27;553,33;181,37;50,43;147,49;282,53;423,59;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    106 => ['idPokemon' => 106, 'name' => 'Hitmonlee', 'minLevel' => 2, 'lvlEvolution' => 236, 'type1' => 10, 'type2' => 0,'attacks' => '425,1;115,1;314,5;438,9;277,13;55,17;185,21;162,25;244,29;189,37;43,35;316,53;76,57;426,61;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 0, 'genderMale' => 1000],
    107 => ['idPokemon' => 107, 'name' => 'Hitmonchan', 'minLevel' => 2, 'lvlEvolution' => 236, 'type1' => 10, 'type2' => 0,'attacks' => '425,1;78,1;10,6;404,11;302,16;63,16;162,21;576,26;556,36;263,36;169,36;479,41;317,46;105,50;186,56;89,61;76,66;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 0, 'genderMale' => 1000],
    108 => ['idPokemon' => 108, 'name' => 'Lickitung', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '292,1;531,5;102,9;281,13;603,17;517,21;108,25;481,29;439,33;72,37;420,45;452,49;389,53;604,57;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    109 => ['idPokemon' => 109, 'name' => 'Koffing', 'minLevel' => 1, 'lvlEvolution' => 110, 'type1' => 8, 'type2' => 0,'attacks' => '377,1;541,1;490,4;491,7;23,12;75,15;485,18;459,23;227,26;223,29;486,34;152,37;104,40;36,42;319,45;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    110 => ['idPokemon' => 110, 'name' => 'Weezing', 'minLevel' => 35, 'lvlEvolution' => 0, 'type1' => 8, 'type2' => 0,'attacks' => '541,1;377,1;490,1;491,1;23,7;75,15;485,18;459,23;227,26;114,29;486,34;152,40;104,46;36,51;319,57;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    111 => ['idPokemon' => 111, 'name' => 'Rhyhorn', 'minLevel' => 1, 'lvlEvolution' => 112, 'type1' => 13, 'type2' => 12,'attacks' => '246,1;544,1;197,5;450,9;488,13;517,17;62,21;72,25;429,29;132,33;546,37;518,41;136,45;318,49;247,53;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    112 => ['idPokemon' => 112, 'name' => 'Rhydon', 'minLevel' => 42, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 12,'attacks' => '246,1;544,1;197,1;450,1;488,13;517,17;62,21;72,25;429,29;132,33;546,37;518,41;225,42;136,48;318,55;247,62;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    113 => ['idPokemon' => 113, 'name' => 'Chansey', 'minLevel' => 1, 'lvlEvolution' => 242, 'type1' => 1, 'type2' => 0,'attacks' => '282,1;102,1;382,1;215,1;544,5;420,9;116,12;496,16;328,23;546,27;473,31;181,34;234,38;139,42;294,46;235,50;', 'requirements' => 998, 'difficulty' => 6, 'genderFemale' => 1000, 'genderMale' => 0],
    114 => ['idPokemon' => 114, 'name' => 'Tangela', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 0,'attacks' => '271,1;82,1;483,4;580,7;1,10;379,14;40,17;216,20;315,23;281,27;524,30;346,33;206,36;15,38;481,41;560,44;604,46;389,50;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    115 => ['idPokemon' => 115, 'name' => 'Kanghaskan', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '78,1;291,1;158,7;544,10;41,13;114,19;609,22;317,25;72,31;112,34;95,37;360,46;527,49;426,50;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 1000, 'genderMale' => 0],
    116 => ['idPokemon' => 116, 'name' => 'Horsea', 'minLevel' => 1, 'lvlEvolution' => 117, 'type1' => 3, 'type2' => 0,'attacks' => '57,1;491,5;291,9;584,13;573,17;58,21;185,26;56,31;10,36;124,41;123,46;252,52;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    117 => ['idPokemon' => 117, 'name' => 'Seadra', 'minLevel' => 32, 'lvlEvolution' => 230, 'type1' => 3, 'type2' => 0,'attacks' => '57,1;491,1;291,1;584,1;473,17;58,21;185,26;56,31;10,38;124,45;123,52;252,60;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    118 => ['idPokemon' => 118, 'name' => 'Goldeen', 'minLevel' => 1, 'lvlEvolution' => 119, 'type1' => 3, 'type2' => 0,'attacks' => '367,1;544,1;531,5;246,8;172,13;585,16;17,21;197,24;10,29;589,32;247,37;318,45;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    119 => ['idPokemon' => 119, 'name' => 'Seaking', 'minLevel' => 33, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '378,1;367,1;544,1;531,1;246,8;172,13;585,16;17,21;197,24;10,29;589,32;247,40;318,54;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    120 => ['idPokemon' => 120, 'name' => 'Staryu', 'minLevel' => 1, 'lvlEvolution' => 121, 'type1' => 3, 'type2' => 0,'attacks' => '541,1;226,1;584,4;412,7;416,10;402,13;536,16;58,18;223,24;56,28;328,31;385,37;80,40;396,42;294,46;86,49;252,53;', 'requirements' => 2, 'difficulty' => 3, 'genderFemale' => 0, 'genderMale' => 0],
    121 => ['idPokemon' => 121, 'name' => 'Starmie', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 7,'attacks' => '252,1;584,1;412,1;416,1;536,1;80,40;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    122 => ['idPokemon' => 122, 'name' => 'Mr.Mime', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '305,1;33,1;81,1;314,8;116,11;326,15;402,15;294,22;394,25;396,39;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    123 => ['idPokemon' => 123, 'name' => 'Scyther', 'minLevel' => 1, 'lvlEvolution' => 212, 'type1' => 16, 'type2' => 6,'attacks' => '576,1;406,1;291,1;185,5;404,9;160,13;10,17;596,21;198,25;482,29;415,33;117,37;605,41;351,45;114,49;12,50;538,57;162,61;', 'requirements' => 990, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    124 => ['idPokemon' => 124, 'name' => 'Jynx', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 14, 'type2' => 7,'attacks' => '129,1;382,1;292,5;296,8;384,11;116,15;263,18;236,21;159,28;583,33;30,39;47,44;604,49;368,55;44,60;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 1000, 'genderMale' => 0],
    125 => ['idPokemon' => 125, 'name' => 'Electabuzz', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 0,'attacks' => '406,1;291,1;557,5;297,8;536,12;469,15;558,19;142,22;294,26;556,29;110,36;452,42;559,49;554,55;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 250, 'genderMale' => 750],
    126 => ['idPokemon' => 126, 'name' => 'Magmar', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '490,1;291,1;145,5;491,8;163,12;170,15;75,19;173,22;80,26;169,29;285,36;176,49;167,55;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 250, 'genderMale' => 750],
    127 => ['idPokemon' => 127, 'name' => 'Pinsir', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 0,'attacks' => '579,1;185,1;40,4;458,8;226,11;425,15;581,18;114,22;55,26;525,29;605,33;520,36;538,40;553,43;530,47;220,50;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    128 => ['idPokemon' => 128, 'name' => 'Tauros', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '541,1;544,3;609,5;246,8;450,11;404,15;422,19;366,24;601,29;608,35;546,41;532,48;553,50;207,63;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 1000],
    129 => ['idPokemon' => 129, 'name' => 'Magikarp', 'minLevel' => 1, 'lvlEvolution' => 130, 'type1' => 3, 'type2' => 0,'attacks' => '507,1;541,15;172,30;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    130 => ['idPokemon' => 130, 'name' => 'Gyarados', 'minLevel' => 20, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 6,'attacks' => '553,1;41,20;125,23;291,26;573,29;262,32;18,35;95,41;252,44;123,47;253,50;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    131 => ['idPokemon' => 131, 'name' => 'Lapras', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 14,'attacks' => '473,1;215,1;584,1;333,4;80,7;585,14;47,18;368,27;260,32;56,37;252,47;466,50;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    132 => ['idPokemon' => 132, 'name' => 'Ditto', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '565,1;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    133 => ['idPokemon' => 133, 'name' => 'Eevee', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '215,1;541,1;544,1;446,5;31,9;536,10;406,13;41,17;420,20;90,23;546,25;70,29;282,37;284,41;571,45;', 'requirements' => 123, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    134 => ['idPokemon' => 134, 'name' => 'Vaporeon', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '541,1;544,1;446,5;584,9;406,13;585,17;28,20;17,25;3,29;227,33;343,37;284,41;252,45;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    135 => ['idPokemon' => 135, 'name' => 'Jolteon', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 0,'attacks' => '541,1;544,1;446,5;557,9;406,13;115,17;555,20;372,25;10,29;558,33;110,37;284,41;554,45;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    136 => ['idPokemon' => 136, 'name' => 'Flareon', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '541,1;544,1;446,5;145,9;406,13;41,17;168,20;170,25;450,29;490,33;285,37;284,41;177,45;', 'requirements' => 999, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    137 => ['idPokemon' => 137, 'name' => 'Porygon', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '83,1;84,1;541,1;465,1;394,7;10,12;416,18;470,29;110,40;566,50;607,62;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 0, 'genderMale' => 0],
    138 => ['idPokemon' => 138, 'name' => 'Omanyte', 'minLevel' => 1, 'lvlEvolution' => 139, 'type1' => 13, 'type2' => 3,'attacks' => '82,1;598,1;41,7;584,10;439,16;291,19;340,25;56,28;393,34;15,37;560,43;429,46;467,50;252,55;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    139 => ['idPokemon' => 139, 'name' => 'Omastar', 'minLevel' => 40, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 3,'attacks' => '82,1;598,1;41,7;584,10;439,16;291,19;340,25;56,28;393,34;15,37;502,40;560,48;429,56;467,67;252,75;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    140 => ['idPokemon' => 140, 'name' => 'Kabuto', 'minLevel' => 1, 'lvlEvolution' => 141, 'type1' => 13, 'type2' => 3,'attacks' => '451,1;226,1;1,6;291,11;340,16;446,21;16,31;315,36;322,41;15,46;604,50;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    141 => ['idPokemon' => 141, 'name' => 'Kabutops', 'minLevel' => 40, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 3,'attacks' => '162,1;451,1;226,1;1,6;291,11;340,16;446,21;16,31;315,36;482,40;322,45;15,54;604,63;351,72;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    142 => ['idPokemon' => 142, 'name' => 'Aerodactyl', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 6,'attacks' => '261,1;168,1;555,1;596,1;531,1;41,1;450,1;10,17;15,25;95,33;546,41;478,49;271,57;253,65;432,73;207,81;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    143 => ['idPokemon' => 143, 'name' => 'Snorlax', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '541,1;102,4;14,9;292,12;72,17;606,20;47,25;422,28;494,28;439,36;37,44;95,49;240,50;207,57;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    144 => ['idPokemon' => 144, 'name' => 'Articuno', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 14, 'type2' => 6,'attacks' => '193,1;222,1;384,1;333,8;264,15;15,29;10,36;260,43;545,64;44,71;466,78;440,85;250,92;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    145 => ['idPokemon' => 145, 'name' => 'Zapdos', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 6,'attacks' => '367,1;557,1;558,8;105,15;375,22;15,29;68,36;10,43;110,50;294,64;131,71;554,78;440,85;607,92;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    146 => ['idPokemon' => 146, 'name' => 'Moltres', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 6,'attacks' => '596,1;145,1;170,8;10,15;15,29;176,36;12,50;239,64;497,71;477,78;440,85;250,92;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    147 => ['idPokemon' => 147, 'name' => 'Dratini', 'minLevel' => 1, 'lvlEvolution' => 148, 'type1' => 17, 'type2' => 0,'attacks' => '603,1;291,1;558,5;573,11;125,15;481,21;10,25;127,31;18,35;126,41;123,51;360,55;253,61;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    148 => ['idPokemon' => 148, 'name' => 'Dragonair', 'minLevel' => 30, 'lvlEvolution' => 149, 'type1' => 17, 'type2' => 0,'attacks' => '603,1;291,1;558,5;573,11;125,15;481,21;10,25;127,33;18,39;126,47;123,61;360,67;253,75;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    149 => ['idPokemon' => 149, 'name' => 'Dragonite', 'minLevel' => 55, 'lvlEvolution' => 0, 'type1' => 17, 'type2' => 6,'attacks' => '169,1;556,1;440,1;603,1;291,1;558,5;573,11;125,15;481,21;10,25;127,33;18,39;126,47;596,55;123,61;360,67;253,75;250,81;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    150 => ['idPokemon' => 150, 'name' => 'Mewtwo', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '81,1;108,1;536,8;202,15;395,22;298,36;416,50;396,57;33,64;27,70;14,79;333,86;401,100;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    151 => ['idPokemon' => 151, 'name' => 'Mew', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '382,1;565,1;317,10;324,20;396,30;33,40;15,50;14,60;345,90;27,100;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    152 => ['idPokemon' => 152, 'name' => 'Chikorita', 'minLevel' => 1, 'lvlEvolution' => 153, 'type1' => 4, 'type2' => 0,'attacks' => '541,1;215,1;413,6;379,9;540,12;418,17;305,20;346,23;535,28;294,31;47,34;20,42;497,45;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 125, 'genderMale' => 875],
    153 => ['idPokemon' => 153, 'name' => 'Bayleef', 'minLevel' => 16, 'lvlEvolution' => 154, 'type1' => 4, 'type2' => 0,'attacks' => '379,1;413,1;215,1;541,1;540,12;418,18;305,22;346,26;535,32;294,36;47,40;20,50;497,54;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 125, 'genderMale' => 875],
    154 => ['idPokemon' => 154, 'name' => 'Meganium', 'minLevel' => 32, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 0,'attacks' => '541,1;369,1;215,1;413,1;379,1;540,12;418,18;305,22;346,26;370,32;535,34;294,40;47,46;20,60;497,66;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 125, 'genderMale' => 875],
    155 => ['idPokemon' => 155, 'name' => 'Cyndaquil', 'minLevel' => 1, 'lvlEvolution' => 156, 'type1' => 2, 'type2' => 0,'attacks' => '541,1;291,1;491,6;145,10;406,13;175,19;102,22;174,28;536,31;285,37;176,40;270,46;439,49;282,55;151,58;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 125, 'genderMale' => 875],
    156 => ['idPokemon' => 156, 'name' => 'Quilava', 'minLevel' => 14, 'lvlEvolution' => 157, 'type1' => 2, 'type2' => 0,'attacks' => '541,1;291,1;491,1;145,10;406,13;175,20;102,24;536,31;174,35;285,42;176,46;270,53;439,57;282,64;151,68;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 125, 'genderMale' => 875],
    157 => ['idPokemon' => 157, 'name' => 'Typhlosion', 'minLevel' => 36, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '291,1;151,1;223,1;541,1;282,1;145,1;491,1;406,13;175,20;102,24;536,31;174,35;285,43;176,48;270,56;439,61;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 125, 'genderMale' => 875],
    158 => ['idPokemon' => 158, 'name' => 'Totodile', 'minLevel' => 1, 'lvlEvolution' => 159, 'type1' => 3, 'type2' => 0,'attacks' => '291,1;451,1;584,6;609,8;41,13;450,15;262,20;172,22;95,27;72,29;482,34;452,36;553,41;18,43;530,48;252,50;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 125, 'genderMale' => 875],
    159 => ['idPokemon' => 159, 'name' => 'Croconaw', 'minLevel' => 18, 'lvlEvolution' => 160, 'type1' => 3, 'type2' => 0,'attacks' => '451,1;291,1;584,1;609,8;41,13;450,15;262,21;172,24;95,30;72,33;482,39;452,42;553,48;18,51;530,57;252,60;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 125, 'genderMale' => 875],
    160 => ['idPokemon' => 160, 'name' => 'Feraligatr', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '291,1;451,1;609,1;584,1;41,13;450,15;262,21;172,24;10,30;95,32;72,37;482,45;452,50;553,58;18,63;530,71;252,76;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 125, 'genderMale' => 875],
    161 => ['idPokemon' => 161, 'name' => 'Sentret', 'minLevel' => 1, 'lvlEvolution' => 162, 'type1' => 1, 'type2' => 0,'attacks' => '451,1;189,1;102,4;406,7;199,13;241,16;187,19;481,25;422,28;527,31;14,36;312,42;255,47;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    162 => ['idPokemon' => 162, 'name' => 'Furret', 'minLevel' => 15, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '189,1;102,1;406,1;451,1;199,13;241,17;187,21;481,28;422,32;527,36;14,42;312,50;255,56;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    163 => ['idPokemon' => 163, 'name' => 'Hoothoot', 'minLevel' => 1, 'lvlEvolution' => 164, 'type1' => 1, 'type2' => 6,'attacks' => '541,1;215,1;189,1;258,5;367,9;575,13;418,17;81,21;137,25;546,29;12,33;608,37;539,41;153,45;399,49;440,53;130,57;546,29;541,1;541,1;541,1;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    164 => ['idPokemon' => 164, 'name' => 'Noctowl', 'minLevel' => 20, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 6,'attacks' => '258,1;215,1;541,1;130,1;477,1;189,1;367,9;575,13;418,17;81,22;137,27;546,32;12,37;608,42;539,47;153,52;399,57;440,62;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    165 => ['idPokemon' => 165, 'name' => 'Ledyba', 'minLevel' => 1, 'lvlEvolution' => 166, 'type1' => 16, 'type2' => 6,'attacks' => '541,1;531,6;78,9;418,14;294,14;302,17;471,25;10,30;536,33;282,38;60,41;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    166 => ['idPokemon' => 166, 'name' => 'Ledian', 'minLevel' => 18, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 6,'attacks' => '78,1;531,1;541,1;418,14;294,14;302,17;471,29;10,36;536,41;282,48;60,53;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    167 => ['idPokemon' => 167, 'name' => 'Spinarak', 'minLevel' => 1, 'lvlEvolution' => 168, 'type1' => 16, 'type2' => 8,'attacks' => '380,1;521,1;450,5;82,8;289,12;350,15;464,19;199,22;527,26;501,29;10,33;372,36;396,40;378,43;94,47;515,50;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    168 => ['idPokemon' => 168, 'name' => 'Ariados', 'minLevel' => 22, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 8,'attacks' => '59,1;450,1;82,1;521,1;164,1;380,1;577,1;289,12;350,15;464,19;199,23;527,28;501,32;10,37;372,41;396,46;378,50;94,55;515,58;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    169 => ['idPokemon' => 169, 'name' => 'Crobat', 'minLevel' => 23, 'lvlEvolution' => 0, 'type1' => 8, 'type2' => 6,'attacks' => '41,1;94,1;24,1;531,1;452,1;289,1;596,13;80,17;11,19;536,24;376,27;5,35;227,40;578,43;12,48;407,51;', 'requirements' => 998, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    170 => ['idPokemon' => 170, 'name' => 'Chinchou', 'minLevel' => 1, 'lvlEvolution' => 171, 'type1' => 3, 'type2' => 5,'attacks' => '57,1;531,1;558,6;142,9;584,12;80,17;58,20;500,23;470,28;172,31;110,34;546,39;17,42;252,45;272,47;68,50;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    171 => ['idPokemon' => 171, 'name' => 'Lanturn', 'minLevel' => 27, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 5,'attacks' => '138,1;142,1;531,1;558,1;57,1;584,12;80,17;58,20;500,23;516,27;533,27;505,27;470,29;172,33;110,37;546,43;17,47;252,51;272,54;68,58;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    172 => ['idPokemon' => 172, 'name' => 'Pichu', 'minLevel' => 1, 'lvlEvolution' => 25, 'type1' => 5, 'type2' => 0,'attacks' => '557,1;70,1;544,5;534,10;345,13;558,18;558,18;', 'requirements' => 998, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    173 => ['idPokemon' => 173, 'name' => 'Cleffa', 'minLevel' => 1, 'lvlEvolution' => 35, 'type1' => 18, 'type2' => 0,'attacks' => '70,1;382,1;146,4;473,7;534,10;85,13;305,16;', 'requirements' => 998, 'difficulty' => 10, 'genderFemale' => 750, 'genderMale' => 250],
    174 => ['idPokemon' => 174, 'name' => 'Igglybuff', 'minLevel' => 39, 'lvlEvolution' => 39, 'type1' => 1, 'type2' => 18,'attacks' => '473,1;70,1;102,3;382,5;534,9;85,11;85,11;', 'requirements' => 998, 'difficulty' => 10, 'genderFemale' => 250, 'genderMale' => 750],
    175 => ['idPokemon' => 175, 'name' => 'Togepi', 'minLevel' => 1, 'lvlEvolution' => 176, 'type1' => 18, 'type2' => 0,'attacks' => '215,1;70,1;324,5;534,9;606,13;146,17;187,21;38,25;597,29;15,33;282,45;284,49;9,53;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    176 => ['idPokemon' => 176, 'name' => 'Togetic', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 18, 'type2' => 6,'attacks' => '305,1;324,1;534,1;70,1;215,1;606,13;157,14;146,17;187,21;38,25;597,29;15,33;282,45;284,49;9,53;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    177 => ['idPokemon' => 177, 'name' => 'Natu', 'minLevel' => 1, 'lvlEvolution' => 178, 'type1' => 7, 'type2' => 6,'attacks' => '367,1;291,1;350,6;551,9;299,12;519,17;358,20;80,23;597,28;396,33;329,36;399,39;202,44;219,47;387,47;312,50;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    178 => ['idPokemon' => 178, 'name' => 'Xatu', 'minLevel' => 25, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 6,'attacks' => '291,1;350,1;545,1;367,1;551,1;299,12;519,17;358,20;80,23;12,25;597,29;396,35;329,39;399,43;202,49;219,53;387,53;312,57;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    179 => ['idPokemon' => 179, 'name' => 'Mareep', 'minLevel' => 1, 'lvlEvolution' => 180, 'type1' => 5, 'type2' => 0,'attacks' => '541,1;215,1;558,4;557,8;88,11;68,15;546,18;142,22;80,25;385,29;110,32;87,36;470,39;294,43;554,46;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    180 => ['idPokemon' => 180, 'name' => 'Flaaffy', 'minLevel' => 15, 'lvlEvolution' => 181, 'type1' => 5, 'type2' => 0,'attacks' => '541,1;215,1;558,1;557,1;88,11;68,16;546,20;142,25;80,29;385,34;110,38;87,43;470,47;294,52;554,56;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    181 => ['idPokemon' => 181, 'name' => 'Ampharos', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 0,'attacks' => '124,1;607,1;272,1;309,1;541,1;215,1;169,1;558,1;557,1;88,11;68,16;546,20;142,25;80,29;556,30;385,35;110,40;87,46;470,51;294,57;554,62;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    182 => ['idPokemon' => 182, 'name' => 'Bellossom', 'minLevel' => 22, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 0,'attacks' => '287,1;535,1;315,1;528,1;524,1;286,1;305,24;369,49;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    183 => ['idPokemon' => 183, 'name' => 'Marill', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 18,'attacks' => '541,1;584,1;544,2;587,5;57,7;102,10;439,10;58,13;241,16;18,20;374,23;17,28;411,31;282,37;530,40;252,47;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    184 => ['idPokemon' => 184, 'name' => 'Azumarill', 'minLevel' => 18, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 18,'attacks' => '541,1;584,1;587,1;544,1;57,7;102,10;439,10;58,13;241,16;18,21;374,25;17,31;411,35;282,42;530,46;252,55;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    185 => ['idPokemon' => 185, 'name' => 'Sudowoodo', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 0,'attacks' => '600,1;85,1;172,1;297,1;434,1;326,15;481,15;163,19;435,22;45,26;432,29;89,33;527,36;282,40;518,43;225,47;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    186 => ['idPokemon' => 186, 'name' => 'Politoed', 'minLevel' => 26, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '58,1;368,1;258,1;116,1;532,27;53,37;255,48;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    187 => ['idPokemon' => 187, 'name' => 'Hoppip', 'minLevel' => 1, 'lvlEvolution' => 188, 'type1' => 4, 'type2' => 6,'attacks' => '507,1;540,4;544,6;541,8;157,10;379,12;524,14;483,16;64,19;290,22;315,25;5,28;410,31;88,34;574,37;602,40;206,43;53,46;319,49;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    188 => ['idPokemon' => 188, 'name' => 'Skiploom', 'minLevel' => 18, 'lvlEvolution' => 189, 'type1' => 4, 'type2' => 6,'attacks' => '507,1;540,1;544,1;541,1;157,10;379,12;524,14;483,16;64,20;290,24;315,28;5,32;410,36;88,40;574,44;602,48;206,52;53,56;319,60;206,43;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    189 => ['idPokemon' => 189, 'name' => 'Jumpluff', 'minLevel' => 27, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 6,'attacks' => '540,1;507,1;544,1;541,1;157,10;379,12;524,14;483,16;64,20;290,24;315,29;5,34;410,39;88,44;574,49;602,54;206,59;53,64;319,69;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    190 => ['idPokemon' => 190, 'name' => 'Aipom', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '544,1;451,1;446,4;24,8;560,15;199,18;536,22;452,25;10,29;114,32;181,36;345,39;284,43;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    191 => ['idPokemon' => 191, 'name' => 'Sunkern', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 0,'attacks' => '1,1;216,1;271,4;212,7;315,10;290,13;413,16;602,19;206,22;147,25;540,28;346,31;497,34;282,37;528,40;456,43;', 'requirements' => 6, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    192 => ['idPokemon' => 192, 'name' => 'Sunflora', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 4, 'type2' => 0,'attacks' => '1,1;382,1;216,1;271,4;212,7;315,10;290,13;413,16;602,19;206,22;370,28;346,31;497,34;282,37;528,40;287,43;369,50;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    193 => ['idPokemon' => 193, 'name' => 'Yanma', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 6,'attacks' => '541,1;189,1;406,6;117,11;498,14;105,17;531,22;575,27;404,30;15,33;258,38;596,43;452,46;574,49;12,54;60,57;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    194 => ['idPokemon' => 194, 'name' => 'Wooper', 'minLevel' => 1, 'lvlEvolution' => 195, 'type1' => 3, 'type2' => 12,'attacks' => '584,1;544,1;341,5;340,9;481,15;339,19;14,23;606,29;136,33;411,37;333,43;227,43;343,47;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    195 => ['idPokemon' => 195, 'name' => 'Quagsire', 'minLevel' => 20, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 12,'attacks' => '341,1;584,1;544,1;340,9;481,15;339,19;14,24;606,31;136,36;411,41;333,48;227,48;343,53;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    196 => ['idPokemon' => 196, 'name' => 'Espeon', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '241,1;544,1;541,1;446,5;81,9;406,13;536,17;394,20;202,25;395,29;338,33;396,37;284,41;387,45;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    197 => ['idPokemon' => 197, 'name' => 'Umbreon', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 15, 'type2' => 0,'attacks' => '241,1;541,1;544,1;446,5;404,9;406,13;80,17;163,20;23,25;452,29;337,33;284,41;219,45;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 125, 'genderMale' => 875],
    198 => ['idPokemon' => 198, 'name' => 'Murkrow', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 15, 'type2' => 6,'attacks' => '367,1;24,1;404,5;227,11;596,15;350,21;23,25;547,31;163,35;191,45;545,50;527,55;562,61;405,65;405,65;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    199 => ['idPokemon' => 199, 'name' => 'Slowking', 'minLevel' => 37, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 7,'attacks' => '98,1;234,1;541,1;606,1;385,1;243,1;215,5;584,9;81,14;108,19;230,23;585,28;608,32;345,36;532,41;396,45;571,49;395,54;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    200 => ['idPokemon' => 200, 'name' => 'Misdreavus', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 9, 'type2' => 0,'attacks' => '215,1;402,1;506,5;24,10;80,14;242,22;394,28;362,32;366,37;460,41;368,46;217,50;385,55;385,55;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    201 => ['idPokemon' => 201, 'name' => 'Unown', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '243,1;243,1;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 0, 'genderMale' => 0],
    202 => ['idPokemon' => 202, 'name' => 'Wobbuffet', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 0,'attacks' => '89,1;330,1;104,1;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    203 => ['idPokemon' => 203, 'name' => 'Girafarig', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 7,'attacks' => '24,1;215,1;541,1;81,1;387,1;219,1;357,5;23,10;517,14;394,19;10,23;114,28;608,32;95,37;345,46;396,50;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    204 => ['idPokemon' => 204, 'name' => 'Pineco', 'minLevel' => 1, 'lvlEvolution' => 205, 'type1' => 16, 'type2' => 0,'attacks' => '541,1;393,1;459,6;59,9;546,12;412,17;39,20;346,23;503,28;366,31;152,34;273,39;223,42;282,45;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    205 => ['idPokemon' => 205, 'name' => 'Forretress', 'minLevel' => 31, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 11,'attacks' => '607,1;308,1;564,1;59,1;459,1;240,1;541,1;393,1;546,12;412,17;39,20;346,23;503,28;332,31;29,32;366,36;152,42;273,46;223,50;282,56;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    206 => ['idPokemon' => 206, 'name' => 'Dunsparce', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '609,1;102,1;439,4;506,7;404,10;452,13;606,16;15,19;546,22;440,25;209,28;107,31;282,34;77,37;148,40;132,43;147,46;172,49;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    207 => ['idPokemon' => 207, 'name' => 'Gligar', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 12, 'type2' => 6,'attacks' => '380,1;446,4;226,7;281,10;406,13;198,16;163,19;5,22;482,27;574,30;452,35;605,40;479,45;538,50;220,55;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    208 => ['idPokemon' => 208, 'name' => 'Steelix', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 11, 'type2' => 12,'attacks' => '555,1;262,1;168,1;341,1;541,1;226,1;40,1;98,4;434,7;435,10;609,13;511,16;29,19;223,20;488,22;121,25;481,28;452,31;432,34;95,37;275,40;107,43;518,46;282,49;448,52;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    209 => ['idPokemon' => 209, 'name' => 'Snubbull', 'minLevel' => 1, 'lvlEvolution' => 210, 'type1' => 18, 'type2' => 0,'attacks' => '262,1;168,1;555,1;541,1;450,1;544,1;70,1;41,7;292,13;230,19;609,31;374,37;366,43;95,49;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 750, 'genderMale' => 250],
    210 => ['idPokemon' => 210, 'name' => 'Granbull', 'minLevel' => 23, 'lvlEvolution' => 0, 'type1' => 18, 'type2' => 0,'attacks' => '360,1;262,1;168,1;555,1;541,1;450,1;544,1;70,1;41,7;292,13;230,19;609,35;374,43;366,51;95,59;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 750, 'genderMale' => 250],
    211 => ['idPokemon' => 211, 'name' => 'Qwilfish', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 8,'attacks' => '164,1;252,1;104,1;584,1;503,1;541,1;380,1;226,9;328,9;57,13;439,17;564,21;516,25;505,25;425,29;56,33;372,37;546,41;18,45;378,49;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    212 => ['idPokemon' => 212, 'name' => 'Scizor', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 11,'attacks' => '162,1;63,1;406,1;291,1;185,5;404,9;160,13;10,17;321,21;198,25;482,29;415,33;273,37;605,41;351,45;114,49;274,50;538,57;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    213 => ['idPokemon' => 213, 'name' => 'Shuckle', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 13,'attacks' => '515,1;598,1;82,1;39,1;439,1;146,5;603,9;523,12;422,20;434,23;203,27;388,31;467,34;432,38;59,42;386,45;218,45;518,49;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    214 => ['idPokemon' => 214, 'name' => 'Heracross', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 16, 'type2' => 10,'attacks' => '19,1;64,1;351,1;541,1;291,1;246,1;148,1;162, 7;7,10;72,16;89,19;197,25;55,28;372,31;546,34;318,37;76,43;426,46;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    215 => ['idPokemon' => 215, 'name' => 'Sneasel', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 15, 'type2' => 14,'attacks' => '451,1;291,1;547,1;406,8;163,10;267,14;199,16;10,20;321,22;245,25;35,28;452,32;482,35;493,40;403,44;264,47;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    216 => ['idPokemon' => 216, 'name' => 'Teddiursa', 'minLevel' => 1, 'lvlEvolution' => 217, 'type1' => 1, 'type2' => 0,'attacks' => '181,1;90,1;451,1;31,1;292,1;159,1;199,8;163,15;535,22;373,25;482,29;70,36;422,43;494,43;553,50;', 'requirements' => 0, 'difficulty' => 2, 'genderFemale' => 500, 'genderMale' => 500],
    217 => ['idPokemon' => 217, 'name' => 'Ursaring', 'minLevel' => 30, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '225,1;90,1;451,1;291,1;292,1;159,1;199,8;163,15;535,22;373,25;482,29;450,38;422,47;494,49;553,58;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    218 => ['idPokemon' => 218, 'name' => 'Slugma', 'minLevel' => 1, 'lvlEvolution' => 219, 'type1' => 2, 'type2' => 0,'attacks' => '606,1;490,1;145,6;434,8;226,13;269,15;75,20;15,22;173,27;432,29;285,34;14,36;47,41;416,43;176,48;135,50;', 'requirements' => 0, 'difficulty' => 1, 'genderFemale' => 500, 'genderMale' => 500],
    219 => ['idPokemon' => 219, 'name' => 'Magcargo', 'minLevel' => 38, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 13,'attacks' => '135,1;606,1;490,1;145,1;434,1;226,13;269,15;75,20;15,22;173,27;432,29;285,34;14,36;467,38;47,43;416,47;176,54;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    220 => ['idPokemon' => 220, 'name' => 'Swinub', 'minLevel' => 1, 'lvlEvolution' => 221, 'type1' => 14, 'type2' => 12,'attacks' => '541,1;357,1;341,5;384,8;342,11;148,14;339,18;267,21;264,24;546,28;333,35;136,37;172,40;44,44;14,48;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 500, 'genderMale' => 500],
    221 => ['idPokemon' => 221, 'name' => 'Piloswine', 'minLevel' => 33, 'lvlEvolution' => 0, 'type1' => 14, 'type2' => 12,'attacks' => '15,1;367,1;357,1;341,1;384,1;342,11;148,14;339,18;267,21;262,24;546,28;197,33;333,37;553,41;136,46;44,52;14,58;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    222 => ['idPokemon' => 222, 'name' => 'Corsola', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 13,'attacks' => '541,1;226,1;57,4;416,8;58,10;420,13;15,17;502,20;299,23;56,27;273,29;429,31;148,35;17,38;385,41;330,45;135,47;172,50;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 750, 'genderMale' => 250],
    223 => ['idPokemon' => 223, 'name' => 'Remoraid', 'minLevel' => 1, 'lvlEvolution' => 224, 'type1' => 3, 'type2' => 0,'attacks' => '584,1;295,6;394,10;28,14;58,18;185,22;585,26;470,30;260,34;64,38;252,42;253,46;495,50;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    224 => ['idPokemon' => 224, 'name' => 'Octillery', 'minLevel' => 25, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '221,1;429,1;584,1;82,1;394,1;28,1;58,18;185,22;356,25;604,28;470,34;260,40;64,46;252,52;253,58;495,64;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    225 => ['idPokemon' => 225, 'name' => 'Delibird', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 14, 'type2' => 6,'attacks' => '392,1;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    226 => ['idPokemon' => 226, 'name' => 'Mantine', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 6,'attacks' => '394,1;64,1;470,1;541,1;57,1;531,1;58,1;80,11;596,14;230,16;585,19;593,23;546,27;10,32;12,36;17,39;53,46;252,49;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    227 => ['idPokemon' => 227, 'name' => 'Skarmory', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 11, 'type2' => 6,'attacks' => '291,1;367,1;446,6;321,9;11,12;197,17;162, 20;536,23;503,28;10,31;514,34;482,39;322,42;12,45;29,50;351,53;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    228 => ['idPokemon' => 228, 'name' => 'Houndour', 'minLevel' => 1, 'lvlEvolution' => 229, 'type1' => 15, 'type2' => 2,'attacks' => '291,1;145,1;249,4;490,8;41,16;357,20;35,25;168,28;163,32;144,37;191,40;176,44;95,49;345,52;270,56;', 'requirements' => 0, 'difficulty' => 3, 'genderFemale' => 500, 'genderMale' => 500],
    229 => ['idPokemon' => 229, 'name' => 'Houndoom', 'minLevel' => 24, 'lvlEvolution' => 0, 'type1' => 15, 'type2' => 2,'attacks' => '270,1;345,1;555,1;291,1;145,1;249,1;490,1;41,16;357,20;35,26;168,30;163,35;144,41;191,45;176,50;95,56;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    230 => ['idPokemon' => 230, 'name' => 'Kingdra', 'minLevel' => 33, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 17,'attacks' => '252,1;606,1;584,1;491,1;291,1;57,1;573,17;58,21;185,26;56,31;10,38;124,45;123,52;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    231 => ['idPokemon' => 231, 'name' => 'Phanpy', 'minLevel' => 1, 'lvlEvolution' => 232, 'type1' => 12, 'type2' => 0,'attacks' => '357,1;541,1;215,1;102,1;172,6;439,10;346,15;148,19;481,24;546,28;70,33;284,37;282,42;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    232 => ['idPokemon' => 232, 'name' => 'Donphan', 'minLevel' => 25, 'lvlEvolution' => 0, 'type1' => 12, 'type2' => 0,'attacks' => '168,1;555,1;246,1;215,1;102,1;62,1;412,6;439,10;23,15;281,19;481,24;197,25;310,30;450,37;136,43;207,50;', 'requirements' => 0, 'difficulty' => 6, 'genderFemale' => 500, 'genderMale' => 500],
    233 => ['idPokemon' => 233, 'name' => 'Porygon2', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '607,1;303,1;84,1;541,1;83,1;102,1;394,7;10,12;416,18;308,23;470,29;417,34;110,40;295,45;566,50;253,67;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    234 => ['idPokemon' => 234, 'name' => 'Stantler', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '312,1;541,1;291,3;24,7;258,10;517,13;446,16;546,21;80,23;65,27;437,33;608,38;277,43;268,49;67,50;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 500, 'genderMale' => 500],
    235 => ['idPokemon' => 235, 'name' => 'Smeargle', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '474,1;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    236 => ['idPokemon' => 236, 'name' => 'Tyrogue', 'minLevel' => 1, 'lvlEvolution' => 237, 'type1' => 10, 'type2' => 0,'attacks' => '541,1;241,1;158,1;189,1;', 'requirements' => 99, 'difficulty' => 4, 'genderFemale' => 0, 'genderMale' => 1000],
    237 => ['idPokemon' => 237, 'name' => 'Hitmontop', 'minLevel' => 20, 'lvlEvolution' => 0, 'type1' => 10, 'type2' => 0,'attacks' => '147,1;76,1;425,1;438,1;185,6;404,10;406,15;570,19;412,24;89,28;162,33;10,37;223,42;593,46;407,46;105,50;', 'requirements' => 0, 'difficulty' => 4, 'genderFemale' => 0, 'genderMale' => 1000],
    238 => ['idPokemon' => 238, 'name' => 'Smoochum', 'minLevel' => 1, 'lvlEvolution' => 124, 'type1' => 14, 'type2' => 7,'attacks' => '382,1;292,5;534,8;384,11;81,15;473,18;236,21;159,28;299,31;30,35;396,38;85,41;368,45;44,48;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 1000, 'genderMale' => 0],
    239 => ['idPokemon' => 239, 'name' => 'Elekid', 'minLevel' => 1, 'lvlEvolution' => 125, 'type1' => 5, 'type2' => 0,'attacks' => '406,1;291,1;557,5;297,8;536,12;469,15;558,19;142,22;294,26;556,29;110,33;452,36;559,40;554,43;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 250, 'genderMale' => 750],
    240 => ['idPokemon' => 240, 'name' => 'Magby', 'minLevel' => 1, 'lvlEvolution' => 126, 'type1' => 2, 'type2' => 0,'attacks' => '490,1;291,1;145,5;491,8;163,12;170,15;75,19;173,22;80,26;169,29;285,33;528,36;176,40;167,43;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 250, 'genderMale' => 750],
    241 => ['idPokemon' => 241, 'name' => 'Miltank', 'minLevel' => 1, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '541,1;215,3;102,5;517,8;325,11;39,15;439,19;47,24;608,29;67,35;223,41;231, 48;583,50;', 'requirements' => 0, 'difficulty' => 5, 'genderFemale' => 1000, 'genderMale' => 0],
    242 => ['idPokemon' => 242, 'name' => 'Blissey', 'minLevel' => 2, 'lvlEvolution' => 0, 'type1' => 1, 'type2' => 0,'attacks' => '282,1;102,1;382,1;215,1;544,5;420,9;116,12;496,16;38,20;328,23;546,27;473,31;181,34;234,38;139,42;294,46;235,50;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 1000, 'genderMale' => 0],
    243 => ['idPokemon' => 243, 'name' => 'Raikou', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 5, 'type2' => 0,'attacks' => '153,1;110,1;41,1;291,1;557,8;406,22;500,29;95,43;555,50;411,71;65,78;554,85;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    244 => ['idPokemon' => 244, 'name' => 'Entei', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 0,'attacks' => '443,1;151,1;153,1;285,1;41,1;291,1;145,8;170,22;517,29;176,36;532,43;168,50;167,71;65,78;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    245 => ['idPokemon' => 245, 'name' => 'Suicune', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 3, 'type2' => 0,'attacks' => '252,1;153,1;545,1;41,1;291,1;58,8;411,15;222,22;28,29;333,36;330,43;262,50;65,78;44,85;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    246 => ['idPokemon' => 246, 'name' => 'Larvitar', 'minLevel' => 1, 'lvlEvolution' => 247, 'type1' => 13, 'type2' => 12,'attacks' => '41,1;291,1;448,5;452,10;72,14;432,19;450,23;553,28;99,32;366,37;95,41;136,46;518,50;253,55;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    247 => ['idPokemon' => 247, 'name' => 'Pupitar', 'minLevel' => 30, 'lvlEvolution' => 248, 'type1' => 13, 'type2' => 12,'attacks' => '41,1;291,1;448,1;452,1;72,14;432,19;450,23;553,28;99,34;366,41;95,47;136,54;518,60;253,67;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    248 => ['idPokemon' => 248, 'name' => 'Tyranitar', 'minLevel' => 55, 'lvlEvolution' => 0, 'type1' => 13, 'type2' => 15,'attacks' => '555,1;262,1;168,1;41,1;291,1;448,1;452,1;72,14;432,19;450,23;553,28;99,34;366,41;95,47;136,54;518,63;253,73;207,82;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 500, 'genderMale' => 500],
    249 => ['idPokemon' => 249, 'name' => 'Lugia', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 6,'attacks' => '592,1;590,1;222,9;126,15;153,23;411,29;252,37;8,43;403,50;15,57;416,71;202,79;346,85;65,93;477,99;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    250 => ['idPokemon' => 250, 'name' => 'Ho-Oh', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 2, 'type2' => 6,'attacks' => '592,1;222,9;54,15;153,23;528,29;167,37;443,43;403,50;15,57;416,71;202,79;346,85;65,93;477,99;590,1;590,1;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
    251 => ['idPokemon' => 251, 'name' => 'Celebi', 'minLevel' => 100, 'lvlEvolution' => 0, 'type1' => 7, 'type2' => 4,'attacks' => '290,1;81,1;416,1;231,1;305,19;15,28;346,46;232,55;202,64;235,73;287,82;368,91;', 'requirements' => 0, 'difficulty' => 10, 'genderFemale' => 0, 'genderMale' => 0],
        ];

    private static $increase = [
    1 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 20],
    2 => ['minLevel' => 16, 'previous' => 1, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 5, 'hp' => 25],
    3 => ['minLevel' => 32, 'previous' => 2, 'attack' => 6, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 6, 'hp' => 30],
    4 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    5 => ['minLevel' => 16, 'previous' => 4, 'attack' => 5, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    6 => ['minLevel' => 36, 'previous' => 5, 'attack' => 6, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 7, 'hp' => 30],
    7 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 4, 'hp' => 20],
    8 => ['minLevel' => 16, 'previous' => 7, 'attack' => 5, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 4, 'hp' => 25],
    9 => ['minLevel' => 36, 'previous' => 8, 'attack' => 6, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 5, 'hp' => 30],
    10 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    11 => ['minLevel' => 7, 'previous' => 10, 'attack' => 3, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 20],
    12 => ['minLevel' => 10, 'previous' => 11, 'attack' => 4, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 5, 'hp' => 25],
    13 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    14 => ['minLevel' => 7, 'previous' => 13, 'attack' => 3, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 20],
    15 => ['minLevel' => 10, 'previous' => 14, 'attack' => 6, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 5, 'hp' => 25],
    16 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    17 => ['minLevel' => 18, 'previous' => 16, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    18 => ['minLevel' => 36, 'previous' => 17, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 6, 'hp' => 30],
    19 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 5, 'hp' => 20],
    20 => ['minLevel' => 20, 'previous' => 19, 'attack' => 6, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    21 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 5, 'hp' => 20],
    22 => ['minLevel' => 20, 'previous' => 21, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 7, 'hp' => 25],
    23 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    24 => ['minLevel' => 22, 'previous' => 23, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    25 => ['minLevel' => 2, 'previous' => 172, 'attack' => 4, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    26 => ['minLevel' => 3, 'previous' => 25, 'attack' => 6, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    27 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 6, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    28 => ['minLevel' => 22, 'previous' => 27, 'attack' => 7, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    29 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    30 => ['minLevel' => 16, 'previous' => 29, 'attack' => 5, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    31 => ['minLevel' => 17, 'previous' => 30, 'attack' => 6, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    32 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    33 => ['minLevel' => 16, 'previous' => 32, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    34 => ['minLevel' => 17, 'previous' => 33, 'attack' => 6, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 30],
    35 => ['minLevel' => 2, 'previous' => 173, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 3, 'hp' => 25],
    36 => ['minLevel' => 3, 'previous' => 35, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    37 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 5, 'hp' => 20],
    38 => ['minLevel' => 2, 'previous' => 37, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 7, 'hp' => 25],
    39 => ['minLevel' => 2, 'previous' => 174, 'attack' => 4, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 3, 'speed' => 3, 'hp' => 35],
    40 => ['minLevel' => 3, 'previous' => 39, 'attack' => 5, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 4, 'hp' => 40],
    41 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    42 => ['minLevel' => 22, 'previous' => 41, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    43 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 3, 'hp' => 20],
    44 => ['minLevel' => 21, 'previous' => 43, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    45 => ['minLevel' => 22, 'previous' => 44, 'attack' => 6, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 4, 'hp' => 25],
    46 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    47 => ['minLevel' => 24, 'previous' => 46, 'attack' => 6, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 3, 'hp' => 25],
    48 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    49 => ['minLevel' => 31, 'previous' => 48, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    50 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 6, 'hp' => 15],
    51 => ['minLevel' => 26, 'previous' => 50, 'attack' => 6, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 8, 'hp' => 20],
    52 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    53 => ['minLevel' => 28, 'previous' => 52, 'attack' => 5, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 7, 'hp' => 25],
    54 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    55 => ['minLevel' => 33, 'previous' => 54, 'attack' => 6, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 6, 'hp' => 30],
    56 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    57 => ['minLevel' => 28, 'previous' => 56, 'attack' => 7, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    58 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    59 => ['minLevel' => 2, 'previous' => 58, 'attack' => 7, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 6, 'hp' => 30],
    60 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    61 => ['minLevel' => 25, 'previous' => 60, 'attack' => 5, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 25],
    62 => ['minLevel' => 26, 'previous' => 61, 'attack' => 6, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    63 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 2, 'spAttack' => 7, 'spDefence' => 4, 'speed' => 6, 'hp' => 15],
    64 => ['minLevel' => 16, 'previous' => 63, 'attack' => 3, 'defence' => 3, 'spAttack' => 8, 'spDefence' => 5, 'speed' => 7, 'hp' => 20],
    65 => ['minLevel' => 17, 'previous' => 64, 'attack' => 4, 'defence' => 4, 'spAttack' => 8, 'spDefence' => 6, 'speed' => 8, 'hp' => 25],
    66 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 25],
    67 => ['minLevel' => 28, 'previous' => 66, 'attack' => 7, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    68 => ['minLevel' => 29, 'previous' => 67, 'attack' => 8, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 4, 'hp' => 30],
    69 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 3, 'spAttack' => 5, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    70 => ['minLevel' => 21, 'previous' => 69, 'attack' => 6, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    71 => ['minLevel' => 22, 'previous' => 70, 'attack' => 7, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 5, 'speed' => 5, 'hp' => 30],
    72 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 7, 'speed' => 5, 'hp' => 20],
    73 => ['minLevel' => 30, 'previous' => 72, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 8, 'speed' => 7, 'hp' => 30],
    74 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 7, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 20],
    75 => ['minLevel' => 25, 'previous' => 74, 'attack' => 6, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 3, 'hp' => 25],
    76 => ['minLevel' => 26, 'previous' => 75, 'attack' => 7, 'defence' => 8, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    77 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 6, 'hp' => 20],
    78 => ['minLevel' => 40, 'previous' => 77, 'attack' => 7, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    79 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 2, 'hp' => 30],
    80 => ['minLevel' => 37, 'previous' => 79, 'attack' => 5, 'defence' => 7, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 3, 'hp' => 30],
    81 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 4, 'hp' => 15],
    82 => ['minLevel' => 30, 'previous' => 81, 'attack' => 5, 'defence' => 6, 'spAttack' => 8, 'spDefence' => 5, 'speed' => 5, 'hp' => 20],
    83 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 5, 'hp' => 25],
    84 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 5, 'hp' => 20],
    85 => ['minLevel' => 31, 'previous' => 84, 'attack' => 7, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 7, 'hp' => 25],
    86 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    87 => ['minLevel' => 34, 'previous' => 86, 'attack' => 5, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    88 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 3, 'hp' => 30],
    89 => ['minLevel' => 38, 'previous' => 88, 'attack' => 7, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 7, 'speed' => 4, 'hp' => 35],
    90 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    91 => ['minLevel' => 2, 'previous' => 90, 'attack' => 6, 'defence' => 10, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    92 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 7, 'spDefence' => 3, 'speed' => 6, 'hp' => 20],
    93 => ['minLevel' => 25, 'previous' => 92, 'attack' => 4, 'defence' => 4, 'spAttack' => 7, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    94 => ['minLevel' => 26, 'previous' => 93, 'attack' => 5, 'defence' => 5, 'spAttack' => 8, 'spDefence' => 5, 'speed' => 7, 'hp' => 25],
    95 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 10, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    96 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 4, 'hp' => 25],
    97 => ['minLevel' => 26, 'previous' => 96, 'attack' => 5, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 7, 'speed' => 5, 'hp' => 30],
    98 => ['minLevel' => 1, 'previous' => 0, 'attack' => 7, 'defence' => 6, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    99 => ['minLevel' => 28, 'previous' => 98, 'attack' => 8, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    100 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 7, 'hp' => 20],
    101 => ['minLevel' => 30, 'previous' => 100, 'attack' => 4, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 9, 'hp' => 25],
    102 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    103 => ['minLevel' => 2, 'previous' => 102, 'attack' => 6, 'defence' => 6, 'spAttack' => 8, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    104 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 6, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    105 => ['minLevel' => 28, 'previous' => 104, 'attack' => 6, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 4, 'hp' => 25],
    106 => ['minLevel' => 2, 'previous' => 236, 'attack' => 8, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 7, 'speed' => 6, 'hp' => 20],
    107 => ['minLevel' => 2, 'previous' => 236, 'attack' => 7, 'defence' => 5, 'spAttack' => 3, 'spDefence' => 7, 'speed' => 5, 'hp' => 20],
    108 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 3, 'hp' => 30],
    109 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    110 => ['minLevel' => 35, 'previous' => 109, 'attack' => 6, 'defence' => 8, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 5, 'hp' => 25],
    111 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 6, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 30],
    112 => ['minLevel' => 42, 'previous' => 111, 'attack' => 8, 'defence' => 8, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 35],
    113 => ['minLevel' => 1, 'previous' => 0, 'attack' => 2, 'defence' => 2, 'spAttack' => 3, 'spDefence' => 7, 'speed' => 4, 'hp' => 50],
    114 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 7, 'spAttack' => 7, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    115 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 6, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 6, 'hp' => 35],
    116 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 3, 'speed' => 5, 'hp' => 20],
    117 => ['minLevel' => 32, 'previous' => 116, 'attack' => 5, 'defence' => 6, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 6, 'hp' => 25],
    118 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    119 => ['minLevel' => 33, 'previous' => 118, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    120 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    121 => ['minLevel' => 2, 'previous' => 120, 'attack' => 5, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    122 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 8, 'speed' => 6, 'hp' => 20],
    123 => ['minLevel' => 1, 'previous' => 0, 'attack' => 7, 'defence' => 6, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    124 => ['minLevel' => 30, 'previous' => 238, 'attack' => 4, 'defence' => 3, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 6, 'hp' => 25],
    125 => ['minLevel' => 30, 'previous' => 239, 'attack' => 6, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    126 => ['minLevel' => 30, 'previous' => 240, 'attack' => 6, 'defence' => 4, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 6, 'hp' => 25],
    127 => ['minLevel' => 1, 'previous' => 0, 'attack' => 8, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    128 => ['minLevel' => 1, 'previous' => 0, 'attack' => 7, 'defence' => 6, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 7, 'hp' => 25],
    129 => ['minLevel' => 1, 'previous' => 0, 'attack' => 2, 'defence' => 4, 'spAttack' => 2, 'spDefence' => 3, 'speed' => 6, 'hp' => 15],
    130 => ['minLevel' => 20, 'previous' => 129, 'attack' => 8, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 7, 'speed' => 6, 'hp' => 30],
    131 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 6, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 5, 'hp' => 40],
    132 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    133 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    134 => ['minLevel' => 2, 'previous' => 133, 'attack' => 5, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 5, 'hp' => 40],
    135 => ['minLevel' => 2, 'previous' => 133, 'attack' => 5, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 8, 'hp' => 25],
    136 => ['minLevel' => 2, 'previous' => 133, 'attack' => 8, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 5, 'hp' => 25],
    137 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    138 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    139 => ['minLevel' => 40, 'previous' => 138, 'attack' => 5, 'defence' => 8, 'spAttack' => 7, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    140 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 6, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    141 => ['minLevel' => 40, 'previous' => 140, 'attack' => 7, 'defence' => 7, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    142 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 8, 'hp' => 30],
    143 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 7, 'speed' => 3, 'hp' => 45],
    144 => ['minLevel' => 100, 'previous' => 0, 'attack' => 6, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 8, 'speed' => 6, 'hp' => 30],
    145 => ['minLevel' => 100, 'previous' => 0, 'attack' => 6, 'defence' => 6, 'spAttack' => 8, 'spDefence' => 6, 'speed' => 7, 'hp' => 30],
    146 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 6, 'spAttack' => 8, 'spDefence' => 6, 'speed' => 6, 'hp' => 30],
    147 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    148 => ['minLevel' => 30, 'previous' => 147, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 5, 'hp' => 25],
    149 => ['minLevel' => 55, 'previous' => 148, 'attack' => 8, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 6, 'hp' => 30],
    150 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 6, 'spAttack' => 9, 'spDefence' => 6, 'speed' => 8, 'hp' => 35],
    151 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 7, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 7, 'hp' => 30],
    152 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 4, 'hp' => 20],
    153 => ['minLevel' => 16, 'previous' => 152, 'attack' => 5, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 5, 'hp' => 25],
    154 => ['minLevel' => 32, 'previous' => 153, 'attack' => 6, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 6, 'hp' => 30],
    155 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    156 => ['minLevel' => 14, 'previous' => 155, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    157 => ['minLevel' => 36, 'previous' => 156, 'attack' => 6, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 7, 'hp' => 30],
    158 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    159 => ['minLevel' => 18, 'previous' => 158, 'attack' => 6, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    160 => ['minLevel' => 30, 'previous' => 159, 'attack' => 7, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    161 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    162 => ['minLevel' => 15, 'previous' => 161, 'attack' => 5, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 30],
    163 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    164 => ['minLevel' => 20, 'previous' => 163, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    165 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 4, 'hp' => 20],
    166 => ['minLevel' => 18, 'previous' => 165, 'attack' => 3, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 7, 'speed' => 6, 'hp' => 25],
    167 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    168 => ['minLevel' => 22, 'previous' => 167, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    169 => ['minLevel' => 23, 'previous' => 42, 'attack' => 6, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 8, 'hp' => 30],
    170 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    171 => ['minLevel' => 27, 'previous' => 170, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 5, 'hp' => 35],
    172 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 2, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 5, 'hp' => 15],
    173 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 2, 'hp' => 20],
    174 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 2, 'spAttack' => 4, 'spDefence' => 3, 'speed' => 2, 'hp' => 30],
    175 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 3, 'hp' => 20],
    176 => ['minLevel' => 2, 'previous' => 175, 'attack' => 4, 'defence' => 6, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 4, 'hp' => 25],
    177 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    178 => ['minLevel' => 25, 'previous' => 177, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    179 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 3, 'hp' => 25],
    180 => ['minLevel' => 15, 'previous' => 179, 'attack' => 4, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    181 => ['minLevel' => 30, 'previous' => 180, 'attack' => 5, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 4, 'hp' => 30],
    182 => ['minLevel' => 22, 'previous' => 44, 'attack' => 6, 'defence' => 6, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 4, 'hp' => 25],
    183 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    184 => ['minLevel' => 18, 'previous' => 183, 'attack' => 4, 'defence' => 6, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 4, 'hp' => 30],
    185 => ['minLevel' => 1, 'previous' => 0, 'attack' => 7, 'defence' => 7, 'spAttack' => 3, 'spDefence' => 5, 'speed' => 3, 'hp' => 25],
    186 => ['minLevel' => 26, 'previous' => 61, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 5, 'hp' => 30],
    187 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    188 => ['minLevel' => 18, 'previous' => 187, 'attack' => 4, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    189 => ['minLevel' => 27, 'previous' => 188, 'attack' => 4, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    190 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 25],
    191 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 20],
    192 => ['minLevel' => 2, 'previous' => 191, 'attack' => 5, 'defence' => 4, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 3, 'hp' => 25],
    193 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 6, 'hp' => 25],
    194 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 2, 'hp' => 25],
    195 => ['minLevel' => 20, 'previous' => 194, 'attack' => 6, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 3, 'hp' => 30],
    196 => ['minLevel' => 2, 'previous' => 133, 'attack' => 5, 'defence' => 5, 'spAttack' => 8, 'spDefence' => 6, 'speed' => 7, 'hp' => 25],
    197 => ['minLevel' => 2, 'previous' => 133, 'attack' => 5, 'defence' => 7, 'spAttack' => 5, 'spDefence' => 8, 'speed' => 5, 'hp' => 30],
    198 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 6, 'hp' => 25],
    199 => ['minLevel' => 2, 'previous' => 79, 'attack' => 5, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 3, 'hp' => 30],
    200 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 6, 'hp' => 25],
    201 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    202 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 5, 'spAttack' => 3, 'spDefence' => 5, 'speed' => 3, 'hp' => 50],
    203 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    204 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 6, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 2, 'hp' => 20],
    205 => ['minLevel' => 31, 'previous' => 204, 'attack' => 6, 'defence' => 9, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    206 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    207 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 7, 'spAttack' => 3, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    208 => ['minLevel' => 2, 'previous' => 95, 'attack' => 6, 'defence' => 11, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 3, 'hp' => 25],
    209 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 3, 'hp' => 25],
    210 => ['minLevel' => 23, 'previous' => 209, 'attack' => 8, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    211 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 6, 'hp' => 25],
    212 => ['minLevel' => 2, 'previous' => 123, 'attack' => 8, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 5, 'hp' => 25],
    213 => ['minLevel' => 1, 'previous' => 0, 'attack' => 2, 'defence' => 11, 'spAttack' => 2, 'spDefence' => 11, 'speed' => 2, 'hp' => 15],
    214 => ['minLevel' => 1, 'previous' => 0, 'attack' => 8, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 6, 'speed' => 6, 'hp' => 30],
    215 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 5, 'speed' => 7, 'hp' => 25],
    216 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 25],
    217 => ['minLevel' => 30, 'previous' => 216, 'attack' => 8, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    218 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 3, 'hp' => 20],
    219 => ['minLevel' => 38, 'previous' => 218, 'attack' => 4, 'defence' => 8, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 3, 'hp' => 20],
    220 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 4, 'hp' => 20],
    221 => ['minLevel' => 33, 'previous' => 220, 'attack' => 7, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    222 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 6, 'spAttack' => 5, 'spDefence' => 6, 'speed' => 3, 'hp' => 25],
    223 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 3, 'spAttack' => 5, 'spDefence' => 3, 'speed' => 5, 'hp' => 20],
    224 => ['minLevel' => 25, 'previous' => 223, 'attack' => 7, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 5, 'speed' => 3, 'hp' => 25],
    225 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 4, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    226 => ['minLevel' => 1, 'previous' => 0, 'attack' => 4, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 9, 'speed' => 5, 'hp' => 25],
    227 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 9, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 5, 'hp' => 25],
    228 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 3, 'spAttack' => 6, 'spDefence' => 4, 'speed' => 5, 'hp' => 20],
    229 => ['minLevel' => 24, 'previous' => 228, 'attack' => 6, 'defence' => 4, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 6, 'hp' => 25],
    230 => ['minLevel' => 33, 'previous' => 117, 'attack' => 6, 'defence' => 6, 'spAttack' => 6, 'spDefence' => 6, 'speed' => 6, 'hp' => 25],
    231 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 5, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 30],
    232 => ['minLevel' => 25, 'previous' => 231, 'attack' => 8, 'defence' => 8, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 30],
    233 => ['minLevel' => 2, 'previous' => 137, 'attack' => 6, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 6, 'speed' => 5, 'hp' => 30],
    234 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 5, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 6, 'hp' => 25],
    235 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 4, 'speed' => 5, 'hp' => 25],
    236 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 3, 'spAttack' => 3, 'spDefence' => 3, 'speed' => 3, 'hp' => 20],
    237 => ['minLevel' => 20, 'previous' => 236, 'attack' => 6, 'defence' => 6, 'spAttack' => 3, 'spDefence' => 7, 'speed' => 5, 'hp' => 20],
    238 => ['minLevel' => 1, 'previous' => 0, 'attack' => 3, 'defence' => 2, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 5, 'hp' => 20],
    239 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 3, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    240 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 3, 'spAttack' => 5, 'spDefence' => 4, 'speed' => 6, 'hp' => 20],
    241 => ['minLevel' => 1, 'previous' => 0, 'attack' => 6, 'defence' => 7, 'spAttack' => 4, 'spDefence' => 5, 'speed' => 7, 'hp' => 30],
    242 => ['minLevel' => 2, 'previous' => 113, 'attack' => 2, 'defence' => 2, 'spAttack' => 5, 'spDefence' => 8, 'speed' => 4, 'hp' => 55],
    243 => ['minLevel' => 100, 'previous' => 0, 'attack' => 6, 'defence' => 5, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 7, 'hp' => 30],
    244 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 6, 'spAttack' => 6, 'spDefence' => 5, 'speed' => 7, 'hp' => 35],
    245 => ['minLevel' => 100, 'previous' => 0, 'attack' => 5, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 6, 'hp' => 30],
    246 => ['minLevel' => 1, 'previous' => 0, 'attack' => 5, 'defence' => 4, 'spAttack' => 4, 'spDefence' => 4, 'speed' => 4, 'hp' => 20],
    247 => ['minLevel' => 30, 'previous' => 246, 'attack' => 6, 'defence' => 5, 'spAttack' => 5, 'spDefence' => 5, 'speed' => 4, 'hp' => 25],
    248 => ['minLevel' => 55, 'previous' => 247, 'attack' => 8, 'defence' => 7, 'spAttack' => 6, 'spDefence' => 7, 'speed' => 5, 'hp' => 30],
    249 => ['minLevel' => 100, 'previous' => 0, 'attack' => 6, 'defence' => 8, 'spAttack' => 6, 'spDefence' => 9, 'speed' => 7, 'hp' => 35],
    250 => ['minLevel' => 100, 'previous' => 0, 'attack' => 8, 'defence' => 6, 'spAttack' => 7, 'spDefence' => 9, 'speed' => 6, 'hp' => 35],
    251 => ['minLevel' => 100, 'previous' => 0, 'attack' => 7, 'defence' => 7, 'spAttack' => 7, 'spDefence' => 7, 'speed' => 7, 'hp' => 30],
        ];

    private static $experienceOnLevel = [
        1 => 20,
        2 => 30,
        3 => 40,
        4 => 50,
        5 => 60,
        6 => 80,
        7 => 100,
        8 => 120,
        9 => 140,
        10 => 160,
        11 => 200,
        12 => 250,
        13 => 300,
        14 => 360,
        15 => 430,
        16 => 500,
        17 => 600,
        18 => 700,
        19 => 800,
        20 => 900,
        21 => 1000,
        22 => 1100,
        23 => 1200,
        24 => 1300,
        25 => 1400,
        26 => 1500,
        27 => 1600,
        28 => 1700,
        29 => 1800,
        30 => 1900,
        31 => 2000,
        32 => 2100,
        33 => 2200,
        34 => 2350,
        35 => 2500,
        36 => 2550,
        37 => 2650,
        38 => 2800,
        39 => 2950,
        40 => 3100,
        41 => 3150,
        42 => 3250,
        43 => 3400,
        44 => 3600,
        45 => 3800,
        46 => 4000,
        47 => 4200,
        48 => 4400,
        49 => 4700,
        50 => 5000,
        51 => 5300,
        52 => 5600,
        53 => 5650,
        54 => 6000,
        55 => 6400,
        56 => 6800,
        57 => 7200,
        58 => 7600,
        59 => 8000,
        60 => 8400,
        61 => 8800,
        62 => 9200,
        63 => 9600,
        64 => 10000,
        65 => 11000,
        66 => 12000,
        67 => 13000,
        68 => 14000,
        69 => 15000,
        70 => 16000,
        71 => 17000,
        72 => 18000,
        73 => 19000,
        74 => 20000,
        75 => 22000,
        76 => 24000,
        77 => 26000,
        78 => 28000,
        79 => 30000,
        80 => 32000,
        81 => 34000,
        82 => 36000,
        83 => 38000,
        84 => 40000,
        85 => 42000,
        86 => 44000,
        87 => 46000,
        88 => 48000,
        89 => 50000,
        90 => 62000,
        91 => 76000,
        92 => 90000,
        93 => 105000,
        94 => 120000,
        95 => 145000,
        96 => 185000,
        97 => 210000,
        98 => 270000,
        99 => 850000,
        100 => 1500000,
    ];

    private static $typeDescription = [
        0 => '',
        1 => 'normalny',
        2 => 'ognisty',
        3 => 'wodny',
        4 => 'roślinny',
        5 => 'elektryczny',
        6 => 'powietrzny',
        7 => 'psychiczny',
        8 => 'trujący',
        9 => 'duch',
        10 => 'walczący',
        11 => 'stalowy',
        12 => 'ziemny',
        13 => 'kamienny',
        14 => 'lodowy',
        15 => 'mroczny',
        16 => 'robaczy',
        17 => 'smoczy',
        18 => 'wróżka'
    ];

    private static $effectiveness = [
        1 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '1', 'type7' => '1', 'type8' => '1', 'type9' => '0', 'type10' => '2', 'type11' => '1', 'type12' => '1', 'type13' => '1', 'type14' => '1', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        2 => ['type1' => '1', 'type2' => '0.5', 'type3' => '2', 'type4' => '0.5', 'type5' => '1', 'type6' => '1', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '1', 'type11' => '0.5', 'type12' => '2', 'type13' => '2', 'type14' => '0.5', 'type15' => '1', 'type16' => '0.5', 'type17' => '1', 'type18' => '0.5',],
        3 => ['type1' => '1', 'type2' => '0.5', 'type3' => '0.5', 'type4' => '2', 'type5' => '2', 'type6' => '1', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '1', 'type11' => '0.5', 'type12' => '1', 'type13' => '1', 'type14' => '0.5', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        4 => ['type1' => '1', 'type2' => '2', 'type3' => '0.5', 'type4' => '0.5', 'type5' => '0.5', 'type6' => '2', 'type7' => '1', 'type8' => '2', 'type9' => '1', 'type10' => '1', 'type11' => '1', 'type12' => '0.5', 'type13' => '1', 'type14' => '2', 'type15' => '1', 'type16' => '2', 'type17' => '1', 'type18' => '1',],
        5 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '0.5', 'type6' => '0.5', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '1', 'type11' => '0.5', 'type12' => '2', 'type13' => '1', 'type14' => '1', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        6 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '0.5', 'type5' => '2', 'type6' => '1', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '0.5', 'type11' => '1', 'type12' => '0', 'type13' => '2', 'type14' => '2', 'type15' => '1', 'type16' => '0.5', 'type17' => '1', 'type18' => '1',],
        7 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '1', 'type7' => '0.5', 'type8' => '1', 'type9' => '2', 'type10' => '0.5', 'type11' => '1', 'type12' => '1', 'type13' => '1', 'type14' => '1', 'type15' => '2', 'type16' => '2', 'type17' => '1', 'type18' => '1',],
        8 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '0.5', 'type5' => '1', 'type6' => '1', 'type7' => '2', 'type8' => '0.5', 'type9' => '1', 'type10' => '0.5', 'type11' => '1', 'type12' => '2', 'type13' => '1', 'type14' => '1', 'type15' => '1', 'type16' => '0.5', 'type17' => '1', 'type18' => '0.5',],
        9 => ['type1' => '0', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '1', 'type7' => '1', 'type8' => '0.5', 'type9' => '2', 'type10' => '0', 'type11' => '1', 'type12' => '1', 'type13' => '1', 'type14' => '1', 'type15' => '2', 'type16' => '0.5', 'type17' => '1', 'type18' => '1',],
        10 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '2', 'type7' => '2', 'type8' => '1', 'type9' => '1', 'type10' => '1', 'type11' => '1', 'type12' => '1', 'type13' => '0.5', 'type14' => '1', 'type15' => '0.5', 'type16' => '0.5', 'type17' => '1', 'type18' => '2',],
        11 => ['type1' => '0.5', 'type2' => '2', 'type3' => '1', 'type4' => '0.5', 'type5' => '1', 'type6' => '0.5', 'type7' => '0.5', 'type8' => '0', 'type9' => '1', 'type10' => '2', 'type11' => '0.5', 'type12' => '2', 'type13' => '0.5', 'type14' => '0.5', 'type15' => '1', 'type16' => '0.5', 'type17' => '0.5', 'type18' => '0.5',],
        12 => ['type1' => '1', 'type2' => '1', 'type3' => '2', 'type4' => '2', 'type5' => '0', 'type6' => '1', 'type7' => '1', 'type8' => '0.5', 'type9' => '1', 'type10' => '1', 'type11' => '1', 'type12' => '1', 'type13' => '0.5', 'type14' => '2', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        13 => ['type1' => '0.5', 'type2' => '0.5', 'type3' => '2', 'type4' => '2', 'type5' => '1', 'type6' => '0.5', 'type7' => '1', 'type8' => '0.5', 'type9' => '1', 'type10' => '2', 'type11' => '2', 'type12' => '2', 'type13' => '1', 'type14' => '1', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        14 => ['type1' => '1', 'type2' => '2', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '1', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '2', 'type11' => '2', 'type12' => '1', 'type13' => '2', 'type14' => '0.5', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        15 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '1', 'type7' => '0', 'type8' => '1', 'type9' => '0.5', 'type10' => '2', 'type11' => '1', 'type12' => '1', 'type13' => '1', 'type14' => '1', 'type15' => '0.5', 'type16' => '2', 'type17' => '1', 'type18' => '2',],
        16 => ['type1' => '1', 'type2' => '2', 'type3' => '1', 'type4' => '0.5', 'type5' => '1', 'type6' => '2', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '0.5', 'type11' => '1', 'type12' => '0.5', 'type13' => '2', 'type14' => '1', 'type15' => '1', 'type16' => '1', 'type17' => '1', 'type18' => '1',],
        17 => ['type1' => '1', 'type2' => '0.5', 'type3' => '0.5', 'type4' => '0.5', 'type5' => '0.5', 'type6' => '1', 'type7' => '1', 'type8' => '1', 'type9' => '1', 'type10' => '1', 'type11' => '1', 'type12' => '1', 'type13' => '1', 'type14' => '2', 'type15' => '1', 'type16' => '1', 'type17' => '2', 'type18' => '2',],
        18 => ['type1' => '1', 'type2' => '1', 'type3' => '1', 'type4' => '1', 'type5' => '1', 'type6' => '1', 'type7' => '1', 'type8' => '2', 'type9' => '1', 'type10' => '0.5', 'type11' => '2', 'type12' => '1', 'type13' => '1', 'type14' => '1', 'type15' => '0.5', 'type16' => '0.5', 'type17' => '0', 'type18' => '1',],
        ];

    public static function getInfo(int $id): array
    {
        return
            array_merge(
                self::$pokemonInfo[$id],
                [
                    'type1Description' => self::$typeDescription[self::$pokemonInfo[$id]['type1']],
                    'type2Description' => self::$typeDescription[self::$pokemonInfo[$id]['type2']],
                    'attackArray' => self::getAttacksAsArray($id)
                ]
            );
    }

    public static function getStartingStats(int $id): array
    {
        return self::$startingStats[$id];
    }

    public static function getExperienceOnLevel(int $level): int
    {
        if ($level <= 100) {
            return self::$experienceOnLevel[$level];
        }
        return 20000000;
    }

    public static function getIncrease(int $id): array
    {
        return self::$increase[$id];
    }

    public static function generatePokemon(int $id, int $level, bool $shiny = false): Pokemon
    {
        $pokemon = new Pokemon();
        $pokemon->setIdPokemon($id);
        $pokemon->setLevel($level);
        $pokemon->setQuality(self::pokemonQuality($shiny));
        $pokemon->setGender(self::getGender(self::$pokemonInfo[$id]['genderFemale'], self::$pokemonInfo[$id]['genderMale']));
        $pokemon->setName(self::$pokemonInfo[$id]['name']);
        $pokemon->setValue(self::getValue(self::$pokemonInfo[$id]['difficulty'], $level));
        $pokemon->setShiny($shiny);
        $pokemon->setExp(0);
        $pokemon->setTeam(0);
        $pokemon->setAttachment(0);
        $pokemon->setBlock(0);
        $pokemon->setLottery(0);
        $pokemon->setBerrysHp(0);
        $pokemon->setSnacks(0);
        $pokemon->setMarket(0);
        $pokemon->setBlockView(0);
        $pokemon->setHunger(0);
        $pokemon->setTr6(0);
        $pokemon->setDescription('');
        $pokemon->setExchange(0);
        $pokemon->setEwolution(0);

        self::generatePokemonStatsAndAttacks($pokemon);

        return $pokemon;
    }

    public static function getEffectiveness(int $type1, int $type2): array
    {
        $effectiveness = [];
        if ($type2) {
            for ($i = 1; $i < 19; $i++) {
                $effectiveness[$i] = self::$effectiveness[$type1]['type'.$i] * self::$effectiveness[$type2]['type'.$i];
            }
        } else {
            for ($i = 1; $i < 19; $i++) {
                $effectiveness[$i] = self::$effectiveness[$type1]['type'.$i];
            }
        }
        return $effectiveness;
    }

    public static function getTypeDescription(int $i): string
    {
        return self::$typeDescription[$i];
    }

    private static function getAttacksAsArray(int $id): ?array
    {
        $attacks = explode(';', self::$pokemonInfo[$id]['attacks']);
        array_pop($attacks);
        $attacksDelimitered = [];

        foreach ($attacks as $attack) {
            $attackExploded = explode(',', $attack);
            $attacksDelimitered[] = [
                'id' => $attackExploded[0],
                'level' => $attackExploded[1]
            ];
        }
        return $attacksDelimitered;
    }

    private static function pokemonQuality(bool $shiny): int
    {
        if (!$shiny) {
            $quality = mt_rand(20, 110);
        } else {
            $quality = mt_rand(90, 110);
        }
        if ($quality > 100) {
            $quality -= 10;
        } elseif ($quality > 50) {
            $quality -= 5;
        }
        return $quality;
    }

    private static function getGender(int $k, int $m): int
    {
        if ($k === 0 && $m === 0) {
            $gender = 2;
        } elseif ($k === 0) {
            $gender = 0;
        } elseif ($m === 0) {
            $gender = 1;
        } else {
            $_0 = $m;
            $p = mt_rand() % 1000;
            ($p < $_0) ? $gender = 0 : $gender = 1;
        }
        return $gender;
    }

    private static function getValue(int $difficulty, int $level): int
    {
        $value = ((2500 + ($level * 290) + ($difficulty * 1280)) * (0.71 * $difficulty)) * (mt_rand(90, 110) / 100);
        //TODO:
        //odznaka1 z Kanto
        //if (User::$odznaki->kanto[1])
        //    $wartosc *= 1.1;
        return floor($value);
    }

    private static function generatePokemonStatsAndAttacks(Pokemon $pokemon): void
    {
        $pokemon->setAccuracy(rand(55, 80));

        self::generateStats($pokemon);
        self::generateAttacks($pokemon);
    }

    private static function generateStats(Pokemon $pokemon): void
    {
        $pokemonId = $pokemon->getIdPokemon();
        $lvl = $pokemon->getLevel();

        $attack = 0;
        $spAttack = 0;
        $defence = 0;
        $spDefence = 0;
        $speed = 0;
        $hp = 0;

        if (self::$increase[$pokemonId]['minLevel'] > 1 && self::$increase[$pokemonId]['minLevel'] != 100) {///jeśli minimalny poziom większy od 1, ale nie równy 100, to pobierz przyrosty preevolucji
            $previous = self::$increase[self::$increase[$pokemonId]['previous']];
            if ($previous['minLevel'] > 1) {///jeśli minimalny poziom nadal większy od 1, to pobierz przyrosty preevolucji
                $previousTwoBack = self::$increase[$previous['previous']];
                $levelsOnThirdForms = $lvl - self::$increase[$pokemonId]['minLevel'] + 4;
                $pokemonStats = self::$increase[$pokemonId];
                $attack += $levelsOnThirdForms * $pokemonStats['attack'];
                $spAttack += $levelsOnThirdForms * $pokemonStats['spAttack'];
                $defence += $levelsOnThirdForms * $pokemonStats['defence'];
                $spDefence += $levelsOnThirdForms * $pokemonStats['spDefence'];
                $speed += $levelsOnThirdForms * $pokemonStats['speed'];
                $hp += $levelsOnThirdForms * $pokemonStats['hp'];

                $levelsOnSecondForm = $previous['minLevel'] + 3;
                $previousStats = $previous;
                $attack += $levelsOnSecondForm * $previousStats['attack'];
                $spAttack += $levelsOnSecondForm * $previousStats['spAttack'];
                $defence += $levelsOnSecondForm * $previousStats['defence'];
                $spDefence += $levelsOnSecondForm * $previousStats['spDefence'];
                $speed += $levelsOnSecondForm * $previousStats['speed'];
                $hp += $levelsOnSecondForm * $previousStats['hp'];

                $levelsOnFirstForm = $previous['minLevel'] - 2;
                $attack += $levelsOnFirstForm * $previousTwoBack['attack'];
                $spAttack += $levelsOnFirstForm * $previousTwoBack['spAttack'];
                $defence += $levelsOnFirstForm * $previousTwoBack['defence'];
                $spDefence += $levelsOnFirstForm * $previousTwoBack['spDefence'];
                $speed += $levelsOnFirstForm * $previousTwoBack['speed'];
                $hp += $levelsOnFirstForm * $previousTwoBack['hp'];
                $startingStats = self::$startingStats[$previous['previous']];
            } else {//2 evo
                $startingStats = self::$increase[$pokemonId]['previous'];

                $levelsOnSecondForms = $lvl - self::$increase[$pokemonId]['minLevel'] + 4;
                $pokemonStats = self::$increase[$pokemonId];
                $attack += $levelsOnSecondForms * $pokemonStats['attack'];
                $spAttack += $levelsOnSecondForms * $pokemonStats['spAttack'];
                $defence += $levelsOnSecondForms * $pokemonStats['defence'];
                $spDefence += $levelsOnSecondForms * $pokemonStats['spDefence'];
                $speed += $levelsOnSecondForms * $pokemonStats['speed'];
                $hp += $levelsOnSecondForms * $pokemonStats['hp'];

                $levelsOnFirstForm = self::$increase[$pokemonId]['minLevel'] - 2;
                $previousStats = $previous;
                $attack += $levelsOnFirstForm * $previousStats['attack'];
                $spAttack += $levelsOnFirstForm * $previousStats['spAttack'];
                $defence += $levelsOnFirstForm * $previousStats['defence'];
                $spDefence += $levelsOnFirstForm * $previousStats['spDefence'];
                $speed += $levelsOnFirstForm * $previousStats['speed'];
                $hp += $levelsOnFirstForm * $previousStats['hp'];
            }
        } else {
            $startingStats = self::$startingStats[$pokemonId];
            $levelsOnFirstForm = $lvl - 1;
            $attack += $levelsOnFirstForm * self::$increase[$pokemonId]['attack'];
            $spAttack += $levelsOnFirstForm * self::$increase[$pokemonId]['spAttack'];
            $defence += $levelsOnFirstForm * self::$increase[$pokemonId]['defence'];
            $spDefence += $levelsOnFirstForm * self::$increase[$pokemonId]['spDefence'];
            $speed += $levelsOnFirstForm * self::$increase[$pokemonId]['speed'];
            $hp += $levelsOnFirstForm * self::$increase[$pokemonId]['hp'];
        }
        $attack += $startingStats['attack'];
        $spAttack += $startingStats['spAttack'];
        $defence += $startingStats['defence'];
        $spDefence += $startingStats['spDefence'];
        $speed += $startingStats['speed'];
        $hp += $startingStats['hp'];

        $pokemon->setAttack($attack);
        $pokemon->setSpAttack($spAttack);
        $pokemon->setDefence($defence);
        $pokemon->setSpDefence($spDefence);
        $pokemon->setSpeed($speed);
        $pokemon->setHp($hp);
        $pokemon->setActualHp(round($pokemon->getHp() * $pokemon->getQuality() / 100));

        $pokemon->setTraining(self::pokemonTrainings());
    }

    private static function generateAttacks(Pokemon $pokemon): void
    {
        $attacks = explode(';', self::$pokemonInfo[$pokemon->getIdPokemon()]['attacks']);
        array_pop($attacks);
        $attacksDelimitered = [];

        foreach ($attacks as $attack) {
            $attackExploded = explode(',', $attack);
            $attacksDelimitered[] = [
                'id' => $attackExploded[0],
                'level' => $attackExploded[1]
            ];
        }
        $possiblyAttacks = [];
        foreach ($attacksDelimitered as $attack) {
            if ($attack['level'] <= $pokemon->getLevel()) {
                $possiblyAttacks[] = $attack['id'];
            }
        }
        $attacksQuantity = count($possiblyAttacks);
        if ($attacksQuantity <= 4) {
            $i = 0;
            for (; $i < $attacksQuantity; $i++) {
                $pokemon->{'setAttack'.$i}($possiblyAttacks[$i]);
            }
            for (; $i < 4; $i++) {
                $pokemon->{'setAttack'.$i}(0);
            }
        } else {
            $b = [0 => 0, 1 => 0, 2 => 0, 3 => 0];
            while ($b[0] === $b[1] || $b[0] === $b[2] || $b[0] === $b[3]
                || $b[1] === $b[2] || $b[1] === $b[3] || $b[2] === $b[3]) {
                $b[0] = (rand() % ($attacksQuantity - 1)) + 1;
                $b[1] = (rand() % ($attacksQuantity - 1)) + 1;
                $b[2] = (rand() % ($attacksQuantity - 1)) + 1;
                $b[3] = (rand() % ($attacksQuantity - 1)) + 1;
            }
            for ($i = 0; $i < 4; $i++) {
                $pokemon->{'setAttack'.$i}($possiblyAttacks[$b[$i]]);
            }
        }
    }

    private static function pokemonTrainings(int $quantity = 0): PokemonTraining
    {
        //TODO
        //ilość treningów
        $trainings = new PokemonTraining();
        $trainings->setTr1(0);
        $trainings->setTr2(0);
        $trainings->setTr3(0);
        $trainings->setTr4(0);
        $trainings->setTr5(0);
        $trainings->setBerrySpeed(0);
        $trainings->setBerryAttack(0);
        $trainings->setBerrySpAttack(0);
        $trainings->setBerryDefence(0);
        $trainings->setBerrySpDefence(0);

        return $trainings;
    }
}
