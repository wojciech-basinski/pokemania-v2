<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ItemsAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('mpa')
            ->add('lemonade')
            ->add('soda')
            ->add('water')
            ->add('flashlight')
            ->add('battery')
            ->add('box')
            ->add('pokedex')
            ->add('cookie')
            ->add('bar')
            ->add('kit')
            ->add('pokemonFood')
            ->add('parts')
            ->add('candy')
            ->add('shovel')
            ->add('coins')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('mpa')
            ->add('lemonade')
            ->add('soda')
            ->add('water')
            ->add('flashlight')
            ->add('battery')
            ->add('box')
            ->add('pokedex')
            ->add('cookie')
            ->add('bar')
            ->add('kit')
            ->add('pokemonFood')
            ->add('parts')
            ->add('candy')
            ->add('shovel')
            ->add('coins')
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
            ->add('mpa')
            ->add('lemonade')
            ->add('soda')
            ->add('water')
            ->add('flashlight')
            ->add('battery')
            ->add('box')
            ->add('pokedex')
            ->add('cookie')
            ->add('bar')
            ->add('kit')
            ->add('pokemonFood')
            ->add('parts')
            ->add('candy')
            ->add('shovel')
            ->add('coins')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('mpa')
            ->add('lemonade')
            ->add('soda')
            ->add('water')
            ->add('flashlight')
            ->add('battery')
            ->add('box')
            ->add('pokedex')
            ->add('cookie')
            ->add('bar')
            ->add('kit')
            ->add('pokemonFood')
            ->add('parts')
            ->add('candy')
            ->add('shovel')
            ->add('coins')
        ;
    }
}
