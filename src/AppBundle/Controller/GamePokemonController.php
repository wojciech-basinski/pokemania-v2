<?php

namespace AppBundle\Controller;

use AppBundle\Utils\AttackHelper;
use AppBundle\Utils\PokemonHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class GamePokemonController extends Controller
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/pokemon/{id}", name="game_pokemon")
     */
    public function gamePokemonShowAction(PokemonHelper $pokemonHelper, AttackHelper $attackHelper, int $id = 0)
    {
        if (!$id) {
            $id = $this->request->get('id');
            if (!$id) {
                $id = $this->get('session')->get('pokemon0')->getId();
            }
        }
        $pokemonAndInfoAboutPokemon = $this->get('game.pokemon')->
            getPokemonInfo($id, $this->getUser(), $this->request->query->get('modal') ?? 0);

        return $this->render('game/pokemon.html.twig', [
            'title' => 'Pokemon',
            'ajax' => $this->request->isXmlHttpRequest(),
            'modal' => $this->request->query->get('modal') ?? 0,
            'pokemon' => $pokemonAndInfoAboutPokemon['pokemon'],
            'isInTeam' => $pokemonAndInfoAboutPokemon['isInTeam'],
            'isOwner' => $pokemonAndInfoAboutPokemon['isOwner'],
            'pokemonId' => $id,
            'owner' => $pokemonAndInfoAboutPokemon['owner'],
            'pokemonHelper' => $pokemonHelper,
            'attackHelper' => $attackHelper
        ]);
    }

    /**
     * @Route("pokemon/change/", name="game_pokemon_change")
     * @Method("POST")
     */
    public function pokemonChangeAction()
    {
        $what = $this->request->request->get('what');
        $value = $this->request->request->get('value');
        $id = $this->request->request->get('id', 0);

        $changeService = $this->get('game.pokemon.change');
        $changeService->changeCheck($what, $value, $id, $this->getUser());

        return $this->redirectToRoute('game_pokemon', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/sala/{id}", name="game_training")
     * @Method("GET")
     */
    public function trainingAction(AttackHelper $attackHelper, int $id = 0)
    {
        $trainingService = $this->get('game.training');

        $pokemonExists = $trainingService->checkId($id);
        $pokemons = $trainingService->getPokemons($this->getUser()->getId())['pokemons'];
        $trainings = $trainingService->calculateTrainings($pokemons);

        return $this->render('game/training.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Sala treningowa',
            'exists' => $pokemonExists,
            'pokemonId' => $id,
            'pokemons' => $pokemons,
            'trainings' => $trainings,
            'attackHelper' => $attackHelper
        ]);
    }

    /**
     * @Route("/sala", name="game_training_pokemon")
     * @Method("POST")
     */
    public function trainingPokemonAction()
    {
        $trainingService = $this->get('game.training');
        $value = $this->request->request->get('value') ?? 1;
        $training = $this->request->request->get('training');
        $pokemonId = $this->request->request->get('pokemonId');

        $trainingService->train($pokemonId, $training, $value, $this->getUser());

        return $this->redirectToRoute("game_training", [
            'id' => $pokemonId
        ]);
    }

    /**
     * @Route("/sala/atak/", name="game_training_attack")
     * @Method("POST")
     */
    public function trainingChangeAttackAction()
    {
        $id = $this->request->request->get('id') ?? 0;
        $attackId = $this->request->request->get('attackId') ?? 0;
        $whichChange = $this->request->request->get('whichChange') ?? -1;

        $this->get('game.training')->changeAttack($id, $attackId, $whichChange);

        return $this->redirectToRoute('game_training', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/pokemony", name="game_user_pokemons")
     */
    public function userPokemonsAction()
    {
        $pokemons = $this->get('game.pokemons');

        $numberOfPokemonsInTeam = $pokemons->getNumberOfPokemonsInTeam();
        $pokemonsInReserve = $pokemons->getPokemonsFromReserveOrdered($this->getUser());
        $pokemonsInWaiting = $pokemons->getPokemonsFromWaitingOrdered($this->getUser());
        $pokemonsInMarket = $pokemons->getPokemonsFromMarketOrdered($this->getUser());

        return $this->render('game/pokemons.html.twig', [
            'title' => 'Pokemony',
            'ajax' => $this->request->isXmlHttpRequest(),
            'active' => $this->request->query->get('active') ?? 1,
            'numberOfPokemonsInTeam' => $numberOfPokemonsInTeam,
            'pokemonsInReserve' => $pokemonsInReserve,
            'pokemonsInWaiting' => $pokemonsInWaiting,
            'pokemonsInMarket' => $pokemonsInMarket
        ]);
    }
    /**
     * @Route("/pokemony/rezerwa", name="game_user_pokemons_reserve")
     * @Method("POST")
     */
    public function userPokemonToReserveAction()
    {
        $pokemons = $this->get('game.pokemons');

        if ($this->request->request->get('fromTeam')) {
            $id = $this->request->request->get('id');
            $pokemons->sendPokemonFromTeamToReserve($id, $this->getUser());
        } else {
            $pokemonsToReserve = $this->request->request->get('selected');
            $pokemons->sendPokemonFromWaitinigToReserve($pokemonsToReserve, $this->getUser());
        }

        return $this->redirectToRoute('game_user_pokemons', [
            'active' => $this->request->query->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/pokemony/druzyna", name="game_user_pokemons_team")
     * @Method("POST")
     */
    public function userPokemonsToTeamAction()
    {
        $pokemons = $this->get('game.pokemons');
        $pokemonsToTeam = $this->request->request->get('selected');

        $pokemons->sendPokemonsToTeam($pokemonsToTeam, $this->getUser());

        return $this->redirectToRoute('game_user_pokemons', [
            'active' => $this->request->query->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/pokemony/poczekalnia", name="game_user_pokemons_waiting")
     * @Method("POST")
     */
    public function userPokemonsToWaitingAction()
    {
        $pokemons = $this->get('game.pokemons');
        $pokemonsToWaiting = $this->request->request->get('selected');

        $pokemons->sendPokemonsToWaiting($pokemonsToWaiting, $this->getUser());

        return $this->redirectToRoute('game_user_pokemons', [
            'active' => $this->request->query->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/pokemony/kolejnosc", name="game_user_pokemons_order")
     * @Method("POST")
     */
    public function changeOrderPokemonAction()
    {
        $pokemons = $this->get('game.pokemons');
        $i = $this->request->request->get('i');
        $this->request->request->get('up') ?
            $pokemons->getOrderUp($i, $this->getUser()->getId()) :
            $pokemons->getOrderDown($i, $this->getUser()->getId());

        return $this->redirectToRoute('game_user_pokemons');
    }

    /**
     * @Route("/pokemony/wymiana", name="game_user_pokemons_exchange")
     * @Method("GET")
     */
    public function pokemonExchangeAction()
    {
        $pokemonsExchange = $this->get('game.pokemons.exchange');

        return $this->render('game/pokemons_exchange.html.twig', [
            'title' => 'Pokemony wymiana',
            'ajax' => $this->request->isXmlHttpRequest(),
            'inExchange' => $pokemonsExchange->inExchange($this->getUser()->getId()),
            'toExchange' => $pokemonsExchange->toExchange(),
            'stones' => $this->get('game.pack')->getStones($this->getUser()->getId())
        ]);
    }

    /**
     * @Route("/pokemony/wymiana", name="game_user_pokemons_exchange_action")
     * @Method("POST")
     */
    public function pokemonExchangeAddAction()
    {
        $id = $this->request->request->get('id');
        $what = $this->request->request->get('mode');

        $pokemonsExchange = $this->get('game.pokemons.exchange');
        $pokemonsExchange->action($this->getUser(), $id, $what);

        return $this->redirectToRoute('game_user_pokemons_exchange');
    }
    /**
     * @Route("/trening", name="activity_training")
     */
    public function trainingWithPokemonsAction()
    {
        $training = $this->get('game.training.pokemons');

        return $this->render('game/trainingPokemons.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Trening',
            'training' => $training->checkIfInTraining($this->getUser()),
            'time' => $training->calculateTime($this->getUser())
        ]);
    }

    /**
     * @Route("/trening/start", name="activity_training_start")
     */
    public function trainingWithPokemonsStartAction()
    {
        $user = $this->getUser();
        if ($user->getActivity() != '' && $user->getActivity() != 'training') {
            return $this->redirectToRoute('activity'.$user->getActivity());
        }

        $training = $this->get('game.training.pokemons');
        $training->startTraining($this->getUser());

        return $this->redirectToRoute('activity_training');
    }
    /**
     * @Route("/trening/koniec", name="activity_training_stop")
     */
    public function trainingWithPokemonsStopAction()
    {
        $user = $this->getUser();
        if ($user->getActivity() != '' && $user->getActivity() != 'training') {
            return $this->redirectToRoute('activity'.$user->getActivity());
        }

        $training = $this->get('game.training.pokemons');
        $training->stopTraining($this->getUser());

        return $this->redirectToRoute('activity_training');
    }
}
