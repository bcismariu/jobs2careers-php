# PHP integration of the Jobs2Careers API

[![Build Status](https://travis-ci.org/bcismariu/jobs2careers-php.svg?branch=master)](https://travis-ci.org/bcismariu/jobs2careers-php)
[![Latest Stable Version](https://poser.pugx.org/bcismariu/jobs2careers-php/v/stable)](https://packagist.org/packages/bcismariu/jobs2careers-php)
[![License](https://poser.pugx.org/bcismariu/jobs2careers-php/license)](https://packagist.org/packages/bcismariu/jobs2careers-php)
[![Total Downloads](https://poser.pugx.org/bcismariu/jobs2careers-php/downloads)](https://packagist.org/packages/bcismariu/jobs2careers-php)

### Installation
Update your `composer.json` file
```json
{
    "require": {
        "bcismariu/jobs2careers-php": "0.*"
    }
}
```
Run `composer update`

### Usage
```php
use Bcismariu\Jobs2Careers\Jobs2Careers;

$provider = new Jobs2Careers([
    'id'    => 'your-id',
    'pass'  => 'your-pass',
    'ip'    => 'your-ip'
]);
$results = $provider->setQuery('Warehouse Worker')
     ->setLocation('31131')
     ->get();
```

### Contributions

This is a very basic implementation that can only handle basic calls. Any project contributions are welcomed!
