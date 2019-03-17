<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Pokemon;
use AppBundle\Entity\PokemonTraining;
use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GamePack
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
     * @var RequestStack
     */
    private $request;
    /**
     * @var AuthenticationService
     */
    private $auth;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(
        EntityManagerInterface $em,
        SessionInterface $session,
        RequestStack $request,
        AuthenticationService $auth,
        PokemonHelper $pokemonHelper,
        Collection $collection
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->request = $request;
        $this->auth = $auth;
        $this->pokemonHelper = $pokemonHelper;
        $this->collection = $collection;
    }

    public function getPokemonsToSelect(): array
    {
        $pokemon = [];
        for ($i = 0; $i < 7; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                $pokemon[] = $this->session->get('pokemon'.$i);
            } else {
                break;
            }
        }

        return $pokemon;
    }

    public function getPokemonDescriptions(): array
    {
        return [
            0 => [
                'nazwa' => 'pokeball',
                'opis' => 'Jest to najprostsze urządzenie łapania pokemonów.',
            ],
            1 => [
                'nazwa' => 'nestball',
                'opis' => 'To wersja pokeballa przeznaczona do łapania młodych i niedoświadczonych pokemonów.',
            ],
            2 => [
                'nazwa' => 'greatball',
                'opis' => 'Jest to ulepszona wersja pokeballa posiadająca dwa razy większą szansę na złapanie pokemona.',
            ],
            3 => [
                'nazwa' => 'ultraball',
                'opis' => 'To pokeball o czterokrotnie większej szansie na złapanie pokemona.',
            ],
            4 => [
                'nazwa' => 'duskball',
                'opis' => 'Ten pokeball służy do łapania pokemonów w nocy, posiada on wtedy trzykrotnie większą szansę na złapanie pokemona, a za dnia posiada skuteczność
        zwykłego pokeballa.',
            ],
            5 => [
                'nazwa' => 'lureball',
                'opis' => 'Lureballe zaprojektowano z myślą o łapaniu pokemonow tego samego typu, posiadają trzykrotnie wiekszą szanse złapania takich pokemonów.',
            ],
            6 => [
                'nazwa' => 'repeatball',
                'opis' => 'Repeatballe zostały stworzone do łapania rzadkich gatunków Pokemonów. Po nieudanej próbie złapania daje wystarczająco dużo czasu na rzucenie kolejnego pokeballa.',
            ],
            7 => [
                'nazwa' => 'safariball',
                'opis' => 'Są to specjalne pokeballe przygotowane dla Safari. Posiadają 70% większą szansę złapania Pokemona niż zwykły pokeball.',
            ],
            8 => [
                'nazwa' => 'cherishball',
                'opis' => 'Cherishballe to zaawansowane technicznie pokeballe o siedmiokrotnie większej szansie złapania niż zwykły pokeball.',
            ],
            9 => [
                'nazwa' => 'masterball',
                'opis' => 'Są to najrzadsze i najbardziej zaawansowane pokeballe. Posiadają 100% szansy na złapanie pokemona.',
            ]
        ];
    }

    public function getBerrysDescriptions(): array
    {
        return [
        0 => [
            'nazwa' => 'Cheri_Berry',
            'nazwa2' => 'Cheri Berry',
            'opis' => 'Jagoda odnawia 15 punktów zdrowia pokemona.',
            'rodzaj' => 1
        ],
        1 => [
            'nazwa' => 'Wiki_Berry',
            'nazwa2' => 'Wiki Berry',
            'opis' => 'Jagoda odnawia 30 punktów zdrowia pokemona.',
            'rodzaj' => 1
        ],
        2 => [
            'nazwa' => 'Chesto_Berry',
            'nazwa2' => 'Chesto Berry',
            'opis' => 'Jagoda odnawia 20 punktów akcji.',
            'rodzaj' => 2
        ],
        3 => [
            'nazwa' => 'Mago_Berry',
            'nazwa2' => 'Mago Berry',
            'opis' => 'Jagoda odnawia 40 punktów akcji.',
            'rodzaj' => 2
        ],
        4 => [
            'nazwa' => 'Pecha_Berry',
            'nazwa2' => 'Pecha Berry',
            'opis' => 'Jagoda dodaje 3 punkty doświadczenia dla pokemona.',
            'rodzaj' => 3
        ],
        5 => [
            'nazwa' => 'Aguav_Berry',
            'nazwa2' => 'Aguav Berry',
            'opis' => 'Jagoda dodaje 5 punktów doświadczenia dla pokemona.',
            'rodzaj' => 3
        ],
        6 => [
            'nazwa' => 'Rawst_Berry',
            'nazwa2' => 'Rawst Berry',
            'opis' => 'Jagoda dodaje 1 punkt doświadczenia dla trenera.',
            'rodzaj' => 2
        ],
        7 => [
            'nazwa' => 'Lapapa_Berry',
            'nazwa2' => 'Lapapa Berry',
            'opis' => 'Jagoda dodaje 2 punkty doświadczenia dla trenera.',
            'rodzaj' => 2
        ],
        8 => [
            'nazwa' => 'Aspear_Berry',
            'nazwa2' => 'Aspear Berry',
            'opis' => 'Jagoda zwiększa maksymalną ilość punktów akcji.',
            'rodzaj' => 2
        ],
        9 => [
            'nazwa' => 'Razz_Berry',
            'nazwa2' => 'Razz Berry',
            'opis' => 'Jagoda zwiększa maksymalną ilość punktów akcji. Działa jak dwie Aspear Berry.',
            'rodzaj' => 2
        ],
        10 => [
            'nazwa' => 'Leppa_Berry',
            'nazwa2' => 'Leppa Berry',
            'opis' => 'Jagoda zwiększa atak pokemona.',
            'rodzaj' => 3
        ],
        11 => [
            'nazwa' => 'Oran_Berry',
            'nazwa2' => 'Oran Berry',
            'opis' => 'Jagoda zwiększa specjalny atak pokemona.',
            'rodzaj' => 3
        ],
        12 => [
            'nazwa' => 'Persim_Berry',
            'nazwa2' => 'Persim Berry',
            'opis' => 'Jagoda zwiększa obronę pokemona.',
            'rodzaj' => 3
        ],
        13 => [
            'nazwa' => 'Lum_Berry',
            'nazwa2' => 'Lum Berry',
            'opis' => 'Jagoda zwiększa specjalną obronę pokemona.',
            'rodzaj' => 3
        ],
        14 => [
            'nazwa' => 'Sitrus_Berry',
            'nazwa2' => 'Sitrus Berry',
            'opis' => 'Jagoda zwiększa szybkość pokemona.',
            'rodzaj' => 3
        ],
        15 => [
            'nazwa' => 'Figy_Berry',
            'nazwa2' => 'Figy Berry',
            'opis' => 'Jagoda zwiększa punkty życia pokemona.',
            'rodzaj' => 3
        ],
        ];
    }

    public function getStonesDescriptions(): array
    {
        return [
            0 => [
                'nazwa' => 'ogniste',
                'nazwa2' => 'ognisty',
                'opis' => 'Pozwala na ewolucję Growlithe, Vulpix, Eevee.',
                'db' => 'fire'
            ],
            1 => [
                'nazwa' => 'wodne',
                'nazwa2' => 'wodny',
                'opis' => 'Pozwala na ewolucję Poliwhirl, Shellder, Staryu, Eevee.',
                'db' => 'water'
            ],
            2 => [
                'nazwa' => 'roslinne',
                'nazwa2' => 'roślinny',
                'opis' => 'Pozwala na ewolucję Gloom, Weepinbell, Exeggcute.',
                'db' => 'leaf'
            ],
            3 => [
                'nazwa' => 'gromu',
                'nazwa2' => 'gromu',
                'opis' => 'Pozwala na ewolucję Pikachu, Eevee.',
                'db' => 'thunder'
            ],
            4 => [
                'nazwa' => 'ksiezycowe',
                'nazwa2' => 'ksieżycowy',
                'opis' => 'Pozwala na ewolucję Nidorina, Nidorino, Clefairy, Jigglypuff.',
                'db' => 'moon'
            ],
        ];
    }


    public function useItem(?string $item, $value, User $user, ?int $pokemon): void
    {
        if (!$this->checkValue($value)) {
            $this->session->getFlashBag()->add('error', 'Błędna ilość');
            return;
        }
        if (method_exists($this, $item.'Use')) {
            $this->{$item.'Use'}($value, $user, $pokemon);
            $this->em->flush();
        } else {
            $this->session->getFlashBag()->add('error', 'Błędna nazwa przedmiotu');
        }
    }


    private function cheri_BerryUse($value, User $user, int $pokemon): bool
    {
        if ($value === 'all') {
            $berrys = $user->getBerrys();
            if (!$berrys->getCheriBerry()) {
                $this->session->getFlashBag()->add('error', 'Nie posiadasz Cheri Berry');
                return false;
            }
            $usedBerrys = 0;
            $healAll = true;
            for ($i = 0; $i < 6; $i++) {
                $pokemon = $this->session->get('pokemon'.$i);
                if ($pokemon === null) {
                    break;
                }
                if (!($pokemon->getActualHp() < $pokemon->getHpToTable())) {
                    break;
                }
                $pokemon = $this->em->merge($pokemon);
                $thisPokemonUsedBerrys = $this->healPokemon(
                    'Cheri_Berry',
                    $pokemon,
                    $berrys->getCheriBerry(),
                    'max',
                    true
                );
                if ($pokemon->getActualHp() < $pokemon->getHpToTable()) {
                    $healAll = false;
                }
                $berrys->setCheriBerry($berrys->getCheriBerry() - $thisPokemonUsedBerrys);
                $usedBerrys += $thisPokemonUsedBerrys;
            }
            if ($usedBerrys > 0) {
                $this->auth->pokemonsToTeam($user);
                if ($healAll) {
                    $this->session->getFlashBag()
                        ->add('success', "Wyleczono Pokemony, użyto $usedBerrys Cherri Berry");
                    return true;
                }
                $this->session->getFlashBag()
                    ->add('success', "Częściowo wyleczono Pokemony, użyto $usedBerrys Cherri Berry");
                return true;
            }
            $this->session->getFlashBag()
                ->add('success', 'Pokemony nie potrzebują leczenia');

            return true;
        } else {
            $berrys = $user->getBerrys();
            if (!$berrys->getCheriBerry()) {
                $this->session->getFlashBag()->add('error', 'Nie posiadasz Cheri Berry');
                return false;
            }
            $iPokemon = $this->getPokemonFromSession($pokemon);
            if ($iPokemon === null) {
                $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
                return false;
            }
            $pokemon = $this->session->get('pokemon'.$iPokemon);
            if (!($pokemon->getActualHp() < $pokemon->getHpToTable())) {
                $this->session->getFlashBag()->add('success', 'Pokemon nie potrzebuje leczenia');
                return false;
            }
            $pokemon = $this->em->merge($pokemon);
            $usedBerrys = $this->healPokemon('Cheri_Berry', $pokemon, $berrys->getCheriBerry(), $value);
            $berrys->setCheriBerry($berrys->getCheriBerry() - $usedBerrys);
            $this->auth->pokemonsToTeam($user);
            return true;
        }
    }


    private function wiki_BerryUse($value, User $user, int $pokemon): bool
    {
        if ($value === 'all') {
            $berrys = $user->getBerrys();
            if (!$berrys->getWikiBerry()) {
                $this->session->getFlashBag()->add('error', 'Nie posiadasz Wiki Berry');
                return false;
            }
            $usedBerrys = 0;
            $healAll = true;
            for ($i = 0; $i < 6; $i++) {
                $pokemon = $this->session->get('pokemon'.$i);
                if ($pokemon === null) {
                    break;
                }
                if (!($pokemon->getActualHp() < $pokemon->getHpToTable())) {
                    break;
                }
                $pokemon = $this->em->merge($pokemon);
                $thisPokemonUsedBerrys = $this->healPokemon(
                    'Wiki_Berry',
                    $pokemon,
                    $berrys->getWikiBerry(),
                    'max',
                    true
                );
                if ($pokemon->getActualHp() < $pokemon->getHpToTable()) {
                    $healAll = false;
                }
                $berrys->setWikiBerry($berrys->getWikiBerry() - $thisPokemonUsedBerrys);
                $usedBerrys += $thisPokemonUsedBerrys;
            }
            if ($usedBerrys > 0) {
                $this->auth->pokemonsToTeam($user);
                if ($healAll) {
                    $this->session->getFlashBag()
                        ->add('success', "Wyleczono Pokemony, użyto $usedBerrys Wiki Berry");
                    return true;
                }
                $this->session->getFlashBag()
                    ->add('success', "Częściowo wyleczono Pokemony, użyto $usedBerrys Wiki Berry");
                return true;
            }
            $this->session->getFlashBag()
                ->add('success', 'Pokemony nie potrzebują leczenia');

            return true;
        } else {
            $berrys = $user->getBerrys();
            if (!$berrys->getWikiBerry()) {
                $this->session->getFlashBag()->add('error', 'Nie posiadasz Wiki Berry');
                return false;
            }
            $iPokemon = $this->getPokemonFromSession($pokemon);
            if ($iPokemon === null) {
                $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
                return false;
            }
            $pokemon = $this->session->get('pokemon'.$iPokemon);
            if (!($pokemon->getActualHp() < $pokemon->getHpToTable())) {
                $this->session->getFlashBag()->add('success', 'Pokemon nie potrzebuje leczenia');
                return false;
            }
            $pokemon = $this->em->merge($pokemon);
            $usedBerrys = $this->healPokemon('Wiki_Berry', $pokemon, $berrys->getWikiBerry(), $value);
            $this->auth->pokemonsToTeam($user);
            $berrys->setWikiBerry($berrys->getWikiBerry() - $usedBerrys);
            return true;
        }
    }


    private function mago_BerryUse($value, User $user): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getMagoBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Mago Berry');
            return false;
        }
        $usedBerrys = $this->addPaBerry($value, $user, 'Mago_Berry', $berrys->getMagoBerry());
        $berrys->setMagoBerry($berrys->getMagoBerry() - $usedBerrys);
        return true;
    }


    private function chesto_BerryUse($value, User $user): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getChestoBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Chesto Berry');
            return false;
        }
        $usedBerrys = $this->addPaBerry($value, $user, 'Chesto_Berry', $berrys->getChestoBerry());
        $berrys->setChestoBerry($berrys->getChestoBerry() - $usedBerrys);
        return true;
    }

    /**
     * @param int|string $value
     * @param User       $user
     * @param string     $berry
     * @param int        $valueOfBerry
     *
     * @return null|int
     */
    private function addPaBerry($value, User $user, string $berry, int $valueOfBerry): ?int
    {
        $berryAddPa = $berry === 'Chesto_Berry' ? 20 : 40;
        $howMany = floor(($user->getMpa() - $user->getPa()) / $berryAddPa);

        if (!$howMany) {
            $this->session->getFlashBag()->add('success', 'Nie potrzebujesz '. str_replace('_', ' ', $berry));
            return null;
        }
        if ($value === 'max' || $value > $howMany) {
            $value = $howMany;
        }
        if ($value > $valueOfBerry) {
            $value = $valueOfBerry;
        }
        $user->setPa($user->getPa() + $value * $berryAddPa);

        $this->session->getFlashBag()->add('success', 'Zjedzono ' . $value . ' ' .
            str_replace('_', ' ', $berry) . '.<br />Przywrócono ' . ($value * $berryAddPa) . ' PA.');

        return $value;
    }

    private function pecha_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getPechaBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Pecha Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $pokemon = $this->em->merge($this->session->get('pokemon'.$iPokemon));
        $usedBerrys = $this->addExpBerry('Pecha_Berry', $pokemon, $berrys->getPechaBerry(), $value);
        $berrys->setPechaBerry($berrys->getPechaBerry() - $usedBerrys);
        $this->auth->pokemonsToTeam($user);
        return true;
    }


    private function aguav_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getAguavBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Aguqv Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $pokemon = $this->em->merge($this->session->get('pokemon'.$iPokemon));
        $usedBerrys = $this->addExpBerry('Aguav_Berry', $pokemon, $berrys->getAguavBerry(), $value);
        $berrys->setAguavBerry($berrys->getAguavBerry() - $usedBerrys);
        $this->auth->pokemonsToTeam($user);
        return true;
    }


    private function addExpBerry(string $berry, Pokemon $pokemon, int $valueOfBerry, $value): int
    {
        if ($value === 'max') {
            $value = $valueOfBerry;
        }
        if ($value > $valueOfBerry) {
            $value = $valueOfBerry;
        }
        $addExp = ($berry === 'Pecha_Berry') ? 3 : 5;
        $pokemon->setExp($pokemon->getExp() + $addExp * $value);
        $this->session->getFlashBag()->add('success', 'Pokemon zjada '.$value. ' ' . str_replace('_', ' ', $berry).
            ' i otrzymuje ' . ($addExp * $value) . ' punktów doświadczenia');
        return $value;
    }

    private function rawst_BerryUse($value, User $user): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getRawstBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Rawst Berry');
            return false;
        }
        $usedBerrys = $this->addExpUser($value, $user, 'Rawst_Berry', $berrys->getRawstBerry());
        $berrys->setRawstBerry($berrys->getRawstBerry() - $usedBerrys);
        return true;
    }

    private function lapapa_BerryUse($value, User $user): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getLapapaBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Lapapa Berry');
            return false;
        }
        $usedBerrys = $this->addExpUser($value, $user, 'Lapapa_Berry', $berrys->getLapapaBerry());
        $berrys->setLapapaBerry($berrys->getLapapaBerry() - $usedBerrys);
        return true;
    }


    private function addExpUser($value, User $user, string $berry, int $valueOfBerry): int
    {
        if ($value === 'max') {
            $value = $valueOfBerry;
        }
        if ($value > $valueOfBerry) {
            $value = $valueOfBerry;
        }
        $addExp = ($berry === 'Rawst_Berry') ? 1 : 2;
        $user->setExperience($user->getExperience() + $addExp * $value);
        $this->session->getFlashBag()->add('success', 'Zjedzono ' . $value . ' ' . str_replace('_', ' ', $berry) .
            ', dodano '. ($addExp * $value) . ' doświadczenia trenera.');
        return $value;
    }

    private function aspear_BerryUse($value, User $user): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getAspearBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Aspear Berry');
            return false;
        }
        $usedBerrys = $this->addMpaUser($value, $user, 'Aspear_Berry', $berrys->getAspearBerry());
        $berrys->setAspearBerry($berrys->getAspearBerry() - $usedBerrys);
        return true;
    }

    private function razz_BerryUse($value, User $user): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getRazzBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Razz Berry');
            return false;
        }
        $usedBerrys = $this->addMpaUser($value, $user, 'Razz_Berry', $berrys->getRazzBerry());
        $berrys->setRazzBerry($berrys->getRazzBerry() - $usedBerrys);
        return true;
    }

    private function addMpaUser($value, User $user, string $berry, int $valueOfBerry): int
    {
        if ($value === 'max') {
            $value = $valueOfBerry;
        }
        if ($value > $valueOfBerry) {
            $value = $valueOfBerry;
        }
        if ($user->getBerryPa() >= 3000) {
            $this->session->getFlashBag()->add('error', 'Nie możesz zjeść więcej ' . str_replace('_', ' ', $berry));
            return 0;
        }
        $valuePerBerry = ($berry === 'Aspear_Berry') ? 1 : 2;
        $before = floor($user->getBerryPa() / 15);
        $after = floor(($user->getBerryPa() + $valuePerBerry * $value) / 15);
        if ($after > 200) {
            $after = 200;
            $value = 3000 - $user->getBerryPa();
        }
        $this->session->getFlashBag()->add('success', 'Zjedzono ' . $value . ' ' .str_replace('_', ' ', $berry));
        if ($after > $before) {
            $this->session->getFlashBag()->add('success', 'Twoje MPA wzrosło o ' . ($after - $before));
            $user->setMpa($user->getMpa() + ($after - $before));
        }
        $user->setBerryPa($user->getBerryPa() + ($valuePerBerry * $value));
        return $value;
    }

    private function leppa_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getLeppaBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Leppa Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $usedBerrys = $this->pokemonAddStats($value, 'Attack', 'ataku', $pokemon, $berrys->getLeppaBerry(), 'Leppa Berry');
        $berrys->setLeppaBerry($berrys->getLeppaBerry() - $usedBerrys);
        return true;
    }

    private function oran_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getOranBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Oran Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $usedBerrys = $this->pokemonAddStats($value, 'SpAttack', 'specjalnego ataku', $pokemon, $berrys->getOranBerry(), 'Oran Berry');
        $berrys->setOranBerry($berrys->getOranBerry() - $usedBerrys);
        return true;
    }

    private function persim_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getPersimBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Persim Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $usedBerrys = $this->pokemonAddStats($value, 'Defence', 'obrony', $pokemon, $berrys->getPersimBerry(), 'Persim Berry');
        $berrys->setPersimBerry($berrys->getPersimBerry() - $usedBerrys);
        return true;
    }

    private function lum_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getLumBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Lum Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $usedBerrys = $this->pokemonAddStats($value, 'SpDefence', 'specjalnej obrony', $pokemon, $berrys->getLumBerry(), 'Lum Berry');
        $berrys->setLumBerry($berrys->getLumBerry() - $usedBerrys);
        return true;
    }

    private function sitrus_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getSitrusBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Sitrus Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $usedBerrys = $this->pokemonAddStats($value, 'Speed', 'szybkości', $pokemon, $berrys->getSitrusBerry(), 'Sitrus Berry');
        $berrys->setSitrusBerry($berrys->getSitrusBerry() - $usedBerrys);
        return true;
    }

    private function Figy_BerryUse($value, User $user, int $pokemon): bool
    {
        $berrys = $user->getBerrys();
        if (!$berrys->getFigyBerry()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Figy Berry');
            return false;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return false;
        }
        $usedBerrys = $this->pokemonAddHp($value, $pokemon, $berrys->getFigyBerry());
        $berrys->setFigyBerry($berrys->getFigyBerry() - $usedBerrys);
        if ($usedBerrys) {
            $this->auth->pokemonsToTeam($user);
        }
        return true;
    }

    private function pokemonAddHp($value, int $pokemon, int $valueOfBerry): int
    {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')->find($pokemon);
        $training = $pokemon->getTraining();
        if (!$this->checkLimitHp($pokemon)) {
            $this->session->getFlashBag()->add('error', 'Pokemon nie może zjeść więcej Figy Berry');
            return 0;
        }
        if ($value === 'max') {
            $value = $valueOfBerry;
        }
        if ($value > $valueOfBerry) {
            $value = $valueOfBerry;
        }

        if ($pokemon->getBerrysHp() + $value > $training->getBerryLimit()) {
            $value = $training->getBerryLimit() - $pokemon->getBerrysHp();
        }

        $pokemon->setBerrysHp($pokemon->getBerrysHp() + $value);
        $this->em->persist($pokemon);
        $this->session->getFlashBag()->add('success', 'Pokemon zjada ' . $value . ' Figy Berry');
        $this->session->getFlashBag()->add('success', 'Życie Pokemona wzrasta o ' . $value);
        return $value;
    }

    private function pokemonAddStats(
        $value,
        string $stat,
        string $statName,
        int $pokemon,
        int $valueOfBerry,
        string $berry
    ): int {
        $pokemon = $this->em->getRepository('AppBundle:Pokemon')->find($pokemon);
        $training = $pokemon->getTraining();
        if (!$this->pokemonCheckBerryLimit($training, $stat)) {
            $this->session->getFlashBag()->add('error', 'Pokemon nie może zjeść więcej '.str_replace('_', ' ', $berry));
            return 0;
        }
        if ($value === 'max') {
            $value = $valueOfBerry;
        }
        if ($value > $valueOfBerry) {
            $value = $valueOfBerry;
        }

        $before = floor($training->{'getBerry'.$stat}() / 5);
        $after = floor(($training->{'getBerry'.$stat}() + $value) / 5);


        if ($after > ($training->getBerryLimit() / 5)) {
            $after = $training->getBerryLimit() / 5;
            $value = $training->getBerryLimit() - $training->{'getBerry'.$stat}();
        }

        $training->{'setBerry'.$stat}($training->{'getBerry'.$stat}() + $value);
        $this->em->persist($training);
        $pokemon->setTraining($training);
        $this->em->persist($pokemon);
        $this->session->getFlashBag()->add('success', 'Pokemon zjada ' . $value . ' ' . $berry . '.');
        if ($after > $before) {
            $this->session->getFlashBag()->add('success', 'Statystyka ' . $statName . ' wzrasta o ' . ($after - $before));
        }
        return $value;
    }
    
    private function lemonadeUse($value, User $user): void
    {
        if ($user->getPa() > 10 && !$this->request->getCurrentRequest()->query->get('confirm')) {
            $this->session->getFlashBag()->add(
                'info',
                'Czy napewno chcesz wypić lemoniadę? Po jej spożyciu ilość PA przekroczy Twoją maksymalną ilość, 
więc część zostanie zmarnowana!<br />
<button class="btn btn-primary confirmDrink" data-add="?item=lemonade&confirm=1">Wypij mimo to</button>'
            );
        } else {
            $items = $user->getItems();
            if ($items->getLemonade()) {
                $items->setLemonade($items->getLemonade() - 1);
                $user->setPa($user->getMpa());
                $this->session->getFlashBag()->add(
                    'success',
                    'Przywrócono ' . $user->getMpa() . ' PA'
                );
            } else {
                $this->session->getFlashBag()->add('error', 'Nie posiadasz lemoniady');
            }
        }
    }

    private function waterUse($value, User $user): void
    {
        if ($value > 4) {
            $value = 4;
        }
        $items = $user->getItems();

        if ($items->getWater() < $value) {
            $value = $items->getWater();
        }

        if (!$value) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz wody.');
            return;
        }

        $restorePercent = $value * 0.25;
        $restoredPa = round($restorePercent * $user->getMpa());

        if (($user->getPa() + $restoredPa) > ($user->getMpa() + 9) &&
            !$this->request->getCurrentRequest()->query->get('confirm')
        ) {
            $this->session->getFlashBag()->add(
                'info',
                'Czy napewno chcesz wypić wodę? Po jej spożyciu ilość PA przekroczy Twoją maksymalną ilość, 
                więc część zostanie zmarnowana!
            <br /><button class="btn btn-primary confirmDrink" 
            data-add="?item=water&value=' . $value . '&confirm=1">Wypij mimo to</button>'
            );
        } else {
            $items->setWater($items->getWater() - $value);
            $user->setPa($user->getPa() + $restoredPa);

            $this->session->getFlashBag()->add(
                'success',
                'Wypito ' . $value . ' wod' . (($value === 1) ? 'ę' : 'y') . '. 
                Przywrócono ' . $restoredPa . ' PA.'
            );
        }
    }

    private function sodaUse($value, User $user): void
    {
        if ($value > 2) {
            $value = 2;
        }
        $items = $user->getItems();

        if ($items->getSoda() < $value) {
            $value = $items->getSoda();
        }

        if (!$value) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz sody.');
            return;
        }

        $restorePercent = $value * 0.5;
        $restoredPa = round($restorePercent * $user->getMpa());

        if (($user->getPa() + $restoredPa) > ($user->getMpa() + 9) &&
            !$this->request->getCurrentRequest()->query->get('confirm')
        ) {
            $this->session->getFlashBag()->add(
                'info',
                'Czy napewno chcesz wypić sodę? Po jej spożyciu ilość PA przekroczy Twoją maksymalną ilość, 
więc część zostanie zmarnowana!
            <br /><button class="btn btn-primary confirmDrink" 
            data-add="?item=soda&value=' . $value . '&confirm=1">Wypij mimo to</button>'
            );
        } else {
            $items->setSoda($items->getSoda() - $value);
            $user->setPa($user->getPa() + $restoredPa);

            $this->session->getFlashBag()->add(
                'success',
                'Wypito ' . $value . ' sod' . (($value === 1) ? 'ę' : 'y') .
                '. Przywrócono ' . $restoredPa . ' PA.'
            );
        }
    }


    private function foodUse($value, User $user, int $pokemonId): void
    {
        if ($value != 'all') {
            if ($value > 4) {
                $value = 4;
            }
        }
        $items = $user->getItems();

        if ($value === 'all' && $pokemonId === 0) {
            $usedFood = 0;
            $fedAll = 1;
            $hungry = 0;
            $flash = '';
            $fedPokemons = 0;
            $arrayOfPokemons = [];


            for ($i = 0; $i < 6; $i++) {
                if ($this->session->get('pokemon'.$i)) {
                    if ($this->session->get('pokemon'.$i)->getHunger() > 100) {
                        $this->session->get('pokemon'.$i)->setHunger(100);
                    }

                    $quantity = ceil($this->session->get('pokemon'.$i)->getHunger() / 25);

                    if ($quantity > $items->getPokemonFood()) {
                        $quantity = $items->getPokemonFood();
                        $fedAll = 0;
                    }

                    if ($quantity) {
                        $newHunger = $this->session->get('pokemon'.$i)->getHunger() - $quantity * 25;
                        if ($newHunger < 0) {
                            $newHunger = 0;
                        }
                        $this->session->get('pokemon'.$i)->setHunger($newHunger);

                        $usedFood += $quantity;
                        $items->setPokemonFood($items->getPokemonFood() - $quantity);

                        $flash .= $this->session->get('pokemon'.$i)->getName() . ' zjada ' . $quantity;
                        $flash .= ($quantity === 1) ? ' pudełko.' : ' pudełka';
                        $flash .= '<br />';

                        $fedPokemons++;

                        $arrayOfPokemons[] = [
                            'id' => $this->session->get('pokemon'.$i)->getId(),
                            'hunger' => $newHunger
                        ];
                    }
                }
            }

            if ($fedPokemons) {
                $this->em->getRepository('AppBundle:Pokemon')->feedPokemons($arrayOfPokemons);
                $flash .= '<br />Użyto ' . $usedFood . ' pudełek karmy.';
                if (!$fedAll) {
                    $flash .= '<br />Nie wszystkie Pokemony się najadły.';
                }
                $this->session->getFlashBag()->add('success', $flash);
            } else {
                $this->session->getFlashBag()->add('success', 'Żaden Pokemon nie jest głodny.');
            }
        } else {
            if ($value === 'all') {
                $value = 4;
            }
            if ($value > $items->getPokemonFood()) {
                $value = $items->getPokemonFood();
            }
            $j = -1;
            for ($i = 0; $i < 6; $i++) {
                if ($this->session->get('pokemon'.$i) && $this->session->get('pokemon'.$i)->getId() === $pokemonId) {
                    $j = $i;
                    break;
                }
            }
            if ($j < 0) {
                $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
                return;
            }
            $minus = $value * 25;
            $pokemonHunger = $this->session->get('pokemon'.$j)->getHunger();
            if (!$pokemonHunger) {
                $this->session->getFlashBag()->add('success', 'Pokemon nie jest głodny');
                return;
            }

            if ($pokemonHunger > 100) {
                $pokemonHunger = 100;
            }

            if ($pokemonHunger < $minus) {
                $value = ceil($pokemonHunger / 25);
                $minus = 0;
            } else {
                $minus = $pokemonHunger - $minus;
            }

            $this->session->get('pokemon'.$j)->setHunger($minus);

            $this->em->getRepository('AppBundle:Pokemon')->feedPokemon($pokemonId, $minus);

            $items->setPokemonFood($items->getPokemonFood() - $value);
            $this->session->getFlashBag()->add(
                'success',
                $this->session->get('pokemon'.$j)->getName() . ' zajada się ' . $value . ' pudełkami karmy.'
            );
        }
    }


    private function barUse($value, User $user, int $pokemonId): void
    {
        $items = $user->getItems();
        $pokemon = $this->getOneUsersPokemon($pokemonId, $user->getId());
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return;
        }

        if (!$this->checkPokemonsSnacks($pokemon)) {
            $this->session->getFlashBag()->add('error', 'Pokemon nie może zjeść więcej przekąsek dzisiaj');
            return;
        }

        if (!$items->getBar()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz batonów');
            return;
        }
        if ($items->getBar() < $value) {
            $value = $items->getBar();
        }

        $value = $this->checkValueSnacks($value, $pokemon->getSnacks());

        $addAttachment = $value * 2;

        $items->setBar($items->getBar() - $value);
        $this->session->getFlashBag()->add('success', 'Pokemon zjadł '.$value.' batonów');
        $this->pokemonEatSnack($pokemon, $addAttachment, $value, $user);
    }


    private function cookieUse($value, User $user, int $pokemonId): void
    {
        $items = $user->getItems();
        $pokemon = $this->getOneUsersPokemon($pokemonId, $user->getId());
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return;
        }

        if (!$this->checkPokemonsSnacks($pokemon)) {
            $this->session->getFlashBag()->add('error', 'Pokemon nie może zjeść więcej przekąsek dzisiaj');
            return;
        }

        if (!$items->getCookie()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz ciastek');
            return;
        }
        if ($items->getCookie() < $value) {
            $value = $items->getCookie();
        }

        $value = $this->checkValueSnacks($value, $pokemon->getSnacks());
        $addAttachment = $value * 5;

        $items->setCookie($items->getCookie() - $value);
        $this->session->getFlashBag()->add('success', 'Pokemon zjadł '.$value.' ciastek');
        $this->pokemonEatSnack($pokemon, $addAttachment, $value, $user);
    }

    /**
     * @param int|string $value
     *
     * @return bool
     */
    private function checkValue($value): bool
    {
        if ($value === 'all' || $value === 'max') {
            return 1;
        }
        return (is_numeric($value) && $value > 0);
    }

    private function getOneUsersPokemon(int $pokemonId, int $userId): ?Pokemon
    {
        return $this->em->getRepository('AppBundle:Pokemon')->findOneBy([
            'id' => $pokemonId,
            'owner' => $userId
        ]);
    }

    private function checkPokemonsSnacks(Pokemon $pokemon): int
    {
        $pokemonCandies = $pokemon->getSnacks();
        return $pokemonCandies >= 21 ? 0 : 1;
    }

    private function checkValueSnacks(int $value, int $pokemonCandies): int
    {
        if ($value > 21) {
            $value = 21;
        }
        if ($value + $pokemonCandies > 21) {
            $value = 21 - $pokemonCandies;
        }
        return $value;
    }

    private function pokemonEatSnack(Pokemon $pokemon, int $addAttachment, int $value, User $user): void
    {
        $pokemon->setAttachment($pokemon->getAttachment() + $addAttachment);
        $pokemon->setSnacks($pokemon->getSnacks() + $value);
        $this->addSnacksToAchievements($value, $user);
    }

    private function addSnacksToAchievements(int $value, User $user): void
    {
        $achievements = $user->getAchievements();
        $achievements->setSnacks($achievements->getSnacks() + $value);
    }

    private function getPokemonFromSession(int $pokemon): ?int
    {
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i) && $this->session->get('pokemon'.$i)->getId() === $pokemon) {
                return $i;
            }
        }
        return null;
    }

    /**
     * @param string     $berry
     * @param Pokemon    $pokemon
     * @param int        $valueOfBerry
     * @param int|string $limit
     * @param bool       $allFlashAsOne
     *
     * @return int
     */
    private function healPokemon(
        string $berry,
        Pokemon $pokemon,
        int $valueOfBerry,
        $limit,
        bool $allFlashAsOne = false
    ): int {
        $berryHealHp = ($berry === 'Cheri_Berry') ? 15 : 30;
        $howMany = ceil((round($pokemon->getHpToTable()) - $pokemon->getActualHp()) / $berryHealHp);
        if ($limit === 'max' || $limit > $howMany) {
            $limit = $howMany;
        }
        if ($limit > $valueOfBerry) {
            $limit = $valueOfBerry;
        }
        $hp = $pokemon->getActualHp() + $limit * $berryHealHp;
        $pokemon->setActualHp($hp);
        if ($pokemon->getActualHp() > $pokemon->getHpToTable()) {
            $pokemon->setActualHp($pokemon->getHpToTable());
        }
        if (!$allFlashAsOne) {
            $cheriDescription = ($berry === 'Cheri_Berry') ? ' Cheri Berry' : ' Wiki Berry';
            $this->session->getFlashBag()->add('success', 'Pokemon uleczony! Użyto ' . $limit . $cheriDescription);
        }
        return $limit;
    }

    private function pokemonCheckBerryLimit(PokemonTraining $training, string $stat): int
    {
        $limit = $training->getBerryLimit();
        $remainingLimit = $training->{'getBerry'.$stat}();
        return $limit - $remainingLimit;
    }

    private function checkLimitHp(Pokemon $pokemon): int
    {
        $limit = $pokemon->getTraining()->getBerryLimit();
        $remainingLimit = $pokemon->getBerrysHp();
        return $limit - $remainingLimit;
    }

    private function ognisteUse($value, User $user, int $pokemon): void
    {
        $stones = $user->getStones();
        if (!$stones->getFireStone()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz kamienia ognistego');
            return;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return;
        }
        $pokemon = $this->session->get('pokemon'.$iPokemon);
        if (!$this->stoneUseOnPokemon($pokemon, 'FireStone', $user)) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może być ewoluowany za pomocą kamienia ognistego');
            return;
        }
        $stones->setFireStone($stones->getFireStone() - 1);
    }

    private function wodneUse($value, User $user, int $pokemon): void
    {
        $stones = $user->getStones();
        if (!$stones->getWaterStone()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz kamienia wodnego');
            return;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return;
        }
        $pokemon = $this->session->get('pokemon'.$iPokemon);
        if (!$this->stoneUseOnPokemon($pokemon, 'WaterStone', $user)) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może być ewoluowany za pomocą kamienia wodnego');
            return;
        }
        $stones->setWaterStone($stones->getWaterStone() - 1);
    }

    private function roslinneUse($value, User $user, int $pokemon): void
    {
        $stones = $user->getStones();
        if (!$stones->getLeafStone()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz kamienia roślinnego');
            return;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return;
        }
        $pokemon = $this->session->get('pokemon'.$iPokemon);
        if (!$this->stoneUseOnPokemon($pokemon, 'LeafStone', $user)) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może być ewoluowany za pomocą kamienia roślinnego');
            return;
        }
        $stones->setLeafStone($stones->getLeafStone() - 1);
    }

    private function gromuUse($value, User $user, int $pokemon): void
    {
        $stones = $user->getStones();
        if (!$stones->getThunderStone()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz kamienia gromu');
            return;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return;
        }
        $pokemon = $this->session->get('pokemon'.$iPokemon);
        if (!$this->stoneUseOnPokemon($pokemon, 'ThunderStone', $user)) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może być ewoluowany za pomocą kamienia gromu');
            return;
        }
        $stones->setThunderStone($stones->getThunderStone() - 1);
    }

    private function ksiezycoweUse($value, User $user, int $pokemon): void
    {
        $stones = $user->getStones();
        if (!$stones->getMoonStone()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz kamienia księżycowego');
            return;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return;
        }
        $pokemon = $this->session->get('pokemon'.$iPokemon);
        if (!$this->stoneUseOnPokemon($pokemon, 'MoonStone', $user)) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może być ewoluowany za pomocą kamienia księżycowego');
            return;
        }
        $stones->setMoonStone($stones->getMoonStone() - 1);
    }

    private function stoneUseOnPokemon(Pokemon $pokemon, string $stoneName, User $user): bool
    {
        $info = $pokemon->getInfo();
        $id = 0;
        switch ($stoneName) {
            case 'FireStone':
                if ($info['wymagania'] === 1) {
                    $id = $info['ewolucja_p'];
                } elseif ($info['wymagania'] === 123) {
                    $id = 136; //eevee
                }
                break;
            case 'WaterStone':
                if ($info['wymagania'] === 2) {
                    $id = $info['ewolucja_p'];
                    if ($id === 62000186) {
                        $id = 62;
                    }
                } elseif ($info['wymagania'] === 123) {
                    $id = 134;
                }
                break;
            case 'ThunderStone':
                if ($info['wymagania'] === 3) {
                    $id = $info['ewolucja_p'];
                } elseif ($info['wymagania'] === 123) {
                    $id = 135;
                }
                break;
            case 'LeafStone':
                if ($info['wymagania'] === 4) {
                    $id = $info['ewolucja_p'];
                    if ($id === 45000182) {
                        $id = 45;
                    }
                }
                break;
            case 'MoonStone':
                if ($info['wymagania'] === 5) {
                    $id = $info['ewolucja_p'];
                }
                break;
        }
        if (!$id) {
            return false;
        }
        $this->pokemonEvolve($pokemon, $user, $info, $id);
        return true;
    }

    private function pokemonEvolve(Pokemon $pokemon, User $user, array $info, int $id): void
    {
        /** @var Pokemon $pokemon */
        $pokemon = $this->em->merge($pokemon);
        $newPokemon = $this->pokemonHelper->getInfo($id);
        if ($pokemon->getName() === $info['nazwa']) {
            $nameChanged = 0;
        } else {
            $nameChanged = 1;
        }
        $increase = $this->pokemonHelper->getIncrease($id);
        $multiplier = 4;
        $attack = $increase['atak'] * $multiplier;
        $spAttack = $increase['sp_atak'] * $multiplier;
        $defence = $increase['obrona'] * $multiplier;
        $spDefence = $increase['sp_obrona'] * $multiplier;
        $speed = $increase['szybkosc'] * $multiplier;
        $hp = $increase['hp'] * $multiplier;

        $this->collection->addOneToPokemonCatchAndMet($id, $user);

        $title = 'Twój Pokemon ' . $pokemon->getName() . ' ewoluował w ' . $newPokemon['nazwa'] . '.';
        $this->session->getFlashBag()->add('success', $title);
        $genderText = ($pokemon->getGender() === 1) ? 'Jej' : 'Jego';
        $report = '<div class="row nomargin text-center"><div class="col-xs-12">Twój Pokemon <span class="pogrubienie">' . $pokemon->getName() . '</span> ewoluował w <span class="pogrubienie">' . $newPokemon['nazwa'] . '</span>.</div>'
            . '<div class="col-xs-12 pogrubienie">' . $genderText .' statystyki rosną:</div><div class="col-xs-12"><div class="row nomargin">'
            . '<div class="col-xs-4">Atak +' . $attack . '</div><div class="col-xs-4">Sp. Atak +' . $spAttack . '</div><div class="col-xs-4">Obrona +' . $defence . '</div></div></div> '
            . '<div class="col-xs-12"><div class="row nomargin">'
            . '<div class="col-xs-4">Sp.Obrona +' . $spDefence . '</div><div class="col-xs-4">Szybkość +' . $speed . '</div><div class="col-xs-4">HP +' . $hp . '</div></div></div></div>';
        $this->addReport($title, $report, $user);

        $pokemon->setAttack($pokemon->getAttack() + $attack);
        $pokemon->setSpAttack($pokemon->getSpAttack() + $spAttack);
        $pokemon->setDefence($pokemon->getDefence() + $defence);
        $pokemon->setSpDefence($pokemon->getSpDefence() + $spDefence);
        $pokemon->setSpeed($pokemon->getSpeed() + $speed);
        $pokemon->setHp($pokemon->getHp() + $hp);
        $pokemon->setActualHp($pokemon->getHpToTable());
        $pokemon->setIdPokemon($id);
        if (!$nameChanged) {
            $pokemon->setName($newPokemon['nazwa']);
        }
        $this->auth->pokemonsToTeam($user);
    }

    private function addReport(string $title, string $content, User $user): void
    {
        $report = new Report();
        $report->setTitle($title);
        $report->setContent($content);
        $report->setIsRead(0);
        $report->setTime(new \DateTime());
        $report->setUser($user);
        $this->em->persist($report);
    }

    private function candyUse($value, User $user, int $pokemon): void
    {
        $items = $user->getItems();
        if (!$items->getCandy()) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz Rare Candy');
            return;
        }
        $iPokemon = $this->getPokemonFromSession($pokemon);
        if ($iPokemon === null) {
            $this->session->getFlashBag()->add('error', 'Nie znaleziono Pokemona');
            return;
        }
        /** @var Pokemon $pokemon */
        $pokemon = $this->session->get('pokemon'.$iPokemon);
        if ($pokemon->getLevel() === 100) {
            $this->session->getFlashBag()->add('error', 'Pokemon osiągnął już maksymalny poziom');
            return;
        }
        $pokemon = $this->em->merge($pokemon);
        $pokemon->setExp($pokemon->getExpOnLevel());
        $items->setCandy($items->getCandy() - 1);
        $this->session->getFlashBag()->add('success', 'Pokemon awansuje na ' .
            ($pokemon->getLevel() + 1) . ' poziom.');
        $this->em->persist($pokemon);
        $this->session->set('pokemon'.$iPokemon, $pokemon);
    }
}
