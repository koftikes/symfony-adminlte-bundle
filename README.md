AdminLTEBundle
==============

AdminLTE Bundle based on the AdminLTE Template for easy integration into symfony.
This bundle integrates several commonly used JavaScripts and the awesome [AdminLTE Template](https://github.com/almasaeed2010/AdminLTE).

## Installation

Installation using composer is really easy: this command will add `"sbs/symfony-adminlte-bundle"` to your composer.json and will download the bundle:

    composer require sbs/symfony-adminlte-bundle

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

Configure composer.json  to install AdminLTE assets into bundle public directory.

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

After that install assets (preferably using symlink method but hardcopy works as well)...

    php app/console assets:install --symlink

### Symfony 2.8 notice
This bundle requires assetic, but it isn't shipped with symfony anymore since version 2.8. To install assetic, follow these steps:

    php composer require symfony/assetic-bundle

Enable the bundle in your kernel:
```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Symfony\Bundle\AsseticBundle\AsseticBundle(),
        new SbS\AdminLTEBundle\SbSAdminLTEBundle(),
    );
}
```
Add the following lines at `app/config/config.yml`:

    # Assetic Configuration
    assetic:
        # ...
        use_controller: false
        bundles:        ["SbSAdminLTEBundle"]

### Changing default values from templates
To apply form theme to all the forms of your application, use the following configuration under `[twig]` section:

    # Twig Configuration
    twig:
        # ...
        form:
            resources: ['bootstrap_3_layout.html.twig']
            # resources: ['bootstrap_3_horizontal_layout.html.twig']

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
If you want to know more then go ahead and check docs for AdminLTE [here][1].

There are a few values you could change for sure without need to touch anything at bundle, just take a look under `Resources/views`.

That's all. Enjoy.

 [1]: https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html
