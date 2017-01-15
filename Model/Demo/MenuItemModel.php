<?php

namespace SbS\AdminLTEBundle\Model\Demo;

use SbS\AdminLTEBundle\Model\MenuItemInterface;

/**
 * Class MenuItemModel
 * @package SbS\AdminLTEBundle\Model\Demo
 */
class MenuItemModel implements MenuItemInterface
{
    /** @var integer */
    private $id;

    /** @var string */
    private $label;

    /** @var string */
    protected $route = null;

    /** @var array */
    protected $routeArgs = [];

    /** @var array */
    protected $children = [];

    /** @var mixed */
    protected $icon = false;

    /** @var array */
    protected $badges = [];

    /** @var bool */
    protected $active = false;

    /** @var MenuItemInterface */
    protected $parent = null;

    public function __construct($id, $label, $route = null, $routeArgs = [])
    {
        $this->id = $id;
        $this->label = $label;
        $this->route = $route;
        $this->routeArgs = $routeArgs;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $label
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
     * @param $routeArgs
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
     * @param $children
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param MenuItemInterface $child
     * @return $this
     */
    public function addChild(MenuItemInterface $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param MenuItemInterface|null $parent
     * @return $this
     */
    public function setParent(MenuItemInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return MenuItemInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param $active
     * @return $this
     */
    public function setActive($active)
    {
        if ($this->parent) {
            $this->getParent()->setActive($active);
        }
        $this->active = $active;

        return $this;
    }

    /**
     * @param $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param $badges
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
     * @return $this
     */
    public function addBadge($text, $color = MenuItemInterface::COLOR_GREEN)
    {
        $this->badges[$text] = $color;

        return $this;
    }
}
