<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\NotificationListEvent;
use SbS\AdminLTEBundle\Model\Demo\NotificationModel;
use SbS\AdminLTEBundle\Model\NotificationInterface;

/**
 * Class NotificationListEventListener.
 */
class NotificationListEventListener
{
    /**
     * @param NotificationListEvent $event
     */
    public function onListNotifications(NotificationListEvent $event)
    {
        foreach ($this->getNotifications() as $notify) {
            $event->addNotification($notify);
        }
    }

    /**
     * @return array
     */
    protected function getNotifications()
    {
        return [
            new NotificationModel(1, 'Some Info Notification', NotificationInterface::TYPE_INFO),
            new NotificationModel(2, 'Some Success Notification', NotificationInterface::TYPE_SUCCESS),
            new NotificationModel(3, 'Some Warning Notification', NotificationInterface::TYPE_WARNING),
            new NotificationModel(4, 'Some Danger Notification', NotificationInterface::TYPE_DANGER),
            new NotificationModel(5, 'Some More Default Notices'),
        ];
    }
}
