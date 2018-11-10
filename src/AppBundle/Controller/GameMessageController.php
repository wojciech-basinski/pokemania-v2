<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class GameMessageController extends Controller
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/raporty", name="game_reports")
     */
    public function showReportsAction()
    {
        $reportsService = $this->get('game.reports');
        $usersReports = $reportsService->getReports($this->getUser()->getId());

        $reportsService->markReportsAsRead($this->getUser()->getId());
        $this->get('session')->get('userSession')->setReports(0);

        return $this->render('game/reports.html.twig', [
            'ajax' => $this->request->isXmlHttpRequest(),
            'reports' => $usersReports,
            'title' => 'Raporty'
        ]);
    }

    /**
     * @Route("/raporty/pokaz/{id}", name="game_reports_show")
     */
    public function showOneReportAction($id)
    {
        $reportsService = $this->get('game.reports');
        $report = $reportsService->getOneReport($this->getUser()->getId(), $id);

        if (!$report) {
            return $this->json([
                'status' => 0
            ]);
        }

        return $this->json($reportsService->getArrayFromReport($report));
    }

    /**
     * @Route("/raporty/usun/{id}", name="game_reports_delete")
     */
    public function deleteOneReportAction($id)
    {
        $reportsService = $this->get('game.reports');
        $status = $reportsService->deleteOneReport($this->getUser()->getId(), $id);

        return $this->json([
            'status' => $status,
            'id' => $id
        ]);
    }

    /**
     * @Route("/raporty/usun/wszystkie/{confirm}", name="game_reports_delete_all")
     */
    public function deleteAllReportsAction(int $confirm = 0)
    {
        die;
        //todo
    }

    /**
     * @Route("/wiadomosci", name="game_messages")
     */
    public function showMessagesAction()
    {
        $messageService = $this->get('game.messages');
        $messages = $messageService->getAllUserMessages($this->getUser()->getId());

        $messageService->markMessagesAsRead($this->getUser()->getId());
        $this->get('session')->get('userSession')->setMessages(0);

        return $this->render('game/messages.html.twig', [
           'ajax' => $this->request->isXmlHttpRequest(),
            'messages' => $messages,
            'title' => 'Wiadomości'
        ]);
    }

    /**
     * @Route("wiadomosci/{id}/{last}", name="game_message_show")
     */
    public function showOneMessageAction(int $id, int $last = 0)
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
     */
    public function announcementAction()
    {
        $countNewAnnouncements = $this->getUser()->getAnnouncements();
        $countAllAnnouncements = $this->get('game.announcement')->countAnnouncements();
        $page = $this->request->query->get('page') ?? 0;
        $announcements = $this->get('game.announcement')->getAnnouncements($page, $this->getUser());

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
