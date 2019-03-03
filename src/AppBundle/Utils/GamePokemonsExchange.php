<?php
namespace AppBundle\Utils;

use AppBundle\Entity\ExchangePokemon;
use AppBundle\Entity\Pokemon;
use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GamePokemonsExchange
{
    /**
     * @var int
     */
    private $pokemonI;
    /**
     * @var array
     */
    private $pokemonIdsToExchange = [64, 75, 67, 93];
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var PokemonHelper
     */
    private $helper;
    /**
     * @var GamePack
     */
    private $pack;
    /**
     * @var GamePokemons
     */
    private $gamePokemons;
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(
        EntityManagerInterface $em,
        Session $session,
        PokemonHelper $helper,
        GamePack $pack,
        GamePokemons $gamePokemons,
        Collection $collection
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->helper = $helper;
        $this->pack = $pack;
        $this->gamePokemons = $gamePokemons;
        $this->collection = $collection;
    }

    public function toExchange(): array
    {
        return $this->checkPokemonsToExchange();
    }

    public function inExchange(int $userId): ?array
    {
        return $this->getPokemonsInExchange($userId);
    }

    public function action(User $user, ?int $id, ?string $mode): void
    {
        if (in_array($mode, ['add', 'get'])) {
            $this->{$mode.'toExchange'}($user, $id);
        } else {
            $this->session->getFlashBag()->add('error', 'Błędna akcja');
        }
    }

    private function getToExchange(User $user, ?int $id): void
    {
        $exchange = $this->em->getRepository('AppBundle:ExchangePokemon')->findOneBy(['owner' => $user->getId(), 'id' => $id]);

        if (!$exchange) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return;
        }

        if (time() < $exchange->getTime()) {
            $this->session->getFlashBag()->add('error', 'Ten Pokemon nie może być jeszcze odebrany');
            return;
        }

        $this->evolvePokemonByExchange($user, $exchange);

        $this->em->flush();
    }

    private function addToExchange(User $user, ?int $id): void
    {
        if (!$this->checkId($id)) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return;
        }
        if ($this->gamePokemons->getNumberOfPokemonsInTeam() < 2) {
            $this->session->getFlashBag()->add('error', 'Aby ewoluować Pokemona przez wymianę musisz posiadać w drużynie co najmniej 2 Pokemony');
            return;
        }
        /** @var Pokemon $pokemon */
        $pokemon = $this->em->merge($this->choosePokemon($id));

        if (!$this->checkItems($user, $pokemon->getIdPokemon())) {
            $this->session->getFlashBag()->add('error', 'Brak przedmiotów do ewolucji Pokemona');
            return;
        }
        $pokemon->setExchange(1);

        $exchange = new ExchangePokemon();
        $exchange->setPokemonId($pokemon->getIdPokemon());
        $exchange->setOwner($user->getId());
        $exchange->setTime(time() + 3600);
        $exchange->setName($pokemon->getName());
        $exchange->setIdInDb($pokemon->getId());

        $this->gamePokemons->sendPokemonFromTeamToReserve($this->pokemonI, $user);


        $this->em->persist($exchange);
        $this->em->flush();

        $this->session->getFlashBag()->clear();
        $this->session->getFlashBag()->add('success', 'Oddano Pokemona do wymiany. Potrwa to godzinę');
    }

    private function checkPokemonsToExchange(): array
    {
        $pokemons = [];

        for ($i = 0; $i < 6; $i++) {
            if ($pokemon = $this->session->get('pokemon'.$i)) {
                if (in_array($pokemon->getIdPokemon(), $this->pokemonIdsToExchange)) {
                    switch ($pokemon->getIdPokemon()) {
                        case 64:
                            $evoLevel = 17;
                            $item = 'Kamień filozoficzny';
                            $itemEn = 'philosophicalStone';
                            break;
                        case 67:
                            $evoLevel = 29;
                            $item = 'Czarny pas';
                            $itemEn = 'belt';
                            break;
                        case 75:
                            $evoLevel = 26;
                            $item = 'Obsydian';
                            $itemEn = 'obsydian';
                            break;
                        case 93:
                            $evoLevel = 26;
                            $item = 'Ektoplazma';
                            $itemEn = 'ectoplasm';
                            break;
                    }
                    $pokemons[] = [
                        'pokemon' => $pokemon,
                        'item' => $item,
                        'evoLevel' => $evoLevel,
                        'itemEn' => $itemEn
                    ];
                }
            }
        }

        return $pokemons;
    }

    private function getPokemonsInExchange(int $userId): array
    {
        return $this->em->getRepository('AppBundle:ExchangePokemon')->findBy(['owner' => $userId]);
    }

    private function checkId(?int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        if (empty($this->checkPokemonsToExchange())) {
            return false;
        }
        return true;
    }

    private function choosePokemon(int $id): Pokemon
    {
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i) &&
                $this->session->get('pokemon'.$i)->getId() === $id
            ) {
                $this->pokemonI = $i;
                return $this->session->get('pokemon'.$i);
            }
        }
    }

    private function checkItems(User $user, int $id): bool
    {
        $items = $this->pack->getStones($user->getId());
        if (!$items->getRunes()) {
            return false;
        }
        switch ($id) {
            case 64:
                $quantity = $items->getPhilosophicalStone();
                $item = 'PhilosophicalStone';
                break;
            case 67:
                $quantity = $items->getBelt();
                $item = 'Belt';
                break;
            case 75:
                $quantity = $items->getObsydian();
                $item = 'Obsydian';
                break;
            case 93:
                $quantity = $items->getEctoplasm();
                $item = 'Ectoplasm';
                break;
        }
        if (!$quantity) {
            return false;
        }
        $items->setRunes($items->getRunes() - 1);
        $items->{'set'.$item}($items->{'get'.$item}() - 1);
        $this->em->persist($items);
        return true;
    }

    private function evolvePokemonByExchange(User $user, ExchangePokemon $exchange): void
    {
        switch ($exchange->getPokemonId()) {
            case 64:
                $id = 65;
                break;
            case 75:
                $id = 76;
                break;
            case 67:
                $id = 68;
                break;
            case 93:
                $id = 94;
                break;
        }
        $increases = $this->helper->getIncrease($id);
        $increases = array_map(
            function ($n) {
                return $n *= 3;
            },
            $increases
        );

        $pokemon = $this->em->getRepository('AppBundle:Pokemon')->findOneBy(['owner' => $user->getId(), 'id' => $exchange->getIdInDb()]);

        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Wystąpił nieoczekiwany błąd');
            return;
        }

        $pokemon->setAttack($pokemon->getAttack() + $increases['atak']);
        $pokemon->setSpAttack($pokemon->getSpAttack() + $increases['sp_atak']);
        $pokemon->setDefence($pokemon->getDefence() + $increases['obrona']);
        $pokemon->setSpDefence($pokemon->getSpDefence() + $increases['sp_obrona']);
        $pokemon->setSpeed($pokemon->getSpeed() + $increases['szybkosc']);
        $pokemon->setHp($pokemon->getHp() + $increases['hp']);
        $pokemon->setActualHp($pokemon->getHpToTable());
        $pokemon->setExchange(0);
        $pokemon->setBlock(1);
        $pokemon->setIdPokemon($id);

        $oldName = $pokemon->getName();

        if ($pokemon->getName() === $this->helper->getInfo($exchange->getPokemonId())['nazwa']) {
            $pokemon->setName($this->helper->getInfo($id)['nazwa']);
        }

        $this->em->persist($pokemon);

        $this->session->getFlashBag()->add(
            'success',
            'Pokemon ewoluował w ' . $this->helper->getInfo($id)['nazwa'] . ' i znajduje się w Twojej rezerwie.'
        );

        $this->addReport($increases, $oldName, $this->helper->getInfo($id)['nazwa'], $pokemon->getGender(), $user->getId());

        $this->addToCollection($id, $user->getId());

        $this->em->remove($exchange);
    }

    private function addReport(array $increases, string $oldName, string $name, int $gender, int $userId): void
    {
        $report = new Report();
        $report->setTime(new \DateTime);
        $report->setUserId($userId);
        $report->setIsRead(0);
        $report->setTitle('Twój Pokemon '.$oldName.' ewoluował w '.$name.'.');

        $content = '<div class="row nomargin text-center"><div class="col-xs-12">Twój Pokemon 
                <span class="pogrubienie">'.$oldName.'</span> ewoluował w <span class="pogrubienie">'.$name.'</span>.</div>
                <div class="col-xs-12 pogrubienie">';

        if ($gender === 1) {
            $content .= 'Jej';
        } else {
            $content .= 'Jego';
        }
        $content .= ' statystyki rosną:</div><div class="col-xs-12"><div class="row nomargin">
            <div class="col-xs-4">Atak +'.$increases['atak'].'</div><div class="col-xs-4">Sp. Atak +'.$increases['sp_atak'].'</div>
            <div class="col-xs-4">Obrona +'.$increases['obrona'].'</div></div></div> 
            <div class="col-xs-12"><div class="row nomargin">
            <div class="col-xs-4">Sp.Obrona +'.$increases['sp_obrona'].'</div><div class="col-xs-4">Szybkość +'.$increases['szybkosc'].'</div>
            <div class="col-xs-4">HP +'.$increases['hp'].'</div></div></div></div>';
        $report->setContent($content);
        $this->em->persist($report);
    }

    private function addToCollection(int $id, int $userId): void
    {
        $this->collection->addOneToPokemonCatchAndMet($id, $userId);
    }
}
