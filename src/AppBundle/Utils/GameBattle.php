<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;

class GameBattle
{
    /**
     * @var Pokemon[]
     */
    private $pokemon;
    /**
     * @var PokemonStatsInBattle[]
     */
    private $stats;
    /**
     * @var string
     */
    private $battleText;
    /**
     * @var int
     */
    private $round;
    /**
     * @var int
     */
    private $score;
    /**
     * @var AttackHelper
     */
    private $attacks;
    /**
     * @var array
     */
    private $currentAttack;
    /**
     * @var array
     */
    private $currentAttackSpecial;

    public function __construct(AttackHelper $attacks)
    {
        $this->attacks = $attacks;
    }

    public function getUserPokemonStats(): PokemonStatsInBattle
    {
        return $this->stats[0];
    }

    public function getPlacePokemonStats(): PokemonStatsInBattle
    {
        return $this->stats[1];
    }

    public function getPokemonUser()
    {
        return $this->pokemon[0];
    }

    public function getPokemonInPlace()
    {
        return $this->pokemon[1];
    }

    public function getBattleText(): string
    {
        return $this->battleText;
    }

    public function clearBattleText()
    {
        $this->battleText = '';
    }

    public function getScore()
    {
        $this->setScore();
        return $this->score;
    }

    public function getUserPokemonHp()
    {
        if ($this->pokemon[0]->getActualHp() < 0) {
            $this->pokemon[0]->setActualHp(0);
        }
        return $this->pokemon[0]->getActualHp();
    }

    public function setPokemons(Pokemon $pokemon1, Pokemon $pokemon2)
    {
        $this->pokemon = [
            0 => $pokemon1,
            1 => $pokemon2
        ];
    }

    public function setStats(PokemonStatsInBattle $stats1, PokemonStatsInBattle $stats2)
    {
        $this->stats = [
            0 => $stats1,
            1 => $stats2
        ];
        $this->stats[0]->setBegginingHp($this->pokemon[0]->getActualHp());
        $this->stats[1]->setBegginingHp($this->pokemon[1]->getActualHp());
    }

    public function battleBetweenPokemons(?string $presentation = null)
    {
        if ($presentation !== null) {
            $this->battleText .= $presentation;
        }
        $this->round = 1;

        while ($this->round <= 300 && $this->checkIfPokemonsHaveHp()) {
            $this->beforeRound();
            $this->presentation();
            $this->attack();
            $this->round++;
        }
    }

    private function presentation(): void
    {
        if ($this->round === 1) {
            $this->addLuckInfo();
            $this->addAttachmentInfo();
            $this->addShinyInfo();
        }

        $this->battleText .= 'alert.rundaRUNDA </span><span class="zloty pogrubienie">' . $this->round . '/sdiv';
        $this->battleText .= '<div class="row nomargin"><div class="col-xs-12"><div class="panel panel-primary jeden_ttlo noborder"><div class="row nomargin">';
        //pokemon gracza
        $this->battleText .= '<div class="col-xs-12 col-md-6"><div class="row nomargin">';
        $this->battleText .= '<div class="col-xs-6 col-md-4 col-lg-3 padding_top">';
        $this->battleText .= '<img src="../../img/poki/srednie/';
        $this->battleText .= $this->pokemon[0]->getShiny() ? 's' : '';
        $this->battleText .= $this->pokemon[0]->getIdPokemon() . '.png" data-toggle="tooltip" 
            data-title="' . $this->pokemon[0]->getName() . '" class="center img-responsive" />';
        $this->battleText .= '</div>';
        $this->battleText .= '<div class="col-xs-6 col-md-8 col-lg-9">';
        $this->battleText .= '<div class="well well-stan noborder padding_2 margin_2 text-center alert-success"><span>';
        $this->battleText .= $this->pokemon[0]->getShiny() ? 'Shiny ' : '';
        $this->battleText .= $this->pokemon[0]->getName();
        $this->battleText .= '/sdiv';//well

        $this->battleText .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">A: ' . $this->pokemon[0]->getAttack() . ' Sp.A:' . $this->pokemon[0]->getSpAttack() . '</div>';
        $this->battleText .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">O: ' . $this->pokemon[0]->getDefence() . ' Sp.O: ' . $this->pokemon[0]->getSpDefence() . '</div>';
        $this->battleText .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">SZ: ' . $this->pokemon[0]->getSpeed() . ' C: ' . $this->pokemon[0]->getAccuracy() . '%</div>';
        $this->battleText .= '<div class="progress progress-gra prog_HP" data-original-title="Życie pokemona" data-toggle="tooltip" data-placement="top">';
        $this->battleText .= '<div class="progress-bar progress-bar-success progBarHP" role="progressbar" aria-valuenow="40"';
        $dl = floor($this->pokemon[0]->getActualHp() / $this->pokemon[0]->getHpToTable() * 10000) / 100;
        $this->battleText .= 'aria-valuemin="0" aria-valuemax="100" style="width:' . $dl . '%;">';
        $this->battleText .= '<span>' . $this->pokemon[0]->getActualHp() . ' / ' . $this->pokemon[0]->getHpToTable() . ' PŻ</span>';
        $this->battleText .= '</div></div>';
        $this->battleText .= '</div>';//col
        $this->battleText .= '</div></div>';//col

        //przeciwnik
        $this->battleText .= '<div class="col-xs-12 col-md-6"><div class="row nomargin">';
        $this->battleText .= '<div class="col-xs-6 col-md-4 col-lg-3 padding_top">';
        $this->battleText .= '<img src="../../img/poki/srednie/';
        $this->battleText .= $this->pokemon[1]->getShiny() ? 's' : '';
        $this->battleText .= $this->pokemon[1]->getIdPokemon() . '.png" data-toggle="tooltip" 
            data-title="' . $this->pokemon[1]->getName() . '" class="center img-responsive" />';
        $this->battleText .= '</div>';//col
        $this->battleText .= '<div class="col-xs-6 col-md-8 col-lg-9">';
        $this->battleText .= '<div class="well well-stan noborder padding_2 margin_2 text-center alert-danger"><span>';
        $this->battleText .= $this->pokemon[1]->getShiny() ? 'Shiny ' : '';
        $this->battleText .= $this->pokemon[1]->getName();
        $this->battleText .= '/sdiv';//well
        $this->battleText .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">A: ' . $this->pokemon[1]->getAttack() . ' Sp.A:' . $this->pokemon[1]->getSpAttack() . '</div>';
        $this->battleText .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">O: ' . $this->pokemon[1]->getDefence() . ' Sp.O: ' . $this->pokemon[1]->getSpDefence() . '</div>';
        $this->battleText .= '<div class="well well-stan jeden_ttlo noborder padding_2 margin_2 text-center">SZ: ' . $this->pokemon[1]->getSpeed() . ' C: ' . $this->pokemon[1]->getAccuracy() . '%</div>';
        $this->battleText .= '<div class="progress progress-gra prog_HP" data-original-title="Życie pokemona" data-toggle="tooltip" data-placement="top">';
        $dl = floor($this->pokemon[1]->getActualHp() / $this->pokemon[1]->getHpToTable() * 10000) / 100;
        $this->battleText .= '<div class="progress-bar progress-bar-success progBarHP" role="progressbar" aria-valuenow="40"';
        $this->battleText .= 'aria-valuemin="0" aria-valuemax="100" style="width:' . $dl . '%;">';
        $this->battleText .= '<span>' . $this->pokemon[1]->getActualHp() . ' / ' . $this->pokemon[1]->getHpToTable() . ' PŻ</span>';
        $this->battleText .= '</div></div>';
        $this->battleText .= '</div>';//col
        $this->battleText .= '</div></div>';//col
        $this->battleText .= '</div></div></div>';
    }

