<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Interface MenuItemInterface.
 */
interface MenuItemInterface
{
    /**
     *  Colors of badge.
     */
    const COLOR_BLUE   = 'blue';

    const COLOR_GREEN  = 'green';

    const COLOR_RED    = 'red';

    const COLOR_YELLOW = 'yellow';

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
     * @return array
     */
    public function getChildren();

    /**
     * @param null|MenuItemInterface $parent
     *
     * @return mixed
     */
    public function setParent(self $parent = null);

    /**
     * @return mixed
     */
    public function getParent();

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
