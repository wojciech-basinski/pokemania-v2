<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class PerformanceAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('lapanie')
            ->add('pokonane')
            ->add('trenerzy')
            ->add('zbieranie')
            ->add('hazardzista')
            ->add('szkolenie')
            ->add('trener')
            ->add('nolife')
            ->add('znawcaKanto')
            ->add('znawcaKanto1')
            ->add('znawcaKanto2')
            ->add('znawcaKanto3')
            ->add('znawcaKanto4')
            ->add('znawcaKanto5')
            ->add('znawcaKanto6')
            ->add('znawcaKanto7')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('lapanie')
            ->add('pokonane')
            ->add('trenerzy')
            ->add('zbieranie')
            ->add('hazardzista')
            ->add('szkolenie')
            ->add('trener')
            ->add('nolife')
            ->add('znawcaKanto')
            ->add('znawcaKanto1')
            ->add('znawcaKanto2')
            ->add('znawcaKanto3')
            ->add('znawcaKanto4')
            ->add('znawcaKanto5')
            ->add('znawcaKanto6')
            ->add('znawcaKanto7')
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
            ->add('lapanie')
            ->add('pokonane')
            ->add('trenerzy')
            ->add('zbieranie')
            ->add('hazardzista')
            ->add('szkolenie')
            ->add('trener')
            ->add('nolife')
            ->add('znawcaKanto')
            ->add('znawcaKanto1')
            ->add('znawcaKanto2')
            ->add('znawcaKanto3')
            ->add('znawcaKanto4')
            ->add('znawcaKanto5')
            ->add('znawcaKanto6')
            ->add('znawcaKanto7')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('lapanie')
            ->add('pokonane')
            ->add('trenerzy')
            ->add('zbieranie')
            ->add('hazardzista')
            ->add('szkolenie')
            ->add('trener')
            ->add('nolife')
            ->add('znawcaKanto')
            ->add('znawcaKanto1')
            ->add('znawcaKanto2')
            ->add('znawcaKanto3')
            ->add('znawcaKanto4')
            ->add('znawcaKanto5')
            ->add('znawcaKanto6')
            ->add('znawcaKanto7')
        ;
    }
}
