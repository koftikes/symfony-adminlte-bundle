<?php

namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\MenuItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class SidebarMenuEvent
 * @package SbS\AdminLTEBundle\Event
 */
class SidebarMenuEvent extends Event
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $menuItems = [];

    /**
     * SidebarMenuEvent constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param MenuItemInterface $item
     */
    public function addItem(MenuItemInterface $item)
    {
        $this->menuItems[$item->getId()] = $item;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->activateByRoute($this->request->get('_route'), $this->menuItems);
    }

    /**
     * @param $route
     * @param $items
     * @return mixed
     */
    protected function activateByRoute($route, $items)
    {
        /** @var $item MenuItemInterface */
        foreach ($items as $item) {
            if ($item->getChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setActive(true);
                }
            }
        }

        return $items;
    }
}
