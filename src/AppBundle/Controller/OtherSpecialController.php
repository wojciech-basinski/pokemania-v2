<?php


namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Utils\GameHuntingBattleBetweenPokemons;
use AppBundle\Utils\GameIndex;
use AppBundle\Utils\LeftTable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OtherSpecialController extends Controller
{
    /**
     * @Route("/lewo", name="game_left")
     * @param LeftTable $leftTable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function leftAction(LeftTable $leftTable)
    {

        $pokemonsInTeam = $leftTable->getUsersPokemonsInTeam();

        return $this->render('game/template/left.html.twig', [
            'pokemonsInTeam' => $pokemonsInTeam
        ]);
    }

    /**
     * @Route("/podglad/walka", name="game_show_battle")
     * @Method("POST")
     * @param GameHuntingBattleBetweenPokemons $battle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBattleBetweenPokemonsAction(GameHuntingBattleBetweenPokemons  $battle)
    {
        $battle = $battle->showBattle($this->getUser()->getId());
        return $this->render('game/hunting/battleShow.html.twig', [
            'battle' => $battle
        ]);
    }

    /**
     * @Route("/podglad/walka/trener", name="game_show_battle_trainer")
     * @Method("POST")
     * @param GameHuntingBattleBetweenPokemons $battle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBattleWithTrainerAction(GameHuntingBattleBetweenPokemons $battle)
    {
        $battle = $battle->showBattle($this->getUser()->getId(), 1);
        return $this->render('game/hunting/battleShow.html.twig', [
            'battle' => $battle
        ]);
    }

    /**
     * @Route("/", name="homepage")
     * @param GameIndex $index
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(GameIndex $index)
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('game_index');
        }
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
     * @param GameIndex $index
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function lastCaughtAction(GameIndex $index)
    {
        $last = $index->getLastCaughtPokemons();

        return $this->json($last);
    }
}
