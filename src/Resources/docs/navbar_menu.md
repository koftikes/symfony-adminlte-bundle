## Navbar Menu Component

Since AdminLTE version 3.0.x bundle support two menus: SidebarMenu and NavbarMenu. For now, this menu doesn't support sub menu items.

### Data Model
In order to use this component, your have to create each menu item using MenuItemModel class `SbS\AdminLTEBundle\Model\MenuItemModel`.
This class provides an auto-generated menu `id` for compatibility with JS and CSS.

If you want (for some reason) to use personal id you have to create a NavbarMenuItemModel class that implements the `SbS\AdminLTEBundle\Model\MenuItemInterface`

```php
<?php
namespace App\Model;

use SbS\AdminLTEBundle\Model\MenuItemInterface;

class NavbarMenuItemModel implements MenuItemInterface {
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

use SbS\AdminLTEBundle\Model\MenuItemModel;
use SbS\AdminLTEBundle\Model\MenuItemInterface;

class NavbarMenuBuilder {

    public function getMenu() {
        
        $main = (new MenuItemModel('Home'))
                ->setRoute('homepage');

        // Menu item with icon
        $profile = (new MenuItemModel('Profile'))
                   ->setRoute('sbs_adminlte_user_profile')
                   ->setIcon('far fa-circle text-danger');
        
        // Menu item with icon and badge
        $tasks = (new MenuItemModel('Tasks'))
                 ->setRoute('sbs_adminlte_all_tasks')
                 ->setIcon('far fa-circle text-info')
                 ->addBadge('6', MenuItemInterface::COLOR_RED)->addBadge('new');
        // ...

        return [
            $main,
            $profile,
            $tasks
        ];
    }
}
```

### Event Listener
Next, you will need to create an EventListener to work with the `onShowMenu`

```php
<?php
namespace App\EventListener;

use App\Component\NavbarMenuBuilder;
use SbS\AdminLTEBundle\Event\NavbarMenuEvent;

class NavbarMenuEventListener {

    protected $builder;

    public function __construct(NavbarMenuBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function onShowMenu(NavbarMenuEvent $event)
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
# config/services.yaml
    App\EventListener\NavbarMenuEventListener:
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.navbar_menu, method: onShowMenu }
```
