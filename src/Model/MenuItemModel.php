<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Class MenuItemModel.
 */
class MenuItemModel implements MenuItemInterface
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var array
     */
    protected $routeArgs = [];

    /**
     * @var string
     */
    protected $icon = '';

    /**
     * @var array
     */
    protected $badges = [];

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * MenuItemModel constructor.
     *
     * @param string $label
     */
    public function __construct($label)
    {
        $this->id    = \uniqid();
        $this->label = $label;
    }

    /**
     * @param int|string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param array $routeArgs
     *
     * @return $this
     */
    public function setRouteArgs($routeArgs)
    {
        $this->routeArgs = $routeArgs;

        return $this;
    }

    /**
     * @return array
     */
    public function getRouteArgs()
    {
        return $this->routeArgs;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param array $badges
     *
     * @return $this
     */
    public function setBadges($badges)
    {
        $this->badges = $badges;

        return $this;
    }

    /**
     * @return array
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * @param string $text
     * @param string $color
     *
     * @return $this
     */
    public function addBadge($text, $color = MenuItemInterface::COLOR_GREEN)
    {
        $this->badges[$text] = $color;

        return $this;
    }
}
