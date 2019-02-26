<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Market;
use AppBundle\Entity\MarketPokemon;
use AppBundle\Entity\Pokemon;
use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameMarket
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
     * @var GamePack
     */
    private $pack;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var int
     */
    private $numberOfOfertsPokemon;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, GamePack $pack, RequestStack $request)
    {
        $this->em = $em;
        $this->session = $session;
        $this->pack = $pack;
        $this->request = $request->getCurrentRequest();
    }

    public function getBerrysDescription(): array
    {
        return [
            0 => [
                'name' => 'Cheri_Berry',
                'name2' => 'Cheri Berry',
                'minValue' => 50
            ],
            1 => [
                'name' => 'Wiki_Berry',
                'name2' => 'Wiki Berry',
                'minValue' => 100
            ],
            2 => [
                'name' => 'Chesto_Berry',
                'name2' => 'Chesto Berry',
                'minValue' => 2500
            ],
            3 => [
                'name' => 'Mago_Berry',
                'name2' => 'Mago Berry',
                'minValue' => 5000
            ],
            4 => [
                'name' => 'Pecha_Berry',
                'name2' => 'Pecha Berry',
                'minValue' => 2000
            ],
            5 => [
                'name' => 'Aguav_Berry',
                'name2' => 'Aguav Berry',
                'minValue' => 4000
                ],
            6 => [
                'name' => 'Rawst_Berry',
                'name2' => 'Rawst Berry',
                'minValue' => 3000
            ],
            7 => [
                'name' => 'Lapapa_Berry',
                'name2' => 'Lapapa Berry',
                'minValue' => 6000
            ],
            8 => [
                'name' => 'Aspear_Berry',
                'name2' => 'Aspear Berry',
                'minValue' => 5000
            ],
            9 => [
                'name' => 'Razz_Berry',
                'name2' => 'Razz Berry',
                'minValue' => 10000
            ],
            10 => [
                'name' => 'Leppa_Berry',
                'name2' => 'Leppa Berry',
                'minValue' => 20000
            ],
            11 => [
                'name' => 'Oran_Berry',
                'name2' => 'Oran Berry',
                'minValue' => 20000
            ],
            12 => [
                'name' => 'Persim_Berry',
                'name2' => 'Persim Berry',
                'minValue' => 20000
            ],
            13 => [
                'name' => 'Lum_Berry',
                'name2' => 'Lum Berry',
                'minValue' => 20000
            ],
            14 => [
                'name' => 'Sitrus_Berry',
                'name2' => 'Sitrus Berry',
                'minValue' => 20000
            ],
            15 => [
                'name' => 'Figy_Berry',
                'name2' => 'Figy Berry',
                'minValue' => 20000
            ]
        ];
    }

    public function getPokeballsDescription(): array
    {
        return [
            0 => [
                'name' => 'Pokeball',
                'minValue' => 70
            ],
            1 => [
                'name' => 'Nestball',
                'minValue' => 250
            ],
            2 => [
                'name' => 'Greatball',
                'minValue' => 750
            ],
            3 => [
                'name' => 'Ultraball',
                'minValue' => 7000
            ]
        ];
    }

    public function getOtherDescription(): array
    {
        return [
            0 => [
                'name' => 'Water',
                'namePl' => 'Woda',
                'minValue' => 45000
            ],
            1 => [
                'name' => 'Soda',
                'namePl' => 'Soda',
                'minValue' => 100000
            ],
        ];
    }

    public function getStonesDescription(): array
    {
        return [
            0 => [
                'namePl' => 'ogniste',
                'name' => 'FireStones',
                'img' => 'ogniste',
                'minValue' => 300000
            ],
            1 => [
                'namePl' => 'wodne',
                'name' => 'WaterStones',
                'img' => 'wodne',
                'minValue' => 300000
            ],
            2 => [
                'namePl' => 'roślinne',
                'name' => 'LeafStones',
                'img' => 'roslinne',
                'minValue' => 300000
            ],
            3 => [
                'namePl' => 'gromu',
                'name' => 'ThunderStones',
                'img' => 'gromu',
                'minValue' => 300000
            ],
            4 => [
                'namePl' => 'księżycowe',
                'name' => 'MoonStones',
                'img' => 'ksiezycowe',
                'minValue' => 300000
            ],
            5 => [
                'namePl' => 'słoneczne',
                'name' => 'SunStones',
                'img' => 'sloneczne',
                'minValue' => 300000
            ],
        ];
    }

    public function countItemMarket(string $name, int $userId, ?string $kind): int
    {
        if (!$kind) {
            $this->session->getFlashBag()->add('error', 'Przedmiot nie znaleziony');
            return 0;
        }
        $own = $this->session->get('userSession')->getUserSettings()->getMarket();
        return $this->em->getRepository('AppBundle:Market')->countOferts($name, $kind, $own, $userId);
    }

    /**
     * @param string      $name
     * @param int         $userId
     * @param null|string $kind
     *
     * @return null|Market|Market[]
     */
    public function getItems(string $name, int $userId, ?string $kind, int $page)
    {
        $own = $this->session->get('userSession')->getUserSettings()->getMarket();
        if ($page < 0) {
            $page = 0;
        }
        if ($page) {
            $page--;
        }
        return $this->em->getRepository('AppBundle:Market')->getOferts($name, $kind, $own, $userId, $page);
    }

    public function checkNameItem(string $name): ?string
    {
        $pokeball = $this->getPokeballsDescription();
        foreach ($pokeball as $item) {
            if ($name === $item['name']) {
                return 'Pokeball';
            }
        }
        $berry = $this->getBerrysDescription();
        foreach ($berry as $item) {
            if ($name === $item['name']) {
                return 'Berry';
            }
        }
        $other = $this->getOtherDescription();
        foreach ($other as $item) {
            if ($name === $item['name']) {
                return 'Items';
            }
        }
        $stones = $this->getStonesDescription();
        foreach ($stones as $item) {
            if ($name === $item['name']) {
                return 'Stones';
            }
        }
        return null;
    }

    public function getInfoPokemonForm(): array
    {
        return [
            'ID' => $this->request->request->get('ID') ?? '',
            'minLevel' => $this->request->request->get('min_level') ?? '',
            'maxLevel' => $this->request->request->get('max_level') ?? '',
            'minValue' => $this->request->request->get('min_value') ?? '',
            'maxValue' => $this->request->request->get('max_value') ?? '',
        ];
    }

    public function pokemonSearchOnMarket(User $user)
    {
        $id = $this->checkValue('ID');
        $minLevel = $this->checkValue('min_level');
        $maxLevel = $this->checkValue('max_level');
        $minValue = $this->checkValue('min_value');
        $maxValue = $this->checkValue('max_value');
        if ($minLevel > $maxLevel && $maxLevel != 0) {
            $maxLevel = $minLevel;
        }
        if ($minValue > $maxValue && $maxValue != 0) {
            $maxValue = $minValue;
        }

        if ($this->request->request->get('page')) {
            $page = $this->request->request->get('page') - 1;
        } else {
            $page = 0;
        }

        if ($page < 0) {
            $page = 0;
        }

        $own = $this->session->get('userSession')->getUserSettings()->getMarket();
        $this->numberOfOfertsPokemon = $this->calculateNumberOfOferts($id, $minLevel, $maxLevel, $minValue, $maxValue, $own, $user->getId());

        return $this->em->getRepository('AppBundle:MarketPokemon')->getOferts($id, $minLevel, $maxLevel, $minValue, $maxValue, $own, $user->getId(), $page);
    }

    public function getNumberOfofertsPokemon(): int
    {
        return $this->numberOfOfertsPokemon;
    }

    public function buyPokemon(User $user)
    {
        if (!$this->checkValue('id')) {
            $this->session->getFlashBag()->add('error', 'Błędne ID oferty');
            return;
        }
        $id = $this->request->request->get('id');
        $ofert = $this->em->find('AppBundle:MarketPokemon', $id);
        if (!$ofert) {
            $this->session->getFlashBag()->add('error', 'Oferta nie znaleziona');
            return;
        }
        if ($ofert->getOwnerId() === $user->getId()) {
            $this->session->getFlashBag()->add('error', 'Nie możesz kupić swojego Pokemona');
            return;
        }
        if ($ofert->getValue() > $user->getCash()) {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na zakup tego Pokemona');
            return;
        }
        /** @var Pokemon $pokemon */
        $pokemon = $this->em->find('AppBundle:Pokemon', $ofert->getIdPokemon());
        $pokemon->setMarket(0);
        $pokemon->setOwner($user->getId());
        $pokemon->setBlock(1);
        $pokemon->setExp(0);
        $pokemon->setAttachment(0);
        $this->em->persist($pokemon);

        $secondUser = $this->em->find('AppBundle:User', $ofert->getOwnerId());
        $secondUser->setCash($secondUser->getCash() + $ofert->getValue());
        $user->setCash($user->getCash() - $ofert->getValue());
        $this->addReportAboutBuyingPokemon($ofert->getValue(), $ofert->getOwnerId(), $pokemon->getName());

        $this->em->remove($ofert);
        $this->em->persist($user);
        $this->em->persist($secondUser);
        $this->em->flush();
        $this->session->getFlashBag()->add('success', 'Kupiono Pokemona. Znajduje się on w Twojej rezerwie.');
    }

    public function pokemonsThatCanBeSold(int $userId)
    {
        return $this->em->getRepository('AppBundle:Pokemon')->pokemonsThatCanBeSoldOnMarket($userId);
    }

    public function pokemonsAddedToSell(int $userId)
    {
        return $this->em->getRepository('AppBundle:MarketPokemon')->pokemonsAddedToSell($userId);
    }

    public function buyItem(User $user)
    {
        $id = $this->checkValue('ID');
        if (!$id) {
            $this->session->getFlashBag()->add('error', 'Błędne ID oferty');
            return;
        }
        $value = $this->checkValue('value');
        if (!$value) {
            $value = 1;
        }
        $ofert = $this->em->find('AppBundle:Market', $id);
        if (!$ofert) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono oferty');
            return;
        }
        if ($value > $ofert->getQuantity()) {
            $value = $ofert->getQuantity();
        }
        $price = $value * $ofert->getValue();
        if ($price > $user->getCash()) {
             $value = intval($user->getCash() / $ofert->getValue());
             $price = $value  * $ofert->getValue();
        }
        if (!$value) {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na zakup tego produktu');
            return;
        }

        $this->buyItemExecute($ofert, $value, $price, $user);
        $this->em->flush();
    }

    private function buyItemExecute(Market $ofert, int $value, int $price, User $user)
    {
        $itemName = $ofert->getName();
        $kind = $ofert->getKind();
        $secondUser = $this->em->find('AppBundle:User', $ofert->getUserId());
        $ofert->setQuantity($ofert->getQuantity() - $value);
        if ($ofert->getQuantity() < 1) {
            $this->em->remove($ofert);
        } else {
            $this->em->persist($ofert);
        }

        $user->setCash($user->getCash() - $price);
        $secondUser->setCash($secondUser->getCash() + round(0.95*$price));

        $this->addItemsToUser($itemName, $kind, $value, $user->getId());
        $itemName = $this->getNamePl($itemName, $kind);
        $this->session->getFlashBag()->add('success', "Kupiono {$value} {$itemName} za cenę {$price} &yen;");

        $this->addReportAboutBuyItem($secondUser, $price, $itemName, $value);
    }

    public function sellingPokemon(User $user)
    {
        $id = $this->checkValue('id');
        if (!$id) {
            $this->session->getFlashBag()->add('error', 'Błędne ID Pokemona');
            return;
        }
        $value = $this->checkValue('value');
        if (!$value) {
            $this->session->getFlashBag()->add('error', 'Błędna cena');
            return;
        }
        $message = $this->request->request->get('message');
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')->findOneBy(['id' => $id, 'owner' => $user->getId(), 'block' => 0, 'team' => 0, 'exchange' => 0, 'market' => 0]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Pokemon nie znaleziony');
            return;
        }
        if ($value < round($pokemon->getValue() * 1.2)) {
            $this->session->getFlashBag()->add('error', 'Cena zbyt niska');
            return;
        }
        if ($user->getCash() < round(0.01 * $value)) {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na zapłacenie opłaty za wystawienia Pokemona na targu.');
            return;
        }

        $this->addToMarketPokemon($pokemon, $user, $value, $message);
        $this->em->flush();
        $cost = round(0.01 * $value);
        $this->session->getFlashBag()->add('success', "Wystawiono Pokemona na targ, zapłacono {$cost} &yen; opłaty.");
    }

    public function removePokemonFromMarket(User $user)
    {
        $id = $this->checkValue('id');
        if (!$id) {
            $this->session->getFlashBag()->add('error', 'Błędny ID oferty');
            return;
        }
        $ofert = $this->em->find('AppBundle:MarketPokemon', $id);
        if (!$ofert) {
            $this->session->getFlashBag()->add('error', 'Oferta nie znaleziona');
            return;
        }
        if ($ofert->getOwnerId() != $user->getId()) {
            $this->session->getFlashBag()->add('error', 'To nie Twoja oferta.');
            return;
        }

        $pokemon = $this->em->find('AppBundle:Pokemon', $ofert->getIdPokemon());
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błąd krytyczny, nie znaleziono Pokemona');
            $this->createReportToAdminPokemonNotFound($ofert);
            $this->em->flush();
            return;
        }

        $pokemon->setMarket(0);
        $this->em->persist($pokemon);
        $this->em->remove($ofert);

        $this->session->getFlashBag()->add('success', 'Wycofano Pokemona z targu');
        $this->em->flush();
    }

    public function getBerrysAvailableToSell(User $user): array
    {
        $berrys = $this->pack->getBerrys($user->getId());
        $berrysToSell = $this->getBerrysDescription();
        $return = [];
        $count = count($berrysToSell);
        for ($i = 0; $i < $count; $i++) {
            if ($berrys->{'get'.str_replace('_', '', $berrysToSell[$i]['name'])}()) {
                $return[] = array_merge($berrysToSell[$i], ['value' => $berrys->{'get'.str_replace('_', '', $berrysToSell[$i]['name'])}()]);
            }
        }
        return $return;
    }

    public function getPokeballsAvailableToSell(User $user): array
    {
        $pokeballs = $this->pack->getPokeballs($user->getId());
        $pokeballsToSell = $this->getPokeballsDescription();
        $return = [];
        $count = count($pokeballsToSell);
        for ($i = 0; $i < $count; $i++) {
            if ($pokeballs->{'get'.$pokeballsToSell[$i]['name'].'s'}()) {
                $return[] = array_merge($pokeballsToSell[$i], ['value' => $pokeballs->{'get'.$pokeballsToSell[$i]['name'].'s'}()]);
            }
        }
        return $return;
    }

    public function getOthersAvailableToSell(User $user): array
    {
        $items = $this->pack->getItems($user->getId());
        $itemsToSell = $this->getOtherDescription();
        $return = [];
        $count = count($itemsToSell);
        for ($i = 0; $i < $count; $i++) {
            if ($items->{'get'.$itemsToSell[$i]['name']}()) {
                $return[] = array_merge($itemsToSell[$i], ['value' => $items->{'get'.$itemsToSell[$i]['name']}()]);
            }
        }
        return $return;
    }

    public function getStonesAvailableToSell(User $user): array
    {
        $stones = $this->pack->getStones($user->getId());
        $stonesToSell = $this->getStonesDescription();
        $return = [];
        $count = count($stonesToSell);
        for ($i = 0; $i < $count; $i++) {
            if ($stones->{'get'.substr($stonesToSell[$i]['name'], 0, strlen($stonesToSell[$i]['name'])-1)}()) {
                $return[] = array_merge($stonesToSell[$i], ['value' => $stones->{'get'.substr($stonesToSell[$i]['name'], 0, strlen($stonesToSell[$i]['name'])-1)}()]);
            }
        }
        return $return;
    }

    public function getItemsOnMarket(int $userId)
    {
        return $this->em->getRepository('AppBundle:Market')->findBy(['userId' => $userId]);
    }

    public function removeItemFromMarket(User $user)
    {
        $id = $this->checkValue('id');
        if (!$id) {
            $this->session->getFlashBag()->add('error', 'Błędne ID oferty');
            return;
        }
        $ofert = $this->em->getRepository('AppBundle:Market')->findOneBy(['id' => $id, 'userId' => $user->getId()]);
        if (!$ofert) {
            $this->session->getFlashBag()->add('error', 'Oferta nie znaleziona lub została już wykupiona');
            return;
        }
        $this->reverseItems($ofert, $user);
        $this->session->getFlashBag()->add('success', 'Wycofano ofertę z targu');

        $this->em->remove($ofert);
        $this->em->flush();
    }

    public function addItemToMarket(User $user)
    {
        $itemName = $this->request->request->get('id');
        $kind = $this->checkNameItem($itemName);
        if (!$kind) {
            $this->session->getFlashBag()->add('error', 'Przedmiot nie znaleziony');
            return;
        }
        $quantity = $this->checkValue('quantity');
        if (!$quantity) {
            $this->session->getFlashBag()->add('error', 'Błędna ilość');
            return;
        }
        $value = $this->checkValueItem($itemName, $kind);
        if (!$value) {
            return;
        }
        $plName = $this->getNamePl($itemName, $kind);
        $itemsQuantity = $this->getItemsQuanity($itemName, $kind, $user->getId());
        if (!$itemsQuantity) {
            $this->session->getFlashBag()->add('error', "Nie posiadasz {$plName}");
            return;
        }
        if ($itemsQuantity < $quantity) {
            $quantity = $itemsQuantity;
        }
        $this->addItemsToUser($itemName, $kind, -$quantity, $user->getId());
        $tax = round(0.01 * $quantity * $value);
        if ($user->getCash() < $tax) {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na zapłacenie opłaty od wystawienia przedmiotów.');
            return;
        }
        $user->setCash($user->getCash() - $tax);
        $ofert = new Market();
        $ofert->setUserId($user->getId())
            ->setQuantity($quantity)
            ->setValue($value)
            ->setKind($kind)
            ->setNamePl($plName)
            ->setName($itemName);
        $this->em->persist($ofert);
        $this->em->persist($user);
        $this->session->getFlashBag()->add('success', "Wystawiono {$quantity} {$plName} za cenę {$value}&yen; za sztukę i zapłacono {$tax}&yen; opłaty za wystawienię produktów");
        $this->em->flush();
    }

    private function checkValueItem(string $itemName, string $kind):int
    {
        $value = $this->checkValue('value');
        if (!$value) {
            $this->session->getFlashBag()->add('error', 'Błędna cena');
            return 0;
        }
        if (!$this->checkMinimalValue($value, $itemName, $kind)) {
            $this->session->getFlashBag()->add('error', 'Cena zbyt niska');
            return 0;
        }
        return $value;
    }

    private function checkValue(string $value): ?int
    {
        $id = $this->request->request->get($value) ?? '';
        if ($id === 0 || $id === '' || !is_numeric($id)) {
            return null;
        }
        return $id;
    }

    private function calculateNumberOfOferts(?int $id, ?int $minLevel, ?int $maxLevel, ?int $minValue, ?int $maxValue, bool $own, int $userId): int
    {
        return $this->em->getRepository('AppBundle:MarketPokemon')->countOfers($id, $minLevel, $maxLevel, $minValue, $maxValue, $own, $userId);
    }

    private function addReportAboutBuyingPokemon(int $value, int $id, string $name)
    {
        $report = new Report();
        $report->setIsRead(0);
        $report->setTime(new \DateTime());
        $report->setUserId($id);
        $report->setTitle('Twój Pokemon został sprzedany na targu');
        $report->setContent("Otrzymujesz {$value}&yen; za sprzedaż {$name} na targu");

        $this->em->persist($report);
    }

    private function addToMarketPokemon(Pokemon $pokemon, User $user, int $value, ?string $message)
    {
        $pokemonMarket = new MarketPokemon();
        $pokemonMarket->setName($pokemon->getName());
        $pokemonMarket->setIdPokemon($pokemon->getId());
        $pokemonMarket->setLevel($pokemon->getLevel());
        $pokemonMarket->setGender($pokemon->getGender());
        $pokemonMarket->setIdPokemonBase($pokemon->getIdPokemon());
        $pokemonMarket->setShiny($pokemon->getShiny());
        $pokemonMarket->setType1($pokemon->getInfo()['typ1']);
        $pokemonMarket->setType2($pokemon->getInfo()['typ2']);
        $pokemonMarket->setOwnerId($user->getId());
        $pokemonMarket->setMessage($message);
        $pokemonMarket->setValue($value);
        $pokemonMarket->setPokemonInfo($pokemon);
        $this->em->persist($pokemonMarket);

        $pokemon->setMarket(1);
        $pokemon->setBlockView(0);
        $this->em->persist($pokemon);
        $user->setCash($user->getCash() - round(0.01 * $value));
    }

    private function createReportToAdminPokemonNotFound(MarketPokemon $ofert)
    {
        $report = new Report();
        $report->setIsRead(0);
        $report->setContent('Nie znaleziono Pokemona o ID '.$ofert->getIdPokemon().' w bazie, id oferty: '.$ofert->getId());
        $report->setTitle('Nie zleziono Pokemona, targ');
        $report->setUserId(1);
        $report->setTime(new \DateTime());
        $this->em->persist($report);
    }

    private function addItemsToUser(string $itemName, string $kind, int $value, int $userId)
    {
        switch ($kind) {
            case 'Pokeball':
                $this->addPokeball($itemName.'s', $value, $userId);
                break;
            case 'Items':
                $this->addItem($itemName, $value, $userId);
                break;
            case 'Berry':
                $itemName = str_replace('_', '', $itemName);
                $this->addBerry($itemName, $value, $userId);
                break;
            case 'Stones':
                $itemName = substr($itemName, 0, strlen($itemName)-1);
                $this->addStone($itemName, $value, $userId);
                break;
        }
    }

    private function addPokeball(string $itemName, int $value, int $userId)
    {
        $pokeball = $this->pack->getPokeballs($userId);
        $pokeball->{'set'.$itemName}($pokeball->{'get'.$itemName}()+ $value);
        $this->em->persist($pokeball);
    }

    private function addItem(string $itemName, int $value, int $userId)
    {
        $items = $this->pack->getItems($userId);
        $items->{'set'.$itemName}($items->{'get'.$itemName}()+ $value);
        $this->em->persist($items);
    }

    private function addBerry(string $itemName, int $value, int $userId)
    {
        $berrys = $this->pack->getBerrys($userId);
        $berrys->{'set'.$itemName}($berrys->{'get'.$itemName}()+ $value);
        $this->em->persist($berrys);
    }

    private function addStone(string $itemName, int $value, int $userId)
    {
        $stones = $this->pack->getStones($userId);
        $stones->{'set'.$itemName}($stones->{'get'.$itemName}()+ $value);
        $this->em->persist($stones);
    }

    private function getNamePl(string $itemName, string $kind): string
    {
        switch ($kind) {
            case 'Pokeball':
                $pokeball = $this->getPokeballsDescription();
                foreach ($pokeball as $item) {
                    if ($itemName === $item['name']) {
                        return $item['name'];
                    }
                }
                //no-break
            case 'Items':
                $other = $this->getOtherDescription();
                foreach ($other as $item) {
                    if ($itemName === $item['name']) {
                        return $item['namePl'];
                    }
                }
            //no-break
            case 'Berry':
                return str_replace('_', ' ', $itemName);
        }
        $stones = $this->getStonesDescription();
        foreach ($stones as $item) {
            if ($itemName === $item['name']) {
                return $item['namePl'];
            }
        }
        return '';
    }

    private function addReportAboutBuyItem(User $user, int $price, string $itemName, int $value)
    {
        $tax = $price - round(0.95 * $price);
        $report = new Report();
        $report->setTime(new \DateTime());
        $report->setUserId($user->getId());
        $report->setIsRead(0);
        $report->setTitle('Twoja oferta została zakupiona');
        $report->setContent("Dostałeś {$price} &yen; za sprzedaż {$value} sztuk {$itemName} na targu, 
            z czego zapłaciłeś {$tax} &yen; opłaty.");
        $this->em->persist($report);
    }

    private function reverseItems(Market $ofert, User $user)
    {
        switch ($ofert->getKind()) {
            case 'Pokeball':
                $this->reverseUsersPokeballs($ofert, $user);
                return;
            case 'Items':
                $this->reverseUsersItems($ofert, $user);
                return;
            case 'Berry':
                $this->reverseUsersBerry($ofert, $user);
                return;
            case 'Stones':
                $this->reverseUsersStones($ofert, $user);
                return;
        }
    }

    private function reverseUsersPokeballs(Market $ofert, User $user)
    {
        $name = $ofert->getName().'s';
        $pokeballs = $this->pack->getPokeballs($user->getId());
        $pokeballs->{'set'.$name}($pokeballs->{'get'.$name}() + $ofert->getQuantity());
        $this->em->persist($pokeballs);
    }

    private function reverseUsersItems(Market $ofert, User $user)
    {
        $items = $this->pack->getItems($user->getId());
        $items->{'set'.$ofert->getName()}($items->{'get'.$ofert->getName()}() + $ofert->getQuantity());
        $this->em->persist($items);
    }

    private function reverseUsersBerry(Market $ofert, User $user)
    {
        $name = str_replace('_', '', $ofert->getName());
        $berry = $this->pack->getBerrys($user->getId());
        $berry->{'set'.$name}($berry->{'get'.$name}() + $ofert->getQuantity());
        $this->em->persist($berry);
    }

    private function reverseUsersStones(Market $ofert, User $user)
    {
        $name = substr($ofert->getName(), 0, strlen($ofert->getName())-1);
        $stones = $this->pack->getStones($user->getId());
        $stones->{'set'.$name}($stones->{'get'.$name}() + $ofert->getQuantity());
        $this->em->persist($stones);
    }

    private function checkMinimalValue(int $value, string $itemName, string $kind): bool
    {
        switch ($kind) {
            case 'Pokeball':
                $pokeball = $this->getPokeballsDescription();
                foreach ($pokeball as $item) {
                    if ($itemName === $item['name']) {
                        return ($item['minValue'] <= $value);
                    }
                }
            //no-break
            case 'Items':
                $other = $this->getOtherDescription();
                foreach ($other as $item) {
                    if ($itemName === $item['name']) {
                        return ($item['minValue'] <= $value);
                    }
                }
            //no-break
            case 'Berry':
                $berry = $this->getBerrysDescription();
                foreach ($berry as $item) {
                    if ($itemName === $item['name']) {
                        return ($item['minValue'] <= $value);
                    }
                }
            //no-break
            case 'Stones':
                $stones = $this->getStonesDescription();
                foreach ($stones as $item) {
                    if ($itemName === $item['name']) {
                        return ($item['minValue'] <= $value);
                    }
                }
        }
        return false;
    }

    private function getItemsQuanity(string $itemName, string $kind, int $userId)
    {
        switch ($kind) {
            case 'Pokeball':
                $pokeball = $this->pack->getPokeballs($userId);
                return $pokeball->{'get'.$itemName.'s'}();
            case 'Items':
                $items = $this->pack->getItems($userId);
                return $items->{'get'.$itemName}();
            case 'Berry':
                $itemName = str_replace('_', '', $itemName);
                $berry = $this->pack->getBerrys($userId);
                return $berry->{'get'.$itemName}();
            case 'Stones':
                $itemName = substr($itemName, 0, strlen($itemName)-1);
                $stones = $this->pack->getStones($userId);
                return $stones->{'get'.$itemName}();
        }
    }
}
