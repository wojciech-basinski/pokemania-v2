<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Berry;
use AppBundle\Entity\Items;
use AppBundle\Entity\Pokeball;
use AppBundle\Entity\Pokemon;
use AppBundle\Entity\Stones;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class GameHunting
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var array
     */
    private $userCollection;

    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    /**
     * @var GameHuntingHelper
     */
    private $gameHuntingHelper;

    /**
     * @var string
     */
    private $place;

    /**
     * @var int
     */
    private $pa;

    /**
     * @var int
     */
    private $event;

    /**
     * @var Pokemon
     */
    private $pokemon;

    /**
     * @var array
     */
    private $pokemonInfo;

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @var GameHuntingTrainerHelper
     */
    private $trainerHelper;

    /**
     * @var null|array
     */
    private $trainerInfo = null;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @var GameCheckCaught
     */
    private $checkCaught;

    public function __construct(
        EntityManagerInterface $em,
        Session $session,
        Collection $collection,
        PokemonHelper $pokemonHelper,
        GameHuntingHelper $gameHuntingHelper,
        RequestStack $request,
        GameHuntingTrainerHelper $trainerHelper,
        GameCheckCaught $checkCaught
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->collection = $collection;
        $this->pokemonHelper = $pokemonHelper;
        $this->gameHuntingHelper = $gameHuntingHelper;
        $this->request = $request;
        $this->trainerHelper = $trainerHelper;
        $this->checkCaught = $checkCaught;
    }

    public function getTrainerBattleInfo(): array
    {
        if ($this->trainerInfo === null) {
            return [];
        }

        return $this->trainerInfo;
    }

    public function getTrainerPokemons()
    {
        return $this->trainerHelper->getTrainerPokemons();
    }

    public function getPlacesJohto(User $user): array
    {
        $this->user = $user;
        $this->getCollection($user);
        return [
            'polana' => [
                'name' => 'laka',
                'namePl' => 'Łąka',
                'description' => 'łąka_opis',
                'pokemons' => $this->pokemonCatchedInPlaces('Laka')
            ],
            'lodowiec' => [
                'name' => 'lodowiec',
                'namePl' => 'Lodowiec',
                'description' => 'lodowiec_opis',
                'pokemons' => $this->pokemonCatchedInPlaces('Lodowiec')
            ],
            'mokradla' => [
                'name' => 'mokradla',
                'namePl' => 'Mokradła',
                'description' => 'mokradła_opis',
                'pokemons' => $this->pokemonCatchedInPlaces('Mokradla')
            ],
            'wulkan' => [
                'name' => 'wulkan',
                'namePl' => 'Wulkan',
                'description' => 'spadaj sobie do wulkanu',
                'pokemons' => $this->pokemonCatchedInPlaces('Wulkan')
            ],
            'johto5' => [
                'name' => 'johto5',
                'namePl' => 'Johto5',
                'description' => 'dzicz bez nazwy',
                'pokemons' => $this->pokemonCatchedInPlaces('Johto5')
            ],
            'jezioro' => [
                'name' => 'jezioro',
                'namePl' => 'Jezioro',
                'description' => 'jezioro_opis',
                'pokemons' => $this->pokemonCatchedInPlaces('Jezioro')
            ],
            'mrocznylas' => [
                'name' => 'mrocznylas',
                'namePl' => 'Mroczny las',
                'description' => 'mroczny las, straszy xD',
                'pokemons' => $this->pokemonCatchedInPlaces('MrocznyLas')
            ],
        ];
    }

    public function getPlacesKanto(User $user): array
    {
        $this->user = $user;
        $this->getCollection($user);
        return [
            'polana' => [
                'name' => 'polana',
                'namePl' => 'Polana',
                'description' => 'Przemierzając ten obszar można natknąć się na pachnące drzewa z jagodami. 
                Dzicz ze względu na brak negatywnych wydarzeń jest 
                dobrym miejscem na wyprawy dla początkujących trenerów. 
                Niewykluczone, że na naszej drodze stanie mędrzec, który pomoże 
                zwiększyć doświadczenie nasze i naszych pokemonów.',
                'pokemons' => $this->pokemonCatchedInPlaces('Polana')
            ],
            'wyspa' => [
                'name' => 'wyspa',
                'namePl' => 'Wyspa',
                'description' => 'Na obszarze wyspy znajdują się oazy, gdzie wraz z pokemonami można odpocząć 
                    i zwiększyć ich przywiązanie do trenera. 
                    Należy jednak pamiętać, aby nie zapuszczać się zbyt daleko od brzegu, 
                    bo do odnalezienia drogi powrotnej trzeba będzie przeznaczyć większą ilość energii.',
                'pokemons' => $this->pokemonCatchedInPlaces('Wyspa')
            ],
            'grota' => [
                'name' => 'grota',
                'namePl' => 'Grota',
                'description' => 'Łowcy z całego regionu przybywają tutaj na poszukiwanie skarbów. 
                Jednak schodząc do środka 
                    łatwo zgubić się w ciemnych komnatach, gdzie znalezienie wyjścia
                     powoduje utratę dodatkowych punktów akcji. 
                    Do zwiedzania tego miejsca należy zaopatrzyć się w latarkę. 
                    Nie zapomnij kupić baterii w pokesklepie, ponieważ zejście 
                    do groty nie będzie możliwe.',
                'pokemons' => $this->pokemonCatchedInPlaces('Grota')
            ],
            'dom_strachow' => [
                'name' => 'domstrachow',
                'namePl' => 'Dom strachów',
                'description' => 'Budynek nie zamieszkiwany od wielu lat przez ludzi, 
                niektórzy twierdzą, że jest nawiedzony. 
                W środku znajduje się wiele sekretnych pomieszczeń a w nich ukryte są cenne przedmioty. 
                Spotkanie przyjaznych 
                duchów zwiększa przywiązanie pokemonów.',
                'pokemons' => $this->pokemonCatchedInPlaces('DomStrachow')
            ],
            'gory' => [
                'name' => 'gory',
                'namePl' => 'Góry',
                'description' => 'Najbardziej kolorowe miejsce w regionie dzięki wszechobecnym jagodom. 
                Można znaleźć tu bardzo rzadkie ich odmiany. 
                Poruszanie się po stromej powierzchni jest dość uciążliwe, 
                dlatego zużycie energii jest większe niż podczas normalnej wyprawy.',
                'pokemons' => $this->pokemonCatchedInPlaces('Gory')
            ],
            'wodospad' => [
                'name' => 'wodospad',
                'namePl' => 'Wodospad',
                'description' => 'Przechodząc obok wodospadu można ujrzeć błysk na jego szczycie. Warto więc zabrać 
                ze sobą pokemona typu powietrznego. Należy jednak uważać na śliskie kamienie, bo jedno zachwianie może 
                spowodować zgubienie balla z plecaka. Królują tu wodne pokemony.',
                'pokemons' => $this->pokemonCatchedInPlaces('Wodospad')
            ],
            'safari' => [
                'name' => 'safari',
                'namePl' => 'Safari',
                'description' => 'Wejście na teren safari możliwy jest poprzez okazanie 
                odpowiedniego kuponu strażnikowi. 
                Jest to miejsce występowania rzadkich gatunków pokemonów. Znajdują się tu również cenne przedmioty, 
                które można wydobyć za pomocą łopaty. Uważaj jednak na dzikiego Psyducka, 
                który wykrada jagody z plecaków.',
                'pokemons' => $this->pokemonCatchedInPlaces('Safari')
            ]
        ];
    }

    public function checkPlace(string $place, User $user): bool
    {
        $this->place = strtolower($place);
        switch ($user->getRegion()) {
            case 1:
                return in_array(
                    $this->place,
                    ['polana', 'grota', 'wyspa', 'domstrachow', 'gory', 'safari', 'wodospad']
                );
            case 2:
                return in_array(
                    $this->place,
                    ['laka', 'lodowiec', 'mokradla', 'wulkan', 'JOHTO5', 'jezioro', 'mrocznylas']
                );
            default:
                return false;
        }
    }

    public function checkActivity(User $user): ?string
    {
        return $user->getActivity();
    }

    public function checkPokemonsCondition(): bool
    {
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon' . $i)) {
                if ($this->session->get('pokemon' . $i)->getActualHp()
                    && $this->session->get('pokemon' . $i)->getHunger() <= 90
                ) {
                    return true;
                }
            }
        }
        return false;
    }

    public function selectEvent(User $user)
    {
        if ($this->session->get('eventHunting')) {
            $this->checkActivityInSession($user);
            if ($this->session->get('eventHunting')) {
                $this->event = $this->session->get('eventHunting');
                return;
            }
        }
        $event = $this->gameHuntingHelper->eventInPlace($this->place);
        $this->event = $event['event'];
        $this->pa = $event['pa'];
    }

    public function checkPa(User $user): bool
    {
        //event that making hunting unavailable don't take PA
        if ($this->pa < 10 && !in_array($this->event, [100])) {
            $this->pa = 10;
        }
        if ($user->getPa() < $this->pa) {
            $this->session->getFlashBag()->add('error', 'Niestety masz za mało PA');
            return false;
        }

        if ($this->place === 'safari') {
            $statistics = $user->getStatistics();
            if (!$statistics->getCupons()) {
                $this->session->getFlashBag()->add('error', 'Niestety nie posiadasz kuponu na safari');
                return false;
            }
            $statistics->setCupons($statistics->getCupons() - 1);
        } elseif ($this->place === 'grota') {
            $items = $user->getItems();
            if (!$items->getFlashlight()) {
                $this->session->getFlashBag()->add('error', 'Niestety nie posiadasz latarki');
                return false;
            }
            if (!$items->getBattery()) {
                $this->session->getFlashBag()->add('error', 'Niestety nie posiadasz baterii');
                return false;
            }
            $items->setBattery($items->getBattery() - 1);
        }
        $this->subtractPa($user, $this->pa);
        return true;
    }

    private function subtractPa(User $user, int $pa)
    {
        $user->setPa($user->getPa() - $pa);
        if ($user->getPa() < 0) {
            $user->setPa(0);
        }
    }

    public function execute(string $place, User $user): bool
    {
        if (!$this->checkPlace($place, $user)) {
            $this->session->getFlashBag()->add('error', 'Błędna nazwa dziczy');
            return 0;
        }
        if ($this->checkActivity($user)) {
            $this->session->getFlashBag()->add('error', 'Nie możesz polować w trakcie aktywności');
            return 0;
        }
        if (!$this->checkPokemonsCondition()) {
            $this->session->getFlashBag()->add(
                'error',
                'Nie możesz podróżować jeśli wszystkie Twoje pokemony są ranne lub głodne.'
            );
            return 0;
        }

        $this->selectEvent($user);

        if (!$this->session->get('eventHunting')) {
            if (!$this->checkPa($user)) {
                return 0;
            }
            $this->addAchievement($user);
        }

        /**
         * TODO
         * eventy
         */
        switch ($this->event) {
            case 0:
                $this->emptyEvent();
                break;
            case -1:
                $this->berrysPolana($user->getId());
                break;
            case -2:
                $this->sagePolana($user);
                break;
            case -3:
                $this->lostWyspa($user);
                break;
            case -4:
                $this->oasaWyspa($user->getId());
                break;
            case -5:
                $this->treasureGrota($user);
                break;
            case -6:
                $this->lostGrota($user);
                break;
            case -7:
                $this->pokemonsDomStrachow($user->getId());
                break;
            case -8:
                $this->itemDomStrachow($user);
                break;
            case -9:
                $this->berrysGory($user->getId());
                break;
            case -11:
                $this->negatywneWodospad();
                break;
            case -18:
                $this->digingSafari($user);
                break;
            case -19:
                $this->flashWodospad($user);
                break;
            case -20:
                $this->stealSafari($user->getId());
                break;
            case -999:
                $this->trainer($user);
                break;
            case 100:
                $this->session->getFlashBag()->add(
                    'error',
                    'Do mrocznego lasu można wejść tylko w godzinach 21-6'
                );
                return 0;

            case 1024:
                $this->generatePokemon($user);
                $this->addPokemonToCollection($this->pokemon->getIdPokemon(), $user);
                break;
        }

        $this->em->flush();
        return 1;
    }

    public function whatRender(): string
    {
        switch ($this->event) {
            case -18:
                return 'game/hunting/event.html.twig';
            case -999:
                return 'game/hunting/trainer.html.twig';
            case 1024:
                return 'game/hunting/pokemon.html.twig';
            default:
                return 'game/hunting/place.html.twig';
        }
    }

    public function getHuntingInfo(): array
    {
        return [
            'pokemonInfo' => $this->pokemonInfo,
            'pokemon' => $this->pokemon,
            'pokedex' => $this->session->get('userSession')->getUserItems()->getPokedex()
        ];
    }

    private function addAchievement(User $user)
    {
        $statistics = $user->getStatistics();
        $achievements = $user->getAchievements();

        $statistics->setTravels($statistics->getTravels() + 1);
        $achievements->{'set' . $this->place}($achievements->{'get' . $this->place}() + 1);
    }

    private function pokemonCatchedInPlaces(string $place): array
    {
        return $this->checkCaught->check($place, $this->user, $this->collection);
    }

    private function getCollection(User $user)
    {
        if ($this->userCollection === null) {
            $this->userCollection = $user->getCollection();
        }
    }

    private function generatePokemon(User $user)
    {
        $this->pokemon = $this->gameHuntingHelper->generatePokemon($this->place, $user);
        $this->session->set('pokemonHunting', $this->pokemon);
    }

    private function addPokemonToCollection(int $id, User $user)
    {
        $info = $this->collection->addOneToPokemonMetAndReturnIfMetAndCaught($id, $user, $this->pokemon->getShiny());

        $this->pokemonInfo['met'] = $info[0];
        $this->pokemonInfo['caught'] = $info[1];
    }

    private function emptyEvent()
    {
        $this->session->getFlashBag()->add('error', 'Niestety nie spotkało Cię nic ciekawego.');
    }

    private function berrysPolana(int $userId)
    {
        $r = mt_rand(0, 20);
        if ($r <= 1) {//tu będą te lepsze jagody, ilość od 1 do 3
            $r = mt_rand(1, 8);
            $quantity = mt_rand(1, 3);
            if ($r === 1) {
                $berrys = 'Leppa Berry';
            } elseif ($r === 2) {
                $berrys = 'Oran Berry';
            } elseif ($r === 3) {
                $berrys = 'Persim Berry';
            } elseif ($r === 4) {
                $berrys = 'Lum Berry';
            } elseif ($r === 5) {
                $berrys = 'Sitrus Berry';
            } elseif ($r === 6) {
                $berrys = 'Figy Berry';
            } elseif ($r === 7) {
                $berrys = 'Mago Berry';
            } elseif ($r === 8) {
                $berrys = 'Razz Berry';
            }
        } elseif ($r <= 8) {//tu będą te średnie, ilość od 4 do 8
            $r = mt_rand(1, 5);
            $quantity = mt_rand(4, 8);
            if ($r === 1) {
                $berrys = 'Aspear Berry';
            } elseif ($r === 2) {
                $berrys = 'Chesto Berry';
            } elseif ($r === 3) {
                $berrys = 'Wiki Berry';
            } elseif ($r === 4) {
                $berrys = 'Aguav Berry';
            } elseif ($r === 5) {
                $berrys = 'Lapapa Berry';
            }
        } else { //tu będą te gorsze, ilość od 9 do 20
            $r = mt_rand(1, 3);
            $quantity = mt_rand(9, 20);
            if ($r === 1) {
                $berrys = 'Cheri Berry';
            } elseif ($r === 2) {
                $berrys = 'Pecha Berry';
            } elseif ($r === 3) {
                $berrys = 'Rawst Berry';
            }
        }
        $this->session->getFlashBag()->add(
            'success',
            "Na swojej drodze znalazłeś drzewko z <strong>{$berrys}</strong> 
Zbierasz z niego <strong>{$quantity}</strong> sztuk."
        );
        $berrys = str_replace(' ', '', $berrys);
        $berry = $this->em->find('AppBundle:Berry', $userId);
        $berry->{'set' . $berrys}($berry->{'get' . $berrys}() + $quantity);
        $this->addBerrysToStatistics($quantity, $userId);
    }

    private function sagePolana(User $user)
    {
        $this->session->getFlashBag()->add(
            'success',
            '<Na swojej drodze spotykasz mędrca, który przekazuje Tobie i Twoim Pokemonom część swojej wiedzy.
<br />Otrzymujesz 5 pkt doświadczenia, a każdy Pokemon z Twojej drużyny dostaje 15 pkt doświadczenia.'
        );
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon' . $i)) {
                $this->session->get('pokemon' . $i)
                    ->setExp($this->session->get('pokemon' . $i)->getExp() + 15);
            }
        }
        $user->setExperience($user->getExperience() + 5);
        $this->em->getRepository('AppBundle:Pokemon')->addExpByTraining(15, $user->getId());
    }

    private function lostWyspa(User $user)
    {
        $this->session->getFlashBag()->add('error', 'Zgubiłeś się na wyspie! Tracisz 10PA');
        $this->subtractPa($user, 10);
    }

    private function oasaWyspa(int $userId)
    {
        $this->session->getFlashBag()->add(
            'success',
            'Znalazłeś oazę. Odpoczywasz razem z Pokemonami co skutkuje zwiększeniem ich zaufania.'
        );
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon' . $i)) {
                $this->session->get('pokemon' . $i)
                    ->setAttachment($this->session->get('pokemon' . $i)->getAttachment() + 10);
            }
        }
        $this->em->getRepository('AppBundle:Pokemon')->addAtachmentToPokemonsInTeam($userId, 10);
    }

    private function treasureGrota(User $user)
    {
        $value = floor((mt_rand(2000, 15000) / 10000) * $user->getTrainerLevel() * 1000);
        $user->setCash($user->getCash() + $value);
        $this->session->getFlashBag()->add('success', "Znalazłeś skarb! Dostajesz za niego {$value} &yen;");
    }

    private function lostGrota(User $user)
    {
        $this->session->getFlashBag()->add('error', 'Zgubiłeś się w grocie! Tracisz 15PA');
        $this->subtractPa($user, 15);
    }

    private function pokemonsDomStrachow(int $userId)
    {
        $this->session->getFlashBag()->add(
            'success',
            'Na drodze spotykasz przyjazną grupę Pokemonów duchów, które chętnie bawią się z Twoimi Pokemonami.
<br />Zaufanie Twoich Pokemonów w drużynie zwiększa się.'
        );
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon' . $i)) {
                $this->session->get('pokemon' . $i)
                    ->setAttachment($this->session->get('pokemon' . $i)->getAttachment() + 10);
            }
        }
        $this->em->getRepository('AppBundle:Pokemon')->addAtachmentToPokemonsInTeam($userId, 10);
    }

    private function berrysGory(int $userId)
    {
        $r = mt_rand(0, 20);
        if ($r <= 8) { //tu będą te lepsze jagody, ilość od 2 do 6
            $r = mt_rand(1, 8);
            $quantity = mt_rand(2, 6);
            if ($r === 1) { //leppa
                $berrys = 'Leppa Berry';
            } elseif ($r === 2) { //oran
                $berrys = 'Oran Berry';
            } elseif ($r === 3) { //Persim
                $berrys = 'Persim Berry';
            } elseif ($r === 4) { //Lum
                $berrys = 'Lum Berry';
            } elseif ($r === 5) { //Sitrus
                $berrys = 'Sitrus Berry';
            } elseif ($r === 6) { //Figy
                $berrys = 'Figy Berry';
            } elseif ($r === 7) { //Mago
                $berrys = 'Mago Berry';
            } elseif ($r === 8) { //Razz
                $berrys = 'Razz Berry';
            }
        } elseif ($r <= 15) {//tu będą te średnie, ilość od 5 do 10
            $r = mt_rand(1, 5);
            $quantity = mt_rand(5, 10);
            if ($r === 1) { //aspear
                $berrys = 'Aspear Berry';
            } elseif ($r === 2) { //chesto
                $berrys = 'Chesto Berry';
            } elseif ($r === 3) { //wiki
                $berrys = 'Wiki Berry';
            } elseif ($r === 4) { //aguav
                $berrys = 'Aguav Berry';
            } elseif ($r === 5) { //lapapa
                $berrys = 'Lapapa Berry';
            }
        } else { //tu będą te gorsze, ilość od 7 do 14
            $r = mt_rand(1, 3);
            $quantity = mt_rand(7, 14);
            if ($r === 1) { //cheri berry
                $berrys = 'Cheri Berry';
            } elseif ($r === 2) { //pecha berry
                $berrys = 'Pecha Berry';
            } elseif ($r === 3) { //rawst
                $berrys = 'Rawst Berry';
            }
        }
        $this->session->getFlashBag()->add(
            'success',
            "Na swojej drodze znalazłeś drzewko z <strong>{$berrys}</strong>. 
Zbierasz z niego <strong>{$quantity}</strong> sztuk."
        );
        $berrys = str_replace(' ', '', $berrys);
        $berry = $this->em->find('AppBundle:Berry', $userId);
        $berry->{'set' . $berrys}($berry->{'get' . $berrys}() + $quantity);
        $this->addBerrysToStatistics($quantity, $userId);
    }

    private function negatywneWodospad()
    {
        $this->session->getFlashBag()->add('error', 'NEGATYWNE WYDARZENIE');
    }

    private function stealSafari(int $userId)
    {
        $this->session->getFlashBag()->add(
            'error',
            'Zobaczyłeś Psyducka, który zagląda do Twojego plecaka.'
        );
        //cheri, chesto, pecha, rawst
        $berrys = $this->em->find('AppBundle:Berry', $userId);
        $berry = [
            1 => ['name' => 'CheriBerry', 'text' => 'Cheri Berry'],
            2 => ['name' => 'ChestoBerry', 'text' => 'Chesto Berry'],
            3 => ['name' => 'PechaBerry', 'text' => 'Pecha Berry'],
            4 => ['name' => 'RawstBerry', 'text' => 'Rawst Berry'],
        ];
        $what = mt_rand(1, 5);

        if ($what != 5 && $berrys->{'get' . $berry[$what]['name']}()) {
            $this->session->getFlashBag()->add(
                'error',
                "Okazało się, że Pokemon zabrał z plecaka {$berry[$what]['text']}"
            );
            $berrys->{'set' . $berry[$what]['name']}($berrys->{'get' . $berry[$what]['name']}() - 1);
            $what = 6;
        } elseif ($what != 5) {
            $i = array();
            $i[1] = $what;
            $j = 1;
            while (1) {
                $what = mt_rand(1, 4);
                if (in_array($what, $i) && $berrys->{'get' . $berry[$what]['name']}()) {
                    $what = $j;
                    break;
                } else {
                    $j++;
                    $i[$j] = $what;
                }
                if ($j === 4) {
                    $what = 5;
                    break;
                }
            }
        }
        if ($what === 5) {
            $this->session->getFlashBag()->add(
                'error',
                'Po obejrzeniu plecaka okazało się, że Pokemon niczego nie zabrał.'
            );
        } elseif ($what < 5) {
            $this->session->getFlashBag()->add(
                'error',
                "Niestety Pokemon zabrał z plecaka {$berry[$what]['$text']}"
            );
            $berrys->{'set' . $berry[$what]}($berrys->{'get' . $berry[$what]['name']}() - 1);
        }
    }

    private function flashWodospad(User $user)
    {
        $this->session->getFlashBag()->add('success', 'Dostrzegasz błysk na górze wodospadu.');
        $flying = 0;
        for ($i = 0; $i < 6; $i++) {
            /** @var Pokemon $pokemon */
            $pokemon = $this->session->get('pokemon' . $i);
            if ($pokemon) {
                $type1 = $pokemon->getInfo()['type1'];
                $type2 = $pokemon->getInfo()['type2'];
                if ($type1 === 6 || $type2 === 6) {
                    $flying = 1;
                    break;
                }
            }
        }

        if (!$flying) {
            $this->session->getFlashBag()->add(
                'error',
                'Niestety nie masz w drużynie latającego Pokemona, więc musisz ruszyć w dalszą podróż.'
            );
        } else {
            $this->session->getFlashBag()->add(
                'success',
                'Posyłasz swojego Pokemona, by zbadał to miejsce.'
            );
            $losuj = mt_rand(1, 1000);
            if ($losuj === 1) {//kamień
                $kamien = mt_rand(1, 6);
                if ($kamien === 1) {
                    $kamien = 'ognisty';
                    $name = 'FireStone';
                } elseif ($kamien === 2) {
                    $kamien = 'wodny';
                    $name = 'WaterStone';
                } elseif ($kamien === 3) {
                    $kamien = 'gromu';
                    $name = 'ThunderStone';
                } elseif ($kamien === 4) {
                    $kamien = 'roślinny';
                    $name = 'LeafStone';
                } elseif ($kamien === 5) {
                    $kamien = 'księżycowy';
                    $name = 'MoonStone';
                } elseif ($kamien === 6) {
                    $kamien = 'słoneczny';
                    $name = 'FireStone';
                }
                $stones = $user->getStones();
                $stones->{'set' . $name}($stones->{'get' . $name}() + 1);
                $this->session->getFlashBag()->add('success', "Pokemon przyniósł kamień {$kamien}");
            } elseif ($losuj <= 600) {
                $value = floor((mt_rand(1900, 8000) / 11000) * $user->getTrainerLevel() * 950);
                $this->session->getFlashBag()->add(
                    'success',
                    "Pokemon przyniósł kawałek srebra o wartości {$value} &yen;"
                );
                $user->setCash($user->getCash() + $value);
            } elseif ($losuj <= 610) {
                $this->session->getFlashBag()->add('success', 'Pokemon przyniósł puszkę wody.');
                $items = $user->getItems();
                $items->setWater($items->getWater() + 1);
                $this->em->persist($items);
            } else {
                $this->session->getFlashBag()->add(
                    'error',
                    'Niestety okazuje się, że to tylko słońce odbiło się w wodzie, a Pokemon wrócił z niczym.'
                );
            }
        }
    }

    private function itemDomStrachow(User $user)
    {
        while (1) {
            $r = mt_rand(0, 300);
            if ($r < 1) { //tu będą te lepsze przedmioty
                $pokeballs = $this->em->find('AppBundle:Pokeball', $user->getId());
                $pokeballs->setMasterballs($pokeballs->getMasterballs() + 1);
                $this->session->getFlashBag()->add('success', 'Znalazłeś Masterballa');
            } elseif ($r < 3) {
                $r2 = mt_rand(1, 5);
                if ($r2 === 1) {
                    $prz = 'ognisty';
                    $name = 'FireStone';
                } elseif ($r2 === 2) {
                    $name = 'WaterStone';
                    $prz = 'wodny';
                } elseif ($r2 === 3) {
                    $name = 'LeafStone';
                    $prz = 'roslinny';
                } elseif ($r2 === 4) {
                    $name = 'ThunderStone';
                    $prz = 'gromu';
                } elseif ($r2 === 5) {
                    $name = 'MoonStone';
                    $prz = 'ksiezycowy';
                } elseif ($r2 === 6) {
                    $name = 'SunStone';
                    $prz = 'słoneczny';
                }
                $stones = $user->getStones();
                $stones->{'set' . $name}($stones->{'get' . $name}() + 1);
                $this->session->getFlashBag()->add('success', "Znalazłeś kamień {$prz}!");
            } elseif ($r < 35) {//karta
                $this->session->getFlashBag()->add(
                    'success',
                    'Znalazłeś kartę!<br />To będzie jeszcze dopracowane...'
                );
            } elseif ($r < 45) {//soda
                $this->session->getFlashBag()->add('success', 'Znalazłeś sodę!');
                $items = $user->getItems();
                $items->setSoda($items->getSoda() + 1);
            } elseif ($r < 150) {//pokeballe
                $r2 = mt_rand(1, 91);
                if ($r2 < 20) {
                    $prz = 'pokeballi';
                    $name = 'Pokeballs';
                    $quantity = 10;
                } elseif ($r2 < 35) {//nestball
                    $prz = 'nestballi';
                    $name = 'Nestballs';
                    $quantity = 10;
                } elseif ($r2 < 50) {//greatball
                    $prz = 'greatballi';
                    $name = 'Greatballs';
                    $quantity = 10;
                } elseif ($r2 < 65) {//duskball
                    $prz = 'duskballi';
                    $name = 'Duskballs';
                    $quantity = 5;
                } elseif ($r2 < 80) {//lureball
                    $prz = 'lureballi';
                    $name = 'Lureballs';
                    $quantity = 5;
                } elseif ($r2 < 85) {//ultraball
                    $prz = 'ultraball';
                    $name = 'Ultraballs';
                    $quantity = 1;
                } elseif ($r2 < 90) {//repeatball
                    $prz = 'repeatballi';
                    $name = 'Repeatballs';
                    $quantity = 5;
                } else {//cherishball
                    $prz = 'cherishballi';
                    $name = 'Cherishballs';
                    $quantity = 1;
                }
                $this->session->getFlashBag()->add('success', "Znalazłeś {$quantity} {$prz}");
                $pokeballs = $this->em->find('AppBundle:Pokeball', $user->getId());
                $pokeballs->{'set' . $name}($pokeballs->{'get' . $name}() + $quantity);
            } else { //tu będą te gorsze
                $this->session->getFlashBag()->add(
                    'success',
                    'Znalazłeś jakiś przedmiot!<br />To też będzie dopracowane'
                );
            }
            break;
        }
    }

    private function digingSafari(User $user)
    {
        if ($this->session->get('eventHunting') && $this->session->get('eventHunting') === -18) {
            $event = explode('|', $this->session->get('eventHunting_set'));
            if ($event[0] === 0) {
                if ($user->getPa() < 5) {
                    $this->session->getFlashBag()->add('error', 'Posiadasz za mało PA, żeby kopać.');
                    return;
                }
                $event[0] = 1;
                $this->subtractPa($user, 5);
            }

            $sum = 0;
            $count = count($event);
            for ($i = 1; $i < $count; $i++) {
                $sum += $event[$i];
            }
            if (!$sum) {
                $random = mt_rand(1, 800);
            } else {
                $random = mt_rand(1, (950 + ($event[0] - 1) * 30));
            }
            if ($random <= 200) {//pusto
                $this->session->getFlashBag()->add('info', 'Wykopałeś tylko kilka bezużytecznych korzeni.');
                $event[0]--;
            } else if ($random <= 350) {
                $value = floor((mt_rand(1900, 8000) / 11000) * $user->getTrainerLevel() * 950);
                $this->session->getFlashBag()->add(
                    'info',
                    "Wykopałeś kawałek srebra o wartości {$value} &yen;"
                );
                $event[1] += $value;
            } else if ($random <= (351 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś kamień ognisty.');
                $event[2]++;
            } else if ($random <= (352 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś kamień wodny.');
                $event[3]++;
            } else if ($random <= (353 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś kamień gromu.');
                $event[4]++;
            } else if ($random <= (354 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś kamień księżycowy.');
                $event[5]++;
            } else if ($random <= (355 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś kamień słoneczny.');
                $event[6]++;
            } else if ($random <= (356 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś Rare Candy.');
                $event[7]++;
            } else if ($random <= (357 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś Masterballa.');
                $event[8]++;
            } else if ($random <= (358 + $event[0])) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś skamielinę.');
                $event[15]++;
            } else if ($random <= 475) {
                $rand = mt_rand(5, 19);
                $this->session->getFlashBag()->add(
                    'info',
                    "Wykopałeś {$rand} owoców Chesto Berry prawdopodobnie 
                        zakopanych wcześniej przez jakiegoś Pokemona."
                );
                $event[9] += $rand;
            } else if ($random <= 550) {
                $rand = mt_rand(4, 10);
                $this->session->getFlashBag()->add(
                    'info',
                    "Wykopałeś {$rand} owoców Aspear Berry prawdopodobnie 
                        zakopanych wcześniej przez jakiegoś Pokemona."
                );
                $event[10] += $rand;
            } else if ($random <= 600) {
                $rand = mt_rand(5, 15);
                $this->session->getFlashBag()->add(
                    'info',
                    "Wykopałeś {$rand} owoców Lapapa Berry prawdopodobnie 
                        zakopanych wcześniej przez jakiegoś Pokemona."
                );
                $event[11] += $rand;
            } else if ($random <= 660) {
                $rand = mt_rand(5, 15);
                $this->session->getFlashBag()->add(
                    'info',
                    "Wykopałeś {$rand} owoców Aguav Berry prawdopodobnie 
                        zakopanych wcześniej przez jakiegoś Pokemona."
                );
                $event[12] += $rand;
            } else if ($random <= 670) {
                $this->session->getFlashBag()->add('info', 'Wykopałeś lemoniadę.');
                $event[13]++;
            } else if ($random <= 800) {
                $rand = mt_rand(1, 3);
                $this->session->getFlashBag()->add('info', "Wykopałeś {$rand} Repeatballi.");
                $event[14] += $rand;
            }
            if ($random > 800) {//zakopał się dół
                $this->session->getFlashBag()->add(
                    'error',
                    'Zauważyłeś, że ziemia zaczęła się osuwać i musiałeś uciekać z dołu. 
                        Niestety podczas ucieczki upuściłeś wszystkie znalezione rzeczy.'
                );
                $this->session->getFlashBag()->add(
                    'info2',
                    '<div class="col-xs-12 text-center margin-top"><button data-place="' . $this->place .
                    '" class="btn btn-primary btn-lg button_kontynuuj">KONTYNUUJ</button></div>'
                );
                $this->session->remove('eventHunting');
                $this->session->remove('eventHunting_set');
            } else {
                $this->session->getFlashBag()->add(
                    'info2',
                    '<div class="col-xs-12 margin_2"><button type="button" class="btn btn-primary btn-block 
                        wydarzenie text-center kursor" name="1">Kop głębiej</button></div>'
                );
                $this->session->getFlashBag()->add(
                    'info2',
                    '<div class="col-xs-12 margin_2"><button type="button" class="btn btn-primary btn-block 
                        wydarzenie text-center kursor" name="2">
                        Nie chcę dłużej kopać i zabieram wszystkie znalezione przedmioty ze sobą.</button></div>'
                );
                $event[0]++;
                $this->session->set('eventHunting_set', implode('|', $event));
            }
        } else {
            if ($this->session->get('userSession')->getUserItems()->getShovel()) {
                $this->session->getFlashBag()->add(
                    'info',
                    'Trafiasz na grząską glebę. Możesz poświęcić 5PA, żeby zacząć w niej kopać.'
                );
                $this->session->getFlashBag()->add(
                    'info2',
                    '<div class="col-xs-12 margin_2"><button type="button" 
class="btn btn-primary btn-block wydarzenie text-center kursor" name="1">
                        Chcę kopać</button></div>'
                );
                $this->session->getFlashBag()->add(
                    'info2',
                    '<div class="col-xs-12 margin_2"><button type="button" 
class="btn btn-primary btn-block wydarzenie text-center kursor" name="2">
                        Nie chcę kopać i idę przed siebie.</button></div>'
                );
                $this->session->set('eventHunting', -18);
                $this->session->set('eventHunting_set', '0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0');
            } else {
                $this->session->getFlashBag()->add(
                    'error',
                    'Trafiasz na grząską glebę, ale nie posiadasz łopaty, żeby w niej kopać.'
                );
            }
        }
    }

    private function checkActivityInSession(User $user)
    {
        switch ($this->session->get('eventHunting')) {
            case -16:
                if (!in_array($wydarzenie, [1, 2, 3])) {
                    Session::_unset('wydarzenie_dzicz');
                }
                break;
            case -18:
                $mode = $this->request->getCurrentRequest()->query->get('mode');
                if ($mode === 2 || $mode === 0) {
                    $event = explode('|', $this->session->get('eventHunting_set'));
                    $sum = 0;
                    $count = count($event);
                    for ($i = 1; $i < $count; $i++) {
                        $sum += $event[$i];
                    }
                    if ($sum) {
                        $info = '<div class="well well-primary jeden_ttlo text-medium text-center">
Wykopane przedmioty, które zabierasz ze sobą:<br />';
                        if ($event[1]) {
                            $info .= "Bryłki srebra o wartości {$event[1]} &yen;<br />";
                            $user->setCash($user->getCash() + $event[1]);
                        }
                        if ($event[2]) {
                            $stones = $user->getStones();
                            $info .= $event[2] . 'x kamień ognisty<br />';
                            $stones->setFireStone($stones->getFireStone() + $event[2]);
                        }
                        if ($event[3]) {
                            $stones = $user->getStones();
                            $info .= $event[3] . 'x kamień wodny<br />';
                            $stones->setWaterStone($stones->getWaterStone() + $event[3]);
                        }
                        if ($event[4]) {
                            $stones = $user->getStones();
                            $info .= $event[4] . 'x kamień gromu<br />';
                            $stones->setThunderStone($stones->getThunderStone() + $event[4]);
                        }
                        if ($event[5]) {
                            $stones = $user->getStones();
                            $info .= $event[5] . 'x kamień księżycowy<br />';
                            $stones->setMoonStone($stones->getMoonStone() + $event[5]);
                        }
                        if ($event[6]) {
                            $stones = $user->getStones();
                            $info .= $event[6] . 'x kamień słoneczny<br />';
                            $stones->setSunStone($stones->getSunStone() + $event[6]);
                        }
                        if ($event[7]) {
                            $items = $user->getItems();
                            $info .= $event[7] . 'x Rare Candy<br />';
                            $items->setCandy($items->getCandy() + $event[7]);
                        }
                        if ($event[8]) {
                            $pokeballs = $user->getPokeballs();
                            $info .= $event[8] . 'x Masterball<br />';
                            $pokeballs->setMasterballs($pokeballs->getMasterballs() + $event[8]);
                        }
                        if ($event[9]) {
                            $berrys = $user->getBerrys();
                            $info .= $event[9] . 'x Chesto Berry<br />';
                            $berrys->setChestoBerry($berrys->getChestoBerry() + $event[9]);
                        }
                        if ($event[10]) {
                            $berrys = $user->getBerrys();
                            $info .= $event[10] . 'x Aspear Berry<br />';
                            $berrys->setAspearBerry($berrys->getAspearBerry() + $event[10]);
                        }
                        if ($event[11]) {
                            $berrys = $user->getBerrys();
                            $info .= $event[11] . 'x Lapapa Berry<br />';
                            $berrys->setLapapaBerry($berrys->getLapapaBerry() + $event[11]);
                        }
                        if ($event[12]) {
                            $berrys = $user->getBerrys();
                            $info .= $event[12] . 'x Aguav Berry<br />';
                            $berrys->setAguavBerry($berrys->getAguavBerry() + $event[12]);
                        }
                        if ($event[13]) {
                            $items = $user->getItems();
                            $info .= $event[13] . 'x Lemoniada<br />';
                            $items->setLemonade($items->getLemonade() + $event[13]);
                        }
                        if ($event[14] > 0) {
                            $pokeballs = $user->getPokeballs();
                            $info .= $event[14] . 'x Repeatball<br />';
                            $pokeballs->setRepeatballs($pokeballs->getRepeatballs() + $event[14]);
                        }
                        if ($event[15] > 0) {
                            $items = $user->getItems();
                            $info .= $event[15] . 'x Skamielina<br />';
                            $items->setParts($items->getParts() + $event[15]);
                        }
                        $info .= '</div>';
                        $this->session->getFlashBag()->add('info2', $info);

                    }
                    $this->session->remove('eventHunting');
                    $this->session->remove('eventHunting_set');
                }
                break;
            default:
                $this->session->remove('eventHunting');
                break;
        }
    }

    private function trainer(User $user)
    {
        $battleInfo = $this->trainerHelper->trainer($user);
        $this->trainerInfo = $battleInfo;
    }

    private function addBerrysToStatistics(int $quantity, int $userId): void
    {
        $stats = $this->em->find('AppBundle:Achievement', $userId);
        $stats->setBeggedBerrys($stats->getBeggedBerrys() + $quantity);
    }
}
