<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class UserTeamAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('pokemon1')
            ->add('pokemon2')
            ->add('pokemon3')
            ->add('pokemon4')
            ->add('pokemon5')
            ->add('pokemon6')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('pokemon1')
            ->add('pokemon2')
            ->add('pokemon3')
            ->add('pokemon4')
            ->add('pokemon5')
            ->add('pokemon6')
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
            ->add('pokemon1')
            ->add('pokemon2')
            ->add('pokemon3')
            ->add('pokemon4')
            ->add('pokemon5')
            ->add('pokemon6')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('pokemon1')
            ->add('pokemon2')
            ->add('pokemon3')
            ->add('pokemon4')
            ->add('pokemon5')
            ->add('pokemon6')
        ;
    }
}
