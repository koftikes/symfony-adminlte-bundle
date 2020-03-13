<?php

namespace SbS\AdminLTEBundle\Event;

use SbS\AdminLTEBundle\Model\MenuItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SidebarMenuEvent.
 */
class NavbarMenuEvent extends Event
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
     * NavbarMenuEvent constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param MenuItemInterface $item
     *
     * @return $this
     */
    public function addItem(MenuItemInterface $item)
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
        /** @var MenuItemInterface $item */
        foreach ($items as $item) {
            if ($item->getRoute() === $route) {
                $item->setActive(true);
            }
        }

        return $items;
    }
}
