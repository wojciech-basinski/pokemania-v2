<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class StonesAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('fireStone')
            ->add('waterStone')
            ->add('leafStone')
            ->add('thunderStone')
            ->add('moonStone')
            ->add('sunStone')
            ->add('runes')
            ->add('obsydian')
            ->add('belt')
            ->add('ectoplasm')
            ->add('philosophicalStone')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('fireStone')
            ->add('waterStone')
            ->add('leafStone')
            ->add('thunderStone')
            ->add('moonStone')
            ->add('sunStone')
            ->add('runes')
            ->add('obsydian')
            ->add('belt')
            ->add('ectoplasm')
            ->add('philosophicalStone')
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
            ->add('fireStone')
            ->add('waterStone')
            ->add('leafStone')
            ->add('thunderStone')
            ->add('moonStone')
            ->add('sunStone')
            ->add('runes')
            ->add('obsydian')
            ->add('belt')
            ->add('ectoplasm')
            ->add('philosophicalStone')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('fireStone')
            ->add('waterStone')
            ->add('leafStone')
            ->add('thunderStone')
            ->add('moonStone')
            ->add('sunStone')
            ->add('runes')
            ->add('obsydian')
            ->add('belt')
            ->add('ectoplasm')
            ->add('philosophicalStone')
        ;
    }
}
