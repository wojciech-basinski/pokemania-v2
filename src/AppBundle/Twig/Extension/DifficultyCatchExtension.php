<?php
namespace AppBundle\Twig\Extension;

class DifficultyCatchExtension extends \Twig_Extension
{
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('catchDifficulty', function ($difficulty) {
                switch ($difficulty) {
                    case 1:
                        return 'bardzo łatwa';
                    case 2:
                        return 'łatwa';
                    case 3:
                        return 'średnia';
                    case 4:
                        return 'średnio trudna';
                    case 5:
                        return 'trudna';
                    case 6:
                        return 'bardzo trudna';
                    default:
                        return 'Niemożliwy do złapania';
                }
            }),
        ];
    }

    public function getName(): string
    {
        return 'catchDifficulty';
    }
}