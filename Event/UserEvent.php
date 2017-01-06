<?php
namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UserEvent
 * @package SbS\AdminLTEBundle\Event
 */
class UserEvent extends Event
{
    /** @var UserInterface */
    protected $user;

    /**
     * @param UserInterface $user
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
