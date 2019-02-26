<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\PokemonTraining;

class PokemonHelper
{
    private static $startingStats = [
        '1' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 10, 'szybkosc' => 9, 'hp' => 45],
        '4' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '7' => ['atak' => 9, 'obrona' => 10, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 9, 'hp' => 45],
        '10' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '13' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '16' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '19' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 45],
        '21' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 45],
        '23' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '25' => ['atak' => 9, 'obrona' => 7, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 40],
        '27' => ['atak' => 10, 'obrona' => 11, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '29' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 50],
        '32' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '35' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 7, 'hp' => 45],
        '37' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 45],
        '39' => ['atak' => 8, 'obrona' => 7, 'sp_atak' => 9, 'sp_obrona' => 8, 'szybkosc' => 7, 'hp' => 55],
        '41' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '43' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 10, 'szybkosc' => 8, 'hp' => 45],
        '46' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '48' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 50],
        '50' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 40],
        '52' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '54' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '56' => ['atak' => 11, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '58' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 50],
        '60' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '63' => ['atak' => 8, 'obrona' => 7, 'sp_atak' => 12, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 40],
        '66' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 50],
        '69' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 10, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '72' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 12, 'szybkosc' => 10, 'hp' => 45],
        '74' => ['atak' => 11, 'obrona' => 12, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 45],
        '77' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 10, 'szybkosc' => 11, 'hp' => 45],
        '79' => ['atak' => 10, 'obrona' => 10, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 7, 'hp' => 55],
        '81' => ['atak' => 8, 'obrona' => 10, 'sp_atak' => 11, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 40],
        '83' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 50],
        '84' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 45],
        '86' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 9, 'hp' => 50],
        '88' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 55],
        '90' => ['atak' => 10, 'obrona' => 12, 'sp_atak' => 9, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '92' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 12, 'sp_obrona' => 8, 'szybkosc' => 11, 'hp' => 45],
        '95' => ['atak' => 9, 'obrona' => 15, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '96' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 11, 'szybkosc' => 9, 'hp' => 50],
        '98' => ['atak' => 12, 'obrona' => 11, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '100' => ['atak' => 8, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 12, 'hp' => 45],
        '102' => ['atak' => 9, 'obrona' => 10, 'sp_atak' => 11, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 50],
        '104' => ['atak' => 9, 'obrona' => 11, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '106' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 45],
        '107' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 45],
        '108' => ['atak' => 9, 'obrona' => 10, 'sp_atak' => 10, 'sp_obrona' => 10, 'szybkosc' => 8, 'hp' => 55],
        '109' => ['atak' => 10, 'obrona' => 11, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '111' => ['atak' => 11, 'obrona' => 11, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 55],
        '113' => ['atak' => 7, 'obrona' => 7, 'sp_atak' => 7, 'sp_obrona' => 10, 'szybkosc' => 8, 'hp' => 55],
        '114' => ['atak' => 9, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 50],
        '115' => ['atak' => 11, 'obrona' => 11, 'sp_atak' => 9, 'sp_obrona' => 11, 'szybkosc' => 11, 'hp' => 60],
        '116' => ['atak' => 9, 'obrona' => 10, 'sp_atak' => 10, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 45],
        '118' => ['atak' => 10, 'obrona' => 10, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '120' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '122' => ['atak' => 8, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 11, 'szybkosc' => 10, 'hp' => 40],
        '123' => ['atak' => 12, 'obrona' => 11, 'sp_atak' => 9, 'sp_obrona' => 11, 'szybkosc' => 12, 'hp' => 50],
        '124' => ['atak' => 8, 'obrona' => 7, 'sp_atak' => 11, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 45],
        '125' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '126' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '127' => ['atak' => 13, 'obrona' => 12, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 11, 'hp' => 50],
        '128' => ['atak' => 12, 'obrona' => 11, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 50],
        '129' => ['atak' => 7, 'obrona' => 9, 'sp_atak' => 7, 'sp_obrona' => 8, 'szybkosc' => 11, 'hp' => 40],
        '131' => ['atak' => 11, 'obrona' => 11, 'sp_atak' => 11, 'sp_obrona' => 11, 'szybkosc' => 10, 'hp' => 65],
        '132' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 35],
        '133' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 9, 'hp' => 50],
        '137' => ['atak' => 10, 'obrona' => 10, 'sp_atak' => 11, 'sp_obrona' => 10, 'szybkosc' => 9, 'hp' => 50],
        '138' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 40],
        '140' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 40],
        '142' => ['atak' => 12, 'obrona' => 11, 'sp_atak' => 7, 'sp_obrona' => 11, 'szybkosc' => 13, 'hp' => 55],
        '143' => ['atak' => 11, 'obrona' => 12, 'sp_atak' => 7, 'sp_obrona' => 12, 'szybkosc' => 5, 'hp' => 75],
        '144' => ['atak' => 25, 'obrona' => 25, 'sp_atak' => 25, 'sp_obrona' => 25, 'szybkosc' => 25, 'hp' => 145],
        '145' => ['atak' => 25, 'obrona' => 25, 'sp_atak' => 25, 'sp_obrona' => 25, 'szybkosc' => 25, 'hp' => 145],
        '146' => ['atak' => 25, 'obrona' => 25, 'sp_atak' => 25, 'sp_obrona' => 25, 'szybkosc' => 25, 'hp' => 145],
        '147' => ['atak' => 11, 'obrona' => 10, 'sp_atak' => 10, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 55],
        '150' => ['atak' => 25, 'obrona' => 25, 'sp_atak' => 25, 'sp_obrona' => 25, 'szybkosc' => 25, 'hp' => 145],
        '151' => ['atak' => 25, 'obrona' => 25, 'sp_atak' => 25, 'sp_obrona' => 25, 'szybkosc' => 25, 'hp' => 145],
        '152' => ['atak' => 9, 'obrona' => 10, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 9, 'hp' => 45],
        '155' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '158' => ['atak' => 10, 'obrona' => 10, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '161' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '163' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 50],
        '165' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 11, 'szybkosc' => 9, 'hp' => 45],
        '167' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '170' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 50],
        '172' => ['atak' => 9, 'obrona' => 7, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 40],
        '173' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 7, 'hp' => 45],
        '174' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 7, 'hp' => 45],
        '175' => ['atak' => 8, 'obrona' => 10, 'sp_atak' => 9, 'sp_obrona' => 10, 'szybkosc' => 8, 'hp' => 45],
        '177' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '179' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 50],
        '183' => ['atak' => 8, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '187' => ['atak' => 8, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '190' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 50],
        '191' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 45],
        '193' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 50],
        '194' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 7, 'hp' => 50],
        '198' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 11, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 50],
        '200' => ['atak' => 10, 'obrona' => 10, 'sp_atak' => 11, 'sp_obrona' => 11, 'szybkosc' => 11, 'hp' => 50],
        '201' => ['atak' => 10, 'obrona' => 10, 'sp_atak' => 10, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 50],
        '202' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '203' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '204' => ['atak' => 10, 'obrona' => 11, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 7, 'hp' => 45],
        '206' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 7, 'hp' => 40],
        '207' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 7, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 50],
        '209' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '211' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 8, 'hp' => 40],
        '213' => ['atak' => 6, 'obrona' => 15, 'sp_atak' => 6, 'sp_obrona' => 15, 'szybkosc' => 6, 'hp' => 35],
        '214' => ['atak' => 10, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 50],
        '215' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 10, 'szybkosc' => 12, 'hp' => 50],
        '216' => ['atak' => 11, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 50],
        '218' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 8, 'hp' => 45],
        '220' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '222' => ['atak' => 9, 'obrona' => 11, 'sp_atak' => 10, 'sp_obrona' => 11, 'szybkosc' => 8, 'hp' => 50],
        '223' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 10, 'sp_obrona' => 8, 'szybkosc' => 10, 'hp' => 45],
        '225' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 40],
        '226' => ['atak' => 6, 'obrona' => 7, 'sp_atak' => 8, 'sp_obrona' => 11, 'szybkosc' => 8, 'hp' => 45],
        '227' => ['atak' => 8, 'obrona' => 14, 'sp_atak' => 7, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 55],
        '228' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 11, 'sp_obrona' => 9, 'szybkosc' => 10, 'hp' => 45],
        '231' => ['atak' => 9, 'obrona' => 9, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '234' => ['atak' => 9, 'obrona' => 8, 'sp_atak' => 9, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 45],
        '235' => ['atak' => 7, 'obrona' => 7, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 7, 'hp' => 45],
        '236' => ['atak' => 8, 'obrona' => 8, 'sp_atak' => 8, 'sp_obrona' => 8, 'szybkosc' => 8, 'hp' => 45],
        '238' => ['atak' => 8, 'obrona' => 7, 'sp_atak' => 11, 'sp_obrona' => 10, 'szybkosc' => 10, 'hp' => 45],
        '239' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '240' => ['atak' => 10, 'obrona' => 8, 'sp_atak' => 10, 'sp_obrona' => 9, 'szybkosc' => 11, 'hp' => 45],
        '241' => ['atak' => 8, 'obrona' => 9, 'sp_atak' => 6, 'sp_obrona' => 8, 'szybkosc' => 9, 'hp' => 50],
        '243' => ['atak' => 12, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 12, 'szybkosc' => 12, 'hp' => 60],
        '244' => ['atak' => 12, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 12, 'szybkosc' => 12, 'hp' => 60],
        '245' => ['atak' => 12, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 12, 'szybkosc' => 12, 'hp' => 60],
        '246' => ['atak' => 10, 'obrona' => 9, 'sp_atak' => 9, 'sp_obrona' => 9, 'szybkosc' => 9, 'hp' => 45],
        '249' => ['atak' => 12, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 12, 'szybkosc' => 12, 'hp' => 60],
        '250' => ['atak' => 12, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 12, 'szybkosc' => 12, 'hp' => 60],
        '251' => ['atak' => 12, 'obrona' => 12, 'sp_atak' => 12, 'sp_obrona' => 12, 'szybkosc' => 12, 'hp' => 60],
        ];

    private static $pokemonInfo = [
    1 => ['id_poka' => 1, 'nazwa' => 'Bulbasaur', 'min_poziom' => 1, 'ewolucja_p' => 2, 'typ1' => 4, 'typ2' => 8,'ataki' => '541,1;215,3;290,7;580,9;379,13;483,13;546,15;413,19;535,21;216,25;282,27;540,33;456,37;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 125, 'plec_m' => 875],
    2 => ['id_poka' => 2, 'nazwa' => 'Ivysaur', 'min_poziom' => 16, 'ewolucja_p' => 3, 'typ1' => 4, 'typ2' => 8,'ataki' => '541,1;215,1;290,1;580,9;379,13;483,13;546,15;413,20;535,23;216,28;282,31;540,39;497,44;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 125, 'plec_m' => 875],
    3 => ['id_poka' => 3, 'nazwa' => 'Venusaur', 'min_poziom' => 32, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 8,'ataki' => '541,1;215,1;290,1;580,1;379,13;483,13;546,15;413,20;535,23;216,28;282,31;370,32;540,45;369,50;497,53;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 125, 'plec_m' => 875],
    4 => ['id_poka' => 4, 'nazwa' => 'Charmander', 'min_poziom' => 1, 'ewolucja_p' => 5, 'typ1' => 2, 'typ2' => 0,'ataki' => '451,1;215,1;145,7;491,10;125,16;450,19;168,25;173,28;482,34;176,37;170,43;270,46;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 125, 'plec_m' => 875],
    5 => ['id_poka' => 5, 'nazwa' => 'Charmeleon', 'min_poziom' => 16, 'ewolucja_p' => 6, 'typ1' => 2, 'typ2' => 0,'ataki' => '451,1;215,1;145,1;491,10;125,17;450,21;168,28;173,32;482,39;176,43;170,50;270,54;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 125, 'plec_m' => 875],
    6 => ['id_poka' => 6, 'nazwa' => 'Charizard', 'min_poziom' => 36, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 6,'ataki' => '122,1;461,1;12,1;451,1;145,1;491,1;125,17;450,21;168,28;173,32;596,36;482,41;176,47;170,56;270,62;239,71;177,77;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 125, 'plec_m' => 875],
    7 => ['id_poka' => 7, 'nazwa' => 'Squirtle', 'min_poziom' => 1, 'ewolucja_p' => 8, 'typ1' => 3, 'typ2' => 0,'ataki' => '541,1;544,4;584,7;598,10;57,13;41,16;412,19;393,22;585,25;18,28;476,31;273,34;252,40;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 125, 'plec_m' => 875],
    8 => ['id_poka' => 8, 'nazwa' => 'Wartortle', 'min_poziom' => 16, 'ewolucja_p' => 9, 'typ1' => 3, 'typ2' => 0,'ataki' => '541,1;544,1;584,1;598,10;57,13;41,16;412,20;393,24;585,28;18,32;476,36;273,40;252,48;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 125, 'plec_m' => 875],
    9 => ['id_poka' => 9, 'nazwa' => 'Blastoise', 'min_poziom' => 36, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '179,1;541,1;544,1;584,1;598,1;57,13;41,16;412,20;393,24;585,28;18,32;476,39;273,46;252,60;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 125, 'plec_m' => 875],
    10 => ['id_poka' => 10, 'nazwa' => 'Caterpie', 'min_poziom' => 1, 'ewolucja_p' => 11, 'typ1' => 16, 'typ2' => 0,'ataki' => '541,1;521,1;59,15;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    11 => ['id_poka' => 11, 'nazwa' => 'Metapod', 'min_poziom' => 7, 'ewolucja_p' => 12, 'typ1' => 16, 'typ2' => 0,'ataki' => '226,1;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    12 => ['id_poka' => 12, 'nazwa' => 'Butterfree', 'min_poziom' => 10, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 6,'ataki' => '81,1;379,12;524,12;483,12;222,16;531,18;394,24;471,28;545,30;410,34;67,40;60,42;408,46;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    13 => ['id_poka' => 13, 'nazwa' => 'Weedle', 'min_poziom' => 1, 'ewolucja_p' => 14, 'typ1' => 16, 'typ2' => 8,'ataki' => '380,1;521,1;59,15;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    14 => ['id_poka' => 14, 'nazwa' => 'Kakuna', 'min_poziom' => 7, 'ewolucja_p' => 15, 'typ1' => 16, 'typ2' => 8,'ataki' => '226,1;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    15 => ['id_poka' => 15, 'nazwa' => 'Beedrill', 'min_poziom' => 10, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 8,'ataki' => '197,1;185,13;572,16;609,19;404,22;564,25;372,28;10,31;23,34;378,37;147,40;164,45;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    16 => ['id_poka' => 16, 'nazwa' => 'Pidgey', 'min_poziom' => 1, 'ewolucja_p' => 17, 'typ1' => 1, 'typ2' => 6,'ataki' => '541,1;446,5;222,9;406,13;573,21;161,25;10,29;596,33;440,37;545,41;331,45;12,49;250,53;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    17 => ['id_poka' => 17, 'nazwa' => 'Pidgeotto', 'min_poziom' => 18, 'ewolucja_p' => 18, 'typ1' => 1, 'typ2' => 6,'ataki' => '541,1;446,1;222,1;406,13;573,22;161,27;10,32;596,37;440,42;545,47;331,52;12,57;250,62;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    18 => ['id_poka' => 18, 'nazwa' => 'Pidgeot', 'min_poziom' => 36, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 6,'ataki' => '541,1;446,1;222,1;406,1;573,22;161,27;10,32;596,38;440,44;545,50;331,56;12,62;250,68;250,68;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    19 => ['id_poka' => 19, 'nazwa' => 'Rattata', 'min_poziom' => 1, 'ewolucja_p' => 20, 'typ1' => 1, 'typ2' => 0,'ataki' => '541,1;544,1;406,4;185,7;41,10;404,13;254,16;527,19;95,22;23,25;529,28;282,31;147,34;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    20 => ['id_poka' => 20, 'nazwa' => 'Raticate', 'min_poziom' => 20, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '541,1;538,1;544,1;406,1;185,1;41,10;404,13;254,16;527,19;450,20;95,24;23,29;529,34;282,39;147,44;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    21 => ['id_poka' => 21, 'nazwa' => 'Spearow', 'min_poziom' => 1, 'ewolucja_p' => 22, 'typ1' => 1, 'typ2' => 6,'ataki' => '367,1;215,1;291,5;197,9;404,13;7,17;331,21;10,25;23,29;440,33;131,37;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    22 => ['id_poka' => 22, 'nazwa' => 'Fearow', 'min_poziom' => 20, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 6,'ataki' => '375,1;367,1;215,1;291,1;197,1;404,13;7,17;331,23;10,29;23,35;440,41;131,47;132,53;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    23 => ['id_poka' => 23, 'nazwa' => 'Ekans', 'min_poziom' => 1, 'ewolucja_p' => 24, 'typ1' => 8, 'typ2' => 0,'ataki' => '603,1;291,1;380,4;41,9;209,12;452,17;2,20;516,25;505,25;4,28;339,33;36,38;227,41;77,44;221,49;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    24 => ['id_poka' => 24, 'nazwa' => 'Arbok', 'min_poziom' => 22, 'ewolucja_p' => 0, 'typ1' => 8, 'typ2' => 0,'ataki' => '262,1;555,1;168,1;603,1;380,1;41,1;209,12;452,17;2,20;95,22;516,27;505,27;4,32;339,39;36,48;227,51;77,56;221,63;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    25 => ['id_poka' => 25, 'nazwa' => 'Pikachu', 'min_poziom' => 2, 'ewolucja_p' => 26, 'typ1' => 5, 'typ2' => 0,'ataki' => '557,1;544,1;215,5;373,7;406,10;142,13;558,18;162,21;117,23;500,26;354,29;110,34;481,37;559,42;10,45;594,50;294,53;554,58;', 'wymagania' => 3, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    26 => ['id_poka' => 26, 'nazwa' => 'Raichu', 'min_poziom' => 3, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 0,'ataki' => '557,1;559,1;544,1;406,1;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    27 => ['id_poka' => 27, 'nazwa' => 'Sandshrew', 'min_poziom' => 1, 'ewolucja_p' => 28, 'typ1' => 12, 'typ2' => 0,'ataki' => '451,1;102,1;446,3;380,5;439,7;412,9;198,11;310,14;536,17;199,20;447,23;482,26;107,30;223,34;538,38;136,46;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    28 => ['id_poka' => 28, 'nazwa' => 'Sandslash', 'min_poziom' => 22, 'ewolucja_p' => 0, 'typ1' => 12, 'typ2' => 0,'ataki' => '451,1;102,1;446,1;380,1;439,7;412,9;198,11;310,14;536,17;199,20;96,22;447,24;482,28;107,33;223,38;538,43;136,53;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    29 => ['id_poka' => 29, 'nazwa' => 'Nidoran', 'min_poziom' => 1, 'ewolucja_p' => 30, 'typ1' => 8, 'typ2' => 0,'ataki' => '215,1;451,1;544,7;115,9;380,13;199,19;41,21;564,31;180,33;95,37;67,43;376,45;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 1000, 'plec_m' => 0],
    30 => ['id_poka' => 30, 'nazwa' => 'Nidorina', 'min_poziom' => 16, 'ewolucja_p' => 31, 'typ1' => 8, 'typ2' => 0,'ataki' => '215,1;451,1;544,7;115,9;380,13;199,20;41,23;564,35;180,38;95,43;67,50;376,58;', 'wymagania' => 5, 'trudnosc' => 3, 'plec_k' => 1000, 'plec_m' => 0],
    31 => ['id_poka' => 31, 'nazwa' => 'Nidoqueen', 'min_poziom' => 17, 'ewolucja_p' => 0, 'typ1' => 8, 'typ2' => 12,'ataki' => '451,1;544,1;115,1;380,1;72,23;47,35;135,43;530,58;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 1000, 'plec_m' => 0],
    32 => ['id_poka' => 32, 'nazwa' => 'Nidoran', 'min_poziom' => 1, 'ewolucja_p' => 33, 'typ1' => 8, 'typ2' => 0,'ataki' => '291,1;367,1;185,7;115,9;380,13;197,19;246,21;564,31;180,33;378,37;67,43;247,45;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 0, 'plec_m' => 1000],
    33 => ['id_poka' => 33, 'nazwa' => 'Nidorino', 'min_poziom' => 16, 'ewolucja_p' => 34, 'typ1' => 8, 'typ2' => 0,'ataki' => '291,1;367,1;185,7;115,9;380,13;197,20;246,23;564,35;180,38;378,43;67,50;247,58;', 'wymagania' => 5, 'trudnosc' => 3, 'plec_k' => 0, 'plec_m' => 1000],
    34 => ['id_poka' => 34, 'nazwa' => 'Nidoking', 'min_poziom' => 17, 'ewolucja_p' => 0, 'typ1' => 8, 'typ2' => 12,'ataki' => '367,1;185,1;115,1;380,1;72,23;553,25;135,43;318,58;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 100],
    35 => ['id_poka' => 35, 'nazwa' => 'Clefairy', 'min_poziom' => 2, 'ewolucja_p' => 36, 'typ1' => 18, 'typ2' => 0,'ataki' => '109,1;382,1;215,1;473,7;116,10;102,13;583,22;328,25;519,28;324,31;86,34;47,40;337,43;336,46;323,50;235,55;', 'wymagania' => 5, 'trudnosc' => 6, 'plec_k' => 750, 'plec_m' => 250],
    36 => ['id_poka' => 36, 'nazwa' => 'Clefable', 'min_poziom' => 3, 'ewolucja_p' => 0, 'typ1' => 18, 'typ2' => 0,'ataki' => '109,1;473,1;116,1;328,1;324,1;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 750, 'plec_m' => 250],
    37 => ['id_poka' => 37, 'nazwa' => 'Vulpix', 'min_poziom' => 1, 'ewolucja_p' => 38, 'typ1' => 2, 'typ2' => 0,'ataki' => '145,1;544,4;31,9;406,10;80,12;170,15;366,18;595,20;163,23;242,26;173,28;153,31;176,36;167,42;67,47;270,50;', 'wymagania' => 1, 'trudnosc' => 4, 'plec_k' => 750, 'plec_m' => 250],
    38 => ['id_poka' => 38, 'nazwa' => 'Ninetales', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '345,1;176,1;406,1;80,1;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 750, 'plec_m' => 250],
    39 => ['id_poka' => 39, 'nazwa' => 'Jigglypuff', 'min_poziom' => 2, 'ewolucja_p' => 40, 'typ1' => 1, 'typ2' => 18,'ataki' => '473,1;102,3;382,5;373,8;109,11;108,15;116,18;439,21;442,24;583,28;422,32;47,35;326,37;223,40;255,44;282,49;', 'wymagania' => 5, 'trudnosc' => 6, 'plec_k' => 750, 'plec_m' => 250],
    40 => ['id_poka' => 40, 'nazwa' => 'Wigglytuff', 'min_poziom' => 3, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 18,'ataki' => '282,1;374,1;473,1;108,1;102,1;116,1;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 750, 'plec_m' => 250],
    41 => ['id_poka' => 41, 'nazwa' => 'Zubat', 'min_poziom' => 1, 'ewolucja_p' => 42, 'typ1' => 8, 'typ2' => 6,'ataki' => '289,1;531,5;24,7;41,11;596,13;80,17;11,19;536,23;376,25;5,31;227,35;578,37;12,41;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    42 => ['id_poka' => 42, 'nazwa' => 'Golbat', 'min_poziom' => 22, 'ewolucja_p' => 169, 'typ1' => 8, 'typ2' => 6,'ataki' => '452,1;289,1;531,1;24,1;41,1;596,13;80,17;11,19;536,24;376,27;5,35;227,40;578,43;12,48;', 'wymagania' => 998, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    43 => ['id_poka' => 43, 'nazwa' => 'Oddish', 'min_poziom' => 1, 'ewolucja_p' => 44, 'typ1' => 4, 'typ2' => 8,'ataki' => '1,1;535,5;2,9;379,13;524,14;483,15;315,19;337,27;206,31;563,35;346,39;336,43;370,51;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    44 => ['id_poka' => 44, 'nazwa' => 'Gloom', 'min_poziom' => 21, 'ewolucja_p' => 45000182, 'typ1' => 4, 'typ2' => 8,'ataki' => '1,1;2,1;535,1;379,13;524,14;483,15;315,19;337,29;206,34;563,39;346,44;369,49;370,59;', 'wymagania' => 4, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    45 => ['id_poka' => 45, 'nazwa' => 'Vileplume', 'min_poziom' => 22, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 8,'ataki' => '315,1;20,1;379,1;524,1;369,49;370,59;497,64;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    46 => ['id_poka' => 46, 'nazwa' => 'Paras', 'min_poziom' => 1, 'ewolucja_p' => 47, 'typ1' => 16, 'typ2' => 4,'ataki' => '451,1;524,6;379,6;289,11;198,17;508,22;482,27;216,33;206,38;20,43;410,49;605,54;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    47 => ['id_poka' => 47, 'nazwa' => 'Parasect', 'min_poziom' => 24, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 4,'ataki' => '94,1;451,1;524,1;379,1;289,1;198,17;508,22;482,29;216,37;206,44;20,51;410,59;605,66;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    48 => ['id_poka' => 48, 'nazwa' => 'Venonat', 'min_poziom' => 1, 'ewolucja_p' => 49, 'typ1' => 16, 'typ2' => 8,'ataki' => '541,1;108,1;189,1;531,5;81,11;379,13;289,17;524,23;394,25;483,29;470,35;608,37;376,41;396,47;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    49 => ['id_poka' => 49, 'nazwa' => 'Venomoth', 'min_poziom' => 31, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 8,'ataki' => '471,1;541,1;108,1;189,1;531,1;80,5;379,13;289,17;524,23;394,25;483,29;222,31;470,37;608,41;376,47;396,55;60,59;408,63;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    50 => ['id_poka' => 50, 'nazwa' => 'Diglett', 'min_poziom' => 1, 'ewolucja_p' => 51, 'typ1' => 12, 'typ2' => 0,'ataki' => '451,1;446,1;215,4;24,7;342,12;310,15;62,18;527,23;339,26;135,29;107,34;482,37;136,40;171,45;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    51 => ['id_poka' => 51, 'nazwa' => 'Dugtrio', 'min_poziom' => 26, 'ewolucja_p' => 0, 'typ1' => 12, 'typ2' => 0,'ataki' => '441,1;351,1;566,1;451,1;446,1;215,1;24,7;342,12;310,15;62,18;527,23;447,26;339,28;135,33;107,40;482,45;136,50;171,57;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    52 => ['id_poka' => 52, 'nazwa' => 'Meowth', 'min_poziom' => 1, 'ewolucja_p' => 53, 'typ1' => 1, 'typ2' => 0,'ataki' => '451,1;215,1;41,6;158,9;199,14;452,17;163,22;574,25;365,30;482,33;345,38;23,41;67,46;350,49;162,50;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    53 => ['id_poka' => 53, 'nazwa' => 'Persian', 'min_poziom' => 28, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '374,1;451,1;215,1;41,1;158,1;199,14;452,17;163,22;536,28;385,32;482,37;345,44;23,49;67,56;351,61;162,65;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    54 => ['id_poka' => 54, 'nazwa' => 'Psyduck', 'min_poziom' => 1, 'ewolucja_p' => 55, 'typ1' => 3, 'typ2' => 0,'ataki' => '451,1;544,4;584,8;81,11;199,15;585,18;108,22;452,25;18,29;608,32;395,39;14,43;252,46;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    55 => ['id_poka' => 55, 'nazwa' => 'Golduck', 'min_poziom' => 33, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '16,1;451,1;544,1;584,1;81,11;199,15;585,18;108,22;608,25;452,29;18,32;395,43;14,49;252,54;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    56 => ['id_poka' => 56, 'nazwa' => 'Mankey', 'min_poziom' => 1, 'ewolucja_p' => 57, 'typ1' => 10, 'typ2' => 0,'ataki' => '90,1;451,1;297,1;291,1;185,1;199,9;278,13;458,17;452,21;23,25;532,33;93,37;553,41;403,45;76,49;166,53;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    57 => ['id_poka' => 57, 'nazwa' => 'Primeape', 'min_poziom' => 28, 'ewolucja_p' => 0, 'typ1' => 10, 'typ2' => 0,'ataki' => '181,1;451,1;297,1;291,1;185,1;199,9;278,13;458,17;452,21;23,25;609,28;532,35;93,41;553,47;403,53;76,59;166,63;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    58 => ['id_poka' => 58, 'nazwa' => 'Growlithe', 'min_poziom' => 1, 'ewolucja_p' => 59, 'typ1' => 2, 'typ2' => 0,'ataki' => '41,1;145,6;291,8;357,10;175,17;546,23;173,28;10,30;423,32;176,34;95,39;239,41;360,43;177,45;', 'wymagania' => 1, 'trudnosc' => 4, 'plec_k' => 250, 'plec_m' => 750],
    59 => ['id_poka' => 59, 'nazwa' => 'Arcanine', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '555,1;41,1;357,1;168,1;154,24;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 250, 'plec_m' => 750],
    60 => ['id_poka' => 60, 'nazwa' => 'Poliwag', 'min_poziom' => 1, 'ewolucja_p' => 61, 'typ1' => 3, 'typ2' => 0,'ataki' => '584,5;258,8;57,11;116,15;47,21;58,25;340,28;37,31;583,25;252,28;339,41;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    61 => ['id_poka' => 61, 'nazwa' => 'Poliwhirl', 'min_poziom' => 25, 'ewolucja_p' => 62000186, 'typ1' => 3, 'typ2' => 0,'ataki' => '584,1;258,1;57,11;116,15;47,21;58,27;342,32;37,37;583,43;252,48;339,53;', 'wymagania' => 2, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    62 => ['id_poka' => 62, 'nazwa' => 'Poliwrath', 'min_poziom' => 26, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 10,'ataki' => '58,1;258,1;116,1;525,1;134,32;73,53;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    63 => ['id_poka' => 63, 'nazwa' => 'Abra', 'min_poziom' => 1, 'ewolucja_p' => 64, 'typ1' => 7, 'typ2' => 0,'ataki' => '551,1;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 250, 'plec_m' => 750],
    64 => ['id_poka' => 64, 'nazwa' => 'Kadabra', 'min_poziom' => 16, 'ewolucja_p' => 65, 'typ1' => 7, 'typ2' => 0,'ataki' => '551,1;279,1;81,1;108,18;394,21;398,28;416,31;396,38;202,43;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 250, 'plec_m' => 750],
    65 => ['id_poka' => 65, 'nazwa' => 'Alakazam', 'min_poziom' => 17, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '551,1;279,1;81,1;108,18;394,21;398,28;416,31;396,38;65,41;202,43;', 'wymagania' => 1, 'trudnosc' => 10, 'plec_k' => 250, 'plec_m' => 750],
    66 => ['id_poka' => 66, 'nazwa' => 'Machop', 'min_poziom' => 1, 'ewolucja_p' => 67, 'typ1' => 10, 'typ2' => 0,'ataki' => '297,1;291,1;185,3;278,7;189,9;298,13;458,15;425,19;281,21;581,25;583,27;133,31;525,33;61,37;93,39;450,43;134,45;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 250, 'plec_m' => 750],
    67 => ['id_poka' => 67, 'nazwa' => 'Machoke', 'min_poziom' => 28, 'ewolucja_p' => 68, 'typ1' => 10, 'typ2' => 0,'ataki' => '297,1;291,1;185,1;278,1;189,9;298,13;458,15;425,19;281,21;581,25;583,27;133,33;525,37;61,43;93,47;450,53;134,57;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 250, 'plec_m' => 750],
    68 => ['id_poka' => 68, 'nazwa' => 'Machamp', 'min_poziom' => 29, 'ewolucja_p' => 0, 'typ1' => 10, 'typ2' => 0,'ataki' => '297,1;291,1;185,1;278,1;189,9;298,13;458,15;425,19;281,21;581,25;583,27;133,33;525,37;61,43;93,47;450,53;134,57;', 'wymagania' => 1, 'trudnosc' => 10, 'plec_k' => 250, 'plec_m' => 750],
    69 => ['id_poka' => 69, 'nazwa' => 'Bellsprout', 'min_poziom' => 1, 'ewolucja_p' => 70, 'typ1' => 4, 'typ2' => 8,'ataki' => '580,1;216,7;603,11;483,13;379,15;524,17;2,23;281,27;535,29;413,39;481,41;604,47;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    70 => ['id_poka' => 70, 'nazwa' => 'Weepinbell', 'min_poziom' => 21, 'ewolucja_p' => 71, 'typ1' => 4, 'typ2' => 8,'ataki' => '580,1;216,1;603,1;483,13;379,15;524,17;2,23;281,27;535,29;413,39;481,41;604,47;', 'wymagania' => 4, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    71 => ['id_poka' => 71, 'nazwa' => 'Victreebel', 'min_poziom' => 22, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 8,'ataki' => '516,1;505,1;580,1;483,1;535,1;413,1;288,27;287,47;286,47;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    72 => ['id_poka' => 72, 'nazwa' => 'Tentacool', 'min_poziom' => 1, 'ewolucja_p' => 73, 'typ1' => 3, 'typ2' => 8,'ataki' => '380,1;531,4;82,7;2,10;564,13;585,16;603,19;4,22;58,25;33,28;378,31;56,34;452,37;242,40;487,43;252,46;604,49;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    73 => ['id_poka' => 73, 'nazwa' => 'Tentacruel', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 8,'ataki' => '380,1;531,1;82,1;2,1;564,13;585,16;603,19;4,22;58,25;33,28;378,32;56,36;452,40;242,44;487,48;252,52;604,56;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    74 => ['id_poka' => 74, 'nazwa' => 'Geodude', 'min_poziom' => 1, 'ewolucja_p' => 75, 'typ1' => 13, 'typ2' => 12,'ataki' => '541,1;102,1;431,6;439,10;310,12;434,16;488,18;62,22;459,24;429,30;136,34;152,36;282,40;518,42;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    75 => ['id_poka' => 75, 'nazwa' => 'Graveler', 'min_poziom' => 25, 'ewolucja_p' => 76, 'typ1' => 13, 'typ2' => 12,'ataki' => '541,1;102,1;431,1;439,10;310,12;434,16;488,18;62,22;459,24;429,34;136,40;152,44;282,50;518,54;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    76 => ['id_poka' => 76, 'nazwa' => 'Golem', 'min_poziom' => 26, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 12,'ataki' => '541,1;102,1;431,1;513,10;310,12;434,16;488,18;62,22;459,24;429,34;136,40;152,44;282,50;518,54;240,60;', 'wymagania' => 1, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    77 => ['id_poka' => 77, 'nazwa' => 'Ponyta', 'min_poziom' => 1, 'ewolucja_p' => 78, 'typ1' => 2, 'typ2' => 0,'ataki' => '541,1;215,1;544,4;145,9;175,13;517,17;174,21;170,25;546,29;270,33;10,37;167,41;53,45;177,49;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    78 => ['id_poka' => 78, 'nazwa' => 'Rapidash', 'min_poziom' => 40, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '378,1;318,1;215,1;406,1;544,1;145,1;175,13;517,17;174,21;170,25;546,29;270,33;10,37;197,40;167,41;53,45;177,49;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    79 => ['id_poka' => 79, 'nazwa' => 'Slowpoke', 'min_poziom' => 1, 'ewolucja_p' => 80000199, 'typ1' => 3, 'typ2' => 7,'ataki' => '98,1;606,1;541,1;215,5;584,9;81,14;108,19;230,23;585,28;608,32;480,36;14,41;396,45;395,54;234,58;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    80 => ['id_poka' => 80, 'nazwa' => 'Slowbro', 'min_poziom' => 37, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 7,'ataki' => '98,1;541,1;606,1;215,1;584,9;81,14;108,19;230,23;585,28;608,32;480,36;598,37;14,43;396,49;395,62;234,68;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    81 => ['id_poka' => 81, 'nazwa' => 'Magnemite', 'min_poziom' => 1, 'ewolucja_p' => 82, 'typ1' => 5, 'typ2' => 11,'ataki' => '541,1;531,5;557,7;498,11;558,13;307,17;500,19;332,23;322,25;142,29;179,31;452,35;110,37;223,47;607,49;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 0, 'plec_m' => 0],
    82 => ['id_poka' => 82, 'nazwa' => 'Magneton', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 11,'ataki' => '541,1;531,1;557,1;498,1;558,13;307,17;500,19;332,23;322,25;143,29;566,30;179,33;452,39;110,43;223,59;607,63;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    83 => ['id_poka' => 83, 'nazwa' => 'Farfetch\'d', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 6,'ataki' => '378,1;367,1;446,1;291,1;198,1;7,9;281,13;482,19;11,21;538,25;10,31;351,33;5,37;162,43;160,45;12,49;54,53;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    84 => ['id_poka' => 84, 'nazwa' => 'Doduo', 'min_poziom' => 1, 'ewolucja_p' => 85, 'typ1' => 1, 'typ2' => 6,'ataki' => '367,1;215,1;406,5;609,9;197,13;404,17;375,21;114,25;6,29;10,33;131,37;575,41;147,45;553,49;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    85 => ['id_poka' => 85, 'nazwa' => 'Dodrio', 'min_poziom' => 31, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 6,'ataki' => '367,1;215,1;406,1;609,1;197,13;404,17;375,21;566,25;6,29;10,35;131,41;575,47;147,53;553,59;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    86 => ['id_poka' => 86, 'nazwa' => 'Seel', 'min_poziom' => 1, 'ewolucja_p' => 87, 'typ1' => 3, 'typ2' => 0,'ataki' => '230,1;215,3;267,11;264,17;422,21;17,23;28,27;16,31;56,33;546,37;111,41;18,43;260,47;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    87 => ['id_poka' => 87, 'nazwa' => 'Dewgong', 'min_poziom' => 34, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 14,'ataki' => '230,1;215,1;470,1;267,1;264,17;422,21;16,23;28,27;16,31;56,33;466,34;546,39;111,45;18,49;260,55;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    88 => ['id_poka' => 88, 'nazwa' => 'Grimer', 'min_poziom' => 1, 'ewolucja_p' => 89, 'typ1' => 8, 'typ2' => 0,'ataki' => '382,1;377,1;226,4;342,7;108,12;485,15;339,18;328,21;181,26;486,29;487,32;452,37;221,40;3,43;36,46;319,48;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    89 => ['id_poka' => 89, 'nazwa' => 'Muk', 'min_poziom' => 38, 'ewolucja_p' => 0, 'typ1' => 8, 'typ2' => 0,'ataki' => '382,1;377,1;226,1;342,1;108,12;485,15;339,18;328,21;181,26;286,29;487,32;452,37;577,38;221,40;3,46;36,52;319,57;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    90 => ['id_poka' => 90, 'nazwa' => 'Shellder', 'min_poziom' => 1, 'ewolucja_p' => 91, 'typ1' => 3, 'typ2' => 0,'ataki' => '541,1;598,4;531,8;265,13;393,16;291,20;74,25;264,28;414,32;28,37;591,40;56,44;273,49;260,52;467,56;252,61;', 'wymagania' => 2, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    91 => ['id_poka' => 91, 'nazwa' => 'Cloyster', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 14,'ataki' => '252,1;467,1;564,1;598,1;531,1;393,1;28,1;502,13;503,28;265,50;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    92 => ['id_poka' => 92, 'nazwa' => 'Gastly', 'min_poziom' => 1, 'ewolucja_p' => 93, 'typ1' => 9, 'typ2' => 8,'ataki' => '258,1;292,1;98,12;350,15;80,19;527,22;366,26;460,29;130,33;99, 36;104,40;242,43;352,47;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    93 => ['id_poka' => 93, 'nazwa' => 'Haunter', 'min_poziom' => 25, 'ewolucja_p' => 94, 'typ1' => 9, 'typ2' => 8,'ataki' => '258,1;292,1;98,12;350,15;80,19;527,22;463,25;366,28;460,33;130,39;99,44;104,50;242,55;352,61;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    94 => ['id_poka' => 94, 'nazwa' => 'Gengar', 'min_poziom' => 26, 'ewolucja_p' => 0, 'typ1' => 9, 'typ2' => 8,'ataki' => '258,1;292,1;98,12;350,15;80,19;527,22;463,25;366,28;460,33;130,39;99,44;104,50,242,55;352,61;', 'wymagania' => 1, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    95 => ['id_poka' => 95, 'nazwa' => 'Onix', 'min_poziom' => 1, 'ewolucja_p' => 208, 'typ1' => 13, 'typ2' => 12,'ataki' => '541,1;226,1;40,1;98,4;434,7;435,10;609,13;431,19;223,20;488,22;121,25;481,28;452,31;432,34;447,37;275,40;107,43;518,46;282,49;', 'wymagania' => 990, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    96 => ['id_poka' => 96, 'nazwa' => 'Drowzee', 'min_poziom' => 1, 'ewolucja_p' => 97, 'typ1' => 7, 'typ2' => 0,'ataki' => '382,1;258,1;108,5;81,9;230,13;377,17;314,21;394,25;395,33;539,37;608,41;532,45;396,49;345,53;400,57;202,61;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    97 => ['id_poka' => 97, 'nazwa' => 'Hypno', 'min_poziom' => 26, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '345,1;352,1;382,1;258,1;108,1;81,1;230,13;377,17;314,21;394,25;395,33;539,37;608,41;532,45;396,49;400,57;202,61;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    98 => ['id_poka' => 98, 'nazwa' => 'Krabby', 'min_poziom' => 1, 'ewolucja_p' => 99, 'typ1' => 3, 'typ2' => 0,'ataki' => '57,1;579,5;291,9;226,11;58,15;340,19;321,21;517,25;393,29;220,21;481,35;56,39;91,41;172,45;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    99 => ['id_poka' => 99, 'nazwa' => 'Kingler', 'min_poziom' => 28, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '57,1;579,1;291,1;226,11;58,15;340,19;321,21;517,25;393,32;220,37;481,44;56,51;91,56;172,63;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    100 => ['id_poka' => 100, 'nazwa' => 'Voltorb', 'min_poziom' => 1, 'ewolucja_p' => 101, 'typ1' => 5, 'typ2' => 0,'ataki' => '68,1;541,1;498,4;138,6;500,9;439,11;452,13;69,16;536,20;142,22;459,26;294,29;110,37;152,41;223,46;330,48;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 0, 'plec_m' => 0],
    101 => ['id_poka' => 101, 'nazwa' => 'Electrode', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 0,'ataki' => '309,1;68,1;541,1;498,1;500,1;138,6;439,11;452,13;69,16;536,20;142,22;459,26;294,29;110,41;152,47;223,54;330,58;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 0, 'plec_m' => 0],
    102 => ['id_poka' => 102, 'nazwa' => 'Exeggcute', 'min_poziom' => 1, 'ewolucja_p' => 103, 'typ1' => 4, 'typ2' => 7,'ataki' => '32,1;575,1;258,1;290,11;64,17;524,19;379,21;483,23;81,27;346,37;497,43;153,47;', 'wymagania' => 4, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    103 => ['id_poka' => 103, 'nazwa' => 'Exeggutor', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 7,'ataki' => '456,1;32,1;258,1;81,1;517,1;400,17;139,27;600,37;287,47;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    104 => ['id_poka' => 104, 'nazwa' => 'Cubone', 'min_poziom' => 1, 'ewolucja_p' => 105, 'typ1' => 12, 'typ2' => 0,'ataki' => '215,1;544,3;49,7;230,11;291,13;185,17;51,21;609,23;160,27;553,31;181,33;50,37;147,41;282,43;423,47;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    105 => ['id_poka' => 105, 'nazwa' => 'Marowak', 'min_poziom' => 28, 'ewolucja_p' => 0, 'typ1' => 12, 'typ2' => 0,'ataki' => '215,1;544,1;49,1;230,1;291,13;185,17;51,21;609,23;160,27;553,33;181,37;50,43;147,49;282,53;423,59;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    106 => ['id_poka' => 106, 'nazwa' => 'Hitmonlee', 'min_poziom' => 2, 'ewolucja_p' => 236, 'typ1' => 10, 'typ2' => 0,'ataki' => '425,1;115,1;314,5;438,9;277,13;55,17;185,21;162,25;244,29;189,37;43,35;316,53;76,57;426,61;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 0, 'plec_m' => 1000],
    107 => ['id_poka' => 107, 'nazwa' => 'Hitmonchan', 'min_poziom' => 2, 'ewolucja_p' => 236, 'typ1' => 10, 'typ2' => 0,'ataki' => '425,1;78,1;10,6;404,11;302,16;63,16;162,21;576,26;556,36;263,36;169,36;479,41;317,46;105,50;186,56;89,61;76,66;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 0, 'plec_m' => 1000],
    108 => ['id_poka' => 108, 'nazwa' => 'Lickitung', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '292,1;531,5;102,9;281,13;603,17;517,21;108,25;481,29;439,33;72,37;420,45;452,49;389,53;604,57;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    109 => ['id_poka' => 109, 'nazwa' => 'Koffing', 'min_poziom' => 1, 'ewolucja_p' => 110, 'typ1' => 8, 'typ2' => 0,'ataki' => '377,1;541,1;490,4;491,7;23,12;75,15;485,18;459,23;227,26;223,29;486,34;152,37;104,40;36,42;319,45;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    110 => ['id_poka' => 110, 'nazwa' => 'Weezing', 'min_poziom' => 35, 'ewolucja_p' => 0, 'typ1' => 8, 'typ2' => 0,'ataki' => '541,1;377,1;490,1;491,1;23,7;75,15;485,18;459,23;227,26;114,29;486,34;152,40;104,46;36,51;319,57;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    111 => ['id_poka' => 111, 'nazwa' => 'Rhyhorn', 'min_poziom' => 1, 'ewolucja_p' => 112, 'typ1' => 13, 'typ2' => 12,'ataki' => '246,1;544,1;197,5;450,9;488,13;517,17;62,21;72,25;429,29;132,33;546,37;518,41;136,45;318,49;247,53;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    112 => ['id_poka' => 112, 'nazwa' => 'Rhydon', 'min_poziom' => 42, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 12,'ataki' => '246,1;544,1;197,1;450,1;488,13;517,17;62,21;72,25;429,29;132,33;546,37;518,41;225,42;136,48;318,55;247,62;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    113 => ['id_poka' => 113, 'nazwa' => 'Chansey', 'min_poziom' => 1, 'ewolucja_p' => 242, 'typ1' => 1, 'typ2' => 0,'ataki' => '282,1;102,1;382,1;215,1;544,5;420,9;116,12;496,16;328,23;546,27;473,31;181,34;234,38;139,42;294,46;235,50;', 'wymagania' => 998, 'trudnosc' => 6, 'plec_k' => 1000, 'plec_m' => 0],
    114 => ['id_poka' => 114, 'nazwa' => 'Tangela', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 0,'ataki' => '271,1;82,1;483,4;580,7;1,10;379,14;40,17;216,20;315,23;281,27;524,30;346,33;206,36;15,38;481,41;560,44;604,46;389,50;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    115 => ['id_poka' => 115, 'nazwa' => 'Kanghaskan', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '78,1;291,1;158,7;544,10;41,13;114,19;609,22;317,25;72,31;112,34;95,37;360,46;527,49;426,50;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 1000, 'plec_m' => 0],
    116 => ['id_poka' => 116, 'nazwa' => 'Horsea', 'min_poziom' => 1, 'ewolucja_p' => 117, 'typ1' => 3, 'typ2' => 0,'ataki' => '57,1;491,5;291,9;584,13;573,17;58,21;185,26;56,31;10,36;124,41;123,46;252,52;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    117 => ['id_poka' => 117, 'nazwa' => 'Seadra', 'min_poziom' => 32, 'ewolucja_p' => 230, 'typ1' => 3, 'typ2' => 0,'ataki' => '57,1;491,1;291,1;584,1;473,17;58,21;185,26;56,31;10,38;124,45;123,52;252,60;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    118 => ['id_poka' => 118, 'nazwa' => 'Goldeen', 'min_poziom' => 1, 'ewolucja_p' => 119, 'typ1' => 3, 'typ2' => 0,'ataki' => '367,1;544,1;531,5;246,8;172,13;585,16;17,21;197,24;10,29;589,32;247,37;318,45;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    119 => ['id_poka' => 119, 'nazwa' => 'Seaking', 'min_poziom' => 33, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '378,1;367,1;544,1;531,1;246,8;172,13;585,16;17,21;197,24;10,29;589,32;247,40;318,54;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    120 => ['id_poka' => 120, 'nazwa' => 'Staryu', 'min_poziom' => 1, 'ewolucja_p' => 121, 'typ1' => 3, 'typ2' => 0,'ataki' => '541,1;226,1;584,4;412,7;416,10;402,13;536,16;58,18;223,24;56,28;328,31;385,37;80,40;396,42;294,46;86,49;252,53;', 'wymagania' => 2, 'trudnosc' => 3, 'plec_k' => 0, 'plec_m' => 0],
    121 => ['id_poka' => 121, 'nazwa' => 'Starmie', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 7,'ataki' => '252,1;584,1;412,1;416,1;536,1;80,40;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    122 => ['id_poka' => 122, 'nazwa' => 'Mr.Mime', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '305,1;33,1;81,1;314,8;116,11;326,15;402,15;294,22;394,25;396,39;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    123 => ['id_poka' => 123, 'nazwa' => 'Scyther', 'min_poziom' => 1, 'ewolucja_p' => 212, 'typ1' => 16, 'typ2' => 6,'ataki' => '576,1;406,1;291,1;185,5;404,9;160,13;10,17;596,21;198,25;482,29;415,33;117,37;605,41;351,45;114,49;12,50;538,57;162,61;', 'wymagania' => 990, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    124 => ['id_poka' => 124, 'nazwa' => 'Jynx', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 14, 'typ2' => 7,'ataki' => '129,1;382,1;292,5;296,8;384,11;116,15;263,18;236,21;159,28;583,33;30,39;47,44;604,49;368,55;44,60;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 1000, 'plec_m' => 0],
    125 => ['id_poka' => 125, 'nazwa' => 'Electabuzz', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 0,'ataki' => '406,1;291,1;557,5;297,8;536,12;469,15;558,19;142,22;294,26;556,29;110,36;452,42;559,49;554,55;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 250, 'plec_m' => 750],
    126 => ['id_poka' => 126, 'nazwa' => 'Magmar', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '490,1;291,1;145,5;491,8;163,12;170,15;75,19;173,22;80,26;169,29;285,36;176,49;167,55;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 250, 'plec_m' => 750],
    127 => ['id_poka' => 127, 'nazwa' => 'Pinsir', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 0,'ataki' => '579,1;185,1;40,4;458,8;226,11;425,15;581,18;114,22;55,26;525,29;605,33;520,36;538,40;553,43;530,47;220,50;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    128 => ['id_poka' => 128, 'nazwa' => 'Tauros', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '541,1;544,3;609,5;246,8;450,11;404,15;422,19;366,24;601,29;608,35;546,41;532,48;553,50;207,63;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 1000],
    129 => ['id_poka' => 129, 'nazwa' => 'Magikarp', 'min_poziom' => 1, 'ewolucja_p' => 130, 'typ1' => 3, 'typ2' => 0,'ataki' => '507,1;541,15;172,30;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    130 => ['id_poka' => 130, 'nazwa' => 'Gyarados', 'min_poziom' => 20, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 6,'ataki' => '553,1;41,20;125,23;291,26;573,29;262,32;18,35;95,41;252,44;123,47;253,50;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    131 => ['id_poka' => 131, 'nazwa' => 'Lapras', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 14,'ataki' => '473,1;215,1;584,1;333,4;80,7;585,14;47,18;368,27;260,32;56,37;252,47;466,50;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    132 => ['id_poka' => 132, 'nazwa' => 'Ditto', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '565,1;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    133 => ['id_poka' => 133, 'nazwa' => 'Eevee', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '215,1;541,1;544,1;446,5;31,9;536,10;406,13;41,17;420,20;90,23;546,25;70,29;282,37;284,41;571,45;', 'wymagania' => 123, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    134 => ['id_poka' => 134, 'nazwa' => 'Vaporeon', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '541,1;544,1;446,5;584,9;406,13;585,17;28,20;17,25;3,29;227,33;343,37;284,41;252,45;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    135 => ['id_poka' => 135, 'nazwa' => 'Jolteon', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 0,'ataki' => '541,1;544,1;446,5;557,9;406,13;115,17;555,20;372,25;10,29;558,33;110,37;284,41;554,45;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    136 => ['id_poka' => 136, 'nazwa' => 'Flareon', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '541,1;544,1;446,5;145,9;406,13;41,17;168,20;170,25;450,29;490,33;285,37;284,41;177,45;', 'wymagania' => 999, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    137 => ['id_poka' => 137, 'nazwa' => 'Porygon', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '83,1;84,1;541,1;465,1;394,7;10,12;416,18;470,29;110,40;566,50;607,62;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 0, 'plec_m' => 0],
    138 => ['id_poka' => 138, 'nazwa' => 'Omanyte', 'min_poziom' => 1, 'ewolucja_p' => 139, 'typ1' => 13, 'typ2' => 3,'ataki' => '82,1;598,1;41,7;584,10;439,16;291,19;340,25;56,28;393,34;15,37;560,43;429,46;467,50;252,55;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    139 => ['id_poka' => 139, 'nazwa' => 'Omastar', 'min_poziom' => 40, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 3,'ataki' => '82,1;598,1;41,7;584,10;439,16;291,19;340,25;56,28;393,34;15,37;502,40;560,48;429,56;467,67;252,75;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    140 => ['id_poka' => 140, 'nazwa' => 'Kabuto', 'min_poziom' => 1, 'ewolucja_p' => 141, 'typ1' => 13, 'typ2' => 3,'ataki' => '451,1;226,1;1,6;291,11;340,16;446,21;16,31;315,36;322,41;15,46;604,50;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    141 => ['id_poka' => 141, 'nazwa' => 'Kabutops', 'min_poziom' => 40, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 3,'ataki' => '162,1;451,1;226,1;1,6;291,11;340,16;446,21;16,31;315,36;482,40;322,45;15,54;604,63;351,72;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    142 => ['id_poka' => 142, 'nazwa' => 'Aerodactyl', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 6,'ataki' => '261,1;168,1;555,1;596,1;531,1;41,1;450,1;10,17;15,25;95,33;546,41;478,49;271,57;253,65;432,73;207,81;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    143 => ['id_poka' => 143, 'nazwa' => 'Snorlax', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '541,1;102,4;14,9;292,12;72,17;606,20;47,25;422,28;494,28;439,36;37,44;95,49;240,50;207,57;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    144 => ['id_poka' => 144, 'nazwa' => 'Articuno', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 14, 'typ2' => 6,'ataki' => '193,1;222,1;384,1;333,8;264,15;15,29;10,36;260,43;545,64;44,71;466,78;440,85;250,92;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    145 => ['id_poka' => 145, 'nazwa' => 'Zapdos', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 6,'ataki' => '367,1;557,1;558,8;105,15;375,22;15,29;68,36;10,43;110,50;294,64;131,71;554,78;440,85;607,92;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    146 => ['id_poka' => 146, 'nazwa' => 'Moltres', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 6,'ataki' => '596,1;145,1;170,8;10,15;15,29;176,36;12,50;239,64;497,71;477,78;440,85;250,92;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    147 => ['id_poka' => 147, 'nazwa' => 'Dratini', 'min_poziom' => 1, 'ewolucja_p' => 148, 'typ1' => 17, 'typ2' => 0,'ataki' => '603,1;291,1;558,5;573,11;125,15;481,21;10,25;127,31;18,35;126,41;123,51;360,55;253,61;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    148 => ['id_poka' => 148, 'nazwa' => 'Dragonair', 'min_poziom' => 30, 'ewolucja_p' => 149, 'typ1' => 17, 'typ2' => 0,'ataki' => '603,1;291,1;558,5;573,11;125,15;481,21;10,25;127,33;18,39;126,47;123,61;360,67;253,75;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    149 => ['id_poka' => 149, 'nazwa' => 'Dragonite', 'min_poziom' => 55, 'ewolucja_p' => 0, 'typ1' => 17, 'typ2' => 6,'ataki' => '169,1;556,1;440,1;603,1;291,1;558,5;573,11;125,15;481,21;10,25;127,33;18,39;126,47;596,55;123,61;360,67;253,75;250,81;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    150 => ['id_poka' => 150, 'nazwa' => 'Mewtwo', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '81,1;108,1;536,8;202,15;395,22;298,36;416,50;396,57;33,64;27,70;14,79;333,86;401,100;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    151 => ['id_poka' => 151, 'nazwa' => 'Mew', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '382,1;565,1;317,10;324,20;396,30;33,40;15,50;14,60;345,90;27,100;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    152 => ['id_poka' => 152, 'nazwa' => 'Chikorita', 'min_poziom' => 1, 'ewolucja_p' => 153, 'typ1' => 4, 'typ2' => 0,'ataki' => '541,1;215,1;413,6;379,9;540,12;418,17;305,20;346,23;535,28;294,31;47,34;20,42;497,45;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 125, 'plec_m' => 875],
    153 => ['id_poka' => 153, 'nazwa' => 'Bayleef', 'min_poziom' => 16, 'ewolucja_p' => 154, 'typ1' => 4, 'typ2' => 0,'ataki' => '379,1;413,1;215,1;541,1;540,12;418,18;305,22;346,26;535,32;294,36;47,40;20,50;497,54;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 125, 'plec_m' => 875],
    154 => ['id_poka' => 154, 'nazwa' => 'Meganium', 'min_poziom' => 32, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 0,'ataki' => '541,1;369,1;215,1;413,1;379,1;540,12;418,18;305,22;346,26;370,32;535,34;294,40;47,46;20,60;497,66;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 125, 'plec_m' => 875],
    155 => ['id_poka' => 155, 'nazwa' => 'Cyndaquil', 'min_poziom' => 1, 'ewolucja_p' => 156, 'typ1' => 2, 'typ2' => 0,'ataki' => '541,1;291,1;491,6;145,10;406,13;175,19;102,22;174,28;536,31;285,37;176,40;270,46;439,49;282,55;151,58;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 125, 'plec_m' => 875],
    156 => ['id_poka' => 156, 'nazwa' => 'Quilava', 'min_poziom' => 14, 'ewolucja_p' => 157, 'typ1' => 2, 'typ2' => 0,'ataki' => '541,1;291,1;491,1;145,10;406,13;175,20;102,24;536,31;174,35;285,42;176,46;270,53;439,57;282,64;151,68;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 125, 'plec_m' => 875],
    157 => ['id_poka' => 157, 'nazwa' => 'Typhlosion', 'min_poziom' => 36, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '291,1;151,1;223,1;541,1;282,1;145,1;491,1;406,13;175,20;102,24;536,31;174,35;285,43;176,48;270,56;439,61;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 125, 'plec_m' => 875],
    158 => ['id_poka' => 158, 'nazwa' => 'Totodile', 'min_poziom' => 1, 'ewolucja_p' => 159, 'typ1' => 3, 'typ2' => 0,'ataki' => '291,1;451,1;584,6;609,8;41,13;450,15;262,20;172,22;95,27;72,29;482,34;452,36;553,41;18,43;530,48;252,50;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 125, 'plec_m' => 875],
    159 => ['id_poka' => 159, 'nazwa' => 'Croconaw', 'min_poziom' => 18, 'ewolucja_p' => 160, 'typ1' => 3, 'typ2' => 0,'ataki' => '451,1;291,1;584,1;609,8;41,13;450,15;262,21;172,24;95,30;72,33;482,39;452,42;553,48;18,51;530,57;252,60;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 125, 'plec_m' => 875],
    160 => ['id_poka' => 160, 'nazwa' => 'Feraligatr', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '291,1;451,1;609,1;584,1;41,13;450,15;262,21;172,24;10,30;95,32;72,37;482,45;452,50;553,58;18,63;530,71;252,76;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 125, 'plec_m' => 875],
    161 => ['id_poka' => 161, 'nazwa' => 'Sentret', 'min_poziom' => 1, 'ewolucja_p' => 162, 'typ1' => 1, 'typ2' => 0,'ataki' => '451,1;189,1;102,4;406,7;199,13;241,16;187,19;481,25;422,28;527,31;14,36;312,42;255,47;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    162 => ['id_poka' => 162, 'nazwa' => 'Furret', 'min_poziom' => 15, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '189,1;102,1;406,1;451,1;199,13;241,17;187,21;481,28;422,32;527,36;14,42;312,50;255,56;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    163 => ['id_poka' => 163, 'nazwa' => 'Hoothoot', 'min_poziom' => 1, 'ewolucja_p' => 164, 'typ1' => 1, 'typ2' => 6,'ataki' => '541,1;215,1;189,1;258,5;367,9;575,13;418,17;81,21;137,25;546,29;12,33;608,37;539,41;153,45;399,49;440,53;130,57;546,29;541,1;541,1;541,1;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    164 => ['id_poka' => 164, 'nazwa' => 'Noctowl', 'min_poziom' => 20, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 6,'ataki' => '258,1;215,1;541,1;130,1;477,1;189,1;367,9;575,13;418,17;81,22;137,27;546,32;12,37;608,42;539,47;153,52;399,57;440,62;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    165 => ['id_poka' => 165, 'nazwa' => 'Ledyba', 'min_poziom' => 1, 'ewolucja_p' => 166, 'typ1' => 16, 'typ2' => 6,'ataki' => '541,1;531,6;78,9;418,14;294,14;302,17;471,25;10,30;536,33;282,38;60,41;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    166 => ['id_poka' => 166, 'nazwa' => 'Ledian', 'min_poziom' => 18, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 6,'ataki' => '78,1;531,1;541,1;418,14;294,14;302,17;471,29;10,36;536,41;282,48;60,53;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    167 => ['id_poka' => 167, 'nazwa' => 'Spinarak', 'min_poziom' => 1, 'ewolucja_p' => 168, 'typ1' => 16, 'typ2' => 8,'ataki' => '380,1;521,1;450,5;82,8;289,12;350,15;464,19;199,22;527,26;501,29;10,33;372,36;396,40;378,43;94,47;515,50;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    168 => ['id_poka' => 168, 'nazwa' => 'Ariados', 'min_poziom' => 22, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 8,'ataki' => '59,1;450,1;82,1;521,1;164,1;380,1;577,1;289,12;350,15;464,19;199,23;527,28;501,32;10,37;372,41;396,46;378,50;94,55;515,58;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    169 => ['id_poka' => 169, 'nazwa' => 'Crobat', 'min_poziom' => 23, 'ewolucja_p' => 0, 'typ1' => 8, 'typ2' => 6,'ataki' => '41,1;94,1;24,1;531,1;452,1;289,1;596,13;80,17;11,19;536,24;376,27;5,35;227,40;578,43;12,48;407,51;', 'wymagania' => 998, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    170 => ['id_poka' => 170, 'nazwa' => 'Chinchou', 'min_poziom' => 1, 'ewolucja_p' => 171, 'typ1' => 3, 'typ2' => 5,'ataki' => '57,1;531,1;558,6;142,9;584,12;80,17;58,20;500,23;470,28;172,31;110,34;546,39;17,42;252,45;272,47;68,50;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    171 => ['id_poka' => 171, 'nazwa' => 'Lanturn', 'min_poziom' => 27, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 5,'ataki' => '138,1;142,1;531,1;558,1;57,1;584,12;80,17;58,20;500,23;516,27;533,27;505,27;470,29;172,33;110,37;546,43;17,47;252,51;272,54;68,58;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    172 => ['id_poka' => 172, 'nazwa' => 'Pichu', 'min_poziom' => 1, 'ewolucja_p' => 25, 'typ1' => 5, 'typ2' => 0,'ataki' => '557,1;70,1;544,5;534,10;345,13;558,18;558,18;', 'wymagania' => 998, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    173 => ['id_poka' => 173, 'nazwa' => 'Cleffa', 'min_poziom' => 1, 'ewolucja_p' => 35, 'typ1' => 18, 'typ2' => 0,'ataki' => '70,1;382,1;146,4;473,7;534,10;85,13;305,16;', 'wymagania' => 998, 'trudnosc' => 10, 'plec_k' => 750, 'plec_m' => 250],
    174 => ['id_poka' => 174, 'nazwa' => 'Igglybuff', 'min_poziom' => 39, 'ewolucja_p' => 39, 'typ1' => 1, 'typ2' => 18,'ataki' => '473,1;70,1;102,3;382,5;534,9;85,11;85,11;', 'wymagania' => 998, 'trudnosc' => 10, 'plec_k' => 250, 'plec_m' => 750],
    175 => ['id_poka' => 175, 'nazwa' => 'Togepi', 'min_poziom' => 1, 'ewolucja_p' => 176, 'typ1' => 18, 'typ2' => 0,'ataki' => '215,1;70,1;324,5;534,9;606,13;146,17;187,21;38,25;597,29;15,33;282,45;284,49;9,53;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    176 => ['id_poka' => 176, 'nazwa' => 'Togetic', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 18, 'typ2' => 6,'ataki' => '305,1;324,1;534,1;70,1;215,1;606,13;157,14;146,17;187,21;38,25;597,29;15,33;282,45;284,49;9,53;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    177 => ['id_poka' => 177, 'nazwa' => 'Natu', 'min_poziom' => 1, 'ewolucja_p' => 178, 'typ1' => 7, 'typ2' => 6,'ataki' => '367,1;291,1;350,6;551,9;299,12;519,17;358,20;80,23;597,28;396,33;329,36;399,39;202,44;219,47;387,47;312,50;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    178 => ['id_poka' => 178, 'nazwa' => 'Xatu', 'min_poziom' => 25, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 6,'ataki' => '291,1;350,1;545,1;367,1;551,1;299,12;519,17;358,20;80,23;12,25;597,29;396,35;329,39;399,43;202,49;219,53;387,53;312,57;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    179 => ['id_poka' => 179, 'nazwa' => 'Mareep', 'min_poziom' => 1, 'ewolucja_p' => 180, 'typ1' => 5, 'typ2' => 0,'ataki' => '541,1;215,1;558,4;557,8;88,11;68,15;546,18;142,22;80,25;385,29;110,32;87,36;470,39;294,43;554,46;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    180 => ['id_poka' => 180, 'nazwa' => 'Flaaffy', 'min_poziom' => 15, 'ewolucja_p' => 181, 'typ1' => 5, 'typ2' => 0,'ataki' => '541,1;215,1;558,1;557,1;88,11;68,16;546,20;142,25;80,29;385,34;110,38;87,43;470,47;294,52;554,56;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    181 => ['id_poka' => 181, 'nazwa' => 'Ampharos', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 0,'ataki' => '124,1;607,1;272,1;309,1;541,1;215,1;169,1;558,1;557,1;88,11;68,16;546,20;142,25;80,29;556,30;385,35;110,40;87,46;470,51;294,57;554,62;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    182 => ['id_poka' => 182, 'nazwa' => 'Bellossom', 'min_poziom' => 22, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 0,'ataki' => '287,1;535,1;315,1;528,1;524,1;286,1;305,24;369,49;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    183 => ['id_poka' => 183, 'nazwa' => 'Marill', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 18,'ataki' => '541,1;584,1;544,2;587,5;57,7;102,10;439,10;58,13;241,16;18,20;374,23;17,28;411,31;282,37;530,40;252,47;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    184 => ['id_poka' => 184, 'nazwa' => 'Azumarill', 'min_poziom' => 18, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 18,'ataki' => '541,1;584,1;587,1;544,1;57,7;102,10;439,10;58,13;241,16;18,21;374,25;17,31;411,35;282,42;530,46;252,55;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    185 => ['id_poka' => 185, 'nazwa' => 'Sudowoodo', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 0,'ataki' => '600,1;85,1;172,1;297,1;434,1;326,15;481,15;163,19;435,22;45,26;432,29;89,33;527,36;282,40;518,43;225,47;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    186 => ['id_poka' => 186, 'nazwa' => 'Politoed', 'min_poziom' => 26, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '58,1;368,1;258,1;116,1;532,27;53,37;255,48;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    187 => ['id_poka' => 187, 'nazwa' => 'Hoppip', 'min_poziom' => 1, 'ewolucja_p' => 188, 'typ1' => 4, 'typ2' => 6,'ataki' => '507,1;540,4;544,6;541,8;157,10;379,12;524,14;483,16;64,19;290,22;315,25;5,28;410,31;88,34;574,37;602,40;206,43;53,46;319,49;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    188 => ['id_poka' => 188, 'nazwa' => 'Skiploom', 'min_poziom' => 18, 'ewolucja_p' => 189, 'typ1' => 4, 'typ2' => 6,'ataki' => '507,1;540,1;544,1;541,1;157,10;379,12;524,14;483,16;64,20;290,24;315,28;5,32;410,36;88,40;574,44;602,48;206,52;53,56;319,60;206,43;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    189 => ['id_poka' => 189, 'nazwa' => 'Jumpluff', 'min_poziom' => 27, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 6,'ataki' => '540,1;507,1;544,1;541,1;157,10;379,12;524,14;483,16;64,20;290,24;315,29;5,34;410,39;88,44;574,49;602,54;206,59;53,64;319,69;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    190 => ['id_poka' => 190, 'nazwa' => 'Aipom', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '544,1;451,1;446,4;24,8;560,15;199,18;536,22;452,25;10,29;114,32;181,36;345,39;284,43;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    191 => ['id_poka' => 191, 'nazwa' => 'Sunkern', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 0,'ataki' => '1,1;216,1;271,4;212,7;315,10;290,13;413,16;602,19;206,22;147,25;540,28;346,31;497,34;282,37;528,40;456,43;', 'wymagania' => 6, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    192 => ['id_poka' => 192, 'nazwa' => 'Sunflora', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 4, 'typ2' => 0,'ataki' => '1,1;382,1;216,1;271,4;212,7;315,10;290,13;413,16;602,19;206,22;370,28;346,31;497,34;282,37;528,40;287,43;369,50;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    193 => ['id_poka' => 193, 'nazwa' => 'Yanma', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 6,'ataki' => '541,1;189,1;406,6;117,11;498,14;105,17;531,22;575,27;404,30;15,33;258,38;596,43;452,46;574,49;12,54;60,57;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    194 => ['id_poka' => 194, 'nazwa' => 'Wooper', 'min_poziom' => 1, 'ewolucja_p' => 195, 'typ1' => 3, 'typ2' => 12,'ataki' => '584,1;544,1;341,5;340,9;481,15;339,19;14,23;606,29;136,33;411,37;333,43;227,43;343,47;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    195 => ['id_poka' => 195, 'nazwa' => 'Quagsire', 'min_poziom' => 20, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 12,'ataki' => '341,1;584,1;544,1;340,9;481,15;339,19;14,24;606,31;136,36;411,41;333,48;227,48;343,53;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    196 => ['id_poka' => 196, 'nazwa' => 'Espeon', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '241,1;544,1;541,1;446,5;81,9;406,13;536,17;394,20;202,25;395,29;338,33;396,37;284,41;387,45;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    197 => ['id_poka' => 197, 'nazwa' => 'Umbreon', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 15, 'typ2' => 0,'ataki' => '241,1;541,1;544,1;446,5;404,9;406,13;80,17;163,20;23,25;452,29;337,33;284,41;219,45;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 125, 'plec_m' => 875],
    198 => ['id_poka' => 198, 'nazwa' => 'Murkrow', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 15, 'typ2' => 6,'ataki' => '367,1;24,1;404,5;227,11;596,15;350,21;23,25;547,31;163,35;191,45;545,50;527,55;562,61;405,65;405,65;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    199 => ['id_poka' => 199, 'nazwa' => 'Slowking', 'min_poziom' => 37, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 7,'ataki' => '98,1;234,1;541,1;606,1;385,1;243,1;215,5;584,9;81,14;108,19;230,23;585,28;608,32;345,36;532,41;396,45;571,49;395,54;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    200 => ['id_poka' => 200, 'nazwa' => 'Misdreavus', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 9, 'typ2' => 0,'ataki' => '215,1;402,1;506,5;24,10;80,14;242,22;394,28;362,32;366,37;460,41;368,46;217,50;385,55;385,55;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    201 => ['id_poka' => 201, 'nazwa' => 'Unown', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '243,1;243,1;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 0, 'plec_m' => 0],
    202 => ['id_poka' => 202, 'nazwa' => 'Wobbuffet', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 0,'ataki' => '89,1;330,1;104,1;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    203 => ['id_poka' => 203, 'nazwa' => 'Girafarig', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 7,'ataki' => '24,1;215,1;541,1;81,1;387,1;219,1;357,5;23,10;517,14;394,19;10,23;114,28;608,32;95,37;345,46;396,50;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    204 => ['id_poka' => 204, 'nazwa' => 'Pineco', 'min_poziom' => 1, 'ewolucja_p' => 205, 'typ1' => 16, 'typ2' => 0,'ataki' => '541,1;393,1;459,6;59,9;546,12;412,17;39,20;346,23;503,28;366,31;152,34;273,39;223,42;282,45;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    205 => ['id_poka' => 205, 'nazwa' => 'Forretress', 'min_poziom' => 31, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 11,'ataki' => '607,1;308,1;564,1;59,1;459,1;240,1;541,1;393,1;546,12;412,17;39,20;346,23;503,28;332,31;29,32;366,36;152,42;273,46;223,50;282,56;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    206 => ['id_poka' => 206, 'nazwa' => 'Dunsparce', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '609,1;102,1;439,4;506,7;404,10;452,13;606,16;15,19;546,22;440,25;209,28;107,31;282,34;77,37;148,40;132,43;147,46;172,49;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    207 => ['id_poka' => 207, 'nazwa' => 'Gligar', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 12, 'typ2' => 6,'ataki' => '380,1;446,4;226,7;281,10;406,13;198,16;163,19;5,22;482,27;574,30;452,35;605,40;479,45;538,50;220,55;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    208 => ['id_poka' => 208, 'nazwa' => 'Steelix', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 11, 'typ2' => 12,'ataki' => '555,1;262,1;168,1;341,1;541,1;226,1;40,1;98,4;434,7;435,10;609,13;511,16;29,19;223,20;488,22;121,25;481,28;452,31;432,34;95,37;275,40;107,43;518,46;282,49;448,52;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    209 => ['id_poka' => 209, 'nazwa' => 'Snubbull', 'min_poziom' => 1, 'ewolucja_p' => 210, 'typ1' => 18, 'typ2' => 0,'ataki' => '262,1;168,1;555,1;541,1;450,1;544,1;70,1;41,7;292,13;230,19;609,31;374,37;366,43;95,49;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 750, 'plec_m' => 250],
    210 => ['id_poka' => 210, 'nazwa' => 'Granbull', 'min_poziom' => 23, 'ewolucja_p' => 0, 'typ1' => 18, 'typ2' => 0,'ataki' => '360,1;262,1;168,1;555,1;541,1;450,1;544,1;70,1;41,7;292,13;230,19;609,35;374,43;366,51;95,59;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 750, 'plec_m' => 250],
    211 => ['id_poka' => 211, 'nazwa' => 'Qwilfish', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 8,'ataki' => '164,1;252,1;104,1;584,1;503,1;541,1;380,1;226,9;328,9;57,13;439,17;564,21;516,25;505,25;425,29;56,33;372,37;546,41;18,45;378,49;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    212 => ['id_poka' => 212, 'nazwa' => 'Scizor', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 11,'ataki' => '162,1;63,1;406,1;291,1;185,5;404,9;160,13;10,17;321,21;198,25;482,29;415,33;273,37;605,41;351,45;114,49;274,50;538,57;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    213 => ['id_poka' => 213, 'nazwa' => 'Shuckle', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 13,'ataki' => '515,1;598,1;82,1;39,1;439,1;146,5;603,9;523,12;422,20;434,23;203,27;388,31;467,34;432,38;59,42;386,45;218,45;518,49;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    214 => ['id_poka' => 214, 'nazwa' => 'Heracross', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 16, 'typ2' => 10,'ataki' => '19,1;64,1;351,1;541,1;291,1;246,1;148,1;162, 7;7,10;72,16;89,19;197,25;55,28;372,31;546,34;318,37;76,43;426,46;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    215 => ['id_poka' => 215, 'nazwa' => 'Sneasel', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 15, 'typ2' => 14,'ataki' => '451,1;291,1;547,1;406,8;163,10;267,14;199,16;10,20;321,22;245,25;35,28;452,32;482,35;493,40;403,44;264,47;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    216 => ['id_poka' => 216, 'nazwa' => 'Teddiursa', 'min_poziom' => 1, 'ewolucja_p' => 217, 'typ1' => 1, 'typ2' => 0,'ataki' => '181,1;90,1;451,1;31,1;292,1;159,1;199,8;163,15;535,22;373,25;482,29;70,36;422,43;494,43;553,50;', 'wymagania' => 0, 'trudnosc' => 2, 'plec_k' => 500, 'plec_m' => 500],
    217 => ['id_poka' => 217, 'nazwa' => 'Ursaring', 'min_poziom' => 30, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '225,1;90,1;451,1;291,1;292,1;159,1;199,8;163,15;535,22;373,25;482,29;450,38;422,47;494,49;553,58;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    218 => ['id_poka' => 218, 'nazwa' => 'Slugma', 'min_poziom' => 1, 'ewolucja_p' => 219, 'typ1' => 2, 'typ2' => 0,'ataki' => '606,1;490,1;145,6;434,8;226,13;269,15;75,20;15,22;173,27;432,29;285,34;14,36;47,41;416,43;176,48;135,50;', 'wymagania' => 0, 'trudnosc' => 1, 'plec_k' => 500, 'plec_m' => 500],
    219 => ['id_poka' => 219, 'nazwa' => 'Magcargo', 'min_poziom' => 38, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 13,'ataki' => '135,1;606,1;490,1;145,1;434,1;226,13;269,15;75,20;15,22;173,27;432,29;285,34;14,36;467,38;47,43;416,47;176,54;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    220 => ['id_poka' => 220, 'nazwa' => 'Swinub', 'min_poziom' => 1, 'ewolucja_p' => 221, 'typ1' => 14, 'typ2' => 12,'ataki' => '541,1;357,1;341,5;384,8;342,11;148,14;339,18;267,21;264,24;546,28;333,35;136,37;172,40;44,44;14,48;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 500, 'plec_m' => 500],
    221 => ['id_poka' => 221, 'nazwa' => 'Piloswine', 'min_poziom' => 33, 'ewolucja_p' => 0, 'typ1' => 14, 'typ2' => 12,'ataki' => '15,1;367,1;357,1;341,1;384,1;342,11;148,14;339,18;267,21;262,24;546,28;197,33;333,37;553,41;136,46;44,52;14,58;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    222 => ['id_poka' => 222, 'nazwa' => 'Corsola', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 13,'ataki' => '541,1;226,1;57,4;416,8;58,10;420,13;15,17;502,20;299,23;56,27;273,29;429,31;148,35;17,38;385,41;330,45;135,47;172,50;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 750, 'plec_m' => 250],
    223 => ['id_poka' => 223, 'nazwa' => 'Remoraid', 'min_poziom' => 1, 'ewolucja_p' => 224, 'typ1' => 3, 'typ2' => 0,'ataki' => '584,1;295,6;394,10;28,14;58,18;185,22;585,26;470,30;260,34;64,38;252,42;253,46;495,50;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    224 => ['id_poka' => 224, 'nazwa' => 'Octillery', 'min_poziom' => 25, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '221,1;429,1;584,1;82,1;394,1;28,1;58,18;185,22;356,25;604,28;470,34;260,40;64,46;252,52;253,58;495,64;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    225 => ['id_poka' => 225, 'nazwa' => 'Delibird', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 14, 'typ2' => 6,'ataki' => '392,1;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    226 => ['id_poka' => 226, 'nazwa' => 'Mantine', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 6,'ataki' => '394,1;64,1;470,1;541,1;57,1;531,1;58,1;80,11;596,14;230,16;585,19;593,23;546,27;10,32;12,36;17,39;53,46;252,49;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    227 => ['id_poka' => 227, 'nazwa' => 'Skarmory', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 11, 'typ2' => 6,'ataki' => '291,1;367,1;446,6;321,9;11,12;197,17;162, 20;536,23;503,28;10,31;514,34;482,39;322,42;12,45;29,50;351,53;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    228 => ['id_poka' => 228, 'nazwa' => 'Houndour', 'min_poziom' => 1, 'ewolucja_p' => 229, 'typ1' => 15, 'typ2' => 2,'ataki' => '291,1;145,1;249,4;490,8;41,16;357,20;35,25;168,28;163,32;144,37;191,40;176,44;95,49;345,52;270,56;', 'wymagania' => 0, 'trudnosc' => 3, 'plec_k' => 500, 'plec_m' => 500],
    229 => ['id_poka' => 229, 'nazwa' => 'Houndoom', 'min_poziom' => 24, 'ewolucja_p' => 0, 'typ1' => 15, 'typ2' => 2,'ataki' => '270,1;345,1;555,1;291,1;145,1;249,1;490,1;41,16;357,20;35,26;168,30;163,35;144,41;191,45;176,50;95,56;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    230 => ['id_poka' => 230, 'nazwa' => 'Kingdra', 'min_poziom' => 33, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 17,'ataki' => '252,1;606,1;584,1;491,1;291,1;57,1;573,17;58,21;185,26;56,31;10,38;124,45;123,52;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    231 => ['id_poka' => 231, 'nazwa' => 'Phanpy', 'min_poziom' => 1, 'ewolucja_p' => 232, 'typ1' => 12, 'typ2' => 0,'ataki' => '357,1;541,1;215,1;102,1;172,6;439,10;346,15;148,19;481,24;546,28;70,33;284,37;282,42;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    232 => ['id_poka' => 232, 'nazwa' => 'Donphan', 'min_poziom' => 25, 'ewolucja_p' => 0, 'typ1' => 12, 'typ2' => 0,'ataki' => '168,1;555,1;246,1;215,1;102,1;62,1;412,6;439,10;23,15;281,19;481,24;197,25;310,30;450,37;136,43;207,50;', 'wymagania' => 0, 'trudnosc' => 6, 'plec_k' => 500, 'plec_m' => 500],
    233 => ['id_poka' => 233, 'nazwa' => 'Porygon2', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '607,1;303,1;84,1;541,1;83,1;102,1;394,7;10,12;416,18;308,23;470,29;417,34;110,40;295,45;566,50;253,67;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    234 => ['id_poka' => 234, 'nazwa' => 'Stantler', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '312,1;541,1;291,3;24,7;258,10;517,13;446,16;546,21;80,23;65,27;437,33;608,38;277,43;268,49;67,50;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 500, 'plec_m' => 500],
    235 => ['id_poka' => 235, 'nazwa' => 'Smeargle', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '474,1;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    236 => ['id_poka' => 236, 'nazwa' => 'Tyrogue', 'min_poziom' => 1, 'ewolucja_p' => 237, 'typ1' => 10, 'typ2' => 0,'ataki' => '541,1;241,1;158,1;189,1;', 'wymagania' => 99, 'trudnosc' => 4, 'plec_k' => 0, 'plec_m' => 1000],
    237 => ['id_poka' => 237, 'nazwa' => 'Hitmontop', 'min_poziom' => 20, 'ewolucja_p' => 0, 'typ1' => 10, 'typ2' => 0,'ataki' => '147,1;76,1;425,1;438,1;185,6;404,10;406,15;570,19;412,24;89,28;162,33;10,37;223,42;593,46;407,46;105,50;', 'wymagania' => 0, 'trudnosc' => 4, 'plec_k' => 0, 'plec_m' => 1000],
    238 => ['id_poka' => 238, 'nazwa' => 'Smoochum', 'min_poziom' => 1, 'ewolucja_p' => 124, 'typ1' => 14, 'typ2' => 7,'ataki' => '382,1;292,5;534,8;384,11;81,15;473,18;236,21;159,28;299,31;30,35;396,38;85,41;368,45;44,48;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 1000, 'plec_m' => 0],
    239 => ['id_poka' => 239, 'nazwa' => 'Elekid', 'min_poziom' => 1, 'ewolucja_p' => 125, 'typ1' => 5, 'typ2' => 0,'ataki' => '406,1;291,1;557,5;297,8;536,12;469,15;558,19;142,22;294,26;556,29;110,33;452,36;559,40;554,43;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 250, 'plec_m' => 750],
    240 => ['id_poka' => 240, 'nazwa' => 'Magby', 'min_poziom' => 1, 'ewolucja_p' => 126, 'typ1' => 2, 'typ2' => 0,'ataki' => '490,1;291,1;145,5;491,8;163,12;170,15;75,19;173,22;80,26;169,29;285,33;528,36;176,40;167,43;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 250, 'plec_m' => 750],
    241 => ['id_poka' => 241, 'nazwa' => 'Miltank', 'min_poziom' => 1, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '541,1;215,3;102,5;517,8;325,11;39,15;439,19;47,24;608,29;67,35;223,41;231, 48;583,50;', 'wymagania' => 0, 'trudnosc' => 5, 'plec_k' => 1000, 'plec_m' => 0],
    242 => ['id_poka' => 242, 'nazwa' => 'Blissey', 'min_poziom' => 2, 'ewolucja_p' => 0, 'typ1' => 1, 'typ2' => 0,'ataki' => '282,1;102,1;382,1;215,1;544,5;420,9;116,12;496,16;38,20;328,23;546,27;473,31;181,34;234,38;139,42;294,46;235,50;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 1000, 'plec_m' => 0],
    243 => ['id_poka' => 243, 'nazwa' => 'Raikou', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 5, 'typ2' => 0,'ataki' => '153,1;110,1;41,1;291,1;557,8;406,22;500,29;95,43;555,50;411,71;65,78;554,85;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    244 => ['id_poka' => 244, 'nazwa' => 'Entei', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 0,'ataki' => '443,1;151,1;153,1;285,1;41,1;291,1;145,8;170,22;517,29;176,36;532,43;168,50;167,71;65,78;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    245 => ['id_poka' => 245, 'nazwa' => 'Suicune', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 3, 'typ2' => 0,'ataki' => '252,1;153,1;545,1;41,1;291,1;58,8;411,15;222,22;28,29;333,36;330,43;262,50;65,78;44,85;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    246 => ['id_poka' => 246, 'nazwa' => 'Larvitar', 'min_poziom' => 1, 'ewolucja_p' => 247, 'typ1' => 13, 'typ2' => 12,'ataki' => '41,1;291,1;448,5;452,10;72,14;432,19;450,23;553,28;99,32;366,37;95,41;136,46;518,50;253,55;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    247 => ['id_poka' => 247, 'nazwa' => 'Pupitar', 'min_poziom' => 30, 'ewolucja_p' => 248, 'typ1' => 13, 'typ2' => 12,'ataki' => '41,1;291,1;448,1;452,1;72,14;432,19;450,23;553,28;99,34;366,41;95,47;136,54;518,60;253,67;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    248 => ['id_poka' => 248, 'nazwa' => 'Tyranitar', 'min_poziom' => 55, 'ewolucja_p' => 0, 'typ1' => 13, 'typ2' => 15,'ataki' => '555,1;262,1;168,1;41,1;291,1;448,1;452,1;72,14;432,19;450,23;553,28;99,34;366,41;95,47;136,54;518,63;253,73;207,82;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 500, 'plec_m' => 500],
    249 => ['id_poka' => 249, 'nazwa' => 'Lugia', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 6,'ataki' => '592,1;590,1;222,9;126,15;153,23;411,29;252,37;8,43;403,50;15,57;416,71;202,79;346,85;65,93;477,99;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    250 => ['id_poka' => 250, 'nazwa' => 'Ho-Oh', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 2, 'typ2' => 6,'ataki' => '592,1;222,9;54,15;153,23;528,29;167,37;443,43;403,50;15,57;416,71;202,79;346,85;65,93;477,99;590,1;590,1;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
    251 => ['id_poka' => 251, 'nazwa' => 'Celebi', 'min_poziom' => 100, 'ewolucja_p' => 0, 'typ1' => 7, 'typ2' => 4,'ataki' => '290,1;81,1;416,1;231,1;305,19;15,28;346,46;232,55;202,64;235,73;287,82;368,91;', 'wymagania' => 0, 'trudnosc' => 10, 'plec_k' => 0, 'plec_m' => 0],
        ];

    private static $increase = [
    '1' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 20],
    '2' => ['min_poziom' => 16, 'poprzedni' => 1, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 25],
    '3' => ['min_poziom' => 32, 'poprzedni' => 2, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 30],
    '4' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '5' => ['min_poziom' => 16, 'poprzedni' => 4, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '6' => ['min_poziom' => 36, 'poprzedni' => 5, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 30],
    '7' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 20],
    '8' => ['min_poziom' => 16, 'poprzedni' => 7, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 25],
    '9' => ['min_poziom' => 36, 'poprzedni' => 8, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 30],
    '10' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '11' => ['min_poziom' => 7, 'poprzedni' => 10, 'atak' => 3, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 20],
    '12' => ['min_poziom' => 10, 'poprzedni' => 11, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 25],
    '13' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '14' => ['min_poziom' => 7, 'poprzedni' => 13, 'atak' => 3, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 20],
    '15' => ['min_poziom' => 10, 'poprzedni' => 14, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 25],
    '16' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '17' => ['min_poziom' => 18, 'poprzedni' => 16, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '18' => ['min_poziom' => 36, 'poprzedni' => 17, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 30],
    '19' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 5, 'hp' => 20],
    '20' => ['min_poziom' => 20, 'poprzedni' => 19, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '21' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 5, 'hp' => 20],
    '22' => ['min_poziom' => 20, 'poprzedni' => 21, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 25],
    '23' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '24' => ['min_poziom' => 22, 'poprzedni' => 23, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '25' => ['min_poziom' => 2, 'poprzedni' => 172, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '26' => ['min_poziom' => 3, 'poprzedni' => 25, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '27' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '28' => ['min_poziom' => 22, 'poprzedni' => 27, 'atak' => 7, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '29' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '30' => ['min_poziom' => 16, 'poprzedni' => 29, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '31' => ['min_poziom' => 17, 'poprzedni' => 30, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '32' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '33' => ['min_poziom' => 16, 'poprzedni' => 32, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '34' => ['min_poziom' => 17, 'poprzedni' => 33, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 30],
    '35' => ['min_poziom' => 2, 'poprzedni' => 173, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 25],
    '36' => ['min_poziom' => 3, 'poprzedni' => 35, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '37' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 20],
    '38' => ['min_poziom' => 2, 'poprzedni' => 37, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 7, 'hp' => 25],
    '39' => ['min_poziom' => 2, 'poprzedni' => 174, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 35],
    '40' => ['min_poziom' => 3, 'poprzedni' => 39, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 40],
    '41' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '42' => ['min_poziom' => 22, 'poprzedni' => 41, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '43' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 20],
    '44' => ['min_poziom' => 21, 'poprzedni' => 43, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '45' => ['min_poziom' => 22, 'poprzedni' => 44, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 25],
    '46' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '47' => ['min_poziom' => 24, 'poprzedni' => 46, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 3, 'hp' => 25],
    '48' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '49' => ['min_poziom' => 31, 'poprzedni' => 48, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '50' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 15],
    '51' => ['min_poziom' => 26, 'poprzedni' => 50, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 8, 'hp' => 20],
    '52' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '53' => ['min_poziom' => 28, 'poprzedni' => 52, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 25],
    '54' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '55' => ['min_poziom' => 33, 'poprzedni' => 54, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 30],
    '56' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '57' => ['min_poziom' => 28, 'poprzedni' => 56, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '58' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '59' => ['min_poziom' => 2, 'poprzedni' => 58, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 30],
    '60' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '61' => ['min_poziom' => 25, 'poprzedni' => 60, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 25],
    '62' => ['min_poziom' => 26, 'poprzedni' => 61, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '63' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 2, 'sp_atak' => 7, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 15],
    '64' => ['min_poziom' => 16, 'poprzedni' => 63, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 8, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 20],
    '65' => ['min_poziom' => 17, 'poprzedni' => 64, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 8, 'sp_obrona' => 6, 'szybkosc' => 8, 'hp' => 25],
    '66' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 25],
    '67' => ['min_poziom' => 28, 'poprzedni' => 66, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '68' => ['min_poziom' => 29, 'poprzedni' => 67, 'atak' => 8, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 30],
    '69' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 3, 'sp_atak' => 5, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '70' => ['min_poziom' => 21, 'poprzedni' => 69, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '71' => ['min_poziom' => 22, 'poprzedni' => 70, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 30],
    '72' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 20],
    '73' => ['min_poziom' => 30, 'poprzedni' => 72, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 8, 'szybkosc' => 7, 'hp' => 30],
    '74' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 20],
    '75' => ['min_poziom' => 25, 'poprzedni' => 74, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 25],
    '76' => ['min_poziom' => 26, 'poprzedni' => 75, 'atak' => 7, 'obrona' => 8, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '77' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 20],
    '78' => ['min_poziom' => 40, 'poprzedni' => 77, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '79' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 2, 'hp' => 30],
    '80' => ['min_poziom' => 37, 'poprzedni' => 79, 'atak' => 5, 'obrona' => 7, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 3, 'hp' => 30],
    '81' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 15],
    '82' => ['min_poziom' => 30, 'poprzedni' => 81, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 8, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 20],
    '83' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 25],
    '84' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 5, 'hp' => 20],
    '85' => ['min_poziom' => 31, 'poprzedni' => 84, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 25],
    '86' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '87' => ['min_poziom' => 34, 'poprzedni' => 86, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '88' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 30],
    '89' => ['min_poziom' => 38, 'poprzedni' => 88, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 7, 'szybkosc' => 4, 'hp' => 35],
    '90' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '91' => ['min_poziom' => 2, 'poprzedni' => 90, 'atak' => 6, 'obrona' => 10, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '92' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 7, 'sp_obrona' => 3, 'szybkosc' => 6, 'hp' => 20],
    '93' => ['min_poziom' => 25, 'poprzedni' => 92, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 7, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '94' => ['min_poziom' => 26, 'poprzedni' => 93, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 8, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 25],
    '95' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 10, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '96' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 25],
    '97' => ['min_poziom' => 26, 'poprzedni' => 96, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 30],
    '98' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '99' => ['min_poziom' => 28, 'poprzedni' => 98, 'atak' => 8, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '100' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 7, 'hp' => 20],
    '101' => ['min_poziom' => 30, 'poprzedni' => 100, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 9, 'hp' => 25],
    '102' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '103' => ['min_poziom' => 2, 'poprzedni' => 102, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 8, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '104' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 6, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '105' => ['min_poziom' => 28, 'poprzedni' => 104, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 25],
    '106' => ['min_poziom' => 2, 'poprzedni' => 236, 'atak' => 8, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 20],
    '107' => ['min_poziom' => 2, 'poprzedni' => 236, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 3, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 20],
    '108' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 30],
    '109' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '110' => ['min_poziom' => 35, 'poprzedni' => 109, 'atak' => 6, 'obrona' => 8, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 25],
    '111' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 30],
    '112' => ['min_poziom' => 42, 'poprzedni' => 111, 'atak' => 8, 'obrona' => 8, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 35],
    '113' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 2, 'obrona' => 2, 'sp_atak' => 3, 'sp_obrona' => 7, 'szybkosc' => 4, 'hp' => 50],
    '114' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 7, 'sp_atak' => 7, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '115' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 35],
    '116' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 3, 'szybkosc' => 5, 'hp' => 20],
    '117' => ['min_poziom' => 32, 'poprzedni' => 116, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 25],
    '118' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '119' => ['min_poziom' => 33, 'poprzedni' => 118, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '120' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '121' => ['min_poziom' => 2, 'poprzedni' => 120, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '122' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 8, 'szybkosc' => 6, 'hp' => 20],
    '123' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '124' => ['min_poziom' => 30, 'poprzedni' => 238, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 25],
    '125' => ['min_poziom' => 30, 'poprzedni' => 239, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '126' => ['min_poziom' => 30, 'poprzedni' => 240, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 25],
    '127' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 8, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '128' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 25],
    '129' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 2, 'obrona' => 4, 'sp_atak' => 2, 'sp_obrona' => 3, 'szybkosc' => 6, 'hp' => 15],
    '130' => ['min_poziom' => 20, 'poprzedni' => 129, 'atak' => 8, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 30],
    '131' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 40],
    '132' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '133' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '134' => ['min_poziom' => 2, 'poprzedni' => 133, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 40],
    '135' => ['min_poziom' => 2, 'poprzedni' => 133, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 8, 'hp' => 25],
    '136' => ['min_poziom' => 2, 'poprzedni' => 133, 'atak' => 8, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 25],
    '137' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '138' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '139' => ['min_poziom' => 40, 'poprzedni' => 138, 'atak' => 5, 'obrona' => 8, 'sp_atak' => 7, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '140' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '141' => ['min_poziom' => 40, 'poprzedni' => 140, 'atak' => 7, 'obrona' => 7, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '142' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 8, 'hp' => 30],
    '143' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 7, 'szybkosc' => 3, 'hp' => 45],
    '144' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 8, 'szybkosc' => 6, 'hp' => 30],
    '145' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 8, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 30],
    '146' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 8, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 30],
    '147' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '148' => ['min_poziom' => 30, 'poprzedni' => 147, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 25],
    '149' => ['min_poziom' => 55, 'poprzedni' => 148, 'atak' => 8, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 30],
    '150' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 9, 'sp_obrona' => 6, 'szybkosc' => 8, 'hp' => 35],
    '151' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 7, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 7, 'hp' => 30],
    '152' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 20],
    '153' => ['min_poziom' => 16, 'poprzedni' => 152, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 25],
    '154' => ['min_poziom' => 32, 'poprzedni' => 153, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 30],
    '155' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '156' => ['min_poziom' => 14, 'poprzedni' => 155, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '157' => ['min_poziom' => 36, 'poprzedni' => 156, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 30],
    '158' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '159' => ['min_poziom' => 18, 'poprzedni' => 158, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '160' => ['min_poziom' => 30, 'poprzedni' => 159, 'atak' => 7, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '161' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '162' => ['min_poziom' => 15, 'poprzedni' => 161, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 30],
    '163' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '164' => ['min_poziom' => 20, 'poprzedni' => 163, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '165' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 20],
    '166' => ['min_poziom' => 18, 'poprzedni' => 165, 'atak' => 3, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 25],
    '167' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '168' => ['min_poziom' => 22, 'poprzedni' => 167, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '169' => ['min_poziom' => 23, 'poprzedni' => 42, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 8, 'hp' => 30],
    '170' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '171' => ['min_poziom' => 27, 'poprzedni' => 170, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 35],
    '172' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 2, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 5, 'hp' => 15],
    '173' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 2, 'hp' => 20],
    '174' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 2, 'sp_atak' => 4, 'sp_obrona' => 3, 'szybkosc' => 2, 'hp' => 30],
    '175' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 20],
    '176' => ['min_poziom' => 2, 'poprzedni' => 175, 'atak' => 4, 'obrona' => 6, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 4, 'hp' => 25],
    '177' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '178' => ['min_poziom' => 25, 'poprzedni' => 177, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '179' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 25],
    '180' => ['min_poziom' => 15, 'poprzedni' => 179, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '181' => ['min_poziom' => 30, 'poprzedni' => 180, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 30],
    '182' => ['min_poziom' => 22, 'poprzedni' => 44, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 4, 'hp' => 25],
    '183' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '184' => ['min_poziom' => 18, 'poprzedni' => 183, 'atak' => 4, 'obrona' => 6, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 4, 'hp' => 30],
    '185' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 7, 'sp_atak' => 3, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 25],
    '186' => ['min_poziom' => 26, 'poprzedni' => 61, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 30],
    '187' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '188' => ['min_poziom' => 18, 'poprzedni' => 187, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '189' => ['min_poziom' => 27, 'poprzedni' => 188, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '190' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 25],
    '191' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 20],
    '192' => ['min_poziom' => 2, 'poprzedni' => 191, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 3, 'hp' => 25],
    '193' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 25],
    '194' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 2, 'hp' => 25],
    '195' => ['min_poziom' => 20, 'poprzedni' => 194, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 30],
    '196' => ['min_poziom' => 2, 'poprzedni' => 133, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 8, 'sp_obrona' => 6, 'szybkosc' => 7, 'hp' => 25],
    '197' => ['min_poziom' => 2, 'poprzedni' => 133, 'atak' => 5, 'obrona' => 7, 'sp_atak' => 5, 'sp_obrona' => 8, 'szybkosc' => 5, 'hp' => 30],
    '198' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 25],
    '199' => ['min_poziom' => 2, 'poprzedni' => 79, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 3, 'hp' => 30],
    '200' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 25],
    '201' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '202' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 5, 'sp_atak' => 3, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 50],
    '203' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '204' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 6, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 2, 'hp' => 20],
    '205' => ['min_poziom' => 31, 'poprzedni' => 204, 'atak' => 6, 'obrona' => 9, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '206' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '207' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 7, 'sp_atak' => 3, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '208' => ['min_poziom' => 2, 'poprzedni' => 95, 'atak' => 6, 'obrona' => 11, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 25],
    '209' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 25],
    '210' => ['min_poziom' => 23, 'poprzedni' => 209, 'atak' => 8, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '211' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 25],
    '212' => ['min_poziom' => 2, 'poprzedni' => 123, 'atak' => 8, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 25],
    '213' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 2, 'obrona' => 11, 'sp_atak' => 2, 'sp_obrona' => 11, 'szybkosc' => 2, 'hp' => 15],
    '214' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 8, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 30],
    '215' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 25],
    '216' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 25],
    '217' => ['min_poziom' => 30, 'poprzedni' => 216, 'atak' => 8, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '218' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 3, 'hp' => 20],
    '219' => ['min_poziom' => 38, 'poprzedni' => 218, 'atak' => 4, 'obrona' => 8, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 3, 'hp' => 20],
    '220' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 4, 'hp' => 20],
    '221' => ['min_poziom' => 33, 'poprzedni' => 220, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '222' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 6, 'sp_atak' => 5, 'sp_obrona' => 6, 'szybkosc' => 3, 'hp' => 25],
    '223' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 3, 'sp_atak' => 5, 'sp_obrona' => 3, 'szybkosc' => 5, 'hp' => 20],
    '224' => ['min_poziom' => 25, 'poprzedni' => 223, 'atak' => 7, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 5, 'szybkosc' => 3, 'hp' => 25],
    '225' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 4, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '226' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 4, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 9, 'szybkosc' => 5, 'hp' => 25],
    '227' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 9, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 25],
    '228' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 3, 'sp_atak' => 6, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 20],
    '229' => ['min_poziom' => 24, 'poprzedni' => 228, 'atak' => 6, 'obrona' => 4, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 25],
    '230' => ['min_poziom' => 33, 'poprzedni' => 117, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 6, 'sp_obrona' => 6, 'szybkosc' => 6, 'hp' => 25],
    '231' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 5, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 30],
    '232' => ['min_poziom' => 25, 'poprzedni' => 231, 'atak' => 8, 'obrona' => 8, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 30],
    '233' => ['min_poziom' => 2, 'poprzedni' => 137, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 6, 'szybkosc' => 5, 'hp' => 30],
    '234' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 6, 'hp' => 25],
    '235' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 4, 'szybkosc' => 5, 'hp' => 25],
    '236' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 3, 'sp_atak' => 3, 'sp_obrona' => 3, 'szybkosc' => 3, 'hp' => 20],
    '237' => ['min_poziom' => 20, 'poprzedni' => 236, 'atak' => 6, 'obrona' => 6, 'sp_atak' => 3, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 20],
    '238' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 3, 'obrona' => 2, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 5, 'hp' => 20],
    '239' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 3, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '240' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 3, 'sp_atak' => 5, 'sp_obrona' => 4, 'szybkosc' => 6, 'hp' => 20],
    '241' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 7, 'sp_atak' => 4, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 30],
    '242' => ['min_poziom' => 2, 'poprzedni' => 113, 'atak' => 2, 'obrona' => 2, 'sp_atak' => 5, 'sp_obrona' => 8, 'szybkosc' => 4, 'hp' => 55],
    '243' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 7, 'hp' => 30],
    '244' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 6, 'sp_atak' => 6, 'sp_obrona' => 5, 'szybkosc' => 7, 'hp' => 35],
    '245' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 6, 'hp' => 30],
    '246' => ['min_poziom' => 1, 'poprzedni' => 0, 'atak' => 5, 'obrona' => 4, 'sp_atak' => 4, 'sp_obrona' => 4, 'szybkosc' => 4, 'hp' => 20],
    '247' => ['min_poziom' => 30, 'poprzedni' => 246, 'atak' => 6, 'obrona' => 5, 'sp_atak' => 5, 'sp_obrona' => 5, 'szybkosc' => 4, 'hp' => 25],
    '248' => ['min_poziom' => 55, 'poprzedni' => 247, 'atak' => 8, 'obrona' => 7, 'sp_atak' => 6, 'sp_obrona' => 7, 'szybkosc' => 5, 'hp' => 30],
    '249' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 6, 'obrona' => 8, 'sp_atak' => 6, 'sp_obrona' => 9, 'szybkosc' => 7, 'hp' => 35],
    '250' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 8, 'obrona' => 6, 'sp_atak' => 7, 'sp_obrona' => 9, 'szybkosc' => 6, 'hp' => 35],
    '251' => ['min_poziom' => 100, 'poprzedni' => 0, 'atak' => 7, 'obrona' => 7, 'sp_atak' => 7, 'sp_obrona' => 7, 'szybkosc' => 7, 'hp' => 30],
        ];

    private static $experienceOnLevel = [
        '1' => 20,
        '2' => 30,
        '3' => 40,
        '4' => 50,
        '5' => 60,
        '6' => 80,
        '7' => 100,
        '8' => 120,
        '9' => 140,
        '10' => 160,
        '11' => 200,
        '12' => 250,
        '13' => 300,
        '14' => 360,
        '15' => 430,
        '16' => 500,
        '17' => 600,
        '18' => 700,
        '19' => 800,
        '20' => 900,
        '21' => 1000,
        '22' => 1100,
        '23' => 1200,
        '24' => 1300,
        '25' => 1400,
        '26' => 1500,
        '27' => 1600,
        '28' => 1700,
        '29' => 1800,
        '30' => 1900,
        '31' => 2000,
        '32' => 2100,
        '33' => 2200,
        '34' => 2350,
        '35' => 2500,
        '36' => 2550,
        '37' => 2650,
        '38' => 2800,
        '39' => 2950,
        '40' => 3100,
        '41' => 3150,
        '42' => 3250,
        '43' => 3400,
        '44' => 3600,
        '45' => 3800,
        '46' => 4000,
        '47' => 4200,
        '48' => 4400,
        '49' => 4700,
        '50' => 5000,
        '51' => 5300,
        '52' => 5600,
        '53' => 5650,
        '54' => 6000,
        '55' => 6400,
        '56' => 6800,
        '57' => 7200,
        '58' => 7600,
        '59' => 8000,
        '60' => 8400,
        '61' => 8800,
        '62' => 9200,
        '63' => 9600,
        '64' => 10000,
        '65' => 11000,
        '66' => 12000,
        '67' => 13000,
        '68' => 14000,
        '69' => 15000,
        '70' => 16000,
        '71' => 17000,
        '72' => 18000,
        '73' => 19000,
        '74' => 20000,
        '75' => 22000,
        '76' => 24000,
        '77' => 26000,
        '78' => 28000,
        '79' => 30000,
        '80' => 32000,
        '81' => 34000,
        '82' => 36000,
        '83' => 38000,
        '84' => 40000,
        '85' => 42000,
        '86' => 44000,
        '87' => 46000,
        '88' => 48000,
        '89' => 50000,
        '90' => 62000,
        '91' => 76000,
        '92' => 90000,
        '93' => 105000,
        '94' => 120000,
        '95' => 145000,
        '96' => 185000,
        '97' => 210000,
        '98' => 270000,
        '99' => 850000,
        '100' => 1500000,
    ];

    private static $typeDescription = [
        '0' => '',
        '1' => 'normalny',
        '2' => 'ognisty',
        '3' => 'wodny',
        '4' => 'roślinny',
        '5' => 'elektryczny',
        '6' => 'powietrzny',
        '7' => 'psychiczny',
        '8' => 'trujący',
        '9' => 'duch',
        '10' => 'walczący',
        '11' => 'stalowy',
        '12' => 'ziemny',
        '13' => 'kamienny',
        '14' => 'lodowy',
        '15' => 'mroczny',
        '16' => 'robaczy',
        '17' => 'smoczy',
        '18' => 'wróżka'
    ];

    private static $effectiveness = [
        '1' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '1', 'typ7' => '1', 'typ8' => '1', 'typ9' => '0', 'typ10' => '2', 'typ11' => '1', 'typ12' => '1', 'typ13' => '1', 'typ14' => '1', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '2' => ['typ1' => '1', 'typ2' => '0.5', 'typ3' => '2', 'typ4' => '0.5', 'typ5' => '1', 'typ6' => '1', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '1', 'typ11' => '0.5', 'typ12' => '2', 'typ13' => '2', 'typ14' => '0.5', 'typ15' => '1', 'typ16' => '0.5', 'typ17' => '1', 'typ18' => '0.5',],
        '3' => ['typ1' => '1', 'typ2' => '0.5', 'typ3' => '0.5', 'typ4' => '2', 'typ5' => '2', 'typ6' => '1', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '1', 'typ11' => '0.5', 'typ12' => '1', 'typ13' => '1', 'typ14' => '0.5', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '4' => ['typ1' => '1', 'typ2' => '2', 'typ3' => '0.5', 'typ4' => '0.5', 'typ5' => '0.5', 'typ6' => '2', 'typ7' => '1', 'typ8' => '2', 'typ9' => '1', 'typ10' => '1', 'typ11' => '1', 'typ12' => '0.5', 'typ13' => '1', 'typ14' => '2', 'typ15' => '1', 'typ16' => '2', 'typ17' => '1', 'typ18' => '1',],
        '5' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '0.5', 'typ6' => '0.5', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '1', 'typ11' => '0.5', 'typ12' => '2', 'typ13' => '1', 'typ14' => '1', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '6' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '0.5', 'typ5' => '2', 'typ6' => '1', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '0.5', 'typ11' => '1', 'typ12' => '0', 'typ13' => '2', 'typ14' => '2', 'typ15' => '1', 'typ16' => '0.5', 'typ17' => '1', 'typ18' => '1',],
        '7' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '1', 'typ7' => '0.5', 'typ8' => '1', 'typ9' => '2', 'typ10' => '0.5', 'typ11' => '1', 'typ12' => '1', 'typ13' => '1', 'typ14' => '1', 'typ15' => '2', 'typ16' => '2', 'typ17' => '1', 'typ18' => '1',],
        '8' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '0.5', 'typ5' => '1', 'typ6' => '1', 'typ7' => '2', 'typ8' => '0.5', 'typ9' => '1', 'typ10' => '0.5', 'typ11' => '1', 'typ12' => '2', 'typ13' => '1', 'typ14' => '1', 'typ15' => '1', 'typ16' => '0.5', 'typ17' => '1', 'typ18' => '0.5',],
        '9' => ['typ1' => '0', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '1', 'typ7' => '1', 'typ8' => '0.5', 'typ9' => '2', 'typ10' => '0', 'typ11' => '1', 'typ12' => '1', 'typ13' => '1', 'typ14' => '1', 'typ15' => '2', 'typ16' => '0.5', 'typ17' => '1', 'typ18' => '1',],
        '10' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '2', 'typ7' => '2', 'typ8' => '1', 'typ9' => '1', 'typ10' => '1', 'typ11' => '1', 'typ12' => '1', 'typ13' => '0.5', 'typ14' => '1', 'typ15' => '0.5', 'typ16' => '0.5', 'typ17' => '1', 'typ18' => '2',],
        '11' => ['typ1' => '0.5', 'typ2' => '2', 'typ3' => '1', 'typ4' => '0.5', 'typ5' => '1', 'typ6' => '0.5', 'typ7' => '0.5', 'typ8' => '0', 'typ9' => '1', 'typ10' => '2', 'typ11' => '0.5', 'typ12' => '2', 'typ13' => '0.5', 'typ14' => '0.5', 'typ15' => '1', 'typ16' => '0.5', 'typ17' => '0.5', 'typ18' => '0.5',],
        '12' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '2', 'typ4' => '2', 'typ5' => '0', 'typ6' => '1', 'typ7' => '1', 'typ8' => '0.5', 'typ9' => '1', 'typ10' => '1', 'typ11' => '1', 'typ12' => '1', 'typ13' => '0.5', 'typ14' => '2', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '13' => ['typ1' => '0.5', 'typ2' => '0.5', 'typ3' => '2', 'typ4' => '2', 'typ5' => '1', 'typ6' => '0.5', 'typ7' => '1', 'typ8' => '0.5', 'typ9' => '1', 'typ10' => '2', 'typ11' => '2', 'typ12' => '2', 'typ13' => '1', 'typ14' => '1', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '14' => ['typ1' => '1', 'typ2' => '2', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '1', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '2', 'typ11' => '2', 'typ12' => '1', 'typ13' => '2', 'typ14' => '0.5', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '15' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '1', 'typ7' => '0', 'typ8' => '1', 'typ9' => '0.5', 'typ10' => '2', 'typ11' => '1', 'typ12' => '1', 'typ13' => '1', 'typ14' => '1', 'typ15' => '0.5', 'typ16' => '2', 'typ17' => '1', 'typ18' => '2',],
        '16' => ['typ1' => '1', 'typ2' => '2', 'typ3' => '1', 'typ4' => '0.5', 'typ5' => '1', 'typ6' => '2', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '0.5', 'typ11' => '1', 'typ12' => '0.5', 'typ13' => '2', 'typ14' => '1', 'typ15' => '1', 'typ16' => '1', 'typ17' => '1', 'typ18' => '1',],
        '17' => ['typ1' => '1', 'typ2' => '0.5', 'typ3' => '0.5', 'typ4' => '0.5', 'typ5' => '0.5', 'typ6' => '1', 'typ7' => '1', 'typ8' => '1', 'typ9' => '1', 'typ10' => '1', 'typ11' => '1', 'typ12' => '1', 'typ13' => '1', 'typ14' => '2', 'typ15' => '1', 'typ16' => '1', 'typ17' => '2', 'typ18' => '2',],
        '18' => ['typ1' => '1', 'typ2' => '1', 'typ3' => '1', 'typ4' => '1', 'typ5' => '1', 'typ6' => '1', 'typ7' => '1', 'typ8' => '2', 'typ9' => '1', 'typ10' => '0.5', 'typ11' => '2', 'typ12' => '1', 'typ13' => '1', 'typ14' => '1', 'typ15' => '0.5', 'typ16' => '0.5', 'typ17' => '0', 'typ18' => '1',],
        ];

    public static function getInfo(int $id): array
    {
        return
            array_merge(
                self::$pokemonInfo[$id],
                [
                    'type1Description' => self::$typeDescription[self::$pokemonInfo[$id]['typ1']],
                    'type2Description' => self::$typeDescription[self::$pokemonInfo[$id]['typ2']],
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

    public static function generatePokemon(int $id, int $level): Pokemon
    {
        $pokemon = new Pokemon();
        $pokemon->setIdPokemon($id);
        $pokemon->setLevel($level);
        $pokemon->setQuality(self::pokemonQuality());
        $pokemon->setGender(self::getGender(self::$pokemonInfo[$id]['plec_k'], self::$pokemonInfo[$id]['plec_m']));
        $pokemon->setName(self::$pokemonInfo[$id]['nazwa']);
        $pokemon->setValue(self::getValue(self::$pokemonInfo[$id]['trudnosc'], $level));
        //TODO
        $pokemon->setShiny(0);
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


        //if($czy_shiny != 0) $wartosc *= 3;
        /*$pokemonn = $this->generuj($id_p, $lvl, $wiersz['ataki']);
        $pokemonn['plec'] = $plec;
        $pokemonn['zlapany'] = $zlapany;
        $pokemonn['pok_nazwa'] = $nazwa;
        $pokemonn['trudnosc'] = $trudnosc;
        $pokemonn['typ1'] = $typ1;
        $pokemonn['typ2'] = $typ2;
        $pokemonn['wartosc'] = $wartosc;
        $pokemonn['shiny'] = 0; //$czy_shiny;*/

        //$this->pokemonToView([$pokemonn['shiny'], $nazwa, $lvl, $jakosc, $zlapany, $plec, $typ1, $typ2, $pokemonn['pok_atak'], $pokemonn['pok_sp_atak'],
        //    $pokemonn['pok_obrona'], $pokemonn['pok_sp_obrona'], $pokemonn['pok_szybkosc'], $pokemonn['pok_hp'], $pokemon_id_losowanie]);
        //$this->trudnosc($trudnosc);
        //Session::_set('pokemon', $pokemonn);


        //Session::_set('walka', 1);
        //$this->pokiGraczaView();

        return $pokemon;
    }

    public static function getEffectiveness(int $type1, int $type2)
    {
        $effectiveness = [];
        if ($type2) {
            for ($i = 1; $i < 19; $i++) {
                $effectiveness[$i] = self::$effectiveness[$type1]['typ'.$i] * self::$effectiveness[$type2]['typ'.$i];
            }
        } else {
            for ($i = 1; $i < 19; $i++) {
                $effectiveness[$i] = self::$effectiveness[$type1]['typ'.$i];
            }
        }
        return $effectiveness;
    }

    public static function getTypeDescription(int $i)
    {
        return self::$typeDescription[$i];
    }

    private static function getAttacksAsArray(int $id): ?array
    {
        $attacks = explode(';', self::$pokemonInfo[$id]['ataki']);
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

    private static function pokemonQuality(): int
    {
        $quality = mt_rand(20, 110);
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

    private static function getValue(int $difficulty, int $level)
    {
        $value = ((2500 + ($level * 290) + ($difficulty * 1280)) * (0.71 * $difficulty)) * (mt_rand(90, 110) / 100);
        //TODO:
        //odznaka1 z Kanto
        //if (User::$odznaki->kanto[1])
        //    $wartosc *= 1.1;
        return floor($value);
    }

    private static function generatePokemonStatsAndAttacks(Pokemon &$pokemon)
    {
        $pokemon->setAccuracy(rand(55, 80));

        self::generateStats($pokemon);
        self::generateAttacks($pokemon);
    }

    private static function generateStats(Pokemon &$pokemon)
    {
        $pokemonId = $pokemon->getIdPokemon();
        $lvl = $pokemon->getLevel();

        $attack = 0;
        $spAttack = 0;
        $defence = 0;
        $spDefence = 0;
        $speed = 0;
        $hp = 0;
        if (self::$increase[$pokemonId]['min_poziom'] > 1 && self::$increase[$pokemonId]['min_poziom'] != 100) {///jeśli minimalny poziom większy od 1, ale nie równy 100, to pobierz przyrosty preevolucji
            $co = self::$increase[$pokemonId]['poprzedni'];
            //echo "SELECT * FROM pokemon, przyrosty WHERE pokemon.id_poka = $co AND pokemon.id_poka = przyrosty.id_poka";
            $wiersz2 = self::$increase[$co];
            if ($wiersz2['min_poziom'] > 1) {///jeśli minimalny poziom nadal większy od 1, to pobierz przyrosty preevolucji
            //3 evo
                $co = self::$increase[$co]['poprzedni'];
                $wiersz3 = self::$increase[$co];
                //3forma
                $attack += ($lvl - self::$increase[$co]['min_poziom'] + 3) * self::$increase[$co]['atak'];
                $spAttack = $spAttack + ($lvl - self::$increase[$co]['min_poziom'] + 3) * self::$increase[$co]['sp_atak'];
                $defence = $defence + ($lvl - self::$increase[$co]['min_poziom'] + 3) * self::$increase[$co]['obrona'];
                $spDefence = $spDefence + ($lvl - self::$increase[$co]['min_poziom'] + 3) * self::$increase[$co]['sp_obrona'];
                $speed = $speed + ($lvl - self::$increase[$co]['min_poziom'] + 3) * self::$increase[$co]['szybkosc'];
                $hp = $hp + ($lvl - self::$increase[$co]['min_poziom'] + 3) * self::$increase[$co]['hp'];
                //2forma
                $attack += (self::$increase[$co]['min_poziom'] - $wiersz2['min_poziom'] + 2) * $wiersz2['atak'];
                $spAttack = $spAttack + (self::$increase[$co]['min_poziom'] - $wiersz2['min_poziom'] + 2) * $wiersz2['sp_atak'];
                $defence = $defence + (self::$increase[$co]['min_poziom'] - $wiersz2['min_poziom'] + 2) * $wiersz2['obrona'];
                $spDefence = $spDefence + (self::$increase[$co]['min_poziom'] - $wiersz2['min_poziom'] + 2) * $wiersz2['sp_obrona'];
                $speed = $speed + (self::$increase[$co]['min_poziom'] - $wiersz2['min_poziom'] + 2) * $wiersz2['szybkosc'];
                $hp = $hp + (self::$increase[$co]['min_poziom'] - $wiersz2['min_poziom'] + 2) * $wiersz2['hp'];
                //1forma
                $attack += ($wiersz2['min_poziom'] - 2) * $wiersz3['atak'];
                $spAttack = $spAttack + ($wiersz2['min_poziom'] - 2) * $wiersz3['sp_atak'];
                $defence = $defence + ($wiersz2['min_poziom'] - 2) * $wiersz3['obrona'];
                $spDefence = $spDefence + ($wiersz2['min_poziom'] - 2) * $wiersz3['sp_obrona'];
                $speed = $speed + ($wiersz2['min_poziom'] - 2) * $wiersz3['szybkosc'];
                $hp = $hp + ($wiersz2['min_poziom'] - 2) * $wiersz3['hp'];

                $rezultat10 = self::$startingStats[$co];
            } else {//2 evo
                $rezultat10 = self::$startingStats[$co];
                //2forma
                $attack += ((($lvl - self::$increase[$co]['min_poziom']) + 3) * self::$increase[$co]['atak']);
                $spAttack = $spAttack + ((($lvl - self::$increase[$co]['min_poziom']) + 3) * self::$increase[$co]['sp_atak']);
                $defence = $defence + ((($lvl - self::$increase[$co]['min_poziom']) + 3) * self::$increase[$co]['obrona']);
                $spDefence = $spDefence + ((($lvl - self::$increase[$co]['min_poziom']) + 3) * self::$increase[$co]['sp_obrona']);
                $speed = $speed + ((($lvl - self::$increase[$co]['min_poziom']) + 3) * self::$increase[$co]['szybkosc']);
                $hp = $hp + ((($lvl - self::$increase[$co]['min_poziom']) + 3) * self::$increase[$co]['hp']);
                //1forma
                $attack += ((self::$increase[$co]['min_poziom'] - 2) * $wiersz2['atak']);
                $spAttack = $spAttack + ((self::$increase[$co]['min_poziom'] - 2) * $wiersz2['sp_atak']);
                $defence = $defence + ((self::$increase[$co]['min_poziom'] - 2) * $wiersz2['obrona']);
                $spDefence = $spDefence + ((self::$increase[$co]['min_poziom'] - 2) * $wiersz2['sp_obrona']);
                $speed = $speed + ((self::$increase[$co]['min_poziom'] - 2) * $wiersz2['szybkosc']);
                $hp = $hp + ((self::$increase[$co]['min_poziom'] - 2) * $wiersz2['hp']);
            }
        } else { /////przyrosty pokemona 1 evo
            $rezultat10 = self::$startingStats[$pokemonId];
            $attack += (($lvl - 1) * self::$increase[$pokemonId]['atak']);
            $spAttack = $spAttack + (($lvl - 1) * self::$increase[$pokemonId]['sp_atak']);
            $defence = $defence + (($lvl - 1) * self::$increase[$pokemonId]['obrona']);
            $spDefence = $spDefence + (($lvl - 1) * self::$increase[$pokemonId]['sp_obrona']);
            $speed = $speed + (($lvl - 1) * self::$increase[$pokemonId]['szybkosc']);
            $hp = $hp + (($lvl - 1) * self::$increase[$pokemonId]['hp']);
        }
        $wiersz10 = $rezultat10;
        $attack += $wiersz10['atak'];
        $spAttack += $wiersz10['sp_atak'];
        $defence += $wiersz10['obrona'];
        $spDefence += $wiersz10['sp_obrona'];
        $speed += $wiersz10['szybkosc'];
        $hp += $wiersz10['hp'];

        $pokemon->setAttack($attack);
        $pokemon->setSpAttack($spAttack);
        $pokemon->setDefence($defence);
        $pokemon->setSpDefence($spDefence);
        $pokemon->setSpeed($speed);
        $pokemon->setHp($hp);
        $pokemon->setActualHp(round($pokemon->getHp() * $pokemon->getQuality() / 100));

        $pokemon->setTraining(self::pokemonTrainings());
    }

    private static function generateAttacks(Pokemon &$pokemon)
    {
        $attacks = explode(';', self::$pokemonInfo[$pokemon->getIdPokemon()]['ataki']);
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
