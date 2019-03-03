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

    public function getCatchingSkill(): int
    {
        return $this->catchingSkill;
    }

    public function setCatchingSkill(int $catchingSkill): self
    {
        $this->catchingSkill = $catchingSkill;

        return $this;
    }
}
