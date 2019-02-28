<?php

namespace AppBundle\Controller;

use AppBundle\Utils\GameHospital;
use AppBundle\Utils\GamePack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends Controller
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
     * @Route("/stopka/wylecz", name="game_footer_heal")
     * @param GameHospital $hospital
     *
     * @return Response
     */
    public function healAction(GameHospital $hospital)
    {
        $hospital->healAllPokemons($this->getUser());
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/soda", name="game_footer_soda")
     * @param GamePack $pack
     *
     * @return Response
     */
    public function sodaAction(GamePack $pack)
    {
        $pack->useItem('soda', 1, $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/woda", name="game_footer_water")
     * @param GamePack $pack
     *
     * @return Response
     */
    public function waterAction(GamePack $pack)
    {
        $pack->useItem('water', 1, $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/lemoniada", name="game_footer_lemonade")
     * @param GamePack $pack
     *
     * @return Response
     */
    public function lemonadeAction(GamePack $pack)
    {
        $pack->useItem('lemonade', 1, $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/cheriberry", name="game_footer_cheriberry")
     * @param GamePack $pack
     *
     * @return Response
     */
    public function cheriberryAction(GamePack $pack)
    {
        $pack->useItem('cheri_Berry', 'all', $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/wikiberry", name="game_footer_wikiberry")
     * @param GamePack $pack
     *
     * @return Response
     */
    public function wikiberryAction(GamePack $pack)
    {
        $pack->useItem('wiki_Berry', 'all', $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/nakarm/{id}", name="game_footer_feed")
     * @param GamePack $pack
     *
     * @param int $id
     *
     * @return Response
     */
    public function feedAction(GamePack $pack, int $id = 0)
    {
        $pack->useItem('food', 'all', $this->getUser(), $id);
        return $this->render('game/footer.html.twig');
    }
}
