<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\UserEvent;
use SbS\AdminLTEBundle\Model\Demo\UserModel;

/**
 * Class UserEventListener
 *
 * @package SbS\AdminLTEBundle\EventListener
 */
class UserEventListener
{
    /**
     * @param UserEvent $event
     */
    public function onShowUser(UserEvent $event)
    {
        $user = new UserModel("demo_user");
        $user
            ->setName('Demo User')
            ->setTitle('User Title')
            ->setInfo('<b>Email:</b> <a href="mailto:demo_user@example.com">demo_user@example.com</a>')
            ->setMemberSince(new \DateTime());

        $event->setUser($user);
    }
}
