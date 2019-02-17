<?php

namespace AppBundle\Controller;

use AppBundle\Utils\GameAnnouncement;
use AppBundle\Utils\Messages;
use AppBundle\Utils\Reports;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameMessageController extends Controller
{
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showReportsAction(Reports $reportsService, SessionInterface $session)
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showOneReportAction(int $id, Reports $reportsService)
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
     * @Route("/raporty/usun/{id}", name="game_reports_delete")
     * @param int $id
     * @param Reports $reportsService
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteOneReportAction(int $id, Reports $reportsService)
    {
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
     * @param Messages $messageService
     *
     * @param SessionInterface $session
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showMessagesAction(Messages $messageService, SessionInterface $session)
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
     * @param GameAnnouncement $announcement
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function announcementAction(GameAnnouncement $announcement)
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
