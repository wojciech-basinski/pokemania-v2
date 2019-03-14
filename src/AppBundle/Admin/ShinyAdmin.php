<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ShinyAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('region')
            ->add('pokemonId')
            ->add('quantity')
            ->add('caught')
            ->add('place')
            ->add('chance')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('region')
            ->add('pokemonId')
            ->add('quantity')
            ->add('caught')
            ->add('place')
            ->add('chance')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => []
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('id')
            ->add('region')
            ->add('pokemonId')
            ->add('quantity')
            ->add('caught')
            ->add('place')
            ->add('chance')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('region')
            ->add('pokemonId')
            ->add('quantity')
            ->add('caught')
            ->add('place')
            ->add('chance')
        ;
    }
}
