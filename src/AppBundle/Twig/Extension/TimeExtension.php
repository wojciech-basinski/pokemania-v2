<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Utils\GameTime;

class TimeExtension extends \Twig_Extension
{
    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('time2string', function ($time) {
                return GameTime::time2string($time);
            }),
        ];
    }

    public function getName()
    {
        return 'time';
    }
}
