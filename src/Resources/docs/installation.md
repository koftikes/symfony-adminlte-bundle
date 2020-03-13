## Installation

Installation using composer is really easy. 
Just run next composer command for download and install `sbs/symfony-adminlte-bundle`:

    composer require "sbs/symfony-adminlte-bundle":"2.0.*"

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

_This section will be updated in near future_
