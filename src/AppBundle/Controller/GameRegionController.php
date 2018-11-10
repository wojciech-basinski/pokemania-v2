<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class GameRegionController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/loteria", name="game_lottery")
     */
    public function lotteryShowAction()
    {
        $tickets = $this->get('game.lottery')->countUserTickets($this->getUser()->getId());

        return $this->render('game/lottery.html.twig', [
            'title' => 'Loteria',
            'ajax' => $this->request->isXmlHttpRequest(),
            'tickets' => $tickets
        ]);
    }
    /**
     * @Route("/loteria/losuj", name="game_lottery_play")
     */
    public function lotteryPlayAction()
    {
        $lotteryService = $this->get('game.lottery');
        $statusOfPlay = $lotteryService->playTheLottery($this->getUser());

        return $this->json($statusOfPlay);
    }
    
    /**
     * @Route("/lecznica", name="game_hospital")
     */
    public function hospitalAction()
    {
        //TODO:
        //ODZNAKA NR 5 Z KANTO
        $freeHeals = $this->get('session')->get('userSession')->getUserItems()->getHeals();
        $hospitalService = $this->get('game.hospital');
        $pokemons = $hospitalService->getPokemonsToView($this->getUser());

        return $this->render('game/hospital.html.twig', [
            'title' => 'Lecznica',
            'ajax' => $this->request->isXmlHttpRequest(),
            'pokemons' => $pokemons,
            'freeHeals' => $freeHeals
        ]);
    }

    /**
     * @Route("/lecznica/{i}", name="game_hospital_heal_one")
     * @Method("POST")
     */
    public function hospitalHealOneAction(int $i)
    {
        $hospitalService = $this->get('game.hospital');
        $hospitalService->healPokemon($this->getUser(), $i);

        return $this->redirectToRoute('game_hospital');
    }

    /**
     * @Route("/lecznica/wszystkie/", name="game_hospital_heal_all")
     * @Method("POST")
     */
    public function hospitalHealAllAction()
    {
        $hospitalService = $this->get('game.hospital');
        $hospitalService->healAllPokemons($this->getUser());

        return $this->redirectToRoute('game_hospital');
    }

    /**
     * @Route("sklep", name="game_shop")
     * @Method("GET")
     */
    public function shopAction()
    {
        $shop = $this->get('game.shop');

        $pokeballs = $shop->getPokeballs($this->getUser()->getId());
        $pokeballsDescription =  $shop->getPokeballsDescriptions();

        $items = $shop->getAllItems($this->getUser()->getId());

        return $this->render('game/shop.html.twig', [
            'title' => 'Sklep',
            'ajax' => $this->request->isXmlHttpRequest(),
            'active' => $this->request->get('active') ?? 1,
            'pokeballs' => $pokeballs,
            'pokeballsDescription' => $pokeballsDescription,
            'items' => $items
        ]);
    }

    /**
     * @Route("sklep", name="game_shop_buy")
     * @Method("POST")
     */
    public function shopBuyAction()
    {
        $shop = $this->get('game.shop');
        $item = $this->request->get('item');
        $quantity = $this->request->get('quantity');

        $shop->buy($item, $quantity, $this->getUser());

        return $this->redirectToRoute('game_shop', [
            'active' => $this->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("kupiec", name="game_merchant")
     * @Method("GET")
     */
    public function merchantAction()
    {
        $pokemonsToSell = $this->get('game.merchant')->getPokemonsAvailableToSell($this->getUser()->getId());

        return $this->render('game/merchant.html.twig', [
           'title' => 'Kupiec Pokemonów',
            'ajax' => $this->request->isXmlHttpRequest(),
            'pokemons' => $pokemonsToSell
        ]);
    }

    /**
     * @Route("kupiec", name="game_merchant_sell")
     * @Method("POST")
     */
    public function merchantSellAction()
    {
        $all = $this->request->get('all');
        $selected = $this->request->get('selected');
        $confirm = $this->request->get('confirm');
        $this->get('game.merchant')->sellPokemons($all, $this->getUser(), $selected, $confirm);

        return $this->redirectToRoute('game_merchant', [
            'selected' => $selected
        ]);
    }

    /**
     * @Route("podroz", name="game_travel")
     * @Method("GET")
     */
    public function travelAction()
    {
        return $this->render('game/travel.html.twig', [
           'title' => 'Podróż',
           'ajax' => $this->request->isXmlHttpRequest()
        ]);
    }

    /**
     * @Route("podroz", name="game_travel_change")
     * @Method("POST")
     */
    public function changeRegionAction()
    {
        $region = $this->request->request->get('region');

        $this->get('game.travel')->changeRegion($this->getUser(), $region);

        return $this->redirectToRoute('game_travel');
    }
}
