<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OtherSpecialController extends Controller
{
    /**
     * @Route("/lewo", name="game_left")
     */
    public function leftAction()
    {
        $leftTableService = $this->get('app.left.table');

        $pokemonsInTeam = $leftTableService->getUsersPokemonsInTeam();

        return $this->render('game/template/left.html.twig', [
            'pokemonsInTeam' => $pokemonsInTeam
        ]);
    }

    /**
     * @Route("/podglad/walka", name="game_show_battle")
     * @Method("POST")
     */
    public function showBattleBetweenPokemonsAction()
    {
        $battle = $this->get('game.hunting.battle.pokemons')->showBattle($this->getUser()->getId());
        return $this->render('game/hunting/battleShow.html.twig', [
            'battle' => $battle
        ]);
    }

    /**
     * @Route("/podglad/walka/trener", name="game_show_battle_trainer")
     * @Method("POST")
     */
    public function showBattleWithTrainerAction()
    {
        $battle = $this->get('game.hunting.battle.pokemons')->showBattle($this->getUser()->getId(), 1);
        return $this->render('game/hunting/battleShow.html.twig', [
            'battle' => $battle
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('game_index');
        }
        $index = $this->get('game.index');
        $user = new User();
        $registerForm = $this->createForm(UserType::class, $user);

        return $this->render('game/index.html.twig', [
            'registerForm' => $registerForm->createView(),
            'online' => $index->getOnline()
        ]);
    }

    /**
     * @Route("/last", name="index_last_caught_pokemons")
     * @Method("POST")
     */
    public function lastCaughtAction()
    {
        $last = $this->get('game.index')->getLastCaughtPokemons();

        return $this->json($last);
    }
}
