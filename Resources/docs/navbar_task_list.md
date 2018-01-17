## Navigation Bar Task List Component

### Routes
This component requires some route names to work.

* `sbs_adminlte_show_task` which should point to the current task page.
* `sbs_adminlte_all_tasks` which should point to the all task list page.

You could use the following route stubs with your `routing.yml`

```yaml
# app/config/routing.yml
sbs_adminlte_show_task:
    path: /task/{taskId}
sbs_adminlte_all_tasks:
    path: /tasks
```

### Data Model
In order to use this component, your Task class has to implement the `SbS\AdminLTEBundle\Model\TaskInterface`

```php
<?php
namespace AppBundle\Entity;

use SbS\AdminLTEBundle\Model\TaskInterface;

class TaskEntity implements TaskInterface {
    // ...
    // implement interface methods
    // ...
}
```

### Event Listener
Next, you will need to create an EventListener to work with the `onListTasks`

```php
<?php
namespace AppBundle\EventListener;

class TaskListEventListener {

    public function onListTasks(TaskListEvent $event)
    {
        foreach ($this->getTasks() as $task) {
            $event->addTask($task);
        }
    }

    protected function getTasks()
    {
        // ...
        // implement return task list method
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
        class: AppBundle\EventListener\TaskListEventListener
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.tasks, method: onListTasks }
```

_For Symfony 3.4.\*_

```yaml
# app/config/services.yml
    AppBundle\EventListener\TaskListEventListener:
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.tasks, method: onListTasks }
```
