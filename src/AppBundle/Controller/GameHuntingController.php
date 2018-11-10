<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class GameHuntingController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/polowanie", name="game_hunting_index")
     */
    public function showRegionAction()
    {
        $hunting = $this->get('game.hunting');

        switch ($this->getUser()->getRegion()) {
            case 1:
                return $this->render('game/hunting/region.html.twig', [
                    'ajax' => $this->request->isXmlHttpRequest(),
                    'title' => 'Polowanie - Kanto',
                    'places' => $hunting->getPlacesKanto($this->getUser()->getId())
                ]);
            default:
                return $this->render('game/hunting/region.html.twig', [
                    'ajax' => $this->request->isXmlHttpRequest(),
                    'title' => 'Polowanie - Johto',
                    'places' => $hunting->getPlacesJohto($this->getUser()->getId())
                ]);
        }
    }

    /**
     * @Route("/polowanie/{place}", name="game_hunting_place")
     * @Method("GET")
     */
    public function gameHuntingPlaceAction(string $place)
    {
        $hunting = $this->get('game.hunting');

        if (!$hunting->execute($place, $this->getUser())) {
            return $this->redirectToRoute('game_hunting_index');
        }
        return $this->render($hunting->whatRender(), [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Polowanie - Kanto',
            'place' => $place,
            'hunting' => $hunting->getHuntingInfo(),
            'trainerPokemons' => $hunting->getTrainerPokemons(),
            'battleWithTrainerInfo' => $hunting->getTrainerBattleInfo()
        ]);
    }

    /**
     * @Route("/polowanie/walka", name="game_hunting_battle")
     * @Method("POST")
     */
    public function gameHuntingBattleAction()
    {
        $pokemonId = $this->request->get('pokemonId');
        $battleService = $this->get('game.hunting.battle.pokemons');

        $battle = $battleService->battle($pokemonId, $this->getUser());
        if (!$battle) {
            return $this->redirectToRoute('game_hunting_index');
        }

        if ($battle['score']) {
            $catching = $this->get('game.hunting.catch');
            $pokeballs = $catching->getPokeballs($this->getUser()->getId());
        }

        return $this->render('game/hunting/battle.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Polowanie walka',
            'place' => $this->request->get('place'),
            'battle' => $battle,
            'pokeballs' => $pokeballs ?? null
        ]);
    }

    /**
     * @Route("/polowanie/lapanie", name="game_hunting_catch")
     * @Method("POST")
     */
    public function gameHuntingCatchAction()
    {
        $pokeball = $this->request->get('pokeball');

        $catch = $this->get('game.hunting.catch');
        $catch->catch($pokeball, $this->getUser());

        $repeatballs = $this->get('session')->get('huntingChangeRepeatball');
        if ($repeatballs) {
            $pokeballs = $this->getDoctrine()
                ->getRepository('AppBundle:Pokeball')
                ->find($this->getUser()->getId());
        }


        return $this->render('game/hunting/catch.html.twig', [
            'place' => $this->request->get('place'),
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Polowanie',
            'repeatball' => $repeatballs,
            'pokeballs' => $pokeballs ?? null
        ]);
    }
}
