<?php



trait FunctionsPolowanie
{

    private function walkaPokemonow($wiersz, $db, $trener = 0, $stan1 = 0, $stan2 = 0, $runda1 = 0, $runda2 = 0, $pulapka1 = 0, $pulapka2 = 0, $at1 = 1, $at2 = 1, $pok2 = 0, $gracz = 0, $atak_runda1 = 0, $atak_runda2 = 0, $dos1 = 0, $dos2 = 0)
    {
        ////stan = 1 - podpalenie, zabiera 1/8 życia
        ////stan = 2 - paraliż
        ////stan = 3 - otępienie 50% szans na zaatakowanie samego siebie
        ////stan = 4 - otrucie
        ////stan = 5 - śmiertelne otrucie
        ////stan = 6 - sen
        ////stan = 7 - pułapka - obrażenia co rundę takie jak we wcześniejszej
        ////stan = 8 - zamrożenie
        ////stan = 9 - oszołomienie
        ////stan = 10 - zakochanie
        ////stan = 11 - klątwa

        $at[1] = $at2;
        $at[2] = $at1;
        $i = 1;
        $seeded[1] = 0;
        $seeded[2] = 0;
        //$pokemon[1]['uniki'] = 5;
        //$pokemon[2]['uniki'] = 5;
        while ($i < 51 && $pokemon[1]->hp > 0 && $pokemon[2]->hp > 0) {////walka


                if ($can == 1) {

                }

            $i++;
        }
        //koniec pętli z walką między pokami
        if ($trener == 0 && $gracz == 0) {
            if (($pokemon[1]->hp <= 0 && $pokemon[2]->hp <= 0) || ($pokemon[1]->hp > 0 && $pokemon[2]->hp > 0)) {
                $_SESSION['walkat1'] .= '<div class="alert alert-warning text-big  margin-top"><span>WYNIK WALKI: Remis</span></div>';
                $_SESSION['walkat1'] .= '<div class="alert alert-info text-medium margin-top walka_alert text-center-alert"><span>Walka nauczyła coś twojego Pokemona, zyskuje on 5 punktów doświadczenia.<br />Dzięki walce zyskujesz 3 punkty doświadczenia.</span></div>';
                if ($pokemon[2]->hp <= 0) $hp = 0;
                else $hp = $pokemon[2]->hp;
                $db->update('UPDATE pokemony SET exp = (exp + 5), akt_HP = ? WHERE ID = ?', [$hp, $pokemon[2]->i2]);
                $db->update('UPDATE uzytkownicy SET doswiadczenie = (doswiadczenie + 3) WHERE ID = ?', [Session::_get('id')]);
                $id = $pokemon[2]->id;
                User::_get('pok', $id)->edit('dos', (User::_get('pok', $id)->get('dos') + 5));
                User::_get('pok', $id)->edit('akt_zycie', ($hp));
                User::_get('pok', $id)->edit('akt_zycie', $hp);
                Session::_set('tr_exp', (Session::_get('tr_exp') + 3));
            } else if ($pokemon[2]->hp <= 0) {
                $tlo = (rand() % 5) + 3;
                $_SESSION['walkat1'] .= '<div class="alert alert-danger text-big margin-top"><span>WYNIK WALKI: Porażka</span></div>';
                $_SESSION['walkat1'] .= '<div class="alert alert-info text-medium text-center-alert margin-top walka_alert"><span>Walka nauczyła coś twojego Pokemona, zyskuje on 2 punkty doświadczenia.<br />Dzięki walce zyskujesz 1 punkt doświadczenia.</span></div>';
                $db->update('UPDATE pokemony SET exp = (exp + 2), akt_HP = 0, przywiazanie = (przywiazanie - ?) WHERE ID = ?', [$tlo, $pokemon[2]->i2]);
                $db->update('UPDATE uzytkownicy SET doswiadczenie = (doswiadczenie + 1) WHERE ID = ?', [Session::_get('id')]);
                $id = $pokemon[2]->id;
                User::_get('pok', $id)->edit('dos', (User::_get('pok', $id)->get('dos') + 2));
                User::_get('pok', $id)->edit('akt_zycie', 0);
                Session::_set('tr_exp', (Session::_get('tr_exp') + 1));
            } else if ($pokemon[1]->hp <= 0) {
                $_SESSION['walkat1'] .= '<div class="alert alert-success text-big margin-top"><span>WYNIK WALKI: Wygrana</span></div>';
                $st = $_SESSION['pokemon']['pok_poziom'] / $wiersz['poziom'];
                $id = $pokemon[2]->id;
                User::_get('pok', $id)->edit('akt_zycie', $pokemon[2]->hp);
                if ($st <= 0.06) $exp = 3;
                else if ($st > 0.06 && $st <= 0.1) $exp = 5;
                else if ($st > 0.1 && $st <= 0.15) $exp = 7;
                else if ($st > 0.15 && $st <= 0.20) $exp = 8;
                else if ($st > 0.2 && $st <= 0.25) $exp = 10;
                else if ($st > 0.25 && $st <= 0.3) $exp = 13;
                else if ($st > 0.3 && $st <= 0.4) $exp = 14;
                else if ($st > 0.4 && $st <= 0.5) $exp = 17;
                else if ($st > 0.5 && $st <= 0.6) $exp = 18;
                else if ($st > 0.6 && $st <= 0.7) $exp = 20;
                else if ($st > 0.7 && $st <= 0.9) $exp = 22;
                else if ($st > 0.9 && $st <= 1) $exp = 24;
                else if ($st > 1 && $st <= 1.15) $exp = 28;
                else if ($st > 1.15 && $st <= 1.35) $exp = 35;
                else if ($st > 1.35) $exp = 40;
                $exp_t = (rand() % 3) + 3;
                if (Session::_get('pokemon')['trudnosc'] == 10) {
                    $exp *= 2;
                    $exp_t *= 2;
                }
                if (Session::_isset('karta')) {
                    $karta = explode('|', Session::_get('karta'));
                    if ($karta['0'] == '2') {
                        $exp *= 1.25;
                        $exp = round($exp);
                    }
                }
                User::_get('pok', $id)->edit('dos', (User::_get('pok', $id)->get('dos') + $exp));
                Session::_set('tr_exp', (Session::_get('tr_exp') + $exp_t));
                $hpp = $pokemon[2]->hp;
                $tlo = (rand() % 5) + 3;
                $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-info text-medium margin-top text-center-alert"><span>Walka nauczyła coś twojego Pokemona, zyskuje on ' . $exp . ' punktów doświadczenia<br />Dzięki walce zyskujesz ' . $exp_t . ' punktów doświadczenia.</span></div>';
                $db->update('UPDATE pokemony SET exp = (exp + ?), akt_HP = ?, przywiazanie = (przywiazanie + ?) WHERE ID = ?', [$exp, $hpp, $tlo, $pokemon[2]->i2]);
                $db->update('UPDATE uzytkownicy SET doswiadczenie = (doswiadczenie + ?) WHERE ID = ?', [$exp_t, Session::_get('id')]);
                $db->update('UPDATE osiagniecia SET pokonane_poki = (pokonane_poki + 1) WHERE id_gracza = ?', [Session::_get('id')]);
                if (Session::_get('pokemon')['trudnosc'] < 10) {
                    $this->wyswietlPokeballe($db);
                } else {
                    $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-warning text-medium margin-top text-center-alert"><span>Pokemon jest pod ochroną i nie możesz go łapać.</span></div>';
                    $kamien = 0;
                    if (in_array($pokemon[1]->id_poka, [59, 38, 136]))//ognisty
                    {
                        $rand = rand(1, 100);
                        if ($rand == 55) {
                            $kamien = 1;
                            $rodzaj = 'ogniste';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą kamień ognisty!</span></div>';
                        }
                    } else if (in_array($pokemon[1]->id_poka, [62, 91, 121, 134]))//wodny
                    {
                        $rand = rand(1, 100);
                        if ($rand == 55) {
                            $kamien = 1;
                            $rodzaj = 'wodne';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą kamień wodny!</span></div>';
                        }
                    } else if (in_array($pokemon[1]->id_poka, [45, 71, 102]))//roślinny
                    {
                        $rand = rand(1, 100);
                        if ($rand == 55) {
                            $kamien = 1;
                            $rodzaj = 'roslinne';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą kamień roślinny!</span></div>';
                        }
                    } else if (in_array($pokemon[1]->id_poka, [16, 135]))//gromu
                    {
                        $rand = rand(1, 100);
                        if ($rand == 55) {
                            $kamien = 1;
                            $rodzaj = 'gromu';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą kamień gromu!</span></div>';
                        }
                    } else if (in_array($pokemon[1]->id_poka, [34, 31, 36, 40]))//księżycowy
                    {
                        $rand = rand(1, 100);
                        if ($rand == 55) {
                            $kamien = 1;
                            $rodzaj = 'ksiezycowe';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą kamień księżycowy!</span></div>';
                        }
                    } else if ($pokemon[1]->id_poka == 65)//kamień filozoficzny
                    {
                        $rand = rand(1, 16);
                        if ($rand == 11) {
                            $kamien = 1;
                            $rodzaj = 'kamien';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą kamień filozoficzny!</span></div>';
                        }
                    } else if ($pokemon[1]->id_poka == 76)//obsydian
                    {
                        $rand = rand(1, 16);
                        if ($rand == 11) {
                            $kamien = 1;
                            $rodzaj = 'obsydian';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą obsydian!</span></div>';
                        }
                    } else if ($pokemon[1]->id_poka == 68) {//czarny pas
                        $rand = rand(1, 16);
                        if ($rand == 11) {
                            $kamien = 1;
                            $rodzaj = 'pas';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą czarny pas!</span></div>';
                        }
                    } else if ($pokemon[1]->id_poka == 94) {//ektoplazma
                        $rand = rand(1, 16);
                        if ($rand == 11) {
                            $kamien = 1;
                            $rodzaj = 'ektoplazma';
                            $_SESSION['walkat1'] .= '<div class="walka_alert alert alert-success text-center"><span>Pokemon gubi za sobą ektoplazmę!</span></div>';
                        }
                    }
                    if ($kamien == 1)
                        $db->sql_query("UPDATE kamienie SET $rodzaj = ($rodzaj + 1) WHERE id_gracza = " . $user->__get('id'));
                }
            }
        } elseif ($trener == 1) {
            if (($pokemon[1]->hp <= 0 && $pokemon[2]->hp <= 0)) {
                //$db->sql_query("UPDATE pokemony SET akt_HP = 0 WHERE ID = '".$pokemon[2]['id']."'");
                $id = $pokemon[2]->i2;
                User::_get('pok', $id)->edit('akt_zycie', 0);
                $tablica['kto'] = 3;//oba przegrały
                return $tablica;
            }
            if ($pokemon[1]->hp > 0 && $pokemon[2]->hp > 0) {//oba mają życie
                //$db->sql_query('UPDATE pokemony SET akt_HP = '.$pokemon[2]->hp.' WHERE ID = '.$pokemon[2]->id);
                $id = $pokemon[2]->i2;
                User::_get('pok', $id)->edit('akt_zycie', $pokemon[2]->hp);
                if (($pokemon[1]->hp / $pokemon[1]->max_hp) > ($pokemon[2]->hp / $pokemon[2]->max_hp)) $pokemon[2]->hp = 0;
                else if (($pokemon[1]->hp / $pokemon[1]->max_hp) < ($pokemon[2]->hp / $pokemon[2]->max_hp)) $pokemon[1]->hp = 0;
                else {
                    $tablica['kto'] = 3;
                    return $tablica;
                }
            }
            if ($pokemon[1]->hp <= 0) $i = 2;
            else if ($pokemon[2]->hp <= 0) $i = 1;
            //$db->sql_query("UPDATE pokemony SET akt_HP = '".$pokemon[2]['hp']."' WHERE ID = '".$pokemon[2]['id']."'");
            $id = $pokemon[2]->i2;
            if ($pokemon[2]->hp < 0) $pokemon[2]->hp = 0;
            User::_get('pok', $id)->edit('akt_zycie', $pokemon[2]->hp);
            $tablica['kto'] = $i;
            $tablica['atak'] = $pokemon[$i]->atak;
            $tablica['sp_atak'] = $pokemon[$i]->sp_atak;
            $tablica['obrona'] = $pokemon[$i]->obrona;
            $tablica['sp_obrona'] = $pokemon[$i]->sp_obrona;
            $tablica['szybkosc'] = $pokemon[$i]->szybkosc;
            $tablica['celnosc'] = $pokemon[$i]->celnosc;
            $tablica['hp'] = $pokemon[$i]->hp;
            $tablica['stan'] = $pokemon[$i]->stan;
            $tablica['runda'] = $pokemon[$i]->runda;
            $tablica['pulapka'] = $pokemon[$i]->pulapka;
            $tablica['id_poka'] = $pokemon[$i]->id_poka;
            $tablica['max_hp'] = $pokemon[$i]->max_hp;
            $tablica['typ1'] = $pokemon[$i]->typ1;
            $tablica['typ2'] = $pokemon[$i]->typ2;
            $tablica['at'] = $at[$i];
            $tablica['atak_runda'] = $pokemon[$i]->atak_runda;
            for ($j = 1; $j < 5; $j++)
                $tablica['atak' . $j]['id'] = $pokemon[$i]->ataki[$j]['ID'];

            return $tablica;
        } else if ($gracz == 1) {
            if (($pokemon[1]['hp'] <= 0 && $pokemon[2]['hp'] <= 0)) {
                $tablica['kto'] = 3;//oba przegrały
                return $tablica;
            }
            if ($pokemon[1]['hp'] > 0 && $pokemon[2]['hp'] > 0) {//oba mają życie
                if (($pokemon[1]['hp'] / $pokemon[1]['max_hp']) > ($pokemon[2]['hp'] / $pokemon[2]['max_hp'])) $pokemon[2]['hp'] = 0;
                elseif (($pokemon[1]['hp'] / $pokemon[1]['max_hp']) < ($pokemon[2]['hp'] / $pokemon[2]['max_hp'])) $pokemon[1]['hp'] = 0;
                else {
                    $tablica['kto'] = 3;
                    return $tablica;
                }
            }
            if ($pokemon[1]['hp'] <= 0) {//wygrał pok 2
                $tablica['kto'] = 2;
                $tablica['atak'] = $pokemon[2]['atak'];
                $tablica['sp_atak'] = $pokemon[2]['sp_atak'];
                $tablica['obrona'] = $pokemon[2]['obrona'];
                $tablica['sp_obrona'] = $pokemon[2]['sp_obrona'];
                $tablica['szybkosc'] = $pokemon[2]['szybkosc'];
                $tablica['celnosc'] = $pokemon[2]['celnosc'];
                $tablica['hp'] = $pokemon[2]['hp'];
                $tablica['stan'] = $pokemon[2]['stan'];
                $tablica['runda'] = $pokemon[2]['runda'];
                $tablica['pulapka'] = $pokemon[2]['pulapka'];
                $tablica['obrona'] = $pokemon[2]['obrona'];
                $tablica['id_poka'] = $pokemon[2]['id_poka'];
                $tablica['max_hp'] = $pokemon[2]['max_hp'];
                $tablica['typ1'] = $pokemon[2]['typ1'];
                $tablica['typ2'] = $pokemon[2]['typ2'];
                $tablica['at'] = $at['2'];
                $tablica['atak_runda'] = $pokemon[2]['atak_runda'];
                for ($i = 1; $i < 5; $i++) {
                    $tablica['atak' . $i]['id'] = $pokemon[2]['atak' . $i]['id'];
                    $tablica['atak' . $i]['nazwa'] = $pokemon[2]['atak' . $i]['nazwa'];
                    $tablica['atak' . $i]['moc'] = $pokemon[2]['atak' . $i]['moc'];
                    $tablica['atak' . $i]['typ'] = $pokemon[2]['atak' . $i]['typ'];
                    $tablica['atak' . $i]['celnosc'] = $pokemon[2]['atak' . $i]['celnosc'];
                    $tablica['atak' . $i]['rodzaj'] = $pokemon[2]['atak' . $i]['rodzaj'];
                }
                return $tablica;
            } elseif ($pokemon[2]['hp'] <= 0) {//wygrał pok 1
                $tablica['kto'] = 1;
                $tablica['atak'] = $pokemon[1]['atak'];
                $tablica['sp_atak'] = $pokemon[1]['sp_atak'];
                $tablica['obrona'] = $pokemon[1]['obrona'];
                $tablica['sp_obrona'] = $pokemon[1]['sp_obrona'];
                $tablica['szybkosc'] = $pokemon[1]['szybkosc'];
                $tablica['celnosc'] = $pokemon[1]['celnosc'];
                $tablica['hp'] = $pokemon[1]['hp'];
                $tablica['stan'] = $pokemon[1]['stan'];
                $tablica['runda'] = $pokemon[1]['runda'];
                $tablica['pulapka'] = $pokemon[1]['pulapka'];
                $tablica['obrona'] = $pokemon[1]['obrona'];
                $tablica['id_poka'] = $pokemon[1]['id_poka'];
                $tablica['max_hp'] = $pokemon[1]['max_hp'];
                $tablica['typ1'] = $pokemon[1]['typ1'];
                $tablica['typ2'] = $pokemon[1]['typ2'];
                $tablica['at'] = $at['1'];
                $tablica['atak_runda'] = $pokemon[1]['atak_runda'];
                for ($i = 1, $j = 0; $i < 5; $i++, $j++) {
                    $tablica['atak' . $j]['id'] = $pokemon[1]['atak' . $i]['id'];
                    $tablica['atak' . $j]['nazwa'] = $pokemon[1]['atak' . $i]['nazwa'];
                    $tablica['atak' . $j]['moc'] = $pokemon[1]['atak' . $i]['moc'];
                    $tablica['atak' . $j]['typ'] = $pokemon[1]['atak' . $i]['typ'];
                    $tablica['atak' . $j]['celnosc'] = $pokemon[1]['atak' . $i]['celnosc'];
                    $tablica['atak' . $j]['rodzaj'] = $pokemon[1]['atak' . $i]['rodzaj'];
                }
                return $tablica;
            }
        }
    }

}