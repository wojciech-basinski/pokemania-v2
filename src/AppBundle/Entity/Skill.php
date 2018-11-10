<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table(name="skill")
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


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set skill1.
     *
     * @param int $skill1
     *
     * @return Skill
     */
    public function setSkill1($skill1)
    {
        $this->skill1 = $skill1;

        return $this;
    }

    /**
     * Get skill1.
     *
     * @return int
     */
    public function getSkill1()
    {
        return $this->skill1;
    }
}
