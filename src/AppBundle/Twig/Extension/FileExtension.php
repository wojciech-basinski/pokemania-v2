<?php
namespace AppBundle\Twig\Extension;

class FileExtension extends \Twig_Extension
{
    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('file_exists', 'file_exists'),
        ];
    }

    public function getName(): string
    {
        return 'app_file';
    }
}
