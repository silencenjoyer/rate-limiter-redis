<?php

namespace Limiters;

use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Limiters\LimiterInterface;
use Silencenjoyer\RateLimit\Limiters\RateLimiter;

/**
 * Class RateLimiterTest
 *
 * @package Limiters
 */
class RateLimiterTest extends AbstractLimiterTest
{
    protected function createInstance(CounterInterface $counter): LimiterInterface
    {
        return new RateLimiter($counter);
    }
}
