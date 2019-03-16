<?php
namespace AppBundle\Twig\Extension;

use AppBundle\Utils\LeftTable;

class LeftTableExtension extends \Twig_Extension
{
    /**
     * @var LeftTable
     */
    private $leftTable;

    public function __construct(LeftTable $leftTable)
    {
        $this->leftTable = $leftTable;
    }

    public function getFunctions(): array
    {
        $leftTable = $this->leftTable;
        return [
            new \Twig_SimpleFunction('get_pokemons_from_team', function () use ($leftTable) {
                return $leftTable->getUsersPokemonsInTeam();
            }),
        ];
    }

    public function getName(): string
    {
        return 'get_pokemons_from_team';
    }
}