<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SkillRepository")
 */
class Skill
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
     * @var int Catching Pokemon Skill
     *
     * @ORM\Column(name="skill_1", type="smallint")
     */
    private $skill1;

    public function getId(): int
    {
        return $this->id;
    }

    public function setSkill1(int $skill1): self
    {
        $this->skill1 = $skill1;

        return $this;
    }

    public function getSkill1(): int
    {
        return $this->skill1;
    }
}
