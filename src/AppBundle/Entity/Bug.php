<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bug
 *
 * @ORM\Table(name="bug")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BugRepository")
 */
class Bug
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="reported_by", type="integer")
     */
    private $reportedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="done", type="boolean")
     */
    private $done;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reportedBy
     *
     * @param integer $reportedBy
     *
     * @return Bug
     */
    public function setReportedBy($reportedBy)
    {
        $this->reportedBy = $reportedBy;

        return $this;
    }

    /**
     * Get reportedBy
     *
     * @return int
     */
    public function getReportedBy()
    {
        return $this->reportedBy;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Bug
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Bug
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param bool $done
     *
     * @return Bug
     */
    public function setDone(bool $done): Bug
    {
        $this->done = $done;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDone(): bool
    {
        return $this->done;
    }

    /**
     * @param \DateTime $time
     *
     * @return Bug
     */
    public function setTime(\DateTime $time): Bug
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }
}
