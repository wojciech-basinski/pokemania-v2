<?php
namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LeftTable
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getUsersPokemonsInTeam(): array
    {
        $pokemon = [];
        for ($i = 0; $i < 6; $i++) {
            if ($this->session->get('pokemon'.$i)) {
                $pokemon[] = $this->session->get('pokemon'.$i);
            }
        }
        return $pokemon;
    }
}
