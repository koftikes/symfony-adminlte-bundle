<?php

namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use SbS\AdminLTEBundle\Model\MenuItemInterface;
use SbS\AdminLTEBundle\Model\MenuItemModel;

/**
 * Class SidebarMenuEventListener.
 */
class SidebarMenuEventListener
{
    /**
     * @param SidebarMenuEvent $event
     */
    public function onShowMenu(SidebarMenuEvent $event): void
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
        $label_main      = new MenuItemModel('MAIN NAVIGATION');
        $label_examples  = (new MenuItemModel('Examples'))->setRoute('sbs_adminlte_user_profile');
        $item_multilevel = (new MenuItemModel('Multilevel'))
            ->setIcon('fa fa-share')
            ->addChild(
                (new MenuItemModel('Level One'))
                    ->addChild(
                        (new MenuItemModel('Level Two'))
                            ->setChildren([
                                (new MenuItemModel('Level Three'))->setRoute('sbs_adminlte_user_profile'),
                                (new MenuItemModel('Level Three'))->setRoute('sbs_adminlte_all_tasks'),
                            ])
                    )
                    ->addChild((new MenuItemModel('Level Two'))->setRoute('sbs_adminlte_all_notifications'))
            )
            ->addChild((new MenuItemModel('Level One'))->setRoute('sbs_adminlte_user_profile')->addBadge('new'));
        $label_other     = new MenuItemModel('LABELS');
        $item_important  = (new MenuItemModel('Important'))
            ->setRoute('sbs_adminlte_user_profile')
            ->setIcon('fa fa-circle-o text-red')
            ->addBadge('12', MenuItemInterface::COLOR_YELLOW);
        $item_warning    = (new MenuItemModel('Warning'))
            ->setRoute('sbs_adminlte_all_tasks')
            ->setIcon('fa fa-circle-o text-yellow')
            ->addBadge('6', MenuItemInterface::COLOR_BLUE);
        $item_info       = (new MenuItemModel('Information'))
            ->setRoute('sbs_adminlte_all_notifications')
            ->setIcon('fa fa-circle-o text-blue')
            ->addBadge('17', MenuItemInterface::COLOR_RED)->addBadge('new');

        return [
            $label_main,
            $label_examples,
            $item_multilevel,
            $label_other,
            $item_important,
            $item_warning,
            $item_info,
        ];
    }
}
