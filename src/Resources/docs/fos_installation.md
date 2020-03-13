## How to install and configure FOSUserBundle in Symfony 4

With the introduction of Symfony 4, a lot of stuff changed, most of it for good. 
However, when you work in an enterprise where you are constantly working on the same things (logic), you will have a bad time discovering how things work on new frameworks. 
That's the case of Symfony 4, where the user system got even easier to implement. 
However, if you are in love with the ease that the FOSUserBundle provides, you may want to know that is still possible to implement it on Symfony 4 as well.

### Install FOSUserBundle

If you using `symfony/website-skeleton` for creating your project, by default it contains `twig/twig 3.0.x`.
You need to downgrade this package to version ~2.x.x, for that run next command:

      composer require twig/twig "2.*"

Hoping it's will be fixed soon by FOS Team.

After that run installs FOSUserBundle with composer with the following command:
    
    composer require friendsofsymfony/user-bundle "~2.1"

This will start with the installation and you won't need to configure anything in the kernel or something like that, 
you will find however an error message once the process finishes:
```bash
    The child node "db_driver" at path "fos_user" must be configured.
```
Ignore this and proceed with the next step.

### Create User Class

As next, you will need to create the User entity in your project, the class object that handles the user object. 
As we are working with FOSUserBundle, the class has the following structure, so be sure to create 
the file in the `src/Entity` directory with the name `User.php` and the following content:
```php
<?php
// src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

### Update Security Configuration File

After creating the user entity, you need to change the security configuration, setting the FOSUserBundle encoder as default defining it as the security provider.
Edit the 'config/packages/security.yaml' file and change its content with the following instead:
```yaml
# config/packages/security.yaml
security:
    encoders:
        FOS\UserBundle\Model\UserInterface: bcrypt
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN
    # ...
    providers:
        fos_userbundle:
            id: fos_user.user_provider.username_email

    firewalls:
        # ....
        main:
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_token_generator: security.csrf.token_manager
            logout:       true
            anonymous:    true
    # ...
    access_control:
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/, role: IS_AUTHENTICATED_REMEMBERED }
```

### Create FOSUserBundle Configuration File

Once FOSUserBundle has been defined as the default user provider, you need to define its configuration. 
In Symfony 4 this can be done through a new yaml file `config/packages/fos_user.yaml` that will have the default configuration of this bundle:
```yaml
# config/packages/fos_user.yaml
fos_user:
    db_driver: orm # other valid values are 'mongodb' and 'couchdb'
    firewall_name: main
    user_class: App\Entity\User
    from_email:
        address: "test@domain.com"
        sender_name: "test@domain.com"
```

### Allow PHP and Twig templating and enable routing

As required by FOSUserBundle the PHP and Twig templating engines must be enabled, so be sure to enable it in the `config/packages/framework.yaml` file:
```yaml
framework:
    templating:
        engines: ['twig', 'php']
```
You need to enable the FOSUserBundle routes as well, so create the routes file for FOSUserBundle with the file `config/routes/fos_user.yaml` and add the following content:
```yaml
fos_user:
    resource: "@FOSUserBundle/Resources/config/routing/all.xml"
```
This will register the default routes of FOSUserBundle like the login, logout, register etc.

### Update your database schema
As last step, you only need to update the schema of your database with the following command:

    php bin/console doctrine:schema:update --force

This will create the fos_user table in your database and you will be able to register users. With this step, the installation and setup of FOSUserBundle finishes.
