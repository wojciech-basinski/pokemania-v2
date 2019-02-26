<?php
namespace AppBundle\Utils;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Hints
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getHint(): string
    {
        $hints = $this->getAllHints();

       return $hints[mt_rand(0, (count($hints)-1))];
    }

    private function getAllHints(): array
    {
        $hints[] = 'Ustawienia stopki możesz zmienić w ustawieniach w zakładce "Wygląd"';
        $hints[] = 'Codziennie w nocy otrzymujesz 2 losy na loterię';
        $hints[] = 'Kolor paneli można zmienić w ustawieniach w zakładce "Wygląd"';
        $hints[] = 'Repeatballe pozwalają na ponowne rzucenie pokeballa przy nieudanej próbie złapania Pokemona';
        $hints[] = 'Latarka nie będzie działać bez baterii';
        $hints[] = 'Kolor tła można zmienić w ustawieniach w zakładce "Wygląd';
        $hints[] = 'Podczas polowania wciśnij \'e\', aby uleczyć swoją drużynę';
        $hints[] = 'Podczas polowania wciśnij \'r\', aby kontynuować wyprawę';
        $hints[] = 'Nie możesz kopać na Safari bez łopaty';
        $hints[] = 'Magneton to najrzadziej występujcy Pokemon, nie zmarnuj okazji, żeby go złapać';

        if ($this->tokenStorage->getToken() && $this->tokenStorage->getToken()->getUser()->getTrainerLevel() > 100) {
            $hints[] = 'Możesz złapać tylko po jednej sztuce każdej legendy';
            $hints[] = 'Od 100 poziomu trenera możesz spotkać w dziczy legendy';
            $hints[] = 'Legendy spotkasz tylko jeśli złapiesz wszystkie pozostałe występujące w dziczy Pokemony';
        }

        return $hints;
    }
}