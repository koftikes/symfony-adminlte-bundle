<?php

namespace SbS\AdminLTEBundle\Model;

/**
 * Interface SidebarMenuItemInterface.
 */
interface SidebarMenuItemInterface extends MenuItemInterface
{
    /**
     * @return array
     */
    public function getChildren();

    /**
     * @param null|SidebarMenuItemInterface $parent
     *
     * @return mixed
     */
    public function setParent(self $parent = null);

    /**
     * @return mixed
     */
    public function getParent();
}
