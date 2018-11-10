<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class GameMarketController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }
    
    /**
     * @Route("/targ", name="game_market")
     */
    public function gameMarketAction()
    {
        $market = $this->get('game.market');

        return $this->render(
            'game/market/items.html.twig',
            [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Targ',
            'active' => $this->request->get('active') ?? 1,
            'berrys' => $market->getBerrysDescription(),
            'pokeballs' => $market->getPokeballsDescription(),
            'other' => $market->getOtherDescription(),
            'stones' => $market->getStonesDescription()
            ]
        );
    }

    /**
     * @Route("targ/szukaj/przedmiot/{name}", name="game_market_search")
     */
    public function searchItemMarketAction(string $name)
    {
        $market = $this->get('game.market');
        $kind = $market->checkNameItem($name);
        $page = $this->request->query->get('page') ?? 0;
        $count = $market->countItemMarket($name, $this->getUser()->getId(), $kind);
        if (!$count) {
            $items = null;
        } else {
            $items = $market->getItems($name, $this->getUser()->getId(), $kind, $page);
        }

        return $this->render('game/market/itemsOferts.html.twig', [
            'items' => $items,
            'count' => $count,
            'name' => $name,
            'kind' => $kind,
            'page' => $page
        ]);
    }

    /**
     * @Route("/targ/kup/przedmiot", name="game_market_buy_item")
     * @Method("POST")
     */
    public function marketBuyItemAction()
    {
        $this->get('game.market')->buyItem($this->getUser());

        return $this->redirectToRoute('game_market_search', [
            'name' => $this->request->request->get('name')
        ]);
    }

    /**
     * @Route("/targ/pokemon", name="game_market_pokemon")
     */
    public function gameMarketPokemonAction()
    {
        $market = $this->get('game.market');

        return $this->render('game/market/pokemon.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Targ- Pokemon',
            'formInfo' => $market->getInfoPokemonForm()
        ]);
    }

    /**
     * @Route("/targ/szukaj/pokemon", name="game_market_pokemon_search")
     * @Method("POST")
     */
    public function searchPokemonOnMarketAction()
    {
        $market = $this->get('game.market');
        $page = $this->request->request->get('page') ?? 1;

        return $this->render('game/market/pokemonOferts.html.twig', [
            'ajax' => 1,
            'title' => '',
            'formInfo' => $market->getInfoPokemonForm(),
            'oferts' => $market->pokemonSearchOnMarket($this->getUser()),
            'count' => $market->getNumberOfofertsPokemon(),
            'page' => $page
        ]);
    }

    /**
     * @Route("/targ/wystaw/przedmiot", name="game_market_item_sell")
     * @Method("GET")
     */
    public function sellItemMarketAction()
    {
        $market = $this->get('game.market');

        return $this->render('game/market/itemsSelling.html.twig', [
            'title' => 'Wystaw produkt na targ',
            'ajax' => $this->request->isXmlHttpRequest(),
            'active' => $this->request->query->get('active') ?? 1,
            'berrys' => $market->getBerrysAvailableToSell($this->getUser()),
            'pokeballs' => $market->getPokeballsAvailableToSell($this->getUser()),
            'others' => $market->getOthersAvailableToSell($this->getUser()),
            'stones' => $market->getStonesAvailableToSell($this->getUser()),
            'onMarket' => $market->getItemsOnMarket($this->getUser()->getId())
        ]);
    }

    /**
     * @Route("/targ/wystaw/przedmiot", name="game_market_item_selling")
     * @Method("POST")
     */
    public function sellingItemMarketAction()
    {
        $this->get('game.market')->addItemToMarket($this->getUser());

        return $this->redirectToRoute('game_market_item_sell');
    }

    /**
     * @Route("/targ/wycofaj/przedmiot", name="game_market_item_remove")
     * @Method("POST")
     */
    public function removeItemFromMarketAction()
    {
        $this->get('game.market')->removeItemFromMarket($this->getUser());

        return $this->redirectToRoute('game_market_item_sell', [
            'active' => 2
        ]);
    }

    /**
     * @Route("/targ/kup/pokemon", name="game_market_pokemon_buy")
     * @Method("POST")
     */
    public function marketPokemonBuyAction()
    {
        $market = $this->get('game.market');
        $market->buyPokemon($this->getUser());

        return $this->redirectToRoute('game_market_pokemon');
    }

    /**
     * @Route("/targ/wystaw/pokemon", name="game_market_pokemon_sell")
     * @Method("GET")
     */
    public function sellPokemonAction()
    {
        $market = $this->get('game.market');

        return $this->render('game/market/pokemonSell.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Wystaw Pokemona na targ',
            'active' => $this->request->query->get('active') ?? 1,
            'pokemonMarked' => $this->request->query->get('marked') ?? 0,
            'pokemonsThatCanBeSold' => $market->pokemonsThatCanBeSold($this->getUser()->getId()),
            'pokemonsAddToSell' => $market->pokemonsAddedToSell($this->getUser()->getId())
        ]);
    }

    /**
     * @Route("/targ/wystaw/pokemon", name="game_market_pokemon_selling")
     * @Method("POST")
     */
    public function sellingPokemonAction()
    {
        $this->get('game.market')->sellingPokemon($this->getUser());

        return $this->redirectToRoute('game_market_pokemon_sell');
    }
    
    /**
     * @Route("/targ/wycofaj/pokemon", name="game_market_pokemon_remove")
     * @Method("POST")
     */
    public function removePokemonFromMarketAction()
    {
        $this->get('game.market')->removePokemonFromMarket($this->getUser());

        return $this->redirectToRoute('game_market_pokemon_sell', [
            'active' => 2
        ]);
    }
}
