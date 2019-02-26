<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\User;

class GameHuntingHelper
{
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    public function __construct(PokemonHelper $pokemonHelper)
    {
        $this->pokemonHelper = $pokemonHelper;
    }

    public function eventInPlace(string $place): array
    {
        return $this->{'event'.ucfirst($place)}();
    }

    public function generatePokemon(string $place, User $user): Pokemon
    {
//sprawdzenie warunków spotkania shiny u gracza
        //jeśli wszystko ok:
        /* $shiny = 0;
          //sprawdzenie przedmiotu itp.
          $sh = $this->model->db->select('SELECT * FROM shiny WHERE ID = 1', []);
          $sh = $sh[0];
          if($sh['ilosc_do_zlapania'] > 0){
          $zl = $this->model->db->select('SELECT zlapana_grupa FROM uzytkownicy WHERE ID = :id', [':id' => Session::_get('id')]);
          $zl = $zl[0];
          if($zl['zlapana_grupa'] === 0) $shiny = 1;
          }
          //sprawdzenie warunków spotkania shiny u gracza koniec
          if($shiny === 1){
          $sh_id = $sh['id_poka'];
          $sh_dzicz = $sh['dzicz'];
          //przypisanie dziczy do shiny:
          } */

        /* $czy_shiny = 0;
          if($shiny != 0){
          $co = $sh_id;
          $czy_shiny = 1;
          } */
        /**
         * $rrr = $co . "s"; ///dodać informacje czy złapany
        $rrr1 = $co . "z";
        $zlapany = $this->pokemonKolekcja($rrr, $rrr1);
         */
        $id = $this->{$place.'RoundId'}($user->getTrainerLevel());
        $pokemon = $this->pokemonHelper->generatePokemon(
            $id,
            $this->roundPokemonLevel($user->getTrainerLevel(), $id)
        );

        return $pokemon;
    }

    private function roundPokemonLevel(int $userLevel, int $idPokemon): int
    {
        $minLevelPokemon = $this->pokemonHelper->getInfo($idPokemon)['min_poziom'];
        if (($userLevel + 6 - $minLevelPokemon) === 0) {
            $minLevelToRound = 1;
        } else {
            if ($userLevel <= 10) {
                $minLevelToRound = $userLevel + 4 - $minLevelPokemon;
            } else {
                $minLevelToRound = $userLevel + 6 - $minLevelPokemon;
            }
        }
        $lvl = (mt_rand() % $minLevelToRound) + $minLevelPokemon;
        if ($lvl > 100) {
            if ($minLevelPokemon === 100) {
                $lvl = 100;
            } else {
                $lvl = mt_rand($minLevelPokemon + 1, 100);
            }
        }
        return $lvl;
    }

