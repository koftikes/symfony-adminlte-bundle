## Installation

Installation using composer is really easy:

_Notice: If you want use AdminLTE theme latest then 2.4.3, you need add next config to your composer,json:_
```json
"repositories": [
    {"type": "composer", "url": "https://asset-packagist.org"}
],
```
_And install `bower-asset/jquery` package:_

    composer require "bower-asset/jquery":">=1.9.0 <4.0.0"

Next composer command download and install `sbs/symfony-adminlte-bundle` bundle to your composer.json:

    composer require "sbs/symfony-adminlte-bundle":"1.5.*"

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


Added to `framework` section  at `app/config/config.yml`._

    framework:
        # ...
        templating:
            engines: ['twig', 'php']

#### Install Assets (run the following command):

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

[1]: https://adminlte.io/docs/2.4/installation
