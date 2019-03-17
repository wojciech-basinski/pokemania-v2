<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class PokemonAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('idPokemon')
            ->add('name')
            ->add('level')
            ->add('exp')
            ->add('shiny')
            ->add('owner')
            ->add('attack')
            ->add('defence')
            ->add('spAttack')
            ->add('spDefence')
            ->add('speed')
            ->add('hp')
            ->add('accuracy')
            ->add('team')
            ->add('actualHp')
            ->add('attack0')
            ->add('attack1')
            ->add('attack2')
            ->add('attack3')
            ->add('ewolution')
            ->add('gender')
            ->add('value')
            ->add('attachment')
            ->add('dateOfCatch')
            ->add('block')
            ->add('lottery')
            ->add('berrysHp')
            ->add('snacks')
            ->add('market')
            ->add('blockView')
            ->add('hunger')
            ->add('tr6')
            ->add('description')
            ->add('firstOwner')
            ->add('exchange')
            ->add('catched')
            ->add('quality')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('idPokemon')
            ->add('name')
            ->add('level')
            ->add('exp')
            ->add('shiny')
            ->add('owner')
            ->add('attack')
            ->add('defence')
            ->add('spAttack')
            ->add('spDefence')
            ->add('speed')
            ->add('hp')
            ->add('accuracy')
            ->add('team')
            ->add('actualHp')
            ->add('attack0')
            ->add('attack1')
            ->add('attack2')
            ->add('attack3')
            ->add('ewolution')
            ->add('gender')
            ->add('value')
            ->add('attachment')
            ->add('dateOfCatch')
            ->add('block')
            ->add('lottery')
            ->add('berrysHp')
            ->add('snacks')
            ->add('market')
            ->add('blockView')
            ->add('hunger')
            ->add('tr6')
            ->add('description')
            ->add('firstOwner')
            ->add('exchange')
            ->add('catched')
            ->add('quality')
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
            ->add('idPokemon')
            ->add('name')
            ->add('level')
            ->add('exp')
            ->add('shiny')
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'login',
            ])
            ->add('attack')
            ->add('defence')
            ->add('spAttack')
            ->add('spDefence')
            ->add('speed')
            ->add('hp')
            ->add('accuracy')
            ->add('team')
            ->add('actualHp')
            ->add('attack0')
            ->add('attack1')
            ->add('attack2')
            ->add('attack3')
            ->add('ewolution')
            ->add('gender')
            ->add('value')
            ->add('attachment')
            ->add('dateOfCatch')
            ->add('block')
            ->add('lottery')
            ->add('berrysHp')
            ->add('snacks')
            ->add('market')
            ->add('blockView')
            ->add('hunger')
            ->add('tr6')
            ->add('description', null, [
                'required' => false
            ])
            ->add('firstOwner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'login',
            ])
            ->add('exchange')
            ->add('catched')
            ->add('quality')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('idPokemon')
            ->add('name')
            ->add('level')
            ->add('exp')
            ->add('shiny')
            ->add('owner')
            ->add('attack')
            ->add('defence')
            ->add('spAttack')
            ->add('spDefence')
            ->add('speed')
            ->add('hp')
            ->add('accuracy')
            ->add('team')
            ->add('actualHp')
            ->add('attack0')
            ->add('attack1')
            ->add('attack2')
            ->add('attack3')
            ->add('ewolution')
            ->add('gender')
            ->add('value')
            ->add('attachment')
            ->add('dateOfCatch')
            ->add('block')
            ->add('lottery')
            ->add('berrysHp')
            ->add('snacks')
            ->add('market')
            ->add('blockView')
            ->add('hunger')
            ->add('tr6')
            ->add('description')
            ->add('firstOwner')
            ->add('exchange')
            ->add('catched')
            ->add('quality')
        ;
    }
}
