<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use SbS\AdminLTEBundle\Model\Demo\MenuItemModel;
use SbS\AdminLTEBundle\Model\MenuItemInterface;

/**
 * Class SidebarMenuEventListener
 * @package SbS\AdminLTEBundle\EventListener
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
        $label_main = new MenuItemModel(1, 'MAIN NAVIGATION');
        $label_examples = new MenuItemModel(7, 'Examples', 'sbs_adminlte_user_profile');
        $item_multilevel = (new MenuItemModel(2, 'Multilevel'))
            ->setIcon('fa fa-share')
            ->addChild(
                (new MenuItemModel(21, 'Level One'))
                    ->addChild(
                        (new MenuItemModel(211, 'Level Two'))
                            ->addChild(new MenuItemModel(221, 'Level Three', 'sbs_adminlte_user_profile'))
                            ->addChild(new MenuItemModel(222, 'Level Three', 'sbs_adminlte_all_tasks'))
                    )
                    ->addChild(new MenuItemModel(212, 'Level Two', 'sbs_adminlte_all_notifications'))
            )
            ->addChild(
                (new MenuItemModel(22, 'Level One', 'sbs_adminlte_user_profile'))->addBadge('new')
            );
        $label_other = new MenuItemModel(3, 'LABELS');
        $item_important = (new MenuItemModel(4, 'Important', 'sbs_adminlte_user_profile'))
            ->setIcon('fa fa-circle-o text-red')
            ->addBadge('12', MenuItemInterface::COLOR_YELLOW);
        $item_warning = (new MenuItemModel(5, 'Warning', 'sbs_adminlte_all_tasks'))
            ->setIcon('fa fa-circle-o text-yellow')
            ->addBadge('6', MenuItemInterface::COLOR_BLUE);
        $item_info = (new MenuItemModel(6, 'Information', 'sbs_adminlte_all_notifications'))
            ->setIcon('fa fa-circle-o text-blue')
            ->addBadge('17', MenuItemInterface::COLOR_RED)->addBadge('new');

        return [$label_main, $label_examples, $item_multilevel, $label_other, $item_important, $item_warning, $item_info];
    }
}
