<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class GameMainController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/statystyki/dzisiejsze", name="game_statistics_today")
     * @Route("/gra", name="game_index")
     */
    public function gameIndexAction()
    {
        $this->getDoctrine()->getRepository('AppBundle:User')->addPa();
        $this->getDoctrine()->getRepository('AppBundle:Pokemon')->addHungerToPokemons();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Statistic');
        $statistics = $repository->find($this->getUser()->getId());

        return $this->render(
            'game/statiticsToday.html.twig',
            [
            'ajax' => $this->request->isXmlHttpRequest(),
            'title' => 'Statystyki',
            'statistics' => $statistics,
            ]
        );
    }

    /**
     * @Route("/desktop/{desktop}", name="game_set_desktop_mode")
     */
    public function desktopAction(int $desktop)
    {
        if ($desktop == 1) {
            $this->get('session')->set('desktop', 1);
        }
        return $this->redirectToRoute('game_index');
    }

    /**
     * @Route("/zglosblad", name="game_bugs")
     * @Method("GET")
     */
    public function gameBugsAction()
    {
        return $this->render('game/bugs.html.twig', [
            'title' => 'Zgłoś błąd',
            'ajax' => $this->request->isXmlHttpRequest(),
            'titleBug' => $this->request->query->get('title') ?? '',
            'contentBug' => $this->request->query->get('content') ?? '',
        ]);
    }

    /**
     * @Route("/zglosblad/lista", name="game_bugs_list")
     */
    public function gameBugsListAction()
    {
        $bugs = $this->get('game.bugs');
        $list = $bugs->list($this->getUser());

        return $this->render('game/bugsList.html.twig', [
            'title' => 'Zgłoś błąd',
            'ajax' => $this->request->isXmlHttpRequest(),
            'list' => $list
        ]);
    }

    /**
     * @Route("/zglosblad", name="game_bugs_add")
     * @Method("POST")
     */
    public function gameBugsAddAction()
    {
        $bugs = $this->get('game.bugs');
        $add = $bugs->add(
            $this->request->request->get('title'),
            $this->request->request->get('content'),
            $this->getUser()->getId()
        );
        if ($add) {
            return $this->redirectToRoute('game_bugs');
        }
        return $this->redirectToRoute('game_bugs', [
           'title' => $this->request->request->get('title'),
            'content' => $this->request->request->get('content')
        ]);
    }

    /**
     * @Route("/zglosblad/admin", name="game_bugs_admin")
     * @Method("POST")
     */
    public function gameBugsAdminAction()
    {
        if (!$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'Nie możesz wykonać tej akcji');
            return $this->redirectToRoute('game_bugs');
        }
        $bugs = $this->get('game.bugs');
        $mode = $this->request->request->get('mode');
        $id = $this->request->request->get('id');
        if ($mode == 'delete') {
            $bugs->delete($id);
        } elseif ($mode == 'resolve') {
            $bugs->setDone($id);
        }
        return $this->redirectToRoute('game_bugs');
    }
}