    private function polanaRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        //warunki shiny koniec
        $szansa = 10200;
        while ($min_poz >= $userLevel + 6) {
            /* if($shiny === 1 && $sh_dzicz === 1){
              $szansa = $sh['szansa']*102;
              $szansa += 10200;
              $l = mt_rand(1, $szansa);
              }
              else */
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 1) {
                $co = 151;
            } elseif ($l <= 851) {
                $co = 10;
            } elseif ($l <= 1701) {
                $co = 13;
            } elseif ($l <= 2551) {
                $co = 16;
            } elseif ($l <= 3401) {
                $co = 23;
            } elseif ($l <= 4251) {
                $co = 43;
            } elseif ($l <= 5101) {
                $co = 69;
            } elseif ($l <= 5551) {
                $co = 1;
            } elseif ($l <= 5901) {
                $co = 11;
            } elseif ($l <= 6251) {
                $co = 14;
            } elseif ($l <= 6601) {
                $co = 17;
            } elseif ($l <= 6951) {
                $co = 24;
            } elseif ($l <= 7301) {
                $co = 25;
            } elseif ($l <= 7651) {
                $co = 44;
            } elseif ($l <= 8001) {
                $co = 70;
            } elseif ($l <= 8351) {
                $co = 108;
            } elseif ($l <= 8701) {
                $co = 114;
            } elseif ($l <= 8801) {
                $co = 2;
            } elseif ($l <= 9101) {
                $co = 12;
            } elseif ($l <= 9301) {
                $co = 15;
            } elseif ($l <= 9501) {
                $co = 18;
            } elseif ($l <= 9801) {
                $co = 102;
            } elseif ($l <= 9831) {
                $co = 3;
            } elseif ($l <= 9951) {
                $co = 37;
            } elseif ($l <= 9961) {
                $co = 26;
            } elseif ($l <= 9971) {
                $co = 38;
            } elseif ($l <= 9981) {
                $co = 45;
            } elseif ($l <= 9999) {
                $co = 71;
            } elseif ($l <= 10100) {
                $co = 103;
            } elseif ($l <= 10200) {
                $co = 133;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function wyspaRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10000;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 1) {
                $co = 150;
            } elseif ($l <= 701) {
                $co = 19;
            } elseif ($l <= 1401) {
                $co = 23;
            } elseif ($l <= 2101) {
                $co = 29;
            } elseif ($l <= 2801) {
                $co = 32;
            } elseif ($l <= 3501) {
                $co = 46;
            } elseif ($l <= 4201) {
                $co = 52;
            } elseif ($l <= 4901) {
                $co = 98;
            } elseif ($l <= 5301) {
                $co = 24;
            } elseif ($l <= 5701) {
                $co = 33;
            } elseif ($l <= 6101) {
                $co = 30;
            } elseif ($l <= 6501) {
                $co = 48;
            } elseif ($l <= 6901) {
                $co = 47;
            } elseif ($l <= 7301) {
                $co = 58;
            } elseif ($l <= 7701) {
                $co = 96;
            } elseif ($l <= 8501) {
                $co = 100;
            } elseif ($l <= 8901) {
                $co = 20;
            } elseif ($l <= 9001) {
                $co = 49;
            } elseif ($l <= 9101) {
                $co = 53;
            } elseif ($l <= 9301) {
                $co = 79;
            } elseif ($l <= 9401) {
                $co = 97;
            } elseif ($l <= 9501) {
                $co = 101;
            } elseif ($l <= 9601) {
                $co = 108;
            } elseif ($l <= 9701) {
                $co = 99;
            } elseif ($l <= 9751) {
                $co = 80;
            } elseif ($l <= 9801) {
                $co = 124;
            } elseif ($l <= 9868) {
                $co = 31;
            } elseif ($l <= 9934) {
                $co = 34;
            } elseif ($l <= 10000) {
                $co = 59;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function grotaRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10000;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 1) {
                $co = 146;
            } elseif ($l <= 1101) {
                $co = 23;
            } elseif ($l <= 2201) {
                $co = 41;
            } elseif ($l <= 3301) {
                $co = 50;
            } elseif ($l <= 4401) {
                $co = 109;
            } elseif ($l <= 5501) {
                $co = 88;
            } elseif ($l <= 6001) {
                $co = 24;
            } elseif ($l <= 6501) {
                $co = 42;
            } elseif ($l <= 7001) {
                $co = 51;
            } elseif ($l <= 7501) {
                $co = 92;
            } elseif ($l <= 8001) {
                $co = 110;
            } elseif ($l <= 8501) {
                $co = 89;
            } elseif ($l <= 9001) {
                $co = 27;
            } elseif ($l <= 9501) {
                $co = 95;
            } elseif ($l <= 9601) {
                $co = 93;
            } elseif ($l <= 9751) {
                $co = 35;
            } elseif ($l <= 9901) {
                $co = 39;
            } elseif ($l <= 9951) {
                $co = 28;
            } elseif ($l <= 9981) {
                $co = 94;
            } elseif ($l <= 9991) {
                $co = 36;
            } elseif ($l <= 10000) {
                $co = 40;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function domstrachowRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        $szansa = 10000;
        while ($min_poz >= $userLevel + 6) {
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 1) {
                $co = 145;
            } elseif ($l <= 1301) {
                $co = 19;
            } elseif ($l <= 2601) {
                $co = 41;
            } elseif ($l <= 3601) {
                $co = 88;
            } elseif ($l <= 4801) {
                $co = 96;
            } elseif ($l <= 5801) {
                $co = 104;
            } elseif ($l <= 6301) {
                $co = 20;
            } elseif ($l <= 6801) {
                $co = 42;
            } elseif ($l <= 7101) {
                $co = 63;
            } elseif ($l <= 7501) {
                $co = 89;
            } elseif ($l <= 7801) {
                $co = 92;
            } elseif ($l <= 8201) {
                $co = 97;
            } elseif ($l <= 8901) {
                $co = 122;
            } elseif ($l <= 9201) {
                $co = 105;
            } elseif ($l <= 9351) {
                $co = 64;
            } elseif ($l <= 9501) {
                $co = 93;
            } elseif ($l <= 9681) {
                $co = 106;
            } elseif ($l <= 9861) {
                $co = 107;
            } elseif ($l <= 9961) {
                $co = 124;
            } elseif ($l <= 9980) {
                $co = 137;
            } elseif ($l <= 9990) {
                $co = 65;
            } elseif ($l <= 10000) {
                $co = 94;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function goryRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        $szansa = 10000;
        while ($min_poz >= $userLevel + 6) {
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 1000) {
                $co = 21;
            } elseif ($l <= 2000) {
                $co = 56;
            } elseif ($l <= 3000) {
                $co = 74;
            } elseif ($l <= 4000) {
                $co = 104;
            } elseif ($l <= 5000) {
                $co = 111;
            } elseif ($l <= 6000) {
                $co = 66;
            } elseif ($l <= 7000) {
                $co = 77;
            } elseif ($l <= 7320) {
                $co = 4;
            } elseif ($l <= 7690) {
                $co = 22;
            } elseif ($l <= 8010) {
                $co = 57;
            } elseif ($l <= 8330) {
                $co = 75;
            } elseif ($l <= 8700) {
                $co = 95;
            } elseif ($l <= 9070) {
                $co = 105;
            } elseif ($l <= 9390) {
                $co = 112;
            } elseif ($l <= 9710) {
                $co = 67;
            } elseif ($l <= 9810) {
                $co = 5;
            } elseif ($l <= 9860) {
                $co = 6;
            } elseif ($l <= 9880) {
                $co = 76;
            } elseif ($l <= 9950) {
                $co = 78;
            } elseif ($l <= 9970) {
                $co = 68;
            } elseif ($l <= 9990) {
                $co = 81;
            } elseif ($l <= 10000) {
                $co = 82;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function wodospadRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        $szansa = 10000;
        while ($min_poz >= $userLevel + 6) {
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 1) {
                $co = 144;
            } elseif ($l <= 701) {
                $co = 54;
            } elseif ($l <= 1401) {
                $co = 60;
            } elseif ($l <= 2101) {
                $co = 72;
            } elseif ($l <= 2801) {
                $co = 79;
            } elseif ($l <= 3501) {
                $co = 86;
            } elseif ($l <= 4201) {
                $co = 90;
            } elseif ($l <= 4901) {
                $co = 98;
            } elseif ($l <= 5601) {
                $co = 118;
            } elseif ($l <= 6301) {
                $co = 129;
            } elseif ($l <= 6701) {
                $co = 7;
            } elseif ($l <= 7101) {
                $co = 55;
            } elseif ($l <= 7501) {
                $co = 61;
            } elseif ($l <= 7901) {
                $co = 73;
            } elseif ($l <= 8301) {
                $co = 99;
            } elseif ($l <= 8701) {
                $co = 116;
            } elseif ($l <= 9101) {
                $co = 119;
            } elseif ($l <= 9501) {
                $co = 120;
            } elseif ($l <= 9601) {
                $co = 8;
            } elseif ($l <= 9651) {
                $co = 80;
            } elseif ($l <= 9701) {
                $co = 87;
            } elseif ($l <= 9751) {
                $co = 117;
            } elseif ($l <= 9801) {
                $co = 130;
            } elseif ($l <= 9851) {
                $co = 131;
            } elseif ($l <= 9901) {
                $co = 9;
            } elseif ($l <= 9934) {
                $co = 62;
            } elseif ($l <= 9967) {
                $co = 91;
            } elseif ($l <= 10000) {
                $co = 121;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function safariRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10598;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 708) {
                $co = 21;
            } elseif ($l <= 1416) {
                $co = 46;
            } elseif ($l <= 2124) {
                $co = 48;
            } elseif ($l <= 2832) {
                $co = 54;
            } elseif ($l <= 3540) {
                $co = 84;
            } elseif ($l <= 4248) {
                $co = 108;
            } elseif ($l <= 4956) {
                $co = 111;
            } elseif ($l <= 5448) {
                $co = 22;
            } elseif ($l <= 5848) {
                $co = 47;
            } elseif ($l <= 6248) {
                $co = 49;
            } elseif ($l <= 6648) {
                $co = 55;
            } elseif ($l <= 7048) {
                $co = 102;
            } elseif ($l <= 7448) {
                $co = 83;
            } elseif ($l <= 7848) {
                $co = 85;
            } elseif ($l <= 8248) {
                $co = 112;
            } elseif ($l <= 8548) {
                $co = 103;
            } elseif ($l <= 8898) {
                $co = 113;
            } elseif ($l <= 9198) {
                $co = 114;
            } elseif ($l <= 9548) {
                $co = 115;
            } elseif ($l <= 9948) {
                $co = 124;
            } elseif ($l <= 10098) {
                $co = 128;
            } elseif ($l <= 10298) {
                $co = 127;
            } elseif ($l <= 10398) {
                $co = 125;
            } elseif ($l <= 10498) {
                $co = 126;
            } elseif ($l <= 10598) {
                $co = 123;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function lakaRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10000;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 700) {
                $co = 161;
            } elseif ($l <= 1400) {
                $co = 165;
            } elseif ($l <= 2100) {
                $co = 179;
            } elseif ($l <= 2800) {
                $co = 43;
            } elseif ($l <= 3500) {
                $co = 187;
            } elseif ($l <= 4200) {
                $co = 191;
            } elseif ($l <= 4950) {
                $co = 204;
            } elseif ($l <= 5100) {
                $co = 154;
            } elseif ($l <= 5200) {
                $co = 182;
            } elseif ($l <= 5300) {
                $co = 192;
            } elseif ($l <= 5700) {
                $co = 209;
            } elseif ($l <= 6100) {
                $co = 205;
            } elseif ($l <= 6500) {
                $co = 152;
            } elseif ($l <= 6900) {
                $co = 162;
            } elseif ($l <= 7300) {
                $co = 166;
            } elseif ($l <= 7700) {
                $co = 180;
            } elseif ($l <= 8100) {
                $co = 44;
            } elseif ($l <= 8500) {
                $co = 188;
            } elseif ($l <= 8700) {
                $co = 153;
            } elseif ($l <= 8900) {
                $co = 181;
            } elseif ($l <= 9100) {
                $co = 177;
            } elseif ($l <= 9300) {
                $co = 189;
            } elseif ($l <= 9500) {
                $co = 210;
            } elseif ($l <= 9700) {
                $co = 241;
            } elseif ($l <= 9850) {
                $co = 178;
            } elseif ($l <= 10000) {
                $co = 172;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function lodowiecRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10000;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 2300) {
                $co = 137;
            } elseif ($l <= 4600) {
                $co = 225;
            } elseif ($l <= 6900) {
                $co = 216;
            } elseif ($l <= 7400) {
                $co = 234;
            } elseif ($l <= 7900) {
                $co = 220;
            } elseif ($l <= 8400) {
                $co = 215;
            } elseif ($l <= 8600) {
                $co = 221;
            } elseif ($l <= 8800) {
                $co = 217;
            } elseif ($l <= 9000) {
                $co = 231;
            } elseif ($l <= 9200) {
                $co = 246;
            } elseif ($l <= 9350) {
                $co = 238;
            } elseif ($l <= 9500) {
                $co = 124;
            } elseif ($l <= 9600) {
                $co = 248;
            } elseif ($l <= 9700) {
                $co = 233;
            } elseif ($l <= 9850) {
                $co = 232;
            } elseif ($l <= 10000) {
                $co = 247;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function mokradlaRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10000;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 2300) {
                $co = 193;
            } elseif ($l <= 4600) {
                $co = 60;
            } elseif ($l <= 6800) {
                $co = 194;
            } elseif ($l <= 7300) {
                $co = 183;
            } elseif ($l <= 7800) {
                $co = 61;
            } elseif ($l <= 8300) {
                $co = 211;
            } elseif ($l <= 8800) {
                $co = 222;
            } elseif ($l <= 9100) {
                $co = 214;
            } elseif ($l <= 9200) {
                $co = 184;
            } elseif ($l <= 9400) {
                $co = 206;
            } elseif ($l <= 9700) {
                $co = 195;
            } elseif ($l <= 10000) {
                $co = 234;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function wulkanRoundId(int $userLevel): int
    {
        $co = 0;
        $min_poz = 2000000000;
        while ($min_poz >= $userLevel + 6) {
            $szansa = 10000;
            $l = mt_rand(1, $szansa); //prawdopodobieństwo do 0,01% (0,0001)
            if ($l <= 2100) {
                $co = 95;
            } elseif ($l <= 4200) {
                $co = 190;
            } elseif ($l <= 6450) {
                $co = 218;
            } elseif ($l <= 6600) {
                $co = 123;
            } elseif ($l <= 6700) {
                $co = 212;
            } elseif ($l <= 6800) {
                $co = 208;
            } elseif ($l <= 6900) {
                $co = 227;
            } elseif ($l <= 7300) {
                $co = 155;
            } elseif ($l <= 7700) {
                $co = 207;
            } elseif ($l <= 8100) {
                $co = 219;
            } elseif ($l <= 8500) {
                $co = 228;
            } elseif ($l <= 8900) {
                $co = 196;
            } elseif ($l <= 9100) {
                $co = 156;
            } elseif ($l <= 9300) {
                $co = 185;
            } elseif ($l <= 9500) {
                $co = 228;
            } elseif ($l <= 9700) {
                $co = 240;
            } elseif ($l <= 9850) {
                $co = 126;
            } elseif ($l <= 10000) {
                $co = 157;
            }

            $min_poz = $this->pokemonHelper->getInfo($co)['min_poziom'];
        }
        return $co;
    }

    private function eventLaka(): array
    {
        $table['pa'] = 10;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -1; //jagody
        } elseif ($l <= 400) {
            $table['event'] = -14; //mistrz
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventLodowiec(): array
    {
        $table['pa'] = 20;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -15; //zamieć
        } elseif ($l <= 400) {
            $table['event'] = -16; //bryły
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventMokradla(): array
    {
        $table['pa'] = 15;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -17; //negatywne
        } elseif ($l <= 400) {
            $table['event'] = -13; //pozytywne
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventWulkan(): array
    {
        $table['pa'] = 15;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -12; //negatywne
        } elseif ($l <= 400) {
            $table['event'] = -13; //pozytywne
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventJohto5(): array
    {
        $table['pa'] = 15;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -12; //negatywne
        } elseif ($l <= 400) {
            $table['event'] = -13; //pozytywne
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventJezioro(): array
    {
        $table['pa'] = 15;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -12; //negatywne
        } elseif ($l <= 400) {
            $table['event'] = -13; //pozytywne
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventMrocznyLas(): array
    {
        if (date("G") > 21 || date("G") < 6) {
            $table['pa'] = 15;
            $l = mt_rand(1, 1000);
            if ($l <= 200) {
                $table['event'] = 0; //pusta wyprawa
            } elseif ($l <= 300) {
                $table['event'] = -12; //negatywne
            } elseif ($l <= 400) {
                $table['event'] = -13; //pozytywne
            } elseif ($l <= 550) {
                $table['event'] = -999; //trener
            } elseif ($l <= 1000) {
                $table['event'] = 1024; //pokemon
            }
            return $table;
        } else {
            return [
                'event' => 100,
                'pa' => 0
            ];
        }
    }

    private function eventPolana(): array
    {
        $table['pa'] = 10;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -1; //jagody
        } elseif ($l <= 400) {
            $table['event'] = -2; //mędrzec
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }

        return $table;
    }

    private function eventWyspa(): array
    {
        $table['pa'] = 10;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -3; //zgubienie się
        } elseif ($l <= 400) {
            $table['event'] = -4; //oaza
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }

        return $table;
    }

    private function eventGrota(): array
    {
        $table['pa'] = 10;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -5; //skarb
        } elseif ($l <= 400) {
            $table['event'] = -6; //zgubienie się
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventGory(): array
    {
        $table['pa'] = 20;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -9; //jagody
        } elseif ($l <= 500) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventDomstrachow(): array
    {
        $table['pa'] = 15;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -7; //pokemony
        } elseif ($l <= 400) {
            $table['event'] = -8; //przedmiot
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventWodospad(): array
    {
        $table['pa'] = 10;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -19; //błysk na górze
        } elseif ($l <= 400) {
            $table['event'] = -11; //negatywne wydarzenie
        } elseif ($l <= 550) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }

    private function eventSafari(): array
    {
        $table['pa'] = 20;
        $l = mt_rand(1, 1000);
        if ($l <= 200) {
            $table['event'] = 0; //pusta wyprawa
        } elseif ($l <= 300) {
            $table['event'] = -1; //jagody
        } elseif ($l <= 400) {
            $table['event'] = -18; //kopanie
        } elseif ($l <= 500) {
            $table['event'] = -20; //pok zabierający jagodę z plecaka
        } elseif ($l <= 650) {
            $table['event'] = -999; //trener
        } elseif ($l <= 1000) {
            $table['event'] = 1024; //pokemon
        }
        return $table;
    }
}
