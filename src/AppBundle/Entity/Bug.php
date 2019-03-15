<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, fetch="EAGER")
     */
    private $reportedBy;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    private $done;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $time;


    public function getId(): int
    {
        return $this->id;
    }

    public function setReportedBy(User $reportedBy): self
    {
        $this->reportedBy = $reportedBy;

        return $this;
    }

    public function getReportedBy(): User
    {
        return $this->reportedBy;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setDone(bool $done): Bug
    {
        $this->done = $done;

        return $this;
    }

    public function getDone(): bool
    {
        return $this->done;
    }

    public function setTime(\DateTime $time): Bug
    {
        $this->time = $time;

        return $this;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }
}
