<?php
namespace AppBundle\Controller;

use AppBundle\Utils\GameAnnouncement;
use AppBundle\Utils\Messages;
use AppBundle\Utils\Reports;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameMessageController extends Controller
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
     * @Route("/raporty", name="game_reports")
     * @param Reports $reportsService
     *
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function showReportsAction(Reports $reportsService, SessionInterface $session): Response
    {
        $usersReports = $reportsService->getReports($this->getUser()->getId());

        $reportsService->markReportsAsRead($this->getUser()->getId());
        $session->get('userSession')->setReports(0);

        return $this->render('game/reports.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'reports' => $usersReports,
            'title' => 'Raporty'
        ]);
    }

    /**
     * @Route("/raporty/pokaz/{id}", name="game_reports_show")
     * @param int $id
     * @param Reports $reportsService
     *
     * @return Response
     */
    public function showOneReportAction(int $id, Reports $reportsService): Response
    {
        $report = $reportsService->getOneReport($this->getUser()->getId(), $id);

        if (!$report) {
            return $this->json([
                'status' => 0
            ]);
        }

        return $this->json($reportsService->getArrayFromReport($report));
    }

    /**
     * @Route("/raporty/usun/wszystkie", name="game_reports_delete_all")
     * @param Reports $reportsService
     *
     * @return Response
     */
    public function deleteAllReportsAction(Reports $reportsService): Response
    {
        $reportsService->deleteAllReports($this->getUser()->getId());

        return $this->json([
            'ok'
        ]);
    }

    /**
     * @Route("/raporty/usun/{id}", name="game_reports_delete")
     * @param int $id
     * @param Reports $reportsService
     *
     * @return Response
     */
    public function deleteOneReportAction(int $id, Reports $reportsService): Response
    {
        $status = $reportsService->deleteOneReport($this->getUser()->getId(), $id);

        return $this->json([
            'status' => $status,
            'id' => $id
        ]);
    }

    /**
     * @Route("/wiadomosci", name="game_messages")
     * @param Messages $messageService
     *
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function showMessagesAction(Messages $messageService, SessionInterface $session): Response
    {
        $messages = $messageService->getAllUserMessages($this->getUser()->getId());

        $messageService->markMessagesAsRead($this->getUser()->getId());
        $session->get('userSession')->setMessages(0);

        return $this->render('game/messages.html.twig', [
           'ajax' => $this->request->isXmlHttpRequest(),
            'messages' => $messages,
            'title' => 'Wiadomości'
        ]);
    }

    /**
     * @Route("wiadomosci/{id}/{last}", name="game_message_show")
     *
     * @return Response
     */
    public function showOneMessageAction(int $id, int $last = 0): Response
    {
        return $this->json([
            'title' => 'userName',
            'messages' => [
                ''
            ]
        ]);
    }

    /**
     * @Route("/ogloszenia", name="game_announcement")
     * @param GameAnnouncement $announcement
     *
     * @return Response
     */
    public function announcementAction(GameAnnouncement $announcement): Response
    {
        $countNewAnnouncements = $this->getUser()->getAnnouncements();
        $countAllAnnouncements = $announcement->countAnnouncements();
        $page = $this->request->query->get('page') ?? 0;
        $announcements = $announcement->getAnnouncements($page, $this->getUser());

        return $this->render('game/announcement.html.twig', [
            'title' => 'Ogłoszenia',
            'ajax' => $this->request->isXmlHttpRequest(),
            'page' => $page+1,
            'count' => $countAllAnnouncements,
            'announcements' => $announcements,
            'notReadAnnouncements' => $countNewAnnouncements
        ]);
    }
}
