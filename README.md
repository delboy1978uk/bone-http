# http
[![Latest Stable Version](https://poser.pugx.org/delboy1978uk/bone-http/v/stable)](https://packagist.org/packages/delboy1978uk/bone-http) [![Total Downloads](https://poser.pugx.org/delboy1978uk/bone/downloads)](https://packagist.org/packages/delboy1978uk/bone) [![Latest Unstable Version](https://poser.pugx.org/delboy1978uk/bone-http/v/unstable)](https://packagist.org/packages/delboy1978uk/bone-http) [![License](https://poser.pugx.org/delboy1978uk/bone-http/license)](https://packagist.org/packages/delboy1978uk/bone-http)<br />
[![Build Status](https://travis-ci.org/delboy1978uk/bone-http.png?branch=master)](https://travis-ci.org/delboy1978uk/bone-http) [![Code Coverage](https://scrutinizer-ci.com/g/delboy1978uk/bone-http/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/bone-http/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/delboy1978uk/bone-http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/bone-http/?branch=master)<br />

Http Middleware stack and HAL middleware for Bone Framework. 
## installation
This is a core package of Bone Framework. It is installed by default.
### usage
#### middleware stack
To add application wide middleware that will run pre-routing, just add your middleware class into your 
`config/middleware.php` file. For instance, to use the `delboy1978uk/bone-firewall` middleware:
```php
<?php

use Bone\Firewall\RouteFirewall;

return [
    'stack' => [
        RouteFirewall::class,
    ],
];
```
You can add middleware of course to the router's stack, either on a group of routes or an individual route.
#### bundled middleware
This package comes with two middleware classes for representing HAL links for an API.
For a single entity, you can use the `Bone\Http\Middleware\HalEntity`, and for an array you can use the
`Bone\Http\Middleware\HalCollection`. 