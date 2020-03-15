## Navigation Bar User Component

### As recommendations you can use [FOSUserBundle][1].

At the moment not exist documentations for installations this bundle to Symfony 4.4 and higher.
This is should help you: [How to install and configure FOSUserBundle in Symfony 4](src/Resources/docs/fos_installation.md)

### Routes
This component requires some route names to work.

* `sbs_adminlte_user_profile` which should point to the current user's profile page.
* `sbs_adminlte_user_logout` which should point to the logout mechanism.

You could use the following route stubs with your `routing.yml`

```yaml
# app/config/routing.yml
sbs_adminlte_user_profile:
    path: /user/profile
    controller: App\Controller\UserProfile:main
sbs_adminlte_user_logout:
    path: /logout
```

### Data Model
In order to use this component, your User class has to implement the `SbS\AdminLTEBundle\Model\UserInterface`

```php
<?php
namespace App\Entity;

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
namespace App\EventListener;

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
# config/services.yml
    App\EventListener\UserEventListener:
        tags:
            - { name: kernel.event_listener, method: onShowUser }
```

[1]: https://github.com/FriendsOfSymfony/FOSUserBundle
