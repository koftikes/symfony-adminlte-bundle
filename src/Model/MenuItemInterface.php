<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Interface MenuItemInterface
 *
 * @package SbS\AdminLTEBundle\Model
 */
interface MenuItemInterface
{
    /**
     *  Colors of badge
     */
    const COLOR_BLUE   = 'blue';
    const COLOR_GREEN  = 'green';
    const COLOR_RED    = 'red';
    const COLOR_YELLOW = 'yellow';

    /**
     * Should return MenuItem identifier
     *
     * @return integer
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
     * @param MenuItemInterface|null $parent
     *
     * @return mixed
     */
    public function setParent(MenuItemInterface $parent = null);

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
     * @param boolean $active
     *
     * @return mixed
     */
    public function setActive($active);

    /**
     * @return boolean
     */
    public function getActive();
}
