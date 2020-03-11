<?php

namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\SidebarMenuItemInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SidebarMenuEvent.
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
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param SidebarMenuItemInterface $item
     *
     * @return $this
     */
    public function addItem(SidebarMenuItemInterface $item)
    {
        $this->menuItems[$item->getId()] = $item;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->activateByRoute($this->request->get('_route'), $this->menuItems);
    }

    /**
     * @param string $route
     * @param array  $items
     *
     * @return mixed
     */
    protected function activateByRoute($route, $items)
    {
        /** @var SidebarMenuItemInterface $item */
        foreach ($items as $item) {
            if ($item->getChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() === $route) {
                    $item->setActive(true);
                }
            }
        }

        return $items;
    }
}
