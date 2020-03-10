<?php

namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\TaskInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class TaskListEvent.
 */
class TaskListEvent extends Event
{
    /**
     * @var array
     */
    protected $tasks = [];

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @param TaskInterface $task
     *
     * @return $this
     */
    public function addTask(TaskInterface $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return 0 === $this->total ? \count($this->tasks) : $this->total;
    }
}
