<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameShop
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
     * @var User
     */
    private $user;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function getPokeballsDescriptions(): array
    {
        return [
            1 => [
                'nazwa' => 'pokeball',
                'opis' => 'Jest to najprostsze urządzenie łapania pokemonów.',
                'cena' => 75,
            ],
            2 => [
                'nazwa' => 'nestball',
                'opis' => 'To wersja pokeballa przeznaczona do łapania młodych i niedoświadczonych pokemonów.',
                'cena' => 350,
            ],
            3 => [
                'nazwa' => 'greatball',
                'opis' => 'Jest to ulepszona wersja pokeballa posiadająca dwa razy większą szansę na złapanie pokemona.',
                'cena' => 800,
            ],
            4 => [
                'nazwa' => 'ultraball',
                'opis' => 'To pokeball o czterokrotnie większej szansie na złapanie pokemona.',
                'cena' => 7500,
            ],
            5 => [
                'nazwa' => 'duskball',
                'opis' => 'Ten pokeball służy do łapania pokemonów w nocy, posiada on wtedy trzykrotnie większą szansę na złapanie pokemona, a za dnia posiada skuteczność
        zwykłego pokeballa.',
                'cena' => 2000,
            ],
            6 => [
                'nazwa' => 'lureball',
                'opis' => 'Lureballe zaprojektowano z myślą o łapaniu pokemonow tego samego typu, posiadają trzykrotnie wiekszą szanse złapania takich pokemonów.',
                'cena' => 1500,
            ],
            7 => [
                'nazwa' => 'repeatball',
                'opis' => 'Repeatballe zostały stworzone do łapania rzadkich gatunków Pokemonów. Po nieudanej próbie złapania daje wystarczająco dużo czasu na rzucenie kolejnego pokeballa.',
                'cena' => 120000,
            ],
            8 => [
                'nazwa' => 'safariball',
                'opis' => 'Są to specjalne pokeballe przygotowane dla Safari. Posiadają 70% większą szansę złapania Pokemona niż zwykły pokeball.',
                'cena' => 1700,
            ]
        ];
    }

    public function getAllItems(User $user, $mode = ''): array
    {
        return [
            'items' => $user->getItems(),
            'statistics' => $user->getStatistics(),
            'stones' => $user->getStones()
        ];
    }

    public function buy(?string $item, ?int $quantity, User $user): void
    {
        $this->user = $user;
        if (!$this->checkItem($item)) {
            $this->session->getFlashBag()->add('error', 'Błędna nazwa przedmiotu');
            return;
        }
        if ($quantity === 0 || $quantity < 0) {
            $quantity = 1;
        }

        $this->{'buy'.ucfirst($item)}($quantity);
        $this->em->flush();
    }

    private function checkItem(?string $item): bool
    {
        if ($item === '' ||
            !in_array($item, ['mpa', 'safari', 'pokemonFood', 'lottery', 'bars', 'cookies', 'box', 'pokedex',
            'kit', 'shovel', 'rune', 'battery', 'flashLight', 'pokeball', 'nestball', 'greatball',
                'ultraball', 'duskball', 'lureball', 'repeatball', 'safariball'])
        ) {
            return false;
        }
        return true;
    }

    private function buyBattery(int $quantity): void
    {
        $items = $this->user->getItems();
        $price = $quantity * 55;
        if (!$this->checkCash($price)) {
            return;
        }
        $items->setBattery($items->getBattery() + $quantity);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' baterii za ' . $price . ' &yen;');
    }

    private function buyFlashLight(): void
    {
        $items = $this->user->getItems();
        if (!$items->getFlashlight()) {
            $price = 5000;
            if (!$this->checkCash($price)) {
                return;
            }
            $items->setFlashlight(1);

            $this->session->getFlashBag()->add('success', 'Kupiono latarkę');
        } else {
            $this->session->getFlashBag()->add('error', 'Posiadasz już złotą latarkę');
        }
    }

    private function buyRune(int $quantity): void
    {
        $stones = $this->user->getStones();
        $price = $quantity * 100000;
        if (!$this->checkCash($price)) {
            return;
        }
        $stones->setRunes($stones->getRunes() + $quantity);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' run ewolucyjnych za cenę ' . $price . ' &yen;');
    }

    private function buyShovel(): void
    {
        $items = $this->user->getItems();
        if (!$items->getShovel()) {
            $price = 500000;
            if (!$this->checkCash($price)) {
                return;
            }
            $items->setShovel(1);

            $this->session->getFlashBag()->add('success', 'Kupiono złotą łopatę');
            $this->session->get('userSession')->getUserItems()->setShovel(1);
        } else {
            $this->session->getFlashBag()->add('error', 'Posiadasz już złotą łopatę');
        }
    }

    private function buyKit(): void
    {
        $items = $this->user->getItems();
        $p = [1 => 25000, 2 => 180000, 3 => 800000];
        if ($items->getKit() < 3) {
            $price = $p[$items->getKit() + 1];
            if (!$this->checkCash($price)) {
                return;
            }
            $items->setKit($items->getKit() + 1);

            $this->session->getFlashBag()->add('success', 'Kupiono apteczkę poziomu ' . $items->getKit() . ' za cenę ' . $price . ' &yen;');
            $this->session->get('userSession')->getUserItems()->setKit($items->getKit());
        } else {
            $this->session->getFlashBag()->add('error', 'Posiadasz już maksymalny poziom apteczki');
        }
    }

    private function buyPokedex(): void
    {
        $items = $this->user->getItems();
        if ($items->getPokedex() <= 3) {
            $price = (5 ** ($items->getPokedex() + 1)) * 10000;
            if (!$this->checkCash($price)) {
                return;
            }
            $items->setPokedex($items->getPokedex() + 1);

            $this->session->getFlashBag()->add('success', 'Kupiono pokedex poziomu ' . $items->getPokedex() . ' za cenę ' . $price . ' &yen;');

            $this->session->get('userSession')->getUserItems()->setPokedex($items->getPokedex());
        } else {
            $this->session->getFlashBag()->add('error', 'Posiadasz już maksymalny poziom pokedexu');
        }
    }

    private function buyBox(): void
    {
        $items = $this->user->getItems();
        if ($items->getBox() < 5) {
            $price = $items->getBox() * 150000;
            if (!$this->checkCash($price)) {
                return;
            }
            $items->setBox($items->getBox() + 1);
            $this->user->setMagazine($this->user->getMagazine() * 2);

            $this->session->getFlashBag()->add('success', 'Kupiono ' . $items->getBox() . ' poziom magazynu za cenę ' . $price . '&yen;');
        } else {
            $this->session->getFlashBag()->add('error', 'Posiadasz już maksymalny poziom magazynu');
        }
    }

    private function buyBars(int $quantity): void
    {
        $items = $this->user->getItems();
        $price = $quantity * 400;
        if (!$this->checkCash($price)) {
            return;
        }
        $items->setBar($items->getBar() + $quantity);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' batonów za cenę ' . $price . ' &yen;');
    }

    private function buyCookies(int $quantity): void
    {
        $items = $this->user->getItems();
        $price = $quantity * 2100;
        if (!$this->checkCash($price)) {
            return;
        }
        $items->setCookie($items->getCookie() + $quantity);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' ciastek za cenę ' . $price . ' &yen;');
    }

    private function buyLottery(int $quantity): void
    {
        $statistics = $this->user->getStatistics();
        $price = $quantity * 60000;
        if (!$this->checkCash($price)) {
            return;
        }
        $statistics->setLottery($statistics->getLottery() + $quantity);
        $this->em->persist($statistics);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' kuponów na  loterię za cenę ' . $price . ' &yen;');
    }

    private function buyMpa(): void
    {
        $items = $this->user->getItems();
        if ($items->getMpa() < 10) {
            $price = 2 ** $items->getMpa() * 25000;
            if (!$this->checkCash($price)) {
                return;
            }

            $this->user->setMpa($this->user->getMpa() + 10);
            $items->setMpa($items->getMpa() + 1);

            $this->session->getFlashBag()->add('success', 'Kupiono przedmiot, Twoje MPA zwiększono o 10 za cenę ' . $price . ' &yen;');
        } else {
            $this->session->getFlashBag()->add('error', 'Nie możesz kupić tego przedmiotu');
        }
    }

    private function buySafari(int $quantity): void
    {
        $statistics = $this->user->getStatistics();
        $price = $quantity * 15000;
        if (!$this->checkCash($price)) {
            return;
        }

        $statistics->setCupons($statistics->getCupons() + $quantity);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' kuponów na Safari za cenę ' . $price . ' &yen;');
    }

    private function buyPokemonFood(int $quantity): void
    {
        $items = $this->user->getItems();
        $price = $quantity * 1500;
        if (!$this->checkCash($price)) {
            return;
        }
        $items->setPokemonFood($items->getPokemonFood() + $quantity);

        $this->session->getFlashBag()->add('success', 'Kupiono ' . $quantity . ' pudełek karmy za ' . $price . ' &yen;');
    }

    private function buyPokeball(int $quantity): void
    {
        $price = 75 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Pokeballs', $quantity);

        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' pokeballi.');
    }

    private function buyNestball(int $quantity): void
    {
        $price = 350 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Nestballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' nestballi.');
    }

    private function buyGreatball(int $quantity): void
    {
        $price = 800 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Greatballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' greatballi');
    }

    private function buyUltraball(int $quantity): void
    {
        $price = 7500 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Ultraballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' ultraballi');
    }

    private function buyDuskball(int $quantity): void
    {
        $price = 2000 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Duskballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' duskballi');
    }

    private function buyLureball(int $quantity): void
    {
        $price = 1500 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Lureballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' lureballi');
    }

    private function buyRepeatball(int $quantity): void
    {
        $price = 120000 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Repeatballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' repeatballi');
    }

    private function buySafariball(int $quantity): void
    {
        $price = 1700 * $quantity;
        if (!$this->checkCash($price)) {
            return;
        }
        $this->updatePokeballs('Safariballs', $quantity);
        $this->session->getFlashBag()->add('success', 'Zakupiono '.$quantity.' safariballi');
    }

    private function checkCash(int $price): bool
    {
        if (!($this->user->getCash() >= $price)) {
            $this->session->getFlashBag()->add('error', 'Nie stać Cię na ten zakup');
            return false;
        }
        $this->user->setCash($this->user->getCash()- $price);
        $this->em->persist($this->user);
        return true;
    }

    private function updatePokeballs(string $pokeball, int $quantity): void
    {
        $pokeballs = $this->user->getPokeballs();
        $pokeballs->{'set'.$pokeball}($pokeballs->{'get'.$pokeball}() + $quantity);
    }
}
