<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Interface MenuItemInterface.
 */
interface MenuItemInterface
{
    /**
     * Colors of badge.
     */
    const COLOR_BLUE = 'info';

    const COLOR_GREEN = 'success';

    const COLOR_RED = 'danger';

    const COLOR_YELLOW = 'warning';

    /**
     * Should return MenuItem identifier.
     *
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return mixed
     */
    public function getRoute();

    /**
     * @return array
     */
    public function getRouteArgs();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return array
     */
    public function getBadges();

    /**
     * @param bool $active
     *
     * @return mixed
     */
    public function setActive($active);

    /**
     * @return bool
     */
    public function getActive();
}
