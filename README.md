AdminLTEBundle
==============
[![Build Status](https://travis-ci.com/koftikes/symfony-adminlte-bundle.svg?branch=master)](https://travis-ci.com/koftikes/symfony-adminlte-bundle)

AdminLTE Bundle based on the AdminLTE Template for easy integration into Symfony. This bundle integrates several commonly used JavaScripts and Font-Awesome.

From version, the 1.5.x:
* does not require AsseticBundle in since it deprecated.
* was locked to version PHP 7.2. 
* was locked to symfony >=3.4 

## Installation

Installation using composer is really easy:
Configure components installers directory in `composer.json`:

```json
"extra": {
    "installer-types": ["library", "component"],
    "installer-paths": {
        "web/components/{$name}/": ["type:component"]
    },
},
```

After that run the next composer command to download and add bundle `sbs/symfony-adminlte-bundle` to your composer.json:

    composer require sbs/symfony-adminlte-bundle

## Configurations

Enable the bundle in your kernel:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new SbS\AdminLTEBundle\SbSAdminLTEBundle(),
        new AppBundle\AppBundle(),
    );
}
```

Configure composer.json to install AdminLTE assets into bundle public directory.

_Notice: insert line before `Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets`_

```json
"scripts": {
    "symfony-scripts": [
        "SbS\\AdminLTEBundle\\Composer\\ScriptHandler::buildAssets",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
    ],
    "post-install-cmd": [
        "@symfony-scripts"
    ],
    "post-update-cmd": [
        "@symfony-scripts"
    ]
},
```

Add the following lines at `app/config/routing.yml`:

    sbs_adminlte:
        resource: "@SbSAdminLTEBundle/Resources/config/routing.xml"


### Notice for Symfony 2.8 and higher

_For Symfony 3.4 and higher next snippet should be added to `framework` section._

    framework:
        # ...
        templating:
            engines: ['twig']

#### Install Assets (run the following command):

_For Symfony 2.8.\*_

    php ./app/console assets:install

_For Symfony 3.4.\*_

    php ./bin/console assets:install

### Changing default values template

If you want to change any default value as for example `skin` all you need to do is define the same at `app/config/config.yml` under `[twig]` section.
See example below:

    # Twig Configuration
    twig:
        # ...
        globals:
            admin_lte_skin: skin-blue
        # ...

You could also define those values at `app/config/parameters.yml`:

    app.skin: skin-blue

and then use as follow in `app/config/config.yml`:

    # Twig Configuration
    twig:
        # ...
        globals:
            admin_lte_skin: "%app.skin%"

AdminLTE skins are: skin-blue (default for this bundle), skin-blue-light, skin-yellow, skin-yellow-light, skin-green, skin-green-light, skin-purple, skin-purple-light, skin-red, skin-red-light, skin-black and skin-black-light.
If you want to know more about theme then go ahead and check [docs for AdminLTE][1].

There are a few values you could change for sure without need to touch anything at bundle, just take a look under `Resources/views`.

## Next Steps

* [Using Layout](src/Resources/docs/layout.md)
* [Navbar User](src/Resources/docs/navbar_user.md)
* [Navbar Task List](src/Resources/docs/navbar_task_list.md)
* [Navbar Notification List](src/Resources/docs/navbar_notification_list.md)
* [Sidebar Menu](src/Resources/docs/sidebar_menu.md)

That's all. Enjoy.

[1]: https://adminlte.io/docs/2.4/installation
[2]: https://adminlte.io/blog/adminlte-v2.4-release-notes-and-upgrade-guide
