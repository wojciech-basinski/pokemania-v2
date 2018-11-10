<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

class GameUserController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/statystyki/ogolne", name="game_statistics")
     */
    public function gameStatisticsAction()
    {
        $statistics  = $this->getDoctrine()->getRepository('AppBundle:Achievement')->find($this->getUser()->getId());

        return $this->render('game/statistics.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Statystyki',
            'statistics' => $statistics
        ]);
    }

    /**
    * @Route("/osiagniecia", name="game_achievements")
    */
    public function gameAchievementsAction()
    {
        $achievements  = $this->getDoctrine()->getRepository('AppBundle:Achievement')->find($this->getUser()->getId());

        return $this->render('game/achievements.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Statystyki ogólne',
            'statistics' => $achievements
        ]);
    }

    /**
     * @Route("/znajomi", name="game_friends")
     */
    public function gameFriendsAction()
    {
        $friendsRepository = $this->getDoctrine()->getRepository('AppBundle:Friend');

        $friends = $friendsRepository->getAllFriends($this->getUser()->getId());
        $invitations = $friendsRepository->getAllInvitations($this->getUser()->getId());
        $invitationsSent = $friendsRepository->getAllSentInvitations($this->getUser()->getId());

        return $this->render('game/friends.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Znajomi',
            'friends' => $friends,
            'invitations' => $invitations,
            'invitationsSent' => $invitationsSent
        ]);
    }

    /**
     * @Route("/znajomi/usun/{id}", name="game_friends_delete")
     */
    public function gameFriendsDeleteAction(int $id)
    {
        $friendsService = $this->get('game.friends');
        $status = $friendsService->deleteFriendship($id, $this->getUser()->getId(), $this->getUser()->getLogin());

        if ($status) {
            $this->addFlash('success', 'Z powodzeniem usunięto znajomość.');
        } else {
            $this->addFlash('error', 'Niepowodzenie podczas usuwania znajomości.');
        }

        return $this->redirectToRoute('game_friends');
    }

    /**
     * @Route("/znajomi/akceptuj/{id}", name="game_friends_accept")
     */
    public function gameFriendsAcceptAction(int $id)
    {
        $friendsService = $this->get('game.friends');
        $status = $friendsService->acceptFriendship($id, $this->getUser()->getId(), $this->getUser()->getLogin());

        if ($status) {
            $this->addFlash('success', 'Z powodzeniem zaakceptowano znajomość.');
        } else {
            $this->addFlash('error', 'Niepowodzenie podczas akceptacji znajomości.');
        }

        return $this->redirectToRoute('game_friends');
    }

    /**
     * @Route("/znajomi/odrzuc/{id}", name="game_friends_reject")
     */
    public function gameFriendsRejectAction(int $id)
    {
        $friendsService = $this->get('game.friends');
        $status = $friendsService->rejectFriendship($id, $this->getUser()->getId(), $this->getUser()->getLogin());

        if ($status) {
            $this->addFlash('success', 'Z powodzeniem odrzucono zaproszenie.');
        } else {
            $this->addFlash('error', 'Niepowodzenie podczas odrzucania zaproszenie.');
        }

        return $this->redirectToRoute('game_friends');
    }

    /**
     * @Route("/znajomi/anuluj/{id}", name="game_friends_cancel")
     */
    public function gameFriendsCancelAction(int $id)
    {
        $friendsService = $this->get('game.friends');
        $status = $friendsService->cancelInvitation($id, $this->getUser()->getId(), $this->getUser()->getLogin());

        if ($status) {
            $this->addFlash('success', 'Z powodzeniem anulowano zaproszenie.');
        } else {
            $this->addFlash('error', 'Niepowodzenie podczas anulowania zaproszenia.');
        }

        return $this->redirectToRoute('game_friends');
    }

    /**
     * @Route("/znajomi/dodaj/{id}", name="game_friends_add")
     */
    public function gameFriendsAddAction(int $id)
    {
        $friendsService = $this->get('game.friends');
        $status = $friendsService->addFriend($id, $this->getUser());

        return new Response((string)$status);
    }

    /**
     * @Route("/kolekcja", name="game_user_collection")
     */
    public function userCollectionAction()
    {
        $collection = $this->get('game.collection');
        $collectionAsArray = $collection->getUserCollection($this->getUser()->getId());

        return $this->render('game/collection.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Kolekcja',
            'collection' => $collectionAsArray
        ]);
    }

    /**
     * @Route("/ustawienia", name="game_settings")
     * @Method("GET")
     */
    public function userSettingAction()
    {
        return $this->render('game/settings.html.twig', [
            'title' => 'Ustawienia',
            'ajax' => $this->request->isXmlHttpRequest(),
            'active' => $this->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/ustawienia", name="game_settings_change")
     * @Method("POST")
     */
    public function userChangeSettingsAction()
    {
        $what = $this->request->get('what') ?? '';
        $value = $this->request->get('value') ?? '';

        $settings = $this->get('game.settings');
        $settings->changeSettings($what, $value, $this->getUser());

        return $this->redirectToRoute('game_settings', [
            'active' => $this->request->get('active') ?? 1 //FIXME nie używać get() w kontrolerze !!!
        ]);
    }

    /**
     * @Route("/plecak", name="game_user_pack")
     * @Method("GET")
     */
    public function userPackAction()
    {
        $userId = $this->getUser()->getId();
        $packService = $this->get('game.pack');

        $pokeballs = $packService->getPokeballs($userId);
        $berrys = $packService->getBerrys($userId);
        $stones = $packService->getStones($userId);
        $items = $packService->getItems($userId);
        $pokemonsToSelect = $packService->getPokemonsToSelect();
        //$cards = $packService->getCards($userId);

        return $this->render('game/pack.html.twig', [
            'title' => 'Plecak',
            'ajax' => $this->request->isXmlHttpRequest(),
            'pokeballs' => $pokeballs,
            'berrys' => $berrys,
            'stones' => $stones,
            'items' => $items,
            'active' => $this->request->get('active') ?? 1,
            'pokemonsToSelect' => $pokemonsToSelect,
            'pokeballsDescription' => $packService->getPokemonDescriptions(),
            'berrysDescription' => $packService->getBerrysDescriptions(),
            'stonesDescription' => $packService->getStonesDescriptions()
            //'cards' => $cards
        ]);
    }

    /**
     * @Route("/plecak", name="game_user_pack_use")
     * @Method("POST")
     */
    public function userPackUseAction()
    {
        $item = $this->request->get('item') ?? '';
        $value = $this->request->get('value') ?? 1;
        $pokemon = $this->request->get('pokemon') ?? '';

        $pack = $this->get('game.pack');
        $pack->useItem($item, $value, $this->getUser(), $pokemon);

        return $this->redirectToRoute('game_user_pack', [
            'active' => $this->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/profil/{id}", name="game_user_profile")
     * @Method("GET")
     */
    public function userProfileAction(int $id = 0)
    {
        $profileService = $this->get('game.profile');
        if (!$id) {
            $user = $this->getUser();
            $profileService->setUser($user);
        } else {
            $user = $profileService->getUserProfile($id, $this->getUser()->getId());
        }

        if ($user) {
            $team = $profileService->getUsersTeam();
            $badges = $profileService->getBadges();
            $friend = $profileService->getFriend();
            $battle = $profileService->getBattle();
            if ($user->getId() == $this->getUser()->getId()) {
                $skills = $profileService->getUserSkills();
            }
        }

        return $this->render('game/profile.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Profil gracza',
            'user' => $user,
            'team' => $team ?? null,
            'badges' => $badges ?? null,
            'battle' => $battle ?? null,
            'friend' => $friend ?? null,
            'skills' => $skills ?? null
        ]);
    }
    /**
     * @Route("/profil", name="game_user_profile_points")
     * @Method("POST")
     */
    public function userProfilePointsAction()
    {
        $id = (int)$this->request->request->get('i');
        if (!is_numeric($id)) {
            $this->addFlash('error', 'Błędne id umiejętności');
        } else {
            $this->get('game.profile')->usePoints($id, $this->getUser());
        }

        return $this->redirectToRoute('game_user_profile', [
            'id' => $this->getUser()->getId()
        ]);
    }

    /**
     * @Route("/wymiana", name="game_exchange")
     * @Method("GET")
     */
    public function exchangeAction()
    {
        $exchange = $this->get('game.exchange');

        return $this->render('game/exchange.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Wymiana',
            'active' => $this->request->query->get('active') ?? 1,
            'pokemonsInExchange' => $exchange->getPokemonsInExchange($this->getUser()),
            'parts' => $exchange->getParts($this->getUser()),
            'coins' => $exchange->getCoins($this->getUser())
        ]);
    }

    /**
     * @Route("/wymiana", name="game_exchange_action")
     * @Method("POST")
     */
    public function exchangeCoinsOrPartsAction()
    {
        $exchange = $this->get('game.exchange');
        $id = $this->request->request->get('id');
        $confirm = $this->request->request->get('confirm') ?? 0;
        if ($this->request->request->get('parts')) {
            $exchange->parts($id, $confirm, $this->getUser());
        } else {
            $exchange->coins($id, $confirm, $this->getUser());
        }

        return $this->redirectToRoute('game_exchange', [
            'active' => $this->request->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/wymiana/odbierz", name="game_exchange_get_pokemon")
     * @Method("POST")
     */
    public function exchangeGetPokemon()
    {
        $exchange = $this->get('game.exchange');
        $id = $this->request->request->get('id') ?? 0;
        $exchange->getPokemon($id, $this->getUser());

        return $this->redirectToRoute('game_exchange');
    }

    /**
     * @Route("/osiagniecia", name="game_achievements")
     */
    public function achievementsAction()
    {
        $achievements = $this->get('game.achievements');
        $achievements->execute($this->getUser());

        return $this->render('game/achievements.html.twig', [
            'title' => 'Osiągnięcia',
            'ajax' => $this->request->isXmlHttpRequest(),
            'main' => $achievements->getMain(),
            'secondary' => $achievements->getSecondary(),
            'kanto' => $achievements->getKanto(),
            'kantoMaster' => $achievements->getKantoMaster()
        ]);
    }
}
