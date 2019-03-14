<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class AchievementAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('polana')
            ->add('wyspa')
            ->add('grota')
            ->add('domStrachow')
            ->add('gory')
            ->add('wodospad')
            ->add('safari')
            ->add('catchedPokemons')
            ->add('winsWithTrainers')
            ->add('winsWithPokemons')
            ->add('beggedBerrys')
            ->add('catchedPokeball')
            ->add('catchedNestball')
            ->add('catchedGreatball')
            ->add('catchedUltraball')
            ->add('catchedDuskball')
            ->add('catchedLureball')
            ->add('catchedCherishball')
            ->add('catchedRepeatball')
            ->add('catchedSafariball')
            ->add('snacks')
            ->add('loggedIn')
            ->add('trainingsWithPokemons')
            ->add('catchedShiny')
            ->add('wulkan')
            ->add('laka')
            ->add('lodowiec')
            ->add('mokradla')
            ->add('johto5')
            ->add('jezioro')
            ->add('mrocznyLas')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('polana')
            ->add('wyspa')
            ->add('grota')
            ->add('domStrachow')
            ->add('gory')
            ->add('wodospad')
            ->add('safari')
            ->add('catchedPokemons')
            ->add('winsWithTrainers')
            ->add('winsWithPokemons')
            ->add('beggedBerrys')
            ->add('catchedPokeball')
            ->add('catchedNestball')
            ->add('catchedGreatball')
            ->add('catchedUltraball')
            ->add('catchedDuskball')
            ->add('catchedLureball')
            ->add('catchedCherishball')
            ->add('catchedRepeatball')
            ->add('catchedSafariball')
            ->add('snacks')
            ->add('loggedIn')
            ->add('trainingsWithPokemons')
            ->add('catchedShiny')
            ->add('wulkan')
            ->add('laka')
            ->add('lodowiec')
            ->add('mokradla')
            ->add('johto5')
            ->add('jezioro')
            ->add('mrocznyLas')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('id')
            ->add('polana')
            ->add('wyspa')
            ->add('grota')
            ->add('domStrachow')
            ->add('gory')
            ->add('wodospad')
            ->add('safari')
            ->add('catchedPokemons')
            ->add('winsWithTrainers')
            ->add('winsWithPokemons')
            ->add('beggedBerrys')
            ->add('catchedPokeball')
            ->add('catchedNestball')
            ->add('catchedGreatball')
            ->add('catchedUltraball')
            ->add('catchedDuskball')
            ->add('catchedLureball')
            ->add('catchedCherishball')
            ->add('catchedRepeatball')
            ->add('catchedSafariball')
            ->add('snacks')
            ->add('loggedIn')
            ->add('trainingsWithPokemons')
            ->add('catchedShiny')
            ->add('wulkan')
            ->add('laka')
            ->add('lodowiec')
            ->add('mokradla')
            ->add('johto5')
            ->add('jezioro')
            ->add('mrocznyLas')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('polana')
            ->add('wyspa')
            ->add('grota')
            ->add('domStrachow')
            ->add('gory')
            ->add('wodospad')
            ->add('safari')
            ->add('catchedPokemons')
            ->add('winsWithTrainers')
            ->add('winsWithPokemons')
            ->add('beggedBerrys')
            ->add('catchedPokeball')
            ->add('catchedNestball')
            ->add('catchedGreatball')
            ->add('catchedUltraball')
            ->add('catchedDuskball')
            ->add('catchedLureball')
            ->add('catchedCherishball')
            ->add('catchedRepeatball')
            ->add('catchedSafariball')
            ->add('snacks')
            ->add('loggedIn')
            ->add('trainingsWithPokemons')
            ->add('catchedShiny')
            ->add('wulkan')
            ->add('laka')
            ->add('lodowiec')
            ->add('mokradla')
            ->add('johto5')
            ->add('jezioro')
            ->add('mrocznyLas')
        ;
    }
}
