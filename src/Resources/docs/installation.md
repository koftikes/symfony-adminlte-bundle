## Installation

Before run composer command you need allow contrib in project composer.json:

```json
"extra": {
    "symfony": {
        "allow-contrib": true,
        ...
    }
}
```
After that run next composer command for download and install `sbs/symfony-adminlte-bundle`:

    composer require "sbs/symfony-adminlte-bundle":"2.1.*"

## Configurations

Bundle will be enable with auto-generated recipe. Your `config/bundles.php` start to be next:

```php
// config/bundles.php
<?php

return [
    // ...
    SbS\AdminLTEBundle\SbSAdminLTEBundle::class => ['all' => true],
];
```

Configure composer.json to install AdminLTE assets into bundle public directory.

_Notice: insert line before `"assets:install %PUBLIC_DIR%": "symfony-cmd"`_

```json
"scripts": {
    "auto-scripts": {
        "cache:clear": "symfony-cmd",
        "sbs:admin-lte:build-assets": "symfony-cmd",
        "assets:install %PUBLIC_DIR%": "symfony-cmd"
    },
    "post-install-cmd": [
        "@auto-scripts"
    ],
    "post-update-cmd": [
        "@auto-scripts"
    ]
},
```

Add the following lines at `config/routes.yaml`:

    sbs_adminlte:
        resource: "@SbSAdminLTEBundle/Resources/config/routing.xml"


Added to `framework` section  at `config/packages/framework.yaml`._

    framework:
        # ...
        templating:
            engines: ['twig', 'php']

#### Install Assets (run the following command):

    php ./bin/console assets:install

### Changing default values template

_This section will be updated in near future_
