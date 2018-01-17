## Navigation Bar User Component

### As recommendations you can use [FOSUserBundle][1].

### Routes
This component requires some route names to work.

* `sbs_adminlte_user_profile` which should point to the current user's profile page.
* `sbs_adminlte_user_logout` which should point to the logout mechanism.

You could use the following route stubs with your `routing.yml`

```yaml
# app/config/routing.yml
sbs_adminlte_user_profile:
    path: /user/profile
    defaults: {_controller: AppBundle:Profile:main}
sbs_adminlte_user_logout:
    path: /logout
```

### Data Model
In order to use this component, your User class has to implement the `SbS\AdminLTEBundle\Model\UserInterface`

```php
<?php
namespace AppBundle\Entity;

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
namespace AppBundle\EventListener;

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

_For Symfony 2.8.\*_

```yaml
# AppBundle/Resources/config/services.yml
    app.user_listener:
        class: AppBundle\EventListener\UserEventListener
        arguments:
            - "@security.token_storage"
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.user, method: onShowUser }
```

_For Symfony 3.4.\*_

```yaml
# app/config/services.yml
    AppBundle\EventListener\UserEventListener:
        tags:
            - { name: kernel.event_listener, event: sbs.admin_lte.user, method: onShowUser }
```

[1]: https://symfony.com/doc/master/bundles/FOSUserBundle/index.html
