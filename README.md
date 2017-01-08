# PHP integration of the Jobs2Careers API

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
