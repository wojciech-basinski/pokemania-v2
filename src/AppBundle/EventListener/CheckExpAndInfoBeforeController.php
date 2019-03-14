<?php
namespace AppBundle\EventListener;

use AppBundle\Controller\OtherSpecialController;
use AppBundle\Entity\Pokemon;
use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use AppBundle\Utils\AuthenticationService;
use AppBundle\Utils\Collection;
use AppBundle\Utils\PokemonHelper;
use AppBundle\Utils\UserExperience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CheckExpAndInfoBeforeController implements EventSubscriberInterface
{
    /**
     * @var Session
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var UserExperience
     */
    private $userExperience;
    /**
     * @var AuthenticationService
     */
    private $auth;
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        UserExperience $userExperience,
        AuthenticationService $auth,
        PokemonHelper $pokemonHelper,
        RouterInterface $router,
        RequestStack $request,
        Collection $collection
    ) {
        $this->session = $session;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->userExperience = $userExperience;
        $this->auth = $auth;
        $this->pokemonHelper = $pokemonHelper;
        $this->router = $router;
        $this->request = $request->getCurrentRequest();
        $this->collection = $collection;
    }

    public function onKernelController(FilterControllerEvent $event): void
    {
        $controller = $event->getController();
        if (!\is_array($controller) || !$controller[0] instanceof OtherSpecialController) {
            if ($this->tokenStorage->getToken() &&
                $this->tokenStorage->getToken()->getUser() instanceof User
            ) {
                $user = $this->tokenStorage->getToken()->getUser();
                $this->checkUserExp($user);
                if (!$this->getUserSession($user) &&
                    !$this->request->cookies->has('REMEMBERME')
                ) {
                    $logoutUrl = $this->router->generate('logout');
                    $event->setController(function () use ($logoutUrl) {
                        return new RedirectResponse($logoutUrl);
                    });
                }
                $this->checkUserOnline($user);
                $this->checkPokemonsExp($user);
                $messages = $this->auth->setUserMessages($this->tokenStorage->getToken()->getUser()->getId());
                $reports = $this->auth->setUserReports($this->tokenStorage->getToken()->getUser()->getId());
                $this->session->get('userSession')->setMessages($messages);
                $this->session->get('userSession')->setReports($reports);
                $this->em->flush();
            }
        }
        $event->stopPropagation();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    private function checkUserExp(User $user): void
    {
        $expOnNextLevel = $this->session->get('userSession')->getExpOnNextLevel();
        if ($user->getExperience() >= $expOnNextLevel) {
            $points = $this->addPoints($user);
            $this->addMessage($user, $points);
            $user->setTrainerLevel($user->getTrainerLevel() + 1);
            $user->setExperience($user->getExperience() - $expOnNextLevel);
            $this->session->get('userSession')
                ->setExpOnNextLevel($this->userExperience->getExperienceOnLevel($user->getTrainerLevel()));
        }
    }

    private function checkPokemonsExp(User $user): void
    {
        if ($user->getPokemonFeeded()) {
            $user->setPokemonFeeded(false);
            $this->clearPokemonsInSession();
            $this->auth->pokemonsToTeam($user->getId());
        }
        $pokemonLevelUpCounter = 0;
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                $pokemon = $this->session->get('pokemon'.$i);
                while ($pokemon->getExp() >= $pokemon->getExpOnLevel() && $pokemon->getLevel() < 100) {
                    $pokemonLevelUpCounter++;
                    /** @var Pokemon $pokemon */
                    $pokemon = $this->em->merge($pokemon);

                    $evolution = $this->checkEvolution($pokemon);
                    $nameChanged = $this->checkName($pokemon);
                    if ($evolution) {
                        $huge = 4;
                    } else {
                        $huge = 1;
                    }
                    $increase = $this->pokemonHelper->getIncrease($pokemon->getIdPokemon());
                    $this->addStatistics($increase, $huge, $pokemon, $nameChanged);
                }
            }
        }
        if ($pokemonLevelUpCounter > 0) {
            $this->clearPokemonsInSession();
            $this->auth->pokemonsToTeam($user->getId());
        }
    }

    private function addPoints(User $user): int
    {
        if ($user->getTrainerLevel() <= 10) {
            $points = 2;
        } elseif ($user->getTrainerLevel() <= 20) {
            $points = 3;
        } elseif ($user->getTrainerLevel() <= 30) {
            $points = 4;
        } else {
            $points = 5;
        }
        $user->setPoints($user->getPoints() + $points);
        return $points;
    }

    private function addMessage(User $user, int $points): void
    {
        $water = 0;
        if ($user->getTrainerLevel() < 11) {
            $lemonade = 1;
            $water = 3;
        } elseif ($user->getTrainerLevel() < 21) {
            $lemonade = 2;
            $water = 6;
        } elseif ($user->getTrainerLevel() < 51) {
            $lemonade = 2;
        } else {
            $lemonade = 3;
        }

        $this->addItems($lemonade, $water, $user->getId());

        $report = new Report();
        $report->setTitle('Nowy poziom trenera ('.($user->getTrainerLevel() + 1).')');
        $report->setTime(new \DateTime());
        $report->setIsRead(0);
        $report->setUserId($user->getId());
        $raport = '<div class="row nomargin text-center"><div class="col-xs-12">
Awansowałeś na kolejny, ' . ($user->getTrainerLevel() + 1) . ' poziom.</div><div class="col-xs-12"> 
Otrzymujesz '.$points.' punkty umiejętności.</div><div class="col-xs-12">';
        if ($lemonade === 1) {
            $raport .= 'Otrzymujesz także '.$lemonade.' lemoniadę';
        } else {
            $raport .= 'Otrzymujesz także '.$lemonade.' lemoniady';
        }
        if ($water) {
            if ($water === 3) {
                $raport .= ' oraz '.$water.' puszki wody.';
            } else {
                $raport .= ' oraz '.$water.' puszek wody.';
            }
        } else {
            $raport .= ".";
        }
        $raport .= '</div></div>';
        $report->setContent($raport);
        $this->em->persist($report);
    }

    private function addItems(int $lemonade, int $water, int $userId): void
    {
        $userItems = $this->em->getRepository('AppBundle:Items')->find($userId);
        $userItems->setLemonade($userItems->getLemonade() + $lemonade);
        $userItems->setWater($userItems->getWater() + $water);
    }

    private function checkEvolution(Pokemon $pokemon): bool
    {
        if (!$pokemon->getEwolution() && $this->pokemonHelper->getInfo($pokemon->getIdPokemon())['lvlEvolution']) {
            //sprawdzenie ewolucji
            $id = $this->pokemonHelper->getInfo($pokemon->getIdPokemon())['lvlEvolution'];///zeby pobrac id ewo
            if ($id === 80000199) {
                $id = 80;
                //$pokemon->setEwolution(80);
            }//slowpoke
            if ($id > 10000) {
                return false;
                //brak ewo przez poziom.
            } else {
                $data = $this->pokemonHelper->getInfo($id);
            }
            //sprawdzenie warunków ewo
            if (($data['minLevel'] <= ($pokemon->getLevel()+1)) && $data['requirements'] != 999) {
                switch ($data['requirements']) {
                    case 998:
                        if ($pokemon->getCountedAttachment() >= 90) {
                            $pokemon->setIdPokemon($id);
                            return true;
                        }
                        return false;
                    case 0:
                        $pokemon->setIdPokemon($id);
                        return true;
                }
            }
        }
        return false;
    }

    private function addStatistics(array $increase, int $huge, Pokemon $pokemon, bool $nameChanged): void
    {
        $attack = $huge * $increase['attack'];
        $spAttack = $huge * $increase['spAttack'];
        $defence = $huge * $increase['defence'];
        $spDefence = $huge * $increase['spDefence'];
        $speed = $huge * $increase['speed'];
        $hp = $huge * $increase['hp'];

        $pokemon->setAttack($pokemon->getAttack() + $attack);
        $pokemon->setSpAttack($pokemon->getSpAttack() + $spAttack);
        $pokemon->setDefence($pokemon->getDefence() + $defence);
        $pokemon->setSpDefence($pokemon->getSpDefence() + $spDefence);
        $pokemon->setSpeed($pokemon->getSpeed() + $speed);
        $pokemon->setHp($pokemon->getHp() + $hp);
        $pokemon->setActualHp($pokemon->getHpToTable());

        $pokemon->setLevel($pokemon->getLevel() + 1);
        $pokemon->setExp($pokemon->getExp() - $pokemon->getExpOnLevel());
        $pokemon->setExpOnLevel($this->pokemonHelper->getExperienceOnLevel($pokemon->getLevel()));

        $report = new Report();
        $report->setTime(new \DateTime);
        $report->setUserId($this->tokenStorage->getToken()->getUser()->getId());
        $report->setIsRead(0);

        $oldName = $pokemon->getName();
        if ($huge === 4) { //ewolucja
            $newName = $this->pokemonHelper->getInfo($pokemon->getIdPokemon())['name'];
            if (!$nameChanged) {
                $pokemon->setName($newName);
            }
            $report->setTitle('Twój Pokemon '.$oldName.' ewoluował w '.$newName.'.');
            $content = '<div class="row nomargin text-center"><div class="col-xs-12">
Twój Pokemon <span class="pogrubienie">'.$oldName.'</span> ewoluował w 
<span class="pogrubienie">'.$newName.'</span>.</div>
                <div class="col-xs-12 pogrubienie">';
            $this->checkCollection($pokemon);
        } else {
            $report->setTitle('Twój Pokemon '.$oldName.' awansował na kolejny, '.$pokemon->getLevel().' poziom.');
            $content = '<div class="row nomargin text-center"><div class="col-xs-12">
Twój Pokemon <span class="pogrubienie">'.$oldName.'</span> awansował na kolejny, '.$pokemon->getLevel().' poziom.</div>
                <div class="col-xs-12 pogrubienie">';
        }
        if ($pokemon->getGender() === 1) {
            $content .= 'Jej';
        } else {
            $content .= 'Jego';
        }
        $content .= ' statystyki rosną:</div><div class="col-xs-12"><div class="row nomargin">
            <div class="col-xs-4">Atak +'.$attack.'</div><div class="col-xs-4">
            Sp. Atak +'.$spAttack.'</div><div class="col-xs-4">Obrona +'.$defence.'</div></div></div> 
            <div class="col-xs-12"><div class="row nomargin">
            <div class="col-xs-4">Sp.Obrona +'.$spDefence.'</div><div class="col-xs-4">Szybkość +'.$speed.'</div>
            <div class="col-xs-4">HP +'.$hp.'</div></div></div></div>';
        $report->setContent($content);

        $this->em->persist($pokemon);
        $this->em->persist($report);
    }

    private function checkName(Pokemon $pokemon): bool
    {
        $data = $this->pokemonHelper->getInfo($pokemon->getIdPokemon());
        return $data['name'] === $pokemon->getName();
    }

    private function checkCollection(Pokemon $pokemon): void
    {
        if (in_array($pokemon->getIdPokemon(), [148, 149, 139, 141])) {
            $this->collection->addOneToPokemonCatchAndMet(
                $pokemon->getIdPokemon(),
                $this->tokenStorage->getToken()->getUser()->getId()
            );
        }
    }

    private function clearPokemonsInSession(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->session->remove('pokemon'.$i);
        }
    }

    private function getUserSession(User $user): bool
    {
        if ($user->getSessionId() && $user->getSessionId() === $this->session->getId()) {
            return 1;
        }
        return 0;
    }

    private function checkUserOnline(User $user): void
    {
        $time = time() - $user->getLastActive();
        $user->setLastActive(time());
        $user->setOnline($user->getOnline() + $time);
        $user->setOnlineToday($user->getOnlineToday() + $time);
    }
}
