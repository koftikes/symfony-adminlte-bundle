## Navigation Bar User Component

### Routes
This component requires some route names to work.

* `sbs_adminlte_user_profile` which should point to the current user's profile page.
* `sbs_adminlte_user_logout` which should point to the logout mechanism.

You could use the following route stubs with your `routing.yml`

```yaml
sbs_adminlte_user_profile:
    path: /user/profile
    defaults: {_controller: MyBundle:Profile:main}
sbs_adminlte_user_logout:
    path: /logout
```

### Data Model
In order to use this component, your user class has to implement the `SbS\AdminLTEBundle\Model\UserInterface`

```php
<?php
namespace MyBundle\Entity;

use SbS\AdminLTEBundle\Model\UserInterface as ThemeUser

class UserEntity implements ThemeUser {
    // ...
    // implement interface methods
    // ...
}
```

### Event Listener
Next, you will need to create an EventListener to work with the `onShowUser`

```php
<?php
namespace MyBundle\EventListener;

use SbS\AdminLTEBundle\Event\UserEvent;
use SbS\AdminLTEBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserEventListener
{
    private $token_storage;

    public function __construct(TokenStorageInterface $token_storage)
    {
        $this->token_storage = $token_storage;
    }

    public function onShowUser(UserEvent $event)
    {
        /** @var UserInterface $user */
        $user = $this->token_storage->getToken()->getUser();

        $event->setUser($user);
    }
}
```

### Service
Finally, you need to attach your new listener to the event system:

```yaml
# Resources/config/services.yml
    my_bundle.user_listener:
        class: MyBundle\EventListener\UserEventListener
        arguments:
            - "@security.token_storage"
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.user, method: onShowUser }
```
