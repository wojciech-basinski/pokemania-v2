<?php
namespace AppBundle\Controller;

use AppBundle\Utils\GameHunting;
use AppBundle\Utils\GameHuntingBattleBetweenPokemons;
use AppBundle\Utils\GameHuntingCatch;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameHuntingController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/polowanie", name="game_hunting_index")
     * @param GameHunting $hunting
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showRegionAction(GameHunting $hunting)
    {
        switch ($this->getUser()->getRegion()) {
            case 1:
                return $this->render('game/hunting/region.html.twig', [
                    'ajax' => $this->request->isXmlHttpRequest(),
                    'title' => 'Polowanie - Kanto',
                    'places' => $hunting->getPlacesKanto($this->getUser())
                ]);
            default:
                return $this->render('game/hunting/region.html.twig', [
                    'ajax' => $this->request->isXmlHttpRequest(),
                    'title' => 'Polowanie - Johto',
                    'places' => $hunting->getPlacesJohto($this->getUser())
                ]);
        }
    }

    /**
     * @Route("/polowanie/{place}", name="game_hunting_place")
     * @Method("GET")
     * @param string $place
     * @param GameHunting $hunting
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function gameHuntingPlaceAction(string $place, GameHunting $hunting)
    {
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
     * @param GameHuntingBattleBetweenPokemons $battleService
     *
     * @param GameHuntingCatch $catching
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function gameHuntingBattleAction(
        GameHuntingBattleBetweenPokemons $battleService,
        GameHuntingCatch $catching
    ) {
        $pokemonId = $this->request->get('pokemonId');

        $battle = $battleService->battle($pokemonId, $this->getUser());
        if (!$battle) {
            return $this->redirectToRoute('game_hunting_index');
        }

        if ($battle['score']) {
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
     * @param GameHuntingCatch $catch
     *
     * @param SessionInterface $session
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gameHuntingCatchAction(GameHuntingCatch $catch, SessionInterface $session)
    {
        $pokeball = $this->request->get('pokeball');

        $catch->catch($pokeball, $this->getUser());

        $repeatballs = $session->get('huntingChangeRepeatball');
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
