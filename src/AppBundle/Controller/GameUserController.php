<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Collection;
use AppBundle\Utils\Friends;
use AppBundle\Utils\GameAchievements;
use AppBundle\Utils\GameExchange;
use AppBundle\Utils\GamePack;
use AppBundle\Utils\GameProfile;
use AppBundle\Utils\GameSettings;
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
    public function gameStatisticsAction(): Response
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
    public function gameAchievementsAction(): Response
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
    public function gameFriendsAction(): Response
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
     * @param int $id
     * @param Friends $friendsService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function gameFriendsDeleteAction(int $id, Friends $friendsService): Response
    {
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
     * @param int $id
     * @param Friends $friendsService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function gameFriendsAcceptAction(int $id, Friends $friendsService): Response
    {
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
     * @param int $id
     * @param Friends $friendsService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function gameFriendsRejectAction(int $id, Friends $friendsService): Response
    {
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
     * @param int $id
     * @param Friends $friendsService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function gameFriendsCancelAction(int $id, Friends $friendsService): Response
    {
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
     * @param int $id
     * @param Friends $friendsService
     *
     * @return Response
     */
    public function gameFriendsAddAction(int $id, Friends $friendsService): Response
    {
        $status = $friendsService->addFriend($id, $this->getUser());

        return new Response((string)$status);
    }

    /**
     * @Route("/kolekcja", name="game_user_collection")
     * @param Collection $collection
     *
     * @return Response
     */
    public function userCollectionAction(Collection $collection): Response
    {
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
    public function userSettingAction(): Response
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
     * @param GameSettings $settings
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function userChangeSettingsAction(GameSettings $settings): Response
    {
        $what = $this->request->get('what') ?? '';
        $value = $this->request->get('value') ?? '';

        $settings->changeSettings($what, $value, $this->getUser());

        return $this->redirectToRoute('game_settings', [
            'active' => $this->request->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/plecak", name="game_user_pack")
     * @Method("GET")
     * @param GamePack $packService
     *
     * @return Response
     */
    public function userPackAction(GamePack $packService): Response
    {
        $userId = $this->getUser()->getId();

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
     * @Route("/plecak/uzyj", name="game_user_pack_use")
     * @param GamePack $pack
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function userPackUseAction(GamePack $pack): Response
    {
        $item = $this->request->get('item') ?? '';
        $value = $this->request->get('value') ?? 1;
        $pokemon = $this->request->get('pokemon') ?? null;

        $pack->useItem($item, $value, $this->getUser(), $pokemon);

        return $this->redirectToRoute('game_user_pack', [
            'active' => $this->request->get('active') ?? 1
        ]);
    }

    /**
     * @Route("/profil/points", name="game_user_profile_points")
     * @Method("POST")
     * @param GameProfile $gameProfile
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function userProfilePointsAction(GameProfile $gameProfile): Response
    {
        $id = (int)$this->request->request->get('i');
        if (!is_numeric($id)) {
            $this->addFlash('error', 'Błędne id umiejętności');
        } else {
            $gameProfile->usePoints($id, $this->getUser());
        }

        return $this->redirectToRoute('game_user_profile', [
            'id' => $this->getUser()->getId()
        ]);
    }

    /**
     * @Route("/profil/{id}", name="game_user_profile")
     * @param GameProfile $profileService
     * @param int $id
     *
     * @return Response
     */
    public function userProfileAction(GameProfile $profileService, int $id = 0): Response
    {
        if (!$id) {
            if ($this->request->request->get('username')) {
                $user = $profileService->getUserProfileFromUsername($this->request->request->get('username'));
            } else {
                $user = $this->getUser();
            }
        } else {
            $user = $profileService->getUserProfile($id, $this->getUser()->getId());
        }

        if ($user) {
            $profileService->setUser($user);
            $team = $profileService->getUsersTeam();
            $badges = $profileService->getBadges();
            $friend = $profileService->getFriend();
            $battle = $profileService->getBattle();
            if ($user->getId() === $this->getUser()->getId()) {
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
     * @Route("/wymiana", name="game_exchange")
     * @Method("GET")
     * @param GameExchange $exchange
     *
     * @return Response
     */
    public function exchangeAction(GameExchange $exchange): Response
    {
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
     * @param GameExchange $exchange
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function exchangeCoinsOrPartsAction(GameExchange $exchange): Response
    {
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
     * @param GameExchange $exchange
     *
     * @return Response
     */
    public function exchangeGetPokemon(GameExchange $exchange): Response
    {
        $id = $this->request->request->get('id') ?? 0;
        $exchange->getPokemon($id, $this->getUser());

        return $this->redirectToRoute('game_exchange');
    }

    /**
     * @Route("/osiagniecia", name="game_achievements")
     * @param GameAchievements $achievements
     *
     * @return Response
     */
    public function achievementsAction(GameAchievements $achievements): Response
    {
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
