<?php

namespace SbS\AdminLTEBundle\Model\Demo;

use SbS\AdminLTEBundle\Model\TaskInterface;

/**
 * Class TaskModel.
 */
class TaskModel implements TaskInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    private $progress;

    /**
     * @var string
     */
    private $color;

    /**
     * TaskModel constructor.
     *
     * @param int    $id
     * @param string $title
     * @param int    $progress
     * @param string $color
     */
    public function __construct($id, $title, $progress = 0, $color = self::COLOR_RED)
    {
        $this->id       = $id;
        $this->title    = $title;
        $this->progress = $progress;
        $this->color    = $color;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param int $progress
     *
     * @return $this
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * @return int
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
