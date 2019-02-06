<?php

namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NotificationListEvent
 *
 * @package SbS\AdminLTEBundle\Event
 */
class NotificationListEvent extends Event
{
    /**
     * @var array
     */
    protected $notifications = [];

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @param NotificationInterface $notification
     *
     * @return $this
     */
    public function addNotification(NotificationInterface $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * @return array
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total === 0 ? count($this->notifications) : $this->total;
    }
}
