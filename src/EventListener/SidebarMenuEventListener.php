<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use SbS\AdminLTEBundle\Model\MenuItemInterface;
use SbS\AdminLTEBundle\Model\SidebarMenuItemModel;

/**
 * Class SidebarMenuEventListener.
 */
class SidebarMenuEventListener
{
    /**
     * @param SidebarMenuEvent $event
     */
    public function onShowMenu(SidebarMenuEvent $event)
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
            new SidebarMenuItemModel('MAIN NAVIGATION'),
            (new SidebarMenuItemModel('Examples'))->setRoute('homepage'),
            new SidebarMenuItemModel('MULTI LEVEL EXAMPLE'),
            (new SidebarMenuItemModel('Multilevel'))
                ->setIcon('fa fa-share')
                ->addChild(
                    (new SidebarMenuItemModel('Level 1'))
                        ->addChild(
                            (new SidebarMenuItemModel('Level 2'))
                                ->setChildren([
                                    (new SidebarMenuItemModel('Level 3'))
                                        ->setRoute('sbs_adminlte_user_profile'),
                                    (new SidebarMenuItemModel('Level 3'))
                                        ->setRoute('sbs_adminlte_all_notifications'),
                                    (new SidebarMenuItemModel('Level 3'))
                                        ->setRoute('sbs_adminlte_all_tasks'),
                                ])
                        )
                        ->addChild((new SidebarMenuItemModel('Level 2'))->setRoute('https://symfonycasts.com'))
                )
                ->addChild((new SidebarMenuItemModel('Level 1'))->setRoute('https://github.com/koftikes')->addBadge('new')),
            new SidebarMenuItemModel('LABELS'),
            (new SidebarMenuItemModel('Important'))
                ->setRoute('https://github.com/koftikes/symfony-adminlte-bundle')
                ->setIcon('far fa-circle text-danger')
                ->addBadge('12', MenuItemInterface::COLOR_YELLOW),
            (new SidebarMenuItemModel('Warning'))
                ->setRoute('https://www.google.com')
                ->setIcon('far fa-circle text-warning')
                ->addBadge('6', MenuItemInterface::COLOR_BLUE),
            (new SidebarMenuItemModel('Information'))
                ->setRoute('https://symfony.com')
                ->setIcon('far fa-circle text-info')
                ->addBadge('17', MenuItemInterface::COLOR_RED)->addBadge('new'),
        ];
    }
}
