<?php
namespace SbS\AdminLTEBundle\Model;

interface TaskInterface
{
    /**
     * Should return Task identifier
     * @return integer
     */
    public function getId();

    /**
     * Should return Task Title
     * @return string
     */
    public function getTitle();

    /**
     * Should return Progress of Task for progress bar
     * @return integer
     */
    public function getProgress();

    /**
     * Should return Task color
     * @return string
     */
    public function getColor();
}
