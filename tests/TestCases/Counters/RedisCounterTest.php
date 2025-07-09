<?php

namespace Silencenjoyer\RateLimitRedis\Tests\TestCases\Counters;

use PHPUnit\Framework\TestCase;
use Redis;
use Silencenjoyer\RateLimitRedis\Counters\RedisCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Rates\Rate;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * Class RedisCounterTest
 *
 * @package Counters
 */
class RedisCounterTest extends TestCase
{
    /**
     * @return array[]
     */
    public function incrementProvider(): array
    {
        return [
            [
                ['test', new Redis(['host' => 'redis'])],
                new Rate(5, new Interval('PT1S')),
                1,
            ],
            [
                ['test_2', new Redis(['host' => 'redis'])],
                new Rate(5, new Interval('PT1S')),
                3,
            ],
        ];
    }

    /**
     * @covers
     * @dataProvider incrementProvider
     * @param array $args
     * @param RateInterface $rate
     * @param int $incr
     * @return void
     */
    public function testIncrement(array $args, RateInterface $rate, int $incr): void
    {
        $counter = new RedisCounter(...$args);
        $before = (int) $counter->current();

        $counter->increment($incr, $rate->getInterval());

        $this->assertEquals($before + $incr, $counter->current());
    }
}
