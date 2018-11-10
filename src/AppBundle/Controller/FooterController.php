<?php

namespace AppBundle\Controller;

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
     */
    public function healAction()
    {
        $this->get('game.hospital')->healAllPokemons($this->getUser());
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/soda", name="game_footer_soda")
     */
    public function sodaAction()
    {
        $this->get('game.pack')->useItem('soda', 1, $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/woda", name="game_footer_water")
     */
    public function waterAction()
    {
        $this->get('game.pack')->useItem('water', 1, $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/lemoniada", name="game_footer_lemonade")
     */
    public function lemonadeAction()
    {
        $this->get('game.pack')->useItem('lemonade', 1, $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/cheriberry", name="game_footer_cheriberry")
     */
    public function cheriberryAction()
    {
        $this->get('game.pack')->useItem('cheri_Berry', 'all', $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/wikiberry", name="game_footer_wikiberry")
     */
    public function wikiberryAction()
    {
        $this->get('game.pack')->useItem('wiki_Berry', 'all', $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }

    /**
     * @Route("/stopka/nakarm", name="game_footer_feed")
     */
    public function feedAction()
    {
        $this->get('game.pack')->useItem('food', 'all', $this->getUser(), 0);
        return $this->render('game/footer.html.twig');
    }
}
