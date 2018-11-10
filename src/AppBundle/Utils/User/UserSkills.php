<?php
namespace AppBundle\Utils\User;

class UserSkills
{
    /**
     * @var int
     */
    private $catchingSkill;

    public function __construct($u)
    {
        $this->catchingSkill = $u[0];
    }

    /**
     * @return int
     */
    public function getCatchingSkill(): int
    {
        return $this->catchingSkill;
    }

    /**
     * @param int $catchingSkill
     */
    public function setCatchingSkill(int $catchingSkill)
    {
        $this->catchingSkill = $catchingSkill;
    }
}
