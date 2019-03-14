<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class PokemonTrainingAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('berryLimit')
            ->add('berryAttack')
            ->add('berryDefence')
            ->add('berrySpAttack')
            ->add('berrySpDefence')
            ->add('berrySpeed')
            ->add('tr1')
            ->add('tr2')
            ->add('tr3')
            ->add('tr4')
            ->add('tr5')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('berryLimit')
            ->add('berryAttack')
            ->add('berryDefence')
            ->add('berrySpAttack')
            ->add('berrySpDefence')
            ->add('berrySpeed')
            ->add('tr1')
            ->add('tr2')
            ->add('tr3')
            ->add('tr4')
            ->add('tr5')
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
            ->add('berryLimit')
            ->add('berryAttack')
            ->add('berryDefence')
            ->add('berrySpAttack')
            ->add('berrySpDefence')
            ->add('berrySpeed')
            ->add('tr1')
            ->add('tr2')
            ->add('tr3')
            ->add('tr4')
            ->add('tr5')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('berryLimit')
            ->add('berryAttack')
            ->add('berryDefence')
            ->add('berrySpAttack')
            ->add('berrySpDefence')
            ->add('berrySpeed')
            ->add('tr1')
            ->add('tr2')
            ->add('tr3')
            ->add('tr4')
            ->add('tr5')
        ;
    }
}
