## Navigation Bar Notification List Component

### Routes
This component requires some route names to work.

* `sbs_adminlte_show_notification` which should point to the current notification page.
* `sbs_adminlte_all_notifications` which should point to the all notification list page.

You could use the following route stubs with your `routing.yml`

```yaml
# app/config/routing.yml
sbs_adminlte_show_notification:
    path: /notification/{noticeId}
sbs_adminlte_all_notifications:
    path: /notifications
```

### Data Model
In order to use this component, your Notification class has to implement the `SbS\AdminLTEBundle\Model\NotificationInterface`

```php
<?php
namespace AppBundle\Entity;

use SbS\AdminLTEBundle\Model\NotificationInterface;

class NotificationEntity implements NotificationInterface {
    // ...
    // implement interface methods
    // ...
}
```

### Event Listener
Next, you will need to create an EventListener to work with the `onListNotifications`

```php
<?php
namespace AppBundle\EventListener;

class NotificationListEventListener {

    public function onListNotifications(NotificationListEvent $event)
    {
        foreach ($this->getNotifications() as $notify) {
            $event->addNotification($notify);
        }
    }

    protected function getNotifications()
    {
        // ...
        // implement return notification list method
        // ...
    }
}
```

### Service
Finally, you need to attach your new listener to the event system:

_For Symfony 2.8.\*_

```yaml
# AppBundle/Resources/config/services.yml
    app.tasks_listener:
        class: AppBundle\EventListener\NotificationListEventListener
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.notifications, method: onListNotifications }
```

_For Symfony 3.4.\*_

```yaml
# app/config/services.yml
    AppBundle\EventListener\NotificationListEventListener:
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.notifications, method: onListNotifications }
```
