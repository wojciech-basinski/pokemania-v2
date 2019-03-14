<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class BerryAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('cheriBerry')
            ->add('chestoBerry')
            ->add('pechaBerry')
            ->add('rawstBerry')
            ->add('aspearBerry')
            ->add('leppaBerry')
            ->add('oranBerry')
            ->add('persimBerry')
            ->add('lumBerry')
            ->add('sitrusBerry')
            ->add('figyBerry')
            ->add('wikiBerry')
            ->add('magoBerry')
            ->add('aguavBerry')
            ->add('lapapaBerry')
            ->add('razzBerry')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('cheriBerry')
            ->add('chestoBerry')
            ->add('pechaBerry')
            ->add('rawstBerry')
            ->add('aspearBerry')
            ->add('leppaBerry')
            ->add('oranBerry')
            ->add('persimBerry')
            ->add('lumBerry')
            ->add('sitrusBerry')
            ->add('figyBerry')
            ->add('wikiBerry')
            ->add('magoBerry')
            ->add('aguavBerry')
            ->add('lapapaBerry')
            ->add('razzBerry')
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
            ->add('cheriBerry')
            ->add('chestoBerry')
            ->add('pechaBerry')
            ->add('rawstBerry')
            ->add('aspearBerry')
            ->add('leppaBerry')
            ->add('oranBerry')
            ->add('persimBerry')
            ->add('lumBerry')
            ->add('sitrusBerry')
            ->add('figyBerry')
            ->add('wikiBerry')
            ->add('magoBerry')
            ->add('aguavBerry')
            ->add('lapapaBerry')
            ->add('razzBerry')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('cheriBerry')
            ->add('chestoBerry')
            ->add('pechaBerry')
            ->add('rawstBerry')
            ->add('aspearBerry')
            ->add('leppaBerry')
            ->add('oranBerry')
            ->add('persimBerry')
            ->add('lumBerry')
            ->add('sitrusBerry')
            ->add('figyBerry')
            ->add('wikiBerry')
            ->add('magoBerry')
            ->add('aguavBerry')
            ->add('lapapaBerry')
            ->add('razzBerry')
        ;
    }
}
