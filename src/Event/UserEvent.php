<?php

namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserEvent.
 */
class UserEvent extends Event
{
    /** @var UserInterface */
    protected $user;

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
