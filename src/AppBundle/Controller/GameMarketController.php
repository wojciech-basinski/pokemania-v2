<?php
namespace AppBundle\Controller;

use AppBundle\Utils\GameMarket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameMarketController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/targ", name="game_market")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function gameMarketAction(GameMarket $market): Response
    {
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
     * @param string $name
     * @param GameMarket $market
     *
     * @return Response
     */
    public function searchItemMarketAction(string $name, GameMarket $market): Response
    {
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
     * @param GameMarket $market
     *
     * @return Response
     */
    public function marketBuyItemAction(GameMarket $market): Response
    {
        $market->buyItem($this->getUser());

        return $this->redirectToRoute('game_market_search', [
            'name' => $this->request->request->get('name')
        ]);
    }

    /**
     * @Route("/targ/pokemon", name="game_market_pokemon")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function gameMarketPokemonAction(GameMarket $market): Response
    {
        return $this->render('game/market/pokemon.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Targ- Pokemon',
            'formInfo' => $market->getInfoPokemonForm()
        ]);
    }

    /**
     * @Route("/targ/szukaj/pokemon", name="game_market_pokemon_search")
     * @Method("POST")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function searchPokemonOnMarketAction(GameMarket $market): Response
    {
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
     * @param GameMarket $market
     *
     * @return Response
     */
    public function sellItemMarketAction(GameMarket $market): Response
    {
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
     * @param GameMarket $market
     *
     * @return Response
     */
    public function sellingItemMarketAction(GameMarket $market): Response
    {
        $market->addItemToMarket($this->getUser());

        return $this->redirectToRoute('game_market_item_sell');
    }

    /**
     * @Route("/targ/wycofaj/przedmiot", name="game_market_item_remove")
     * @Method("POST")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function removeItemFromMarketAction(GameMarket $market): Response
    {
        $market->removeItemFromMarket($this->getUser());

        return $this->redirectToRoute('game_market_item_sell', [
            'active' => 2
        ]);
    }

    /**
     * @Route("/targ/kup/pokemon", name="game_market_pokemon_buy")
     * @Method("POST")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function marketPokemonBuyAction(GameMarket $market): Response
    {
        $market->buyPokemon($this->getUser());

        return $this->redirectToRoute('game_market_pokemon');
    }

    /**
     * @Route("/targ/wystaw/pokemon", name="game_market_pokemon_sell")
     * @Method("GET")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function sellPokemonAction(GameMarket $market): Response
    {
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
     * @param GameMarket $market
     *
     * @return Response
     */
    public function sellingPokemonAction(GameMarket $market): Response
    {
        $market->sellingPokemon($this->getUser());

        return $this->redirectToRoute('game_market_pokemon_sell');
    }

    /**
     * @Route("/targ/wycofaj/pokemon", name="game_market_pokemon_remove")
     * @Method("POST")
     * @param GameMarket $market
     *
     * @return Response
     */
    public function removePokemonFromMarketAction(GameMarket $market): Response
    {
        $market->removePokemonFromMarket($this->getUser());

        return $this->redirectToRoute('game_market_pokemon_sell', [
            'active' => 2
        ]);
    }
}
