<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Class MenuItemModel
 * @package SbS\AdminLTEBundle\Model
 */
class MenuItemModel implements MenuItemInterface
{
    /** @var integer */
    private $id;

    /** @var string */
    private $label;

    /** @var string */
    private $route = null;

    /** @var array */
    private $routeArgs = [];

    /** @var array */
    private $children = [];

    /** @var string */
    private $icon = '';

    /** @var array */
    private $badges = [];

    /** @var bool */
    private $active = false;

    /** @var MenuItemInterface */
    private $parent = null;

    public function __construct($label)
    {
        $this->id    = uniqid();
        $this->label = $label;
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
        /** @var MenuItemInterface $child */
        foreach ($children as $child) {
            $child->setParent($this);
        }
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
