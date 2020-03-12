<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Class SidebarMenuItemModel.
 */
class SidebarMenuItemModel extends MenuItemModel implements SidebarMenuItemInterface
{
    /**
     * @var array
     */
    protected $children = [];

    /**
     * @var null|SidebarMenuItemInterface
     */
    protected $parent;

    /**
     * @param array $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        /** @var SidebarMenuItemInterface $child */
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
     * @param SidebarMenuItemInterface $child
     *
     * @return $this
     */
    public function addChild(SidebarMenuItemInterface $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param null|SidebarMenuItemInterface $parent
     *
     * @return $this
     */
    public function setParent(SidebarMenuItemInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return null|SidebarMenuItemInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        if ($this->parent instanceof MenuItemInterface) {
            $this->parent->setActive($active);
        }
        $this->active = $active;

        return $this;
    }
}
