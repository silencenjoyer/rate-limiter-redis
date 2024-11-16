# Short description of the package

This package provides possibility to control and manage execution flow.

## Installation

You can install the package via composer:

```bash
composer require silencenjoyer/rate-limiter
```

## Usage

```php
use Silencenjoyer\RateLimit\Counters\RedisCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Limiters\RateLimiter;
use Silencenjoyer\RateLimit\Rates\Rate;

$counter = (new RedisCounter('rate:send:api', new Redis()))
    ->setRate(new Rate(10, new Interval('PT1S')))
;
$rateLimiter = new RateLimiter($counter);

foreach ($messages as $message) {
    $rateLimiter->stretch(function() use ($api) {
        $api->post($message);
    });
}
```
```php
use Silencenjoyer\RateLimit\Counters\LocalCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Limiters\RateLimiter;
use Silencenjoyer\RateLimit\Rates\Rate;

require_once __DIR__ . '/vendor/autoload.php';

$counter = (new LocalCounter())
    ->setRate(new Rate(5, new Interval('PT1S')))
;
$rateLimiter = new RateLimiter($counter);

if (!$rateLimiter->isExceed()) {
    $rateLimiter->collectUsage();
    // do some logic
}
throw new RuntimeException('Rate limit has been exceeded.');
```

### Testing

```bash
composer test  
composer test-coverage  
docker-compose -f tests/docker/docker-compose.test.yml up
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email an_gebrich@outlook.com instead of using the issue tracker.

## Credits

-   [Andrew Gebrich](https://github.com/silencenjoyer)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
