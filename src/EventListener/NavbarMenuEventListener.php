<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\NavbarMenuEvent;
use SbS\AdminLTEBundle\Model\MenuItemInterface;
use SbS\AdminLTEBundle\Model\MenuItemModel;

/**
 * Class NavbarMenuEventListener.
 */
class NavbarMenuEventListener
{
    /**
     * @param NavbarMenuEvent $event
     */
    public function onShowMenu(NavbarMenuEvent $event): void
    {
        foreach ($this->getMenu() as $item) {
            $event->addItem($item);
        }
    }

    /**
     * @return array
     */
    protected function getMenu()
    {
        return [
            (new MenuItemModel('Home'))->setRoute('homepage'),
            (new MenuItemModel('Profile'))
                ->setRoute('sbs_adminlte_user_profile')
                ->setIcon('far fa-circle text-danger'),
            (new MenuItemModel('Notifications'))
                ->setRoute('sbs_adminlte_all_notifications')
                ->setIcon('far fa-circle text-warning')
                ->addBadge('5', MenuItemInterface::COLOR_YELLOW),
            (new MenuItemModel('Tasks'))
                ->setRoute('sbs_adminlte_all_tasks')
                ->setIcon('far fa-circle text-info')
                ->addBadge('6', MenuItemInterface::COLOR_RED)->addBadge('new'),
        ];
    }
}
