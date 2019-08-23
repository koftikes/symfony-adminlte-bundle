<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\TaskListEvent;
use SbS\AdminLTEBundle\Model\Demo\TaskModel;

/**
 * Class TaskListEventListener.
 */
class TaskListEventListener
{
    /**
     * @param TaskListEvent $event
     */
    public function onListTasks(TaskListEvent $event)
    {
        foreach ($this->getTasks() as $task) {
            $event->addTask($task);
        }
    }

    /**
     * @return array
     */
    protected function getTasks()
    {
        return [
            new TaskModel(1, 'Make stuff', 10, TaskModel::COLOR_BLUE),
            new TaskModel(2, 'Make more stuff', 20),
            new TaskModel(3, 'Some more tasks to do', 30, TaskModel::COLOR_RED),
            new TaskModel(4, 'Some more tasks to do', 40, TaskModel::COLOR_YELLOW),
            new TaskModel(5, 'Make more stuff', 80, TaskModel::COLOR_GREEN),
            new TaskModel(6, 'Some more tasks to do', 100, TaskModel::COLOR_GREEN),
        ];
    }
}
