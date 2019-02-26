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

    public function getReports(int $userId): array
    {
        return $this->em->getRepository('AppBundle:Report')->getReports($userId);
    }

    public function markReportsAsRead(int $userId): void
    {
        $this->em->getRepository('AppBundle:Report')->markReportsAsRead($userId);
    }

    public function getOneReport(int $userId, int $reportId): bool
    {
        return $this->em->getRepository('AppBundle:Report')->getOneReport($userId, $reportId);
    }

    public function deleteOneReport(int $userId, int $reportId): bool
    {
        return $this->em->getRepository('AppBundle:Report')->deleteOneReport($userId, $reportId);
    }

    public function deleteAllReports(int $userId): void
    {
        $this->em->getRepository('AppBundle:Report')->deleteReports($userId);
    }

    public function getArrayFromReport(Report $report): array
    {
        return [
            'status' => 1,
            'title' => $report->getTitle(),
            'body' => $report->getContent()
        ];
    }
}
