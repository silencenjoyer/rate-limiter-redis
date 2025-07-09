# Short description of the package

This package is an extension for `silencenjoyer/rate-limiter` that allows you to measure the rate using redis.

## Installation

You can install the package via composer:

```bash
composer require silencenjoyer/rate-limiter-redis
```

## Usage

```php
use Silencenjoyer\RateLimitRedis\Counters\RedisCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Limiters\RateLimiter;
use Silencenjoyer\RateLimit\Rates\Rate;

$counter = new RedisCounter('rate:send:api', new Redis());
$rateLimiter = new RateLimiter($counter, new Rate(10, new Interval('PT1S')));

foreach ($messages as $message) {
    $rateLimiter->stretch(function() use ($api) {
        $api->post($message);
    });
}
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
