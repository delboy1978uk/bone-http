# http
Http package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-http
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\Http\HttpPackage;

return [
    'packages' => [
        // packages here...,
        HttpPackage::class,
    ],
    // ...
];
```