<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Interface TaskInterface.
 */
interface TaskInterface
{
    /**
     *  Colors of tasks.
     */
    const COLOR_BLUE   = 'blue';

    const COLOR_GREEN  = 'green';

    const COLOR_RED    = 'red';

    const COLOR_YELLOW = 'yellow';

    /**
     * Should return Task identifier.
     *
     * @return int
     */
    public function getId();

    /**
     * Should return Task Title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Should return Progress of Task for progress bar.
     *
     * @return int
     */
    public function getProgress();

    /**
     * Should return Task color.
     *
     * @return string
     */
    public function getColor();
}
