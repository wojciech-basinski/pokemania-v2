<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Utils\PokemonHelper;

class PokemonInfoExtension extends \Twig_Extension
{

    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    public function __construct(PokemonHelper $pokemonHelper)
    {
        $this->pokemonHelper = $pokemonHelper;
    }
    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('pokemonInfo', function ($id) {
                return $this->pokemonHelper->getInfo($id);
            }),
        ];
    }

    public function getName()
    {
        return 'pokemonInfo';
    }
}
