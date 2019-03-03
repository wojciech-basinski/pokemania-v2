<?php
namespace AppBundle\Controller;

use AppBundle\Utils\Bugs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameMainController extends Controller
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
     * @Route("/statystyki/dzisiejsze", name="game_statistics_today")
     * @Route("/gra", name="game_index")
     *
     * @return Response
     */
    public function gameIndexAction(): Response
    {
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
     * @param int $desktop
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function desktopAction(int $desktop, SessionInterface $session): Response
    {
        if ($desktop === 1) {
            $session->set('desktop', 1);
        }
        return $this->redirectToRoute('game_index');
    }

    /**
     * @Route("/zglosblad", name="game_bugs")
     * @Method("GET")
     *
     * @return Response
     */
    public function gameBugsAction(): Response
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
     * @param Bugs $bugs
     *
     * @return Response
     */
    public function gameBugsListAction(Bugs $bugs): Response
    {
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
     * @param Bugs $bugs
     *
     * @return Response
     */
    public function gameBugsAddAction(Bugs $bugs): Response
    {
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
     * @param Bugs $bugs
     *
     * @return Response
     */
    public function gameBugsAdminAction(Bugs $bugs): Response
    {
        if (!$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'Nie możesz wykonać tej akcji');
            return $this->redirectToRoute('game_bugs');
        }
        $mode = $this->request->request->get('mode');
        $id = $this->request->request->get('id');
        if ($mode === 'delete') {
            $bugs->delete($id);
        } elseif ($mode === 'resolve') {
            $bugs->setDone($id);
        }
        return $this->redirectToRoute('game_bugs');
    }
}
