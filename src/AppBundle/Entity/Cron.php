<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CronRepository")
 */
class Cron
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $log;

    public function getId(): int
    {
        return $this->id;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setLog($log): self
    {
        $this->log = $log;

        return $this;
    }

    public function getLog(): string
    {
        return $this->log;
    }
}