    private function attack()
    {
        if ($this->pokemon[0]->getSpeed() > $this->pokemon[1]->getSpeed()) {
            $attacking = 0;
            $second = 1;
        } else {
            $attacking = 1;
            $second = 0;
        }

        for ($i = 0; $i < 2; $i++) {
            $attackId = $this->pokemon[$attacking]->{'getAttack' . $this->stats[$attacking]->getAttack()}();
            if (!$attackId) {
                $attackId = 612;//Struggle
            }
            $this->currentAttack = $this->attacks->getAttack($attackId);

            //TODO
            /*if ($this->stats[$attacking]->getAttackRound() <= 0) {
                if ($pokemon[$kto]->ataki[$at[$kto]]['ile_rund'] > 10) {
                    $l1 = $pokemon[$kto]->ataki[$at[$kto]]['ile_rund'] / 10;
                    $l2 = $pokemon[$kto]->ataki[$at[$kto]]['ile_rund'] % 10;
                    $pokemon[$kto]->atak_runda = rand($l1, $l2);
                } else
                    $pokemon[$kto]->atak_runda = $pokemon[$kto]->ataki[$at[$kto]]['ile_rund'];
            }
            if ($pokemon[$kto]->atak_runda_jeden <= 0) {
                if ($pokemon[$kto]->ataki[$at[$kto]]['ile_runda'] > 10) {
                    $l1 = $pokemon[$kto]->ataki[$at[$kto]]['ile_runda'] / 10;
                    $l2 = $pokemon[$kto]->ataki[$at[$kto]]['ile_runda'] % 10;
                    $pokemon[$kto]->atak_runda_jeden = rand($l1, $l2);
                } else
                    $pokemon[$kto]->atak_runda_jeden = $pokemon[$kto]->ataki[$at[$kto]]['ile_runda'];
                if ($id_ataku === 198) { //fury cutter
                    $pokemon[$kto]->fury = 1;
                    $pokemon[$kto]->fury_t = 1;
                }
            }*/
            $can = 0;

            if ($this->stats[$attacking]->isSeeded()) {
                if ($this->pokemon[$attacking]->getActualHp() < 16) {
                    $damage = 1;
                } else {
                    $damage = floor($this->pokemon[$attacking]->getActualHp() * (1 / 16));
                }
                $this->pokemon[$attacking]->setActualHp($this->pokemon[$attacking]->getActualHp() - $damage);
                $this->battleText .= 'alert.infoNasiona zadają ' . $damage . ' obrażeń Pokemonowi <span class="pogrubienie">' . $this->pokemon[$attacking]->getName() .
                    '</span> . /sdiv';
                $hp = $this->pokemon[$second]->getActualHp() + $damage;
                if ($hp > $this->stats[$second]->getBegginingHp()) {
                    $damage = $this->stats[$second]->getBegginingHp() - $this->pokemon[$second]->getActualHp();
                }
                $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$second]->getName() . '</span> leczy ' . $damage . ' obrażeń./sdiv';
                $this->pokemon[$second]->setActualHp($this->pokemon[$second]->getActualHp() + $damage);
                if (!$this->pokemon[$attacking]->getActualHp()) {
                    $this->battleText .= 'alert.info.b' . $this->pokemon[$attacking]->getName() . '</span><span> pada nieprzytomnie na ziemię./sdiv';
                    break;
                }
            }

            if (!empty($this->stats[$attacking]->getStatePokemon())) {
                ////////////////////////otępienie//////////////////////////////////////
                if ($pokemon[$kto]->stan === 3) {
                    $pokemon[$kto]->runda++;
                    if ($pokemon[$kto]->runda > 0) {
                        $ff = rand() % 3;
                        if ($ff === 0 && $pokemon[$kto]->runda > 1) {
                            $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już otępiony./sdiv';
                            $pokemon[$kto]->stan = 0;
                            $pokemon[$kto]->runda = 0;
                            $can = 1;
                        } else {
                            $rr = rand() % 2;
                            if ($rr === 0) {
                                $can = 1;
                            } else {  ////////pokemon może atakować
                                ////pokemon atakuje sam siebie

                                ///atak fizyczny o mocy 40.
                                $o = ceil(($pokemon[$kto]->atak / $pokemon[$kto]->obrona) * 40 * 1.15);
                                $pokemon[$kto]->hp -= $o;
                                $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> jest otępiony i atakuje sam siebie zadając ' . $o . ' obrażeń./sdiv';
                                if ($pokemon[$kto]->hp <= 0) {
                                    $_SESSION['walkat'] .= 'alert.info.bPokemon pada nieprzytomny na ziemię./sdiv';
                                }
                            }
                        }
                    }
                } else { ////////////////////oszołomienie//////////////////////////////////////
                    if ($pokemon[$kto]->stan === 9) {
                        $pokemon[$kto]->runda++;
                        if ($pokemon[$kto]->runda < 3) {
                            $ff = rand() % 3;
                            if ($ff === 0 && $pokemon[$kto]->runda > 1) {
                                $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już oszołomiony./sdiv';
                                $pokemon[$kto]->stan = 0;
                                $pokemon[$kto]->runda = 0;
                                $can = 1;
                            } else {
                                $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> jest oszołomiony i nie może wykonać ruchu./sdiv';
                            }
                        } else {
                            $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już oszołomiony./sdiv';
                            $pokemon[$kto]->stan = 0;
                            $pokemon[$kto]->runda = 0;
                            $can = 1;
                        }
                    } ///////////////////zakochanie/////////////////////////////////////////
                    else {
                        if ($pokemon[$kto]->stan === 10) {
                            $ff = rand() % 5;
                            if ($ff === 0 && $pokemon[$kto]->runda > 1) {
                                $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już zakochany./sdiv';
                                $pokemon[$kto]->stan = 0;
                                $pokemon[$kto]->runda = 0;
                                $can = 1;
                            } else {
                                $fab = rand() % 4;
                                if ($fab > 1) {
                                    $_SESSION['walkat'] .= 'alert.info.b' . $pokemon[$kto]->nazwa . '</span> jest zakochany i nie skrzywdzi drugiego pokemona./sdiv';
                                } else {
                                    $can = 1;
                                }
                            }
                        } //////////////////pułapka/////////////////////////////////////////////
                        else {
                            if ($pokemon[$kto]->stan === 7 && $pokemon[$kto]->pulapka > 0) {
                                $ff = rand() % 4;
                                if ($ff === 0 && $pokemon[$kto]->runda > 1) {
                                    $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> wydostał się z pułapki./sdiv';
                                    $pokemon[$kto]->stan = 0;
                                    $pokemon[$kto]->runda = 0;
                                    $pokemon[$kto]->pulapka = 0;

                                    $can = 1;
                                } else {
                                    $pokemon[$kto]->hp -= $pokemon[$kto]->pulapka;
                                    $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> jest uwięziony. Pułapka zadaje ' . $pokemon[$kto]->pulapka . ' obrażeń./sdiv';
                                    if ($pokemon[$kto]->hp <= 0) {
                                        $_SESSION['walkat'] .= 'alert.info.bPokemon pada nieprzytomny na ziemię./sdiv';
                                    } else {
                                        $can = 1;
                                    }
                                }
                            }
                        }
                    }
                }
                //////////////////////////////////////////////////////////////////////tu ewentualnie będzie jeszcze klątwa.
            }

            /////////////ZROBIONE/////////////////////////////////////////
            if ($this->stats[$attacking]->getStatePhysical()) {
                /////////////////////paraliż//////////////////////////////////////////
                if ($this->stats[$attacking]->getStatePhysical() === 2) {
                    $can = $this->checkPokemonParalysis($attacking);
                }  ////////////////////////sen///////////////////////////////////////////
                elseif ($this->stats[$attacking]->getStatePhysical() === 6) {
                    $can = $this->checkPokemonSleep($attacking);
                } /////////////////////zamrożenie//////////////////////////////////////
                else {
                    if ($this->stats[$attacking]->getStatePhysical() === 8) {
                        $can = $this->checkPokemonFreezed($attacking);
                    }
                }
            } else {
                $can = 1;
            }
            //////////////////ZROBIONE KONIEC//////////////////////////////
            if ($can) {
                $hit = 1;
                $twoRounds = 0;
                if (($attackId === 497) && ($this->stats[$attacking]->getAttackRound() === 2)) {//solar beam
                    $twoRounds = 1;
                    $hit = 0;
                    $this->attackSolarBeam($attacking);
                }

                if (($attackId === 253) && ($this->stats[$attacking]->getAttackRound() === 1)) {//hyper beam
                    $hit = 0;
                    $this->attackHyperBeam($attacking);
                }

                if (($attackId === 107) && ($this->stats[$attacking]->getAttackRound() === 1)) {//dig 2 tura, usunięcie nietykalności
                    $this->stats[$attacking]->setImmune(0);
                }

                if (($attackId === 107) && ($this->stats[$attacking]->getAttackRound() === 2)) {//dig 1 tura, dodanie nietykalnosci
                    $twoRounds = 1;
                    $this->stats[$attacking]->setImmune(1);
                    $hit = 0;
                    $this->attackDig($attacking);
                }
                if (($attackId === 182) && ($this->stats[$attacking]->getAttackRound() === 1)) {//fly 2 tura, usunięcie nietykalności
                    $this->stats[$attacking]->setImmune(0);
                }
                if (($attackId === 182) && ($this->stats[$attacking]->getAttackRound() === 2)) {//fly 1 tura, dodanie nietykalnosci
                    $twoRounds = 1;
                    $hit = 0;
                    $this->attackFly($attacking);
                }
                if (($attackId === 111) && ($this->stats[$attacking]->getAttackRound() === 1)) {//dive 2 tura, usunięcie nietykalności
                    $this->stats[$attacking]->setImmune(0);
                }
                if (($attackId === 111) && ($this->stats[$attacking]->getAttackRound() === 2)) {//dive 1 tura, dodanie nietykalnosci
                    $twoRounds = 1;
                    $hit = 0;
                    $this->attackDive($attacking);
                }

                if (in_array($attackId, [171, 220, 247, 466])) { /////ataki KO
                    if ($this->pokemon[$attacking]->getLevel() > $this->pokemon[$second]->getLevel()) {
                        $this->currentAttack['celnosc'] = 30 + ($this->pokemon[$attacking]->getLevel() - $this->pokemon[$second]->getLevel());
                    }
                }
                //////////////////////////////obliczanie celności ataku, gdy celność mniejsza niż 100%///
                $this->battleText .= 'accuracy: ' . $this->currentAttack['celnosc'] . '<br/>';
                $attackAccuracy = $this->currentAttack['celnosc'] - ((100 - $this->pokemon[$attacking]->getAccuracy()) / 2);
                if ($this->stats[$second]->isImmune() && $attackId != 107) { //jeśli nietykalność
                    $hit = 0;
                    $this->battleText .= 'alert.info.b' . $this->pokemon[$attacking]->getName() . '</span> nie trafia przeciwnika atakiem <span class="pogrubienie">' . $this->currentAttack['nazwa'] . '</span>!/sdiv';
                    $this->decreaseRound($attacking);
                } elseif ($this->stats[$second]->isImmune() && $attackId === 107 && ($attackId != 136)) {//jeśli nietykalność
                    $hit = 0;
                    $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> nie trafia przeciwnika atakiem <span class="pogrubienie">' . $this->currentAttack['nazwa'] . '</span>!/sdiv';
                    $this->decreaseRound($attacking);
                } elseif ($this->currentAttack['rodzaj'] === 'statusowy' &&
                    ($this->currentAttackSpecial['kogo'] === 1 || $this->currentAttackSpecial['kto'] === 1)
                ) {
                    $hit = 1;
                } elseif ($attackAccuracy < 100 && $attackId != 610 && !$twoRounds) {
                    $attackAccuracy = $this->calculateAccuracy($attackAccuracy);
                    if (!$attackAccuracy) {
                        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> nie trafia przeciwnika atakiem <span class="pogrubienie">' . $this->currentAttack['nazwa'] . '</span>!/sdiv';
                        $hit = 0;
                        /*TODO
                        if ($pokemon[$kto]->atak_runda > 1 && ($id_ataku != '253')) $pokemon[$kto]->atak_runda = 0;
                        else $pokemon[$kto]->atak_runda--;*/
                    }
                }
                //////////////////////////obliczanie celności ataku koniec/////////////////////
                /////////////atak skrypt:
                if ($hit) {
                    $this->decreaseRound($attacking);
                    $this->currentAttack = $this->attacks->getAttack($attackId);
                    $this->currentAttackSpecial = $this->attacks->getSpecial($attackId);
                    $canMakeDamage = $this->currentAttack['moc'] ? 1 : 0;

                    if (!$canMakeDamage) { ///ataki statusowe
                        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> używa ataku <span class="pogrubienie">' . $this->attacks->getAttack(
                            $attackId
                        )['nazwa'] . '</span>.';
                        if ($attackId === 290) {//LEECH SEED
                            $this->attackLeechSeed($second);
                        } elseif ($attackId === 147) {//ENDEAVOUR
                            $this->attackEndeavour($attacking, $second);
                        } elseif ($attackId === 20 || $attackId === 231) {//AROMATHERAPY i HEAL BELL
                            //TODO
                            //$this->attackAromatherapy($attacking);
                        } elseif ($attackId === 189) {//FORESIGHT
                            $this->attackForesight($second);
                        }
                        $this->battleText .= '/sdiv';
                    } else {
                        ////////////////////////////////moc ataku////////////////////////////////////
                        $power = $this->calculatePower($attacking);
                        /////////////////////////////////////ZMIENNA MOC ATAKU!//////////////////////////////////////////////
                        $this->variablePower($attackId, $attacking, $second);

                        $damage = $this->calculateAttackDamage($attacking, $second, $power);

                        $secondAttack = $this->stats[$second]->getAttack();
                        /*if ($at[$aaaa] > 0 && $at[$aaaa] < 5) {
                            $atak_oo = $at[$aaaa];
                            if (($id_ataku === '107') && ($id_ataku === '136')) {
                                $obrazenia *= 2;
                                $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> jest zakopany, <span class="pogrubienie">Earthquake</span> zadaje podwójne obrażenia./sdiv';
                            }
                        $at[$kto]++;
                    if ($kto === 1) {
                        $kto = 2;
                        $tlo = 'alert-success';
                    } else {
                        $kto = 1;
                        $tlo = 'alert-danger';
                    }
                    continue;
                        }*/
                        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> używa ataku <span class="pogrubienie">' . $this->currentAttack['nazwa'] . '</span>.<br />';
                        //////SPECJALNE ATAKI Z INNYMI OBRAŻENIAMI ITP.///////////////////////
                        if ($attackId === 56) {//BRINE
                            $damage *= $this->attackBrine($second);
                        } elseif ($attackId === 166) {//Final Gambit
                            $damage = $this->attackFinalGambit($second);
                        }
                        //////SPECJALNE ATAKI Z INNYMI OBRAŻENIAMI ITP.////// KONIEC///////////////////////
                        ///obrażenia lub pokonanie przez KO
                        if (in_array($attackId, [171, 220, 247, 466]) && $damage) {/////ataki KO
                            $this->attackKO($second);
                        } elseif ($attackId === 130) {//Dream Eater
                            //TODO $this->attackDreamEater($attacking, $second);
                        } else if ($attackId === 89) {//COUNTER
                            $damage = $this->attackCounter($i, $attacking, $second);
                        } else {
                            $this->attackResults($second, $damage);
                        }

                        //OBRAŻENIA ZWROTNE
                        if ($this->currentAttackSpecial['obr_zwrotne']) {
                            $this->recoilDamage($damage, $attacking);
                        }

                        $this->pokemon[$second]->setActualHp($this->pokemon[$second]->getActualHp() - $damage);
                        if ($this->stats[$attacking]->getFury()) {
                            $this->stats[$attacking]->setFuryHit(1);
                        }
                        if ($this->pokemon[$second]->getActualHp() <= 0) {
                            $this->battleText .= 'alert.infoPrzeciwnik pada nieprzytomny na ziemię./sdiv';
                        }
                        /*
                          /////////szansa na stan specjalny -> podpalenie itp. ///////////////
                          if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] > 0 && (($pokemon[1]->hp) > 0 && ($pokemon[2]->hp > 0))) {
                              if ($id_ataku === 168 && $a === 1)//fire fang
                              {
                                  $s = 10;
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                      {
                                          $pokemon[$aaaa]->stan = 3;
                                          $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje otępiony./sdiv';
                                      }
                                  }
                              } ///////////////podpalenie/////////////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 1)//podpalenie
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  ///jeśli pok jest wodny - mniejsza szansa na podpalenie, jeśli jest roślinny większa szansa
                                  if ($k === 1)//siebie
                                  {
                                      if ($pokemon[$kto]->typ1 === 4 || $pokemon[$kto]->typ2 === 4) $s *= 2;
                                      if ($pokemon[$kto]->typ1 === 3 || $pokemon[$kto]->typ2 === 3) $s /= 2;
                                  } else if ($k === 2)//u przeciwnika
                                  {
                                      if ($pokemon[$aaaa]->typ1 === 4 || $pokemon[$aaaa]->typ2 === 4) $s *= 2;
                                      if ($pokemon[$aaaa]->typ1 === 3 || $pokemon[$aaaa]->typ2 === 3) $s /= 2;
                                  }
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0 && $pokemon[$kto]->typ1 != 2 && $pokemon[$kto]->typ2 != 2)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 1;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje podpalony./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0 && $pokemon[$aaaa]->typ1 != 2 && $pokemon[$aaaa]->typ2 != 2)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$aaaa]->stan = 1;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje podpalony./sdiv';
                                          }
                                      }
                                  }
                              }
                              //////////////////////podpalenie koniec///////////////////////////
                              ///////////////////////paraliż////////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 2)//paraliż
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0 && $pokemon[$kto]->typ1 != 5 && $pokemon[$kto]->typ2 != 5)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 2;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje sparaliżowany./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0 && $pokemon[$aaaa]->typ1 != 5 && $pokemon[$aaaa]->typ2 != 5)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego
                                          {
                                              $pokemon[$aaaa]->stan = 2;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje sparaliżowany./sdiv';
                                          }
                                      }
                                  }
                              }
                              ///////////////////////paraliż koniec/////////////////////////////
                              //////////////////////otępienie///////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 3)//otępienie
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 3;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje otępiony./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$aaaa]->stan = 3;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje otępiony./sdiv';
                                          }
                                      }
                                  }
                              }
                              //////////////////////otępienie koniec////////////////////////////
                              /////////////////////otrucie i śmiertelne otrucie/////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 4)//otrucie i śmiertelne otrucie //4 i 5
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {

                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0 && $pokemon[$kto]->typ1 != 8 && $pokemon[$kto]->typ2 != 8 && $pokemon[$kto]->typ1 != 11 && $pokemon[$kto]->typ2 != 11)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 4;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje otruty./sdiv';
                                          } else if ($pokemon[$kto]->stan === 4 && $pokemon[$kto]->typ1 != 8 && $pokemon[$kto]->typ2 != 8 && $pokemon[$kto]->typ1 != 11 && $pokemon[$kto]->typ2 != 11) {
                                              $pokemon[$kto]->stan = 5;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje śmiertelnie otruty./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0 && $pokemon[$aaaa]->typ1 != 8 && $pokemon[$aaaa]->typ2 != 8 && $pokemon[$aaaa]->typ1 != 11 && $pokemon[$aaaa]->typ2 != 11)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$aaaa]->stan = 4;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje otruty./sdiv';
                                          } else if ($pokemon[$aaaa]->stan === 4 && $pokemon[$aaaa]->typ1 != 8 && $pokemon[$aaaa]->typ2 != 8 && $pokemon[$aaaa]->typ1 != 11 && $pokemon[$aaaa]->typ2 != 11) {
                                              $pokemon[$aaaa]->stan = 5;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje śmiertelnie otruty./sdiv';
                                          }
                                      }
                                  }
                              }
                              /////////////////////otrucie i śmiertelne otrucie koniec//////////
                              ////////////////////sen///////////////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 6)//sen
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 6;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje uśpiony./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$aaaa]->stan = 6;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje uśpiony./sdiv';
                                          }
                                      }
                                  }
                              }
                              ///////////////////sen koniec/////////////////////////////////////
                              //////////////////pułapka/////////////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 7 && $obrazenia > 0)//pułapka
                              {
                                  if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                  {
                                      $pokemon[$aaaa]->stan = 7;
                                      $pokemon[$aaaa]->pulapka = $obrazenia;
                                      $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje uwięziony./sdiv';
                                  }
                              }
                              //////////////////pułapka koniec//////////////////////////////////
                              //////////////////zamrożenie//////////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 8)//zamrożenie
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 8;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje zamrożony./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$aaaa]->stan = 8;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje zamrożony./sdiv';
                                          }
                                      }
                                  }
                              }
                              //////////////////zamrożenie koniec///////////////////////////////
                              //////////////////oszołomienie////////////////////////////////////
                              if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 9)//oszołomienie
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $k = $pokemon[$kto]->ataki[$at[$kto]]['kto'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($k === 1) {
                                          if ($pokemon[$kto]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$kto]->stan = 9;
                                              $_SESSION['walkat'] .= '<div class="walka_alert alert alert-info><span><span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zostaje oszołomiony./sdiv';
                                          }
                                      } else {
                                          if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                          {
                                              $pokemon[$aaaa]->stan = 9;
                                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zostaje oszołomiony./sdiv';
                                          }
                                      }
                                  }
                              }
                              //////////////////oszołomienie koniec/////////////////////////////
                              //////////////////zakochanie//////////////////////////////////////
                              else if ($pokemon[$kto]->ataki[$at[$kto]]['stan'] === 10)//zakochanie
                              {
                                  $s = $pokemon[$kto]->ataki[$at[$kto]]['procent'];
                                  $ab = $this->obliczenieCelnosci($s);///////obliczenie czy pok ma mieć nałożony stan.
                                  if ($ab === 2) {
                                      if ($pokemon[$aaaa]->stan === 0)//jeśli pokemon ma nałożony stan, to nie może mieć drugiego stanu.
                                      {
                                          $pokemon[$aaaa]->stan = 10;
                                          $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> jest zakochany w przeciwniku./sdiv';
                                      }
                                  }
                              }
                              //////////////////zakochanie koniec///////////////////////////////
                          }
                          ////////////////szansa na stan specjalny koniec/////////////////////
                          /////////////////zwiększenie/zmniejszenie alertstyk/////////////////

                          ////////////////////////////////////////////////////////////////////
                          ////////1.Atak//////////////////////////////////////////////////////
                          ////////2.sp.atak///////////////////////////////////////////////////
                          ////////3.obrona////////////////////////////////////////////////////
                          ////////4.sp.obrona/////////////////////////////////////////////////
                          ////////5.szybkosc//////////////////////////////////////////////////
                          ////////6.losowo////////////////////////////////////////////////////
                          ////////7.wszystko//////////////////////////////////////////////////
                          ////////9.celność///////////////////////////////////////////////////
                          ////////-1.uniki////////////////////////////////////////////////////
                          ////////////////////////////////////////////////////////////////////

                          if ($pokemon[$kto]->ataki[$at[$kto]]['podwyzszenie'] === 1 && (($pokemon[1]->hp) > 0 && ($pokemon[2]->hp > 0)))/////podwyższenie alertstyk siebie lub przeciwnika
                          {
                              $l = 0;
                              $proc = $pokemon[$kto]->ataki[$at[$kto]]['procent_obn'];
                              $proc = $this->obliczenieCelnosci($proc);
                              if ($proc === 2) {
                                  $_SESSION['walkat'] .= 'alert.info';
                                  $ile = ($pokemon[$kto]->ataki[$at[$kto]]['obn_ile'] * 5) / 100;
                                  $kogo = $pokemon[$kto]->ataki[$at[$kto]]['kogo'];
                                  $czego2 = 0;
                                  $czego3 = 0;
                                  if ($pokemon[$kto]->atak[$at[$kto]]['czego'] > 100) {
                                      $czego = $pokemon[$kto]->ataki[$at[$kto]]['czego'];
                                      $czego3 = intval($czego / 100);
                                      $czego -= $czego3 * 100;
                                      $czego2 = intval($czego / 10);
                                      $czego -= $czego2 * 10;
                                      $czego1 = $czego;
                                  } else if ($pokemon[$kto]->ataki[$at[$kto]]['czego'] > 10) {
                                      $czego = $pokemon[$kto]->ataki[$at[$kto]]['czego'];
                                      $czego2 = intval($czego / 10);
                                      $czego -= $czego2 * 10;
                                      $czego1 = $czego;
                                  } else $czego1 = $pokemon[$kto]->ataki[$at[$kto]]['czego'];
                                  if ($czego1 === 6 || $l === 1)//losowo
                                  {
                                      $czego1 = rand(1, 5);
                                      $l = 1;
                                  }
                                  if ($czego1 === 7) {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->atak);
                                          $_SESSION['walkat'] .= 'Atak <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->atak += $zw;
                                          $zw = ceil($ile * $pokemon[$kto]->sp_atak);
                                          $_SESSION['walkat'] .= 'Specjlny atak <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->sp_atak += $zw;
                                          $zw = ceil($ile * $pokemon[$kto]->obrona);
                                          $_SESSION['walkat'] .= 'Obrona <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->obrona += $zw;
                                          $zw = ceil($ile * $pokemon[$kto]->sp_obrona);
                                          $_SESSION['walkat'] .= 'Specjala obrona <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->sp_obrona += $zw;
                                          $zw = ceil($ile * $pokemon[$kto]->szybkosc);
                                          $_SESSION['walkat'] .= 'Szybkość <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->szybkosc += $zw;
                                      }
                                  } else if ($czego1 === 1 || $czego2 === 1 || $czego3 === 1)//atak
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->atak);
                                          $_SESSION['walkat'] .= 'Atak <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->atak += $zw;
                                      }
                                      if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->atak);
                                          $_SESSION['walkat'] .= 'Atak <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->atak += $zw;
                                      }
                                  } else if ($czego1 === 2 || $czego2 === 2 || $czego3 === 2)//sp.atak
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->sp_atak);
                                          $_SESSION['walkat'] .= 'Specjalny atak <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->sp_atak += $zw;
                                      }
                                      if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->sp_atak);
                                          $_SESSION['walkat'] .= 'Specjalny atak <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->sp_atak += $zw;
                                      }
                                  } else if ($czego1 === 3 || $czego2 === 3 || $czego3 === 3)//obrona
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->obrona);
                                          $_SESSION['walkat'] .= 'Obrona <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->obrona += $zw;
                                      }
                                      if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->obrona);
                                          $_SESSION['walkat'] .= 'Obrona <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->obrona += $zw;
                                      }
                                  } else if ($czego1 === 4 || $czego2 === 4 || $czego3 === 4)//sp.obrona
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->sp_obrona);
                                          $_SESSION['walkat'] .= 'Specjalna obrona <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->sp_obrona += $zw;
                                      }
                                      if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->sp_obrona);
                                          $_SESSION['walkat'] .= 'Specjalna obrona <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->sp_obrona += $zw;
                                      }
                                  } else if ($czego1 === 5 || $czego2 === 5 || $czego3 === 5)//szybkość
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->szybkosc);
                                          $_SESSION['walkat'] .= 'Szybkość <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->szybkosc += $zw;
                                      }
                                      if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->szybkosc);
                                          $_SESSION['walkat'] .= 'Szybkość <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zwiększa się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->szybkosc += $zw;
                                      }
                                  }
                                  $_SESSION['walkat'] .= '/sdiv';
                              }
                          } else if ($pokemon[$kto]->ataki[$at[$kto]]['obnizenie'] === 1 && (($pokemon[1]->hp) > 0 && ($pokemon[2]->hp > 0)))/////obniżenie alertstyk siebie lub przeciwnika
                          {
                              $l = 0;
                              $proc = $pokemon[$kto]->atak[$at[$kto]]['procent_obn'];
                              $proc = $this->obliczenieCelnosci($proc);
                              if ($proc === 2) {
                                  $_SESSION['walkat'] .= 'alert.info';
                                  $ile = ($pokemon[$kto]->ataki[$at[$kto]]['obn_ile'] * 5) / 100;
                                  $kogo = $pokemon[$kto]->ataki[$at[$kto]]['kogo'];
                                  $czego2 = 0;
                                  $czego3 = 0;
                                  if ($pokemon[$kto]->atak[$at[$kto]]['czego'] > 100) {
                                      $czego = $pokemon[$kto]->atak[$at[$kto]]['czego'];
                                      $czego3 = intval($czego / 100);
                                      $czego -= $czego3 * 100;
                                      $czego2 = intval($czego / 10);
                                      $czego -= $czego2 * 10;
                                      $czego1 = $czego;
                                  } else if ($pokemon[$kto]->atak[$at[$kto]]['czego'] > 10) {
                                      $czego = $pokemon[$kto]->atak[$at[$kto]]['czego'];
                                      $czego2 = intval($czego / 10);
                                      $czego -= $czego2 * 10;
                                      $czego1 = $czego;
                                  } else $czego1 = $pokemon[$kto]->atak[$at[$kto]]['czego'];
                                  if ($czego1 === 6 || $l === 1)//losowo
                                  {
                                      $czego1 = rand(1, 5);
                                      $l = 1;
                                  }
                                  if ($czego1 === 1 || $czego2 === 1 || $czego3 === 1)//atak
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->atak);
                                          $_SESSION['walkat'] .= 'Atak <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->atak -= $zw;
                                      } else if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->atak);
                                          $_SESSION['walkat'] .= 'Atak <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->atak -= $zw;
                                      }
                                  } else if ($czego1 === 2 || $czego2 === 2 || $czego3 === 2)//sp.atak
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->sp_atak);
                                          $_SESSION['walkat'] .= 'Specjalny atak <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zwmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->sp_atak -= $zw;
                                      } else if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->sp_atak);
                                          $_SESSION['walkat'] .= 'Specjalny atak <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->sp_atak -= $zw;
                                      }
                                  } else if ($czego1 === 3 || $czego2 === 3 || $czego3 === 3)//obrona
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->obrona);
                                          $_SESSION['walkat'] .= 'Obrona <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->obrona -= $zw;
                                      } else if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->obrona);
                                          $_SESSION['walkat'] .= 'Obrona <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->obrona -= $zw;
                                      }
                                  } else if ($czego1 === 4 || $czego2 === 4 || $czego3 === 4)//sp.obrona
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->sp_obrona);
                                          $_SESSION['walkat'] .= 'Specjalna obrona <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->sp_obrona -= $zw;
                                      } else if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->sp_obrona);
                                          $_SESSION['walkat'] .= 'Specjalna obrona <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->sp_obrona -= $zw;
                                      }
                                  } else if ($czego1 === 5 || $czego2 === 5 || $czego3 === 5)//szybkość
                                  {
                                      if ($kogo === 1) {
                                          $zw = ceil($ile * $pokemon[$kto]->szybkosc);
                                          $_SESSION['walkat'] .= 'Szybkość <span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$kto]->szybkosc -= $zw;
                                      } else if ($kogo === 2) {
                                          $zw = ceil($ile * $pokemon[$aaaa]->szybkosc);
                                          $_SESSION['walkat'] .= 'Szybkość <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '</span>.<br />';
                                          $pokemon[$aaaa]->szybkosc -= $zw;
                                      }
                                  } else if ($czego1 === 9)//celnosc
                                  {
                                      $zw = ceil($ile * $pokemon[$aaaa]->celnosc);
                                      $_SESSION['walkat'] .= 'Celność <span class="pogrubienie">' . $pokemon[$aaaa]->nazwa . '</span> zmniejsza się o <span class="pogrubienie">' . $zw . '%</span>.<br />';
                                      $pokemon[$aaaa]->celnosc -= $zw;
                                  }
                                  $_SESSION['walkat'] .= '/sdiv';
                              }
                          }
                          /////////////////zwiększenie/zmniejszenie alertstyk koniec//////////
                          /////////////////leczenie///////////////////////////////////////////
                          if ($pokemon[$kto]->ataki[$at[$kto]]['procent_o'] > 0)///leczenie z zadanych obrażeń
                          {
                              $proc = $pokemon[$kto]->ataki[$at[$kto]]['procent_o'] / 100;
                              $lecz = ceil($obrazenia * $proc);
                              if ($pokemon[$kto]->hp + $lecz > $pokemon[$kto]->pocz_HP)
                                  $lecz = $pokemon[$kto]->pocz_HP - $pokemon[$kto]->hp;
                              $pokemon[$kto]->hp += $lecz;
                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> leczy <span class="pogrubienie">' . $lecz . '</span> punktów zdrowia z zadanych obrażeń./sdiv';
                          }
                          if ($pokemon[$kto]->ataki[$at[$kto]]['procent_l'] > 0) {
                              $proc = $pokemon[$kto]->ataki[$at[$kto]]['procent_l'] / 100;
                              $lecz = ceil($proc * $pokemon[$kto]->hp);
                              if (($pokemon[$kto]->hp + $lecz) > $pokemon[$kto]->pocz_HP)
                                  $lecz = $pokemon[$kto]->pocz_HP - $pokemon[$kto]->hp;
                              $pokemon[$kto]->hp += $lecz;
                              $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> leczy <span class="pogrubienie">' . $lecz . '</span> punktów zdrowia./sdiv';
                          }
                          /////////////////leczenie koniec////////////////////////////////////
                      }
                      //////////////////podpalenie//////////////////////////////////////////
                      if ($pokemon[$kto]->stan === 1) {
                          $pokemon[$kto]->runda++;
                          if ($pokemon[$kto]->runda > 0) {
                              $r = rand() % 3;
                              if ($r === 0 && $pokemon[$kto]->runda > 1) {
                                  $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> udaje ugasić się płomienie otaczające jego ciało./sdiv';
                                  $pokemon[$kto]->stan = 0;
                                  $pokemon[$kto]->runda = 0;
                              } else {
                                  $o = ceil(0.125 * $pokemon[$kto]->max_hp);
                                  $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> płonie. Płomienie zadają <span class="pogrubienie">' . $o . '</span> obrażeń./sdiv';
                                  $pokemon[$kto]->hp -= $o;
                                  if ($pokemon[$kto]->hp < 0) $_SESSION['walkat'] .= 'alert.info.bPokemon pada nieprzytomny na ziemię./sdiv';
                              }
                          }
                      } /////////////////////otrucie////////////////////////////////////////
                      else if ($pokemon[$kto]->stan === 4) {
                          $pokemon[$kto]->runda++;
                          if ($pokemon[$kto]->runda > 0) {
                              $r = rand() % 3;
                              if ($r === 0 && $pokemon[$kto]->runda > 1) {
                                  $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już otruty./sdiv';
                                  $pokemon[$kto]->stan = 0;
                                  $pokemon[$kto]->runda = 0;
                              } else {
                                  $o = ceil(0.125 * $pokemon[$kto]->max_hp);
                                  $pokemon[$kto]->hp -= $o;
                                  $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> jest otruty. Trucizna zadaje <span class="pogrubienie">' . $o . '</span> obrażeń./sdiv';
                                  if ($pokemon[$kto]->hp <= 0) $_SESSION['walkat'] .= 'alert.info.bPokemon pada nieprzytomny na ziemię./sdiv';
                              }
                          }
                      } /////////////////śmiertelne otrucie///////////////////////////////////
                      else if ($pokemon[$kto]->stan === 5) {
                          $pokemon[$kto]->runda++;
                          if ($pokemon[$kto]->runda > 0) {
                              $r = rand() % 3;
                              if ($r === 0 && $pokemon[$kto]->runda > 1) {
                                  $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już śmiertelnie otruty./sdiv';
                                  $pokemon[$kto]->stan = 0;
                                  $pokemon[$kto]->runda = 0;
                              } else {
                                  $o = ceil(0.25 * $pokemon[$kto]->max_hp);
                                  $pokemon[$kto]->hp -= $o;
                                  $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> jest śmiertelnie otruty. Trucizna zadaje <span class="pogrubienie">' . $o . '</span> obrażeń./sdiv';
                                  if ($pokemon[$kto]->hp <= 0) $_SESSION['walkat'] .= 'alert.info.bPokemon pada nieprzytomny na ziemię./sdiv';
                              }
                          }
                      }
                        //////////////////////
                    }
                }
            }
        }*/
                    }
                }
                $this->stats[$attacking]->setAttackRoundOne($this->stats[$attacking]->getAttackRoundOne() - 1);
                if ($attackId === 198) {//fury cutter
                    $this->stats[$attacking]->setFury($this->stats[$attacking]->getFury() + 1);
                    if ($hit) {
                        $this->stats[$attacking]->setFuryHit(1);
                    } else {
                        $this->stats[$attacking]->setFuryHit(0);
                    }
                }
                if ($this->stats[$attacking]->getAttackRound() <= 0 && $this->stats[$attacking]->getAttackRoundOne() <= 0) {
                    $this->stats[$attacking]->setAttack($this->stats[$attacking]->getAttack() + 1);
                }
                if (!$this->checkIfPokemonsHaveHp()) {
                    return;
                }
                //TODO
                //if ($pokemon[$kto]->atak_runda_jeden > 0) {
                //    $a--;
                //    continue;
                //}
                //$atak = $at[$kto] - 1;
                //if (($pokemon[$kto]->atak_runda <= 0) &&
                //    (($pokemon[$kto]->atak[$atak]['ID'] === 360) || ($pokemon[$kto]->ataki[$atak]['ID'] === 553) || ($pokemon[$kto]->ataki[$atak]['ID'] === 370))
                // ) //Outrage
                //{
                //    $_SESSION['walkat'] .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> popada w otępienie./sdiv';
                //    $pokemon[$kto]->stan = 3;
                //}
                if (!$attacking) {
                    $attacking = 1;
                    $second = 0;
                } else {
                    $attacking = 0;
                    $second = 1;
                }
            }
        }
    }

    private function beforeRound()
    {
        if ($this->stats[0]->getAttack() > 3) {
            $this->stats[0]->setAttack(0);
        }
        if ($this->stats[1]->getAttack() > 3) {
            $this->stats[1]->setAttack(0);
        }
    }

    private function checkIfPokemonsHaveHp(): bool
    {
        return !($this->pokemon[0]->getActualHp() <= 0 || $this->pokemon[1]->getActualHp() <= 0);
    }

    private function checkPokemonParalysis(int $attacking): bool
    {
        $can = 0;
        $this->stats[$attacking]['roundStatePhysical']++;
        if ($this->stats[$attacking]['roundStatePhysical'] === 1) {
            $r1 = rand() % 4;
            if ($r1 < 2) {
                $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> jest sparaliżowany i nie może wykonać ruchu./sdiv';
            } else {
                $can = 1;
            }
        } else {
            $round = rand() % 3;
            if (!$round) {
                $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> nie jest już pod wpływem paraliżu./sdiv';
                $this->setPokemonStateAsHealthy($attacking);
                $can = 1;
            } else {
                $round = rand() % 4;
                if ($round < 2) {
                    $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> jest sparaliżowany i nie może wykonać ruchu./sdiv';
                } else {
                    $can = 1;
                }
            }
        }
        return $can;
    }

    private function checkPokemonSleep(int $attacking): bool
    {
        $can = 0;
        $this->stats[$attacking]->setStateRound($this->stats[$attacking]->getStateRound() + 1);
        $round = rand() % 3;
        if (!$round && $this->stats[$attacking]->getStateRound() > 1) {
            $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> budzi się ze snu./sdiv';
            $this->setPokemonStateAsHealthy($attacking);
            $can = 1;
        } else {
            $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> śpi./sdiv';
        }
        return $can;
    }

    private function checkPokemonFreezed(int $attacking): bool
    {
        $can = 0;
        $this->stats[$attacking]->setStateRound($this->stats[$attacking]->getStateRound() + 1);
        $round = rand() % 5;
        if (!$round && $this->stats[$attacking]->getStateRound() > 1) {
            $this->battleText .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie jest już zamrożony./sdiv';
            $this->setPokemonStateAsHealthy($attacking);
            $can = 1;
        } else {
            $this->battleText .= 'alert.info.b' . $pokemon[$kto]->nazwa . '</span> jest zamrożony i nie może wykonać ruchu./sdiv';
        }
        return $can;
    }

    private function setPokemonStateAsHealthy(int $attacking)
    {
        $this->stats[$attacking]->setStatePhysical(0);
        $this->stats[$attacking]->setRoundStatePhysical(0);
    }

    private function decreaseRound(int $attacking)
    {
        $this->stats[$attacking]->setAttackRound($this->stats[$attacking]->getAttackRound() - 1);
    }

    private function attackSolarBeam(int $attacking)
    {
        $this->decreaseRound($attacking);
        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> zbiera energię słoneczną./sdiv';
    }

    private function attackHyperBeam(int $attacking)
    {
        $this->decreaseRound($attacking);
        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> odpoczywa po ostatnim ataku./sdiv';
    }

    private function attackDig(int $attacking)
    {
        $this->decreaseRound($attacking);
        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> zakopuje się pod ziemią./sdiv';
    }

    private function attackFly(int $attacking)
    {
        $this->stats[$attacking]->setImmune(1);
        $this->decreaseRound($attacking);
        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> wznosi się w powietrze./sdiv';
    }

    private function attackDive(int $attacking)
    {
        $this->stats[$attacking]->setImmune(1);
        $this->decreaseRound($attacking);
        $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> nurkuje pod wodą./sdiv';
    }

    private function attackAromatherapy(int $attacking)
    {
        //TODO
        if (in_array($pokemon[$kto]->stan, [1, 2, 4, 5, 8])) {
            $_SESSION['walkat'] .= '<span class="pogrubienie"> ' . $pokemon[$aaaa]->nazwa . '</span> leczy swój stan.';
            $pokemon[$kto]->stan = 0;
        } else {
            $_SESSION['walkat'] .= '<span class="pogrubienie"> ' . $pokemon[$kto]->nazwa . '</span> nie wymaga uleczenia';
        }
    }

    private function attackForesight(int $second)
    {
        if ($this->pokemon[$second]->getInfo()['typ1'] === 9 || $this->pokemon[$second]->getInfo()['typ2'] === 9) {
            $this->pokemon[$second]->setEffectiveness(1, 1);
            $this->pokemon[$second]->setEffectiveness(10, 1);
            $this->battleText .= '<span class="pogrubienie"> ' . $this->pokemon[$second]->getName() . '</span> traci odporność na ataki typu normalnego i walczącego!';
        } else {
            $this->battleText .= '<span class="pogrubienie"> ' . $this->pokemon[$second]->getName() . '</span> nie jest duchem!';
        }
    }

    private function attackLeechSeed(int $second)
    {
        if ($this->pokemon[$second]->getInfo()['typ1'] === 4
            || $this->pokemon[$second]->getInfo()['typ2'] === 4
            || $this->stats[$second]->isSeeded()
        ) {
            $this->battleText .= '<span class="pogrubienie"> ' . $this->pokemon[$second]->getName() . '</span> unika nasion.';
        } else {
            $this->battleText .= 'Nasiona przyklejają się do <span class="pogrubienie">' . $this->pokemon[$second]->getName() . '</span>.';
            $this->stats[$second]->setSeeded(1);
        }
    }

    private function attackEndeavour(int $attacking, int $second)
    {
        if ($this->pokemon[$attacking]->getActualHp() < $this->pokemon[$second]->getActualHp()) {
            $this->battleText .= 'alert.infoŻycie <span class="pogrubienie">' . $this->pokemon[$second]->getName() . '</span> zrównuje się z życiem <span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span>/sdiv';
            $this->pokemon[$second]->setActualHp($this->pokemon[$attacking]->getActualHp());
        } else {
            $this->battleText .= 'alert.infoAtak nie osiągnął żadnego efektu!/sdiv';
        }
    }

    private function calculatePower(int $pokemon)
    {
        if ($this->currentAttack['typ'] === $this->pokemon[$pokemon]->getInfo()['type1']
            || $this->currentAttack['typ'] === $this->pokemon[$pokemon]->getInfo()['type2']
        ) {
            $power = 1.25;
        } else {
            $power = 1;
        }

        return $power;
    }

    private function variablePower(int $attackId, int $attacking, int $second)
    {
        if ($attackId === 142) {//ELECTRO BALL
            $this->attackElectroBall($attacking, $second);
        } elseif ($attackId === 310) {//MAGNITUDE
            $this->attackMagnitude();
        } elseif ($attackId === 125) {//DRAGON RAGE
            $this->attackDragonRage($attacking);
        } elseif ($attackId === 151) {//ERUPTION
            $this->attackEruption($second);
        } elseif ($attackId === 172) {//FLAIL
            $this->attackFlail($attacking);
        } elseif ($attackId === 196) {//FRUSTRATION
            //TODO
            // jakie kurwa tlo??
            //$pokemon[$kto]->ataki[$at[$kto]]['moc'] = (255 - $tlo) / 2.5;
        } elseif ($attackId === 198) {//FURY CUTTER
            $this->attackFuryCutter($attacking);
        }
        /*else if($id_ataku === 97)//CRUSH GRIP <- TYLKO JEDNA LEGENDA, TO W KOMENTARZU
        {
                  $pokemon[$kto]['atak'.$at[$kto]]['moc'] = 1 + ($pokemon[$aaaa]->hp / $pokemon[$aaaa]['max_hp']);
                }*/
    }

    private function attackElectroBall(int $attacking, int $second)
    {
        $st_sz = $this->pokemon[$second]->getSpeed() / $this->pokemon[$attacking]->getSpeed();
        if ($st_sz > 0.5) {
            $this->currentAttack['moc'] = 60;
        } elseif ($st_sz > 0.33) {
            $this->currentAttack['moc'] = 80;
        } elseif ($st_sz > 0.24) {
            $this->currentAttack['moc'] = 100;
        } else {
            $this->currentAttack['moc'] = 120;
        }
    }

    private function attackMagnitude()
    {
        $random = rand(0, 100);
        if ($random <= 5) {
            $this->currentAttack['moc'] = 10;
            $this->currentAttack['nazwa'] = "Magnitude 4";
        } elseif ($random <= 15) {
            $this->currentAttack['moc'] = 30;
            $this->currentAttack['nazwa'] = "Magnitude 5";
        } elseif ($random <= 35) {
            $this->currentAttack['moc'] = 50;
            $this->currentAttack['nazwa'] = "Magnitude 6";
        } elseif ($random <= 65) {
            $this->currentAttack['moc'] = 70;
            $this->currentAttack['nazwa'] = "Magnitude 7";
        } elseif ($random <= 85) {
            $this->currentAttack['moc'] = 90;
            $this->currentAttack['nazwa'] = "Magnitude 8";
        } elseif ($random <= 95) {
            $this->currentAttack['moc'] = 110;
            $this->currentAttack['nazwa'] = "Magnitude 9";
        } else {
            $this->currentAttack['moc'] = 150;
            $this->currentAttack['nazwa'] = "Magnitude 10";
        }
    }

    private function attackDragonRage(int $attacking)
    {
        $this->currentAttack['moc'] = $this->pokemon[$attacking]->getLevel();
    }

    private function attackEruption(int $second)
    {
        $this->currentAttack['moc'] = floor(150 * ($this->pokemon[$second]->getActualHp() / $this->pokemon[$second]->getHpToTable()));
    }

    private function attackFlail(int $attacking)
    {
        $st_hp = $this->pokemon[$attacking]->getActualHp() / $this->pokemon[$attacking]->getHpToTable();
        if ($st_hp >= 0.71) {
            $this->currentAttack['moc'] = 20;
        } else if ($st_hp >= 0.36) {
            $this->currentAttack['moc'] = 40;
        } else if ($st_hp >= 0.21) {
            $this->currentAttack['moc'] = 80;
        } else if ($st_hp >= 0.11) {
            $this->currentAttack['moc'] = 100;
        } else if ($st_hp >= 0.05) {
            $this->currentAttack['moc'] = 150;
        } else {
            $this->currentAttack['moc'] = 200;
        }
    }

    private function attackFuryCutter(int $attacking)
    {
        if ($this->stats[$attacking]->getFury() === 1 || !$this->stats[$attacking]->getFuryHit()) {
            $this->currentAttack['moc'] = 40;
        } else {
            $this->currentAttack['moc'] *= 2;
        }
    }

    private function calculateAttackDamage(int $attacking, int $second, float $power)
    {
        if ($this->currentAttack['rodzaj'] === "fizyczny") {
            $damage = ($this->pokemon[$attacking]->getAttack() / $this->pokemon[$second]->getDefence())
                * $power * $this->currentAttack['moc'] * 1.15 * $this->pokemon[$second]->getEffectiveness()[$this->currentAttack['typ']];
        } else {
            $damage = ($this->pokemon[$attacking]->getSpAttack() / $this->pokemon[$second]->getSpDefence())
                * $power * $this->currentAttack['moc'] * 1.15 * $this->pokemon[$second]->getEffectiveness()[$this->currentAttack['typ']];
        }
        $rand = rand(90, 110) / 100;
        return ceil($damage * $rand);
    }

    private function attackBrine(int $second)
    {
        $akt_h = $this->pokemon[$second]->getActualHp() / $this->pokemon[$second]->getHpToTable();
        if ($akt_h <= 0.5) {
            $this->battleText .= 'Przeciwnik ma 50% lub mniej życia, Brine zadaje 2x więcej obrażeń.';
            return 2;
        }
        return 1;
    }

    private function attackFinalGambit(int $attacking)
    {
        $damage = $this->pokemon[$attacking]->getActualHp();
        $this->pokemon[$attacking]->setActualHp(0);
        return $damage;
    }

    private function attackKO(int $second)
    {
        $this->battleText .= '<span class="pogrubienie">Jest to atak KO./sdiv';
        $this->pokemon[$second]->setActualHp(0);
    }

    private function attackDreamEater($attacking, $second)
    {
        //TODO
        if ($pokemon[$aaaa]->stan === '6') {
            $pokemon[$aaaa]->hp -= $obrazenia;
            $_SESSION['walkat'] .= 'Pokemon zadaje <span class="pogrubienie">' . $obrazenia . "</span> obrażeń.";
            $obrazenia /= 2;
            $obrazenia = ceil($obrazenia);
            if (($pokemon[$kto]->hp + $obrazenia) > $pokemon[$kto]->pocz_HP) {
                $obrazenia = $pokemon[$kto]->pocz_HP - $pokemon[$kto]->hp;
                $pokemon[$kto]->hp = $pokemon[$kto]->pocz_HP;
            } else {
                $pokemon[$kto]->hp += $obrazenia;
            }
            $_SESSION['walkat'] .= '<span class="pogrubienie"> ' . $pokemon[$kto]->nazwa . '</span> leczy <span class="pogrubienie">' . $obrazenia . '</span> obrażeń.';
        } else {
            $_SESSION['walkat'] .= '<span class="pogrubienie"> ' . $pokemon[$aaaa]->nazwa . '</span> nie śpi.';
        }
        $_SESSION['walkat'] .= '</div>';
        if ($pokemon[$aaaa]->hp <= 0) {
            $_SESSION['walkat'] .= '<div class="walka_alert alert ' . $ktot . '"><span class="pogrubienie"> ' . $pokemon[$aaaa]->nazwa . '</span> pada nieprzytomnie na ziemię.</div>';
            $at[$kto]++;
            //break;
        }
    }

    private function attackCounter(int $i, int $attacking, int $second)
    {
        //TODO
        if ($i) {
            $attackSecond = $this->stats[$second]->getAttack() - 1;
            if ($attackSecond < 0) {
                $attackSecond = 3;
            }
            if ($pokemon[$aaaa]->ataki['atak' . $atak_oo]['rodzaj'] === 'fizyczny') {
                $pokemon[$kto]->ataki['atak' . $at[$kto]]['moc'] = $pokemon[$kto]->ataki['atak' . $at[$kto]]['moc'] * 2;
                if ($kto === 1) {
                    $damage = ($pokemon[1]->atak / $pokemon[2]->obrona) * $moc * $pokemon[$kto]->ataki['atak' . $at[$kto]]['moc'] * 1.15 * $pokemon[2]->odp[$pokemon[$kto]->ataki[$at[$kto]]['typ']];
                } else {
                    $damage = ($pokemon[2]->atak / $pokemon[1]->obrona) * $moc * $pokemon[$kto]->ataki['atak' . $at[$kto]]['moc'] * 1.15 * $pokemon[1]->odp[$pokemon[$kto]->ataki[$at[$kto]]['typ']];
                }
                $damage = ceil($damage);
                $this->battleText .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> zadaje <span class="pogrubienie">' . $obrazenia . '</span> obrażeń./span></div>';
                $pokemon[$aaaa]->hp -= $obrazenia;
            } else {
                $this->battleText .= 'alert.info<span class="pogrubienie">' . $pokemon[$kto]->nazwa . '</span> nie może skontrować ataku!/sdiv';
                $damage = 0;
            }
        } else {
            $this->battleText .= 'alert.info<span class="pogrubienie">' . $this->pokemon[$attacking]->getName() . '</span> nie może skontrować ataku!/sdiv';
            $damage = 0;
        }
        $this->battleText .= '</div>';
        return $damage;
    }

    private function attackResults(int $second, int $damage)
    {
        $this->battleText .= 'Pokemon zadaje <span class="pogrubienie">' . $damage . "</span> obrażeń./sdiv";
        if ($this->pokemon[$second]->getEffectiveness()[$this->currentAttack['typ']] > 1) {
            $this->battleText .= '<div class="walka_alert alert alert-info"><span class="zielony">Ten ruch jest super efektywny!/sdiv';
        } elseif (!$this->pokemon[$second]->getEffectiveness()[$this->currentAttack['typ']]) {
            $this->battleText .= '<div class="walka_alert alert alert-info"><span class="czerwony">Ten ruch nie może zranić przeciwnika!/sdiv';
        } elseif ($this->pokemon[$second]->getEffectiveness()[$this->currentAttack['typ']] < 1) {
            $this->battleText .= '<div class="walka_alert alert alert-info"><span class="czerwony">Ten ruch jest mało efektywny!/sdiv';
        }
    }

    private function recoilDamage(int $damage, int $attacking)
    {
        $recoilDamage = ceil($damage * ($this->currentAttackSpecial['obr_zwrotne'] / 100));
        $this->battleText .= 'alert.infoPokemon otrzymuje <span class="pogrubienie">' . $recoilDamage . '</span> obrażeń zwrotnych./sdiv';
        $this->pokemon[$attacking]->setActualHp($this->pokemon[$attacking]->getActualHp() - $recoilDamage);
        if ($this->pokemon[$attacking]->getActualHp() <= 0) {
            $this->battleText .= 'alert.info.bPokemon pada nieprzytomny na ziemię./sdiv';
        }
    }

    private function setScore()
    {
        if ($this->pokemon[1]->getActualHp() <= 0) {//wygrana
            $this->score = 1;
        } elseif ($this->pokemon[0]->getActualHp() <= 0) {//porażka
            $this->score = 0;
        } else {//remis
            $this->score = -1;
        }
    }

    private function calculateAccuracy($attackAccuracy): bool
    {
        $this->battleText .= 'accuracy: ' . $attackAccuracy . '<br/>';//TODO usunąć
        if (mt_rand(0, 100) < (100 - $attackAccuracy)) {
            return 0;
        } else {
            return 1;
        }
    }

    private function addLuckInfo()
    {
        $this->battleText .= '<div class="row"><div class="col-xs-12">';
        for ($i = 0; $i < 2; $i++) {
            if (!$this->stats[$i]->isLuckyGiven()) {
                $this->stats[$i]->setLuckyGiven(1);

                if ($this->stats[$i]->getLucky() > 0) {
                    $this->battleText .= 'alert.info<span><span class="pogrubienie">'.$this->pokemon[$i]->getName().'</span> ma szczęście w walce. ';
                    $this->battleText .= $this->pokemon[$i]->getGender() === 1 ?  'Jej' :  'Jego';
                    $this->battleText .= ' statystyki zwiększają się o <span class="zielony">'.$this->stats[$i]->getLucky().' %</span>./sdiv';
                } elseif ($this->stats[$i]->getLucky() < 0) {
                    $this->battleText .= 'alert.info<span><span class="pogrubienie">'.$this->pokemon[$i]->getName().'</span> ma pecha w walce. ';
                    $this->battleText .= $this->pokemon[$i]->getGender() === 1 ?  'Jej' :  'Jego';
                    $this->battleText .= ' statystyki zmniejszają się o <span class="czerwony">'.(-$this->stats[$i]->getLucky()).' %</span>./sdiv';
                }
            }
        }
        $this->battleText .= '</div></div>';
    }

    private function addAttachmentInfo()
    {
        $this->battleText .= '<div class="row"><div class="col-xs-12">';
        for ($i = 0; $i < 2; $i++) {
            if (!$this->stats[$i]->isAttachmentGiven()) {
                $this->stats[$i]->setAttachmentGiven(1);
                if ($this->pokemon[$i]->getCountedAttachment() > 70) {
                    $this->battleText .= 'alert.info<span><span class="pogrubienie">'.$this->pokemon[$i]->getName().'</span> jest bardzo przywiązan';
                    $this->battleText .= ($this->pokemon[$i]->getGender() === 1) ? 'a' : 'y';
                    $this->battleText .= ' do swojego trenera. ';
                    $this->battleText .= ($this->pokemon[$i]->getGender() === 1) ? 'Jej' : 'Jego';
                    $this->battleText .= ' statystyki rosną o <span class="zielony">'.(round((($this->pokemon[$i]->getCountedAttachment() - 70)/2), 2)).' %</span>./sdiv';
                }
            }
        }
        $this->battleText .= '</div></div>';
    }

    private function addShinyInfo()
    {
        $this->battleText .= '<div class="row"><div class="col-xs-12">';
        for ($i = 0; $i < 2; $i++) {
            if (!$this->stats[$i]->isShinyBonusGiven() && $this->stats[$i]->getShinyBonus()) {
                $this->stats[$i]->setShinyBonusGiven(1);
                $this->battleText .= 'alert.info<span>Ciało <span class="pogrubienie">'.$this->pokemon[$i]->getName().'</span> lśni przed walką. ';
                $this->battleText .= ($this->pokemon[$i]->getGender() === 1) ? 'Jej' : 'Jego';
                $this->battleText .= ' statystyki rosną o <span class="zielony">'.$this->stats[$i]->getShinyBonus().' %</span>./sdiv';
            }
        }
        $this->battleText .= '</div></div>';
    }
}
