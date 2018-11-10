<?php
namespace AppBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;

class GameIndex
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getOnline(): int
    {
        return $this->em->getRepository('AppBundle:User')->countOnline();
    }

    public function getLastCaughtPokemons()
    {
        $last = $this->em->getRepository('AppBundle:Pokemon')->getLastCaughtIds();

        $return = [];
        foreach ($last as $pokemon) {
            $return[] = [
                'id' => $pokemon->getIdPokemon(),
                'name' => $pokemon->getName()
            ];
        }
        return $return;
    }
}
