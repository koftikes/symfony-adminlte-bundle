## Sidebar Menu Component

The bundle are designed to support an unlimited depth the sidebar menu. Also it supports all styles of the side menu AdminLTE Template.

### Data Model
In order to use this component, your have to create each menu item using MenuItemModel class `SbS\AdminLTEBundle\Model\MenuItemModel`. This class provide auto generate menu `id` for compatibility with JS and CSS.

If you want (for some reason) to use personal id your have to create a MenuItemModel class that implements the `SbS\AdminLTEBundle\Model\MenuItemInterface`

```php
<?php
namespace AppBundle\Model;

use SbS\AdminLTEBundle\Model\MenuItemInterface as ThemeMenuItem

class MenuItemModel implements ThemeMenuItem {
    // ...
    // implement interface methods
    // ...
}
```

### MenuBuilder
As recommendations you can create own class to building menu. Also you can check permissions to show some item menu in that class.

```php
<?php
namespace AppBundle\Component;

use SbS\AdminLTEBundle\Model\MenuItemModel;
use SbS\AdminLTEBundle\Model\MenuItemInterface;

class MenuBuilder {

    public function getMenu() {

        // Menu Label
        $label_main = new MenuItemModel('MAIN NAVIGATION');

        // One Level Menu
        $item_info = (new MenuItemModel('Information'))
            ->setRoute('sbs_adminlte_all_notifications')
            ->setIcon('fa fa-circle-o text-blue')
            ->addBadge('17', MenuItemInterface::COLOR_RED)
            ->addBadge('new');

        // Multi Level Menu
        $item_multilevel = (new MenuItemModel('Multilevel'))
            ->setIcon('fa fa-share')
            ->addChild(
                (new MenuItemModel('Level One'))
                    ->addChild(
                        (new MenuItemModel('Level Two'))
                            ->setChildren([
                                (new MenuItemModel('Level Three'))->setRoute('sbs_adminlte_user_profile'),
                                (new MenuItemModel('Level Three'))->setRoute('sbs_adminlte_all_tasks')
                            ])
                    )
                    ->addChild((new MenuItemModel('Level Two'))->setRoute('sbs_adminlte_all_notifications'))
            )
            ->addChild((new MenuItemModel('Level One'))->setRoute('sbs_adminlte_user_profile')->addBadge('new'));
        // ...

        return [
            $label_main,
            $item_multilevel,
            $item_info
        ];
    }
}
```

### Event Listener
Next, you will need to create an EventListener to work with the `onShowMenu`

```php
<?php
namespace AppBundle\EventListener;

use AppBundle\Component\MenuBuilder;
use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use SbS\AdminLTEBundle\Model\MenuItemModel;

class SidebarMenuEventListener {

    public function __construct(MenuBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function onShowMenu(SidebarMenuEvent $event)
    {
        foreach ($this->builder->getMenu() as $item) {
            $event->addItem($item);
        }
    }
}
```

### Service
Finally, you need to attach your new listener to the event system:

_For Symfony 2.8.\*_

```yaml
# AppBundle/Resources/config/services.yml
    app.menu_builder:
        class: AppBundle\Component\MenuBuilder

    app.sidebar_menu_listener:
        class: AppBundle\EventListener\SidebarMenuEventListener
        arguments:
            - "@app.menu_builder"
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.sidebar_menu, method: onShowMenu }
```

_For Symfony 3.4.\*_

```yaml
# app/config/services.yml
    AppBundle\EventListener\SidebarMenuEventListener:
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.user, method: onShowUser }
```
