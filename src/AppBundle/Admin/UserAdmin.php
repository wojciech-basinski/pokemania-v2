<?php

declare(strict_types=1);

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class UserAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('login')
            ->add('password')
            ->add('email')
            ->add('cash')
            ->add('trainerLevel')
            ->add('experience')
            ->add('points')
            ->add('mpa')
            ->add('pa')
            ->add('ban')
            ->add('banDate')
            ->add('banReason')
            ->add('region')
            ->add('admin')
            ->add('magazine')
            ->add('avatar')
            ->add('lastActive')
            ->add('lastActiveSec')
            ->add('loggedToday')
            ->add('loggedInRow')
            ->add('settings')
            ->add('announcements')
            ->add('club')
            ->add('online')
            ->add('onlineToday')
            ->add('berryPa')
            ->add('shinyCatched')
            ->add('travelledToday')
            ->add('description')
            ->add('pokemonFeeded')
            ->add('pokemonFeededIp')
            ->add('tutorial')
            ->add('badges')
            ->add('sessionId')
            ->add('activity')
            ->add('activityTime')
            ->add('ip')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('login')
            ->add('password')
            ->add('email')
            ->add('cash')
            ->add('trainerLevel')
            ->add('experience')
            ->add('points')
            ->add('mpa')
            ->add('pa')
            ->add('ban')
            ->add('banDate')
            ->add('banReason')
            ->add('region')
            ->add('admin')
            ->add('magazine')
            ->add('avatar')
            ->add('lastActive')
            ->add('lastActiveSec')
            ->add('loggedToday')
            ->add('loggedInRow')
            ->add('settings')
            ->add('announcements')
            ->add('club')
            ->add('online')
            ->add('onlineToday')
            ->add('berryPa')
            ->add('shinyCatched')
            ->add('travelledToday')
            ->add('description')
            ->add('pokemonFeeded')
            ->add('pokemonFeededIp')
            ->add('tutorial')
            ->add('badges')
            ->add('sessionId')
            ->add('activity')
            ->add('activityTime')
            ->add('ip')
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
            ->add('login')
            ->add('password')
            ->add('email')
            ->add('cash')
            ->add('trainerLevel')
            ->add('experience')
            ->add('points')
            ->add('mpa')
            ->add('pa')
            ->add('ban')
            ->add('banDate')
            ->add('banReason')
            ->add('region')
            ->add('admin')
            ->add('magazine')
            ->add('avatar')
            ->add('lastActive')
            ->add('lastActiveSec')
            ->add('loggedToday')
            ->add('loggedInRow')
            ->add('settings')
            ->add('announcements')
            ->add('club')
            ->add('online')
            ->add('onlineToday')
            ->add('berryPa')
            ->add('shinyCatched')
            ->add('travelledToday')
            ->add('description')
            ->add('pokemonFeeded')
            ->add('pokemonFeededIp')
            ->add('tutorial')
            ->add('badges')
            ->add('sessionId')
            ->add('activity')
            ->add('activityTime')
            ->add('ip')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('login')
            ->add('password')
            ->add('email')
            ->add('cash')
            ->add('trainerLevel')
            ->add('experience')
            ->add('points')
            ->add('mpa')
            ->add('pa')
            ->add('ban')
            ->add('banDate')
            ->add('banReason')
            ->add('region')
            ->add('admin')
            ->add('magazine')
            ->add('avatar')
            ->add('lastActive')
            ->add('lastActiveSec')
            ->add('loggedToday')
            ->add('loggedInRow')
            ->add('settings')
            ->add('announcements')
            ->add('club')
            ->add('online')
            ->add('onlineToday')
            ->add('berryPa')
            ->add('shinyCatched')
            ->add('travelledToday')
            ->add('description')
            ->add('pokemonFeeded')
            ->add('pokemonFeededIp')
            ->add('tutorial')
            ->add('badges')
            ->add('sessionId')
            ->add('activity')
            ->add('activityTime')
            ->add('ip')
        ;
    }
}
