<?php

namespace AppBundle\Twig\Extension;

class ChangeString extends \Twig_Extension
{
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('changeString', function (string $text) {
                $search = [
                    'alert.info',
                    'alert.info.b',
                    'alert.runda',
                    '/sdiv'

                ];
                $replace = [
                    '<div class="walka_alert alert alert-info"><span>',
                    '<div class="walka_alert alert alert-info"><span class="pogrubienie">',
                    '<div class="alert alert-runda text-center margin-top"><span>',
                    '</span></div>'
                ];
                return str_replace($search, $replace, $text);
            }),
        ];
    }

    public function getName(): string
    {
        return 'change_string';
    }
}
