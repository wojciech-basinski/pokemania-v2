<?php


namespace AppBundle\Controller;

use AppBundle\Utils\GameHospital;
use AppBundle\Utils\GameMerchant;
use AppBundle\Utils\GameShop;
use AppBundle\Utils\GameTravel;
use AppBundle\Utils\Lottery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameRegionController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/loteria", name="game_lottery")
     * @param Lottery $lottery
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lotteryShowAction(Lottery $lottery)
    {
        $tickets = $lottery->countUserTickets($this->getUser()->getId());

        return $this->render('game/lottery.html.twig', [
            'title' => 'Loteria',
            'ajax' => $this->request->isXmlHttpRequest(),
            'tickets' => $tickets
        ]);
    }

    /**
     * @Route("/loteria/losuj", name="game_lottery_play")
     * @param Lottery $lottery
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function lotteryPlayAction(Lottery $lottery)
    {
        $statusOfPlay = $lottery->playTheLottery($this->getUser());

        return $this->json($statusOfPlay);
    }

    /**
     * @Route("/lecznica", name="game_hospital")
     * @param GameHospital $hospitalService
     *
     * @param SessionInterface $session
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hospitalAction(GameHospital $hospitalService, SessionInterface $session)
    {
        //TODO:
        //ODZNAKA NR 5 Z KANTO
        $freeHeals = $session->get('userSession')->getUserItems()->getHeals();
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
     * @param int $i
     * @param GameHospital $hospitalService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hospitalHealOneAction(int $i, GameHospital $hospitalService)
    {
        $hospitalService->healPokemon($this->getUser(), $i);

        return $this->redirectToRoute('game_hospital');
    }

    /**
     * @Route("/lecznica/wszystkie/", name="game_hospital_heal_all")
     * @Method("POST")
     * @param GameHospital $hospitalService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hospitalHealAllAction(GameHospital $hospitalService)
    {
        $hospitalService->healAllPokemons($this->getUser());

        return $this->redirectToRoute('game_hospital');
    }

    /**
     * @Route("sklep", name="game_shop")
     * @Method("GET")
     * @param GameShop $shop
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function shopAction(GameShop $shop)
    {
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
     * @param GameShop $shop
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function shopBuyAction(GameShop $shop)
    {
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
     * @param GameMerchant $merchant
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function merchantAction(GameMerchant $merchant)
    {
        $pokemonsToSell = $merchant->getPokemonsAvailableToSell($this->getUser()->getId());

        return $this->render('game/merchant.html.twig', [
           'title' => 'Kupiec Pokemonów',
            'ajax' => $this->request->isXmlHttpRequest(),
            'pokemons' => $pokemonsToSell
        ]);
    }

    /**
     * @Route("kupiec", name="game_merchant_sell")
     * @Method("POST")
     * @param GameMerchant $merchant
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function merchantSellAction(GameMerchant $merchant)
    {
        $all = $this->request->get('all');
        $selected = $this->request->get('selected');
        $confirm = $this->request->get('confirm');
        $merchant->sellPokemons($all, $this->getUser(), $selected, $confirm);

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
     * @param GameTravel $gameTravel
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeRegionAction(GameTravel $gameTravel)
    {
        $region = $this->request->request->get('region');

        $gameTravel->changeRegion($this->getUser(), $region);

        return $this->redirectToRoute('game_travel');
    }
}
