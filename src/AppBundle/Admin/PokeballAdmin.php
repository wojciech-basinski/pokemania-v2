<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class PokeballAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('pokeballs')
            ->add('nestballs')
            ->add('greatballs')
            ->add('ultraballs')
            ->add('duskballs')
            ->add('lureballs')
            ->add('cherishballs')
            ->add('masterballs')
            ->add('repeatballs')
            ->add('safariballs')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('pokeballs')
            ->add('nestballs')
            ->add('greatballs')
            ->add('ultraballs')
            ->add('duskballs')
            ->add('lureballs')
            ->add('cherishballs')
            ->add('masterballs')
            ->add('repeatballs')
            ->add('safariballs')
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
            ->add('pokeballs')
            ->add('nestballs')
            ->add('greatballs')
            ->add('ultraballs')
            ->add('duskballs')
            ->add('lureballs')
            ->add('cherishballs')
            ->add('masterballs')
            ->add('repeatballs')
            ->add('safariballs')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('pokeballs')
            ->add('nestballs')
            ->add('greatballs')
            ->add('ultraballs')
            ->add('duskballs')
            ->add('lureballs')
            ->add('cherishballs')
            ->add('masterballs')
            ->add('repeatballs')
            ->add('safariballs')
        ;
    }
}
