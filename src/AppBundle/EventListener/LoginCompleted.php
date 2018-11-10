<?php

namespace AppBundle\EventListener;

use AppBundle\Utils\AuthenticationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginCompleted implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthenticationService
     */
    private $auth;

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationService $auth)
    {
        $this->tokenStorage = $tokenStorage;
        $this->auth = $auth;
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.interactive_login' => ['onUserLoginComplete'],
        ];
    }

    public function onUserLoginComplete(InteractiveLoginEvent $event)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $this->auth->loginUser($user->getId());
        //$this->em->persist($user);
        //$this->em->flush();
        //$newtoken = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user,null,'main', $user->getRoles());
        //$this->tokenStorage->setToken($newtoken);


        /*
         if($wiersz['ogloszenie'] > 0){
                Session::_set('ogloszenie', $wiersz['ogloszenie']);
            }
            $rezultat = $this->model->wiadomosci($wiersz['ID']);
            $rezultat = $rezultat[0];
            if($rezultat['abcd'] > 0) Session::_set('nowe_w', $rezultat['abcd']);
            $rezultat = $this->model->raporty($wiersz['ID']);
            $rezultat = $rezultat[0];
            if($rezultat['abcd'] > 0) Session::_set('nowe_p', $rezultat['abcd']);


         Session::_set('style', $wiersz['styl']);
        Session::_set('samouczek', $wiersz['samouczek']);

         if($rez['aktywnosc'] == 'trening') Session::_set('aktywnosc', 'trening');
            else Session::_set('aktywnosc', '');


        if(!$wiersz['logowanie_dzis']){
            $kwer .= ', logowanie_dzis = 1, logowanie_pod_rzad = (logowanie_pod_rzad + 1)';
            Session::_set('nagroda', $wiersz['logowanie_pod_rzad'] +1);
            $this->model->osiagniecieLogowanie($wiersz['ID']);
        }


        $wiersz['ustawienia'] .= '|'.$wiersz['tlo'] . '|' . $wiersz['tabelka'];
            //print_r($wiersz['ustawienia']);exit;
            Session::_set('ustawienia', $wiersz['ustawienia']);
            $przedmioty =  $rez['darmowe_leczenia'] . '|' . $w['apteczka'] . '|' . $w['pokedex'] . '|' . $w['lopata'];
            Session::_set('przedmioty', $przedmioty);
            Session::_set('kasa', $wiersz['pieniadze']);
            Session::_set('poziom', $wiersz['poziom_trenera']);
            Session::_set('tr_exp', $wiersz['doswiadczenie']);
            Session::_set('exp_lvl_tr', $exp_next);
            //Session::_set('debug', $debug);
            Session::_set('mpa', $wiersz['mpa']);
            Session::_set('pa', $wiersz['pa']);
            Session::_set('magazyn', $wiersz['magazyn']);
            Session::_set('poki_magazyn', $a['abcd']);
            Session::_set('region', $wiersz['region']);
            Session::_set('nick', $wiersz['login']);
            Session::_set('punkty', $wiersz['punkty']);
            Session::_set('godzina', date('G'));

        $odznaki = $this->model->odznaki($wiersz['ID']);
            $odznaki = $odznaki[0];
            $zero = '0000-00-00';
            $odznaki_s = '';
            for($k = 0 ; $k < 8 ; $k++)
            {
                if($odznaki['Kanto'.($k+1)] > $zero)//odznaka zdobyta
                   $odznaki_s .= '1';
                else $odznaki_s .= '0';

                if($k < 7) $odznaki_s .= '|';

            }
            $zlapane = $this->model->zlapane($wiersz['ID']);
            $zlapane = $zlapane[0];
            $odznaki_s .= '|'.$zlapane['zlapanych'];
            Session::_set('odznaki', $odznaki_s);
            $um = $this->model->punkty($wiersz['ID']);
            $um = $um[0];
            $um = $um['p1'];
            Session::_set('umiejetnosci', $um);

        $rezultat = $this->model->druzyna($wiersz['ID']);
            require("./src/includes/pokemony/exp_na_poziom.php");
            $wiersz = $rezultat[0];
            $kwer = 'SELECT * FROM pokemony WHERE ID in (';
        $kwer2 = ")order by case ID ";
            for($i = 1 ; $i < 7 ; $i++)////dla poków z drużyny, robienie kwerendy
            {

              if($wiersz['pok'.$i] > 0)
              {
                if($i == 1) $kwer .= $wiersz['pok'.$i];
                else $kwer .= ','.$wiersz['pok'.$i];
                $kwer2 .= " WHEN '".$wiersz['pok'.$i]."' THEN ".$i;
              }
              else if($wiersz['pok'.$i] == 0) {$c = $i-1; break;}
            }
            $kwer .= $kwer2 ." END";
            $rezultat2 = $this->model->db->select($kwer, []);//pobranie informacji o pokemonie

            if(!isset($c)) $c = 6;
            $kwer = 'SELECT ewolucja_p, nazwa, id_poka FROM pokemon WHERE id_poka in (';
            $kwer2 = ")order by case id_poka ";
            for($j = 1 ; $j <= $c ; $j++)////dla i poków z drużyny
            {
              $wiersz2 = $rezultat2[$j-1];
              if($j == 1) $kwer .= "'".$wiersz2['id_poka']."'";
              else $kwer .= ",'".$wiersz2['id_poka']."'";
              $kwer2 .=" WHEN '".$wiersz2['id_poka']."' THEN ".$j;

              $lvl = $wiersz2['poziom']+1;
              if($lvl <= 100)$exp_next = $exp_na_poziom[$lvl];
              else $exp_next = 9999999999;
              $pok = $wiersz['pok'.$j] . '|' . $wiersz2['exp'] . '|' . $wiersz2['poziom'] . '|' . $wiersz2['id_poka'] . '|' . $wiersz2['imie'] . '|' . (round($wiersz2['jakosc'] * $wiersz2['HP'] / 100) + $wiersz2['Jag_HP'] + $wiersz2['tr_6'] * 5)
                     . '|' . $wiersz2['ewolucja'] . '|' . $wiersz2['akt_HP'] . '|' . $wiersz2['shiny'] . '|' . $exp_next . '|';
              Session::_set('pok'.$j, $pok);
              $poke[$j]['id'] = $wiersz2['id_poka'];
              $poke[$j]['imie'] = $wiersz2['imie'];
              $poke[$j]['plec'] = $wiersz2['plec'];
              $poke[$j]['glod'] = $wiersz2['glod'];
              $poke[$j]['jakosc'] = $wiersz2['jakosc'];

              //echo "<br /><br />";
              //$_SESSION['pok'.$i]['imie_z'] = 0;
              //if($_SESSION['pok'.$i]['imie'] != $wiersz2['nazwa']) $_SESSION['pok'.$i]['imie_z'] = 1;
            }
            $kwer .= $kwer2 ." END";
            //echo $kwer.'<br />';

            $rezultat3 = $this->model->db->select($kwer, []);//pobranie ID ewolucii
            $ile = $rezultat3['rowCount'];
            if($ile < $c)
            {
              for($j = 1 ; $j <= $ile ; $j++)////dla i poków z drużyny
              {
                $wiersz3 = $rezultat3[$j-1];
                for($i = 1 ; $i <= $c ; $i++)
                {
                  if($poke[$i]['id'] == $wiersz3['id_poka'])
                  {
                    if($poke[$i]['imie'] == $wiersz3['nazwa'])$_SESSION['pok'.$i] .= 0;
                    else $_SESSION['pok'.$i] .= 1;
                    $_SESSION['pok'.$i] .= '|' . $wiersz3['ewolucja_p'];
                    //print_r($_SESSION['pok'.$i]);
                    //echo '<br />';
                  }
                }

              }
            }
            else
              for($j = 1 ; $j <= $c ; $j++)////dla i poków z drużyny
              {
                $wiersz3 = $rezultat3[$j-1];
                if($poke[$j]['imie'] == $wiersz3['nazwa']) $_SESSION['pok'.$j] .= 0;
                else $_SESSION['pok'.$j] .= 1;
                $_SESSION['pok'.$j] .= '|' . $wiersz3['ewolucja_p'];
                //print_r($_SESSION['pok'.$j]);
                //echo '<br />';
              }
            for($i = 1 ; $i <= $c ; $i++)
                $_SESSION['pok'.$i] .= '|' . $poke[$i]['plec'] . '|'. $poke[$i]['glod']. '|'. $poke[$i]['jakosc'];

             ///////////////////////////////////////////////////////////////////////
            Session::_set('beta', 1);
        } else {
            Session::_set('bladZaloguj', '<span style="color:red;">Nieprawidłowy login lub hasło!</span>');
            header('Location: '.URL);
        }
        */






        //todo add variables to session
        $event->stopPropagation();
    }
}
