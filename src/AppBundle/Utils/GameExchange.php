<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Exchange;
use AppBundle\Entity\Items;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameExchange
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
        PokemonHelper $pokemonHelper,
        Collection $collection
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->pokemonHelper = $pokemonHelper;
        $this->collection = $collection;
    }

    public function getPokemonsInExchange(User $user): array
    {
        return $this->em->getRepository('AppBundle:Exchange')->findBy(['userId' => $user->getId()]);
    }

    public function parts(?int $id, bool $confirm, User $user): void
    {
        if (!in_array($id, [138, 140, 142])) {
            $this->session->getFlashBag()->add('error', 'Błędny ID Pokemona');
            return;
        }
        if (!$confirm) {
            $this->addConfirmFlashParts($id);
            return;
        }
        $this->makePokemonFromParts($id, $user);
        $this->em->flush();
    }

    /**
     * @param int|string $id
     * @param bool       $confirm
     * @param User       $user
     */
    public function coins($id, bool $confirm, User $user): void
    {
        if (!in_array($id, [133, 132, 'masterball', 'candy', 'part'])) {
            $this->session->getFlashBag()->add('error', 'Błędny przedmiot/Pokemon');
            return;
        }
        if (!$confirm) {
            $this->addConfirmFlashCoins($id);
            return;
        }
        $this->makePokemonOrItemFromCoins($id, $user);
        $this->em->flush();
    }

    public function getPokemon(int $id, User $user): void
    {
        $pokemon = $this->em->getRepository('AppBundle:Exchange')->findOneBy(['id' => $id, 'userId' => $user->getId()]);
        if (!$pokemon) {
            $this->session->getFlashBag()->add('error', 'Niepoprawny Id Pokemona');
            return;
        }
        if (time() < $pokemon->getTime()) {
            $this->session->getFlashBag()->add('error', 'Nie możesz jeszcze odebrać tego Pokemona');
            return;
        }
        $this->addPokemonToReserve($pokemon->getPokemonId(), $user);
        $this->em->remove($pokemon);
        $this->em->flush();
        $this->session->getFlashBag()->add(
            'success',
            'Poprawnie odebrano Pokemona, znajdziesz go w swojej poczekalni'
        );
    }

    private function makePokemonFromParts(int $id, User $user): void
    {
        $items = $user->getItems();
        $pokemon = $this->checkPokemonParts($id);
        if ($items->getParts() < $pokemon['partsRequired']) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz wystarczającej ilości części');
            return;
        }
        $items->setParts($items->getParts() - $pokemon['partsRequired']);
        $this->addPokemon($id, $user);
    }

    private function checkPokemonParts(int $id): array
    {
        switch ($id) {
            case 142://aerodactyl
                $pok['partsRequired'] = 65;
                $pok['name'] = 'Aerodactyla';
                break;
            case 140://kabuto
                $pok['partsRequired'] = 40;
                $pok['name'] = 'Kabuto';
                break;
            case 138://omanyte
                $pok['partsRequired'] = 40;
                $pok['name'] = 'Omanyte';
                break;
        }
        return $pok;
    }

    private function addPokemon(int $id, User $user): void
    {
        $exchange = new Exchange();
        $exchange->setUserId($user);
        $exchange->setPokemonId($id);
        $exchange->setTime(time()+86400);
        $this->em->persist($exchange);
    }

    private function addPokemonToReserve(int $id, User $user): void
    {
        $this->collection->addOneToPokemonCatchAndMet($id, $user);

        $pokemon = $this->pokemonHelper->generatePokemon($id, 1);
        $pokemon->setOwner($user->getId());
        $pokemon->setFirstOwner($user->getId());
        $pokemon->setDateOfCatch(new \DateTime());
        $pokemon->setDescription('');
        $pokemon->setExchange(0);
        $pokemon->setCatched('wymiana');
        $pokemon->getTraining()->setBerryLimit(500);
        $this->em->persist($pokemon->getTraining());
        $this->em->persist($pokemon);
    }

    /**
     * @param $id int|string
     */
    private function addConfirmFlashParts($id): void
    {
        $parts = ($id === 142) ? 65 : 40;
        $name = $this->pokemonHelper->getInfo($id)['name'];
        $this->session->getFlashBag()->add(
            'success',
            "Czy na pewno chcesz wymienić {$parts} części na {$name}?<br />
                         <div class='center'>
                         <button class='tak btn btn-info' data-id='{$id}' data-parts='1'>TAK</button>
                         <button class='nie btn btn-info' data-active='1'>NIE</button>
                        </div>"
        );
    }

    /**
     * @param $id int|string
     * @param User $user
     */
    private function makePokemonOrItemFromCoins($id, User $user): void
    {
        $items = $user->getItems();
        $item = $this->checkPokemonCoins($id);
        if ($items->getCoins() < $item['coinsRequired']) {
            $this->session->getFlashBag()->add('error', 'Nie posiadasz wystarczającej ilości monet');
            return;
        }
        $this->createItemOrPokemon($item, $user);
        $items->setCoins($items->getCoins() - $item['coinsRequired']);
    }

    /**
     * @param int|string $id
     * @return array
     */
    private function checkPokemonCoins($id): array
    {
        switch ($id) {
            case 132:
                $item['coinsRequired'] = 50;
                $item['name'] = 'Ditto';
                break;
            case 133:
                $item['coinsRequired'] = 150;
                $item['name'] = 'Eevee';
                break;
            case 'masterball':
                $item['coinsRequired'] = 120;
                $item['name'] = 'Masterballa';
                break;
            case 'part':
                $item['coinsRequired'] = 80;
                $item['name'] = 'Część skamieliny';
                break;
            case 'candy':
                $item['coinsRequired'] = 100;
                $item['name'] = 'Rare Candy';
                break;
        }
        return $item;
    }

    private function createItemOrPokemon(array $item, User $user): array
    {
        switch ($item['name']) {
            case 'Ditto':
                $this->addPokemonToReserve(132, $user);
                $this->session->getFlashBag()->add('success', 'Wymieniono 50 monet na Ditto, Pokemona znajdziesz w swojej przechowalni.');
                break;
            case 'Eevee':
                $this->addPokemonToReserve(133, $user);
                $this->session->getFlashBag()->add('success', 'Wymieniono 150 monet na Eevee, Pokemona znajdziesz w swojej przechowalni.');
                break;
            case 'Masterballa':
                $this->addMasterball($user);
                $this->session->getFlashBag()->add('success', 'Wymieniono 120 monet na Masterballa.');
                break;
            case 'Część skamieliny':
                $this->addPart($user);
                $this->session->getFlashBag()->add('success', 'Wymieniono 80 monet na część skamieliny.');
                break;
            case 'Rare Candy':
                $this->addCandy($user);
                $this->session->getFlashBag()->add('success', 'Wymieniono 100 monet na Rare Candy.');
                break;
        }
        return $item;
    }

    /**
     * @param $id int|string
     */
    private function addConfirmFlashCoins($id): void
    {
        $item =  $this->checkPokemonCoins($id);
        $parts = $item['coinsRequired'];
        $name = $item['name'];
        $this->session->getFlashBag()->add(
            'success',
            "Czy na pewno chcesz wymienić {$parts} dukatów na {$name}?<br />
                         <div class='center'>
                         <button class='tak btn btn-info' data-id='{$id}' data-parts='0' data-active='2'>TAK</button>
                         <button class='nie btn btn-info' data-active='2'>NIE</button>
                        </div>"
        );
    }

    private function addMasterball(User $user): void
    {
        $pokeballs = $user->getPokeballs();
        $pokeballs->setMasterballs($pokeballs->getMasterballs() + 1);
    }

    private function addCandy(User $user): void
    {
        $items = $user->getItems();
        $items->setCandy($items->getCandy() + 1);
    }

    private function addPart(User $user): void
    {
        $items = $user->getItems();
        $items->setParts($items->getParts() + 1);
    }
}
