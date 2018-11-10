<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Report;
use Doctrine\ORM\EntityManagerInterface;

class Reports
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getReports(int $userId)
    {
        return $this->em->getRepository('AppBundle:Report')->getReports($userId);
    }

    public function markReportsAsRead(int $userId)
    {
        $this->em->getRepository('AppBundle:Report')->markReportsAsRead($userId);
    }

    public function getOneReport(int $userId, int $reportId)
    {
        return $this->em->getRepository('AppBundle:Report')->getOneReport($userId, $reportId);
    }

    public function deleteOneReport(int $userId, int $reportId): bool
    {
        return $this->em->getRepository('AppBundle:Report')->deleteOneReport($userId, $reportId);
    }

    public function getArrayFromReport(Report $report)
    {
        return [
            'status' => 1,
            'title' => $report->getTitle(),
            'body' => $report->getContent()
        ];
    }
}
