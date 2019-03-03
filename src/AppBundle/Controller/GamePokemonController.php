<?php
namespace AppBundle\Controller;

use AppBundle\Utils\AttackHelper;
use AppBundle\Utils\GamePack;
use AppBundle\Utils\GamePokemon;
use AppBundle\Utils\GamePokemonChange;
use AppBundle\Utils\GamePokemons;
use AppBundle\Utils\GamePokemonsExchange;
use AppBundle\Utils\GameTraining;
use AppBundle\Utils\GameTrainingPokemon;
use AppBundle\Utils\PokemonHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GamePokemonController extends Controller
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
     * @Route("/pokemon", name="game_pokemon_post")
     * @Method("POST")
     *
     * @return Response
     */
    public function pokemonFromLeftFormAction(): Response
    {
        $id = $this->request->request->get('id');
        return $this->redirectToRoute('game_pokemon', ['id' => $id]);
    }

    /**
     * @Route("/game/pokemon/{id}", name="game_pokemon")
     * @param PokemonHelper $pokemonHelper
     * @param AttackHelper $attackHelper
     * @param GamePokemon $pokemonService
     * @param SessionInterface $session
     * @param int $id
     *
     * @return Response
     */
    public function gamePokemonShowAction(
        PokemonHelper $pokemonHelper,
        AttackHelper $attackHelper,
        GamePokemon $pokemonService,
        SessionInterface $session,
        int $id = 0
    ): Response {
        if (!$id) {
            $id = $this->request->get('id');
            if (!$id) {
                $id = $session->get('pokemon0')->getId();
            }
        }
        $pokemonAndInfoAboutPokemon = $pokemonService->
            getPokemonInfo($id, $this->getUser(), $this->request->query->get('modal') ?? 0);

        if ($this->getUser() === null) {
            $renderFile = 'game/pokemonNotLogged.html.twig';
        } else {
            $renderFile = 'game/pokemon.html.twig';
        }
        return $this->render($renderFile, [
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
     * @param GamePokemonChange $gamePokemonChange
     *
     * @return Response
     */
    public function pokemonChangeAction(GamePokemonChange $gamePokemonChange): Response
    {
        $what = $this->request->request->get('what');
        $value = $this->request->request->get('value');
        $id = $this->request->request->get('id', 0);

        $gamePokemonChange->changeCheck($what, $value, $id, $this->getUser());

        return $this->redirectToRoute('game_pokemon', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/sala/{id}", name="game_training")
     * @Method("GET")
     * @param AttackHelper $attackHelper
     * @param GameTraining $trainingService
     * @param int $id
     *
     * @return Response
     */
    public function trainingAction(AttackHelper $attackHelper, GameTraining $trainingService, int $id = 0): Response
    {
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
     * @param GameTraining $trainingService
     *
     * @return Response
     */
    public function trainingPokemonAction(GameTraining $trainingService): Response
    {
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
     * @param GameTraining $trainingService
     *
     * @return Response
     */
    public function trainingChangeAttackAction(GameTraining $trainingService): Response
    {
        $id = $this->request->request->get('id') ?? 0;
        $attackId = $this->request->request->get('attackId') ?? 0;
        $whichChange = $this->request->request->get('whichChange') ?? -1;

        $trainingService->changeAttack($id, $attackId, $whichChange);

        return $this->redirectToRoute('game_training', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/pokemony", name="game_user_pokemons")
     * @param GamePokemons $pokemons
     *
     * @return Response
     */
    public function userPokemonsAction(GamePokemons $pokemons): Response
    {
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
     * @param GamePokemons $pokemons
     *
     * @return Response
     */
    public function userPokemonToReserveAction(GamePokemons $pokemons): Response
    {
        if ($this->request->request->get('fromTeam')) {
            $id = $this->request->request->get('id');
            $pokemons->sendPokemonFromTeamToReserve($id, $this->getUser());
        } else {
            $pokemonsToReserve = $this->request->request->get('selected');
            $pokemons->sendPokemonFromWaitinigToReserve($pokemonsToReserve, $this->getUser());
        }

        return $this->redirectToRoute('game_user_pokemons', [
            'active' => $this->request->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/pokemony/druzyna", name="game_user_pokemons_team")
     * @Method("POST")
     * @param GamePokemons $pokemons
     *
     * @return Response
     */
    public function userPokemonsToTeamAction(GamePokemons $pokemons): Response
    {
        $pokemonsToTeam = $this->request->request->get('selected');

        $pokemons->sendPokemonsToTeam($pokemonsToTeam, $this->getUser());

        return $this->redirectToRoute('game_user_pokemons', [
            'active' => $this->request->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/pokemony/poczekalnia", name="game_user_pokemons_waiting")
     * @Method("POST")
     * @param GamePokemons $pokemons
     *
     * @return Response
     */
    public function userPokemonsToWaitingAction(GamePokemons $pokemons): Response
    {
        $pokemonsToWaiting = $this->request->request->get('selected');

        $pokemons->sendPokemonsToWaiting($pokemonsToWaiting, $this->getUser());

        return $this->redirectToRoute('game_user_pokemons', [
            'active' => $this->request->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/pokemony/kolejnosc", name="game_user_pokemons_order")
     * @Method("POST")
     * @param GamePokemons $pokemons
     *
     * @return Response
     */
    public function changeOrderPokemonAction(GamePokemons $pokemons): Response
    {
        $i = $this->request->request->get('i');
        $this->request->request->get('up') ?
            $pokemons->getOrderUp($i, $this->getUser()->getId()) :
            $pokemons->getOrderDown($i, $this->getUser()->getId());

        return $this->redirectToRoute('game_user_pokemons');
    }

    /**
     * @Route("/pokemony/wymiana", name="game_user_pokemons_exchange")
     * @Method("GET")
     * @param GamePokemonsExchange $pokemonsExchange
     *
     * @param GamePack $gamePack
     *
     * @return Response
     */
    public function pokemonExchangeAction(GamePokemonsExchange $pokemonsExchange, GamePack $gamePack): Response
    {
        return $this->render('game/pokemons_exchange.html.twig', [
            'title' => 'Pokemony wymiana',
            'ajax' => $this->request->isXmlHttpRequest(),
            'inExchange' => $pokemonsExchange->inExchange($this->getUser()->getId()),
            'toExchange' => $pokemonsExchange->toExchange(),
            'stones' => $gamePack->getStones($this->getUser()->getId())
        ]);
    }

    /**
     * @Route("/pokemony/wymiana", name="game_user_pokemons_exchange_action")
     * @Method("POST")
     * @param GamePokemonsExchange $pokemonsExchange
     *
     * @return Response
     */
    public function pokemonExchangeAddAction(GamePokemonsExchange $pokemonsExchange): Response
    {
        $id = $this->request->request->get('id');
        $what = $this->request->request->get('mode');

        $pokemonsExchange->action($this->getUser(), $id, $what);

        return $this->redirectToRoute('game_user_pokemons_exchange');
    }

    /**
     * @Route("/trening", name="activity_training")
     * @param GameTrainingPokemon $training
     *
     * @return Response
     */
    public function trainingWithPokemonsAction(GameTrainingPokemon $training): Response
    {
        return $this->render('game/trainingPokemons.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Trening',
            'training' => $training->checkIfInTraining($this->getUser()),
            'time' => $training->calculateTime($this->getUser())
        ]);
    }

    /**
     * @Route("/trening/start", name="activity_training_start")
     * @param GameTrainingPokemon $training
     *
     * @return Response
     */
    public function trainingWithPokemonsStartAction(GameTrainingPokemon $training): Response
    {
        $user = $this->getUser();
        if ($user->getActivity() != '' && $user->getActivity() != 'training') {
            return $this->redirectToRoute('activity'.$user->getActivity());
        }

        $training->startTraining($this->getUser());

        return $this->redirectToRoute('activity_training');
    }

    /**
     * @Route("/trening/koniec", name="activity_training_stop")
     * @param GameTrainingPokemon $training
     *
     * @return Response
     */
    public function trainingWithPokemonsStopAction(GameTrainingPokemon $training): Response
    {
        $user = $this->getUser();
        if ($user->getActivity() != '' && $user->getActivity() != 'training') {
            return $this->redirectToRoute('activity'.$user->getActivity());
        }

        $training->stopTraining($this->getUser());

        return $this->redirectToRoute('activity_training');
    }

    /**
     * @Route("/game/pokemon/nakarm/{id}", name="game_pokemon_feed")
     * @param int $id
     *
     * @param GamePokemon $pokemonService
     *
     * @return Response
     */
    public function feedPokemon(int $id, GamePokemon $pokemonService): Response
    {
        $pokemonService->feedPokemon($id, $this->getUser(), $this->request->server->get('REMOTE_ADDR'));

        return $this->render('game/pokemonFeed.html.twig');
    }
}
