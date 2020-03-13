## Sidebar Menu Component

The bundle are designed to support an unlimited depth the sidebar menu. Also it supports all styles of the side menu AdminLTE Template.

### Data Model
In order to use this component, your have to create each menu item using SidebarMenuItemModel class `SbS\AdminLTEBundle\Model\SidebarMenuItemModel`.
This class provides an auto-generated menu `id` for compatibility with JS and CSS.

If you want (for some reason) to use personal id you have to create a SidebarMenuItemModel class that implements the `SbS\AdminLTEBundle\Model\SidebarMenuItemInterface`

```php
<?php
namespace App\Model;

use SbS\AdminLTEBundle\Model\SidebarMenuItemInterface;

class SidebarMenuItemModel implements SidebarMenuItemInterface {
    // ...
    // implement interface methods
    // ...
}
```

### MenuBuilder
As for recommendations, you can create own class for building a menu. Also, you can check permissions to show some item menu in that class.

```php
<?php
namespace App\Component;

use SbS\AdminLTEBundle\Model\MenuItemInterface;
use SbS\AdminLTEBundle\Model\SidebarMenuItemModel;

class SidebarMenuBuilder {

    public function getMenu() {

        // Menu Label
        $label_main = new SidebarMenuItemModel('MAIN NAVIGATION');

        // One Level Menu
        $item_info = (new SidebarMenuItemModel('Information'))
            ->setRoute('sbs_adminlte_all_notifications')
            ->setIcon('fa fa-circle-o text-blue')
            ->addBadge('17', MenuItemInterface::COLOR_RED)
            ->addBadge('new');

        // Multi Level Menu
        $item_multilevel = (new SidebarMenuItemModel('Multilevel'))
            ->setIcon('fa fa-share')
            ->addChild(
                (new SidebarMenuItemModel('Level One'))
                    ->addChild(
                        (new SidebarMenuItemModel('Level Two'))
                            ->setChildren([
                                (new SidebarMenuItemModel('Level Three'))->setRoute('sbs_adminlte_user_profile'),
                                (new SidebarMenuItemModel('Level Three'))->setRoute('sbs_adminlte_all_tasks')
                            ])
                    )
                    ->addChild((new SidebarMenuItemModel('Level Two'))->setRoute('sbs_adminlte_all_notifications'))
            )
            ->addChild((new SidebarMenuItemModel('Level One'))->setRoute('sbs_adminlte_user_profile')->addBadge('new'));
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
namespace App\EventListener;

use App\Component\SidebarMenuBuilder;
use SbS\AdminLTEBundle\Event\SidebarMenuEvent;

class SidebarMenuEventListener {

    protected $builder;

    public function __construct(SidebarMenuBuilder $builder)
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

```yaml
# config/services.yml
    App\EventListener\SidebarMenuEventListener:
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.sidebar_menu, method: onShowMenu }
```
