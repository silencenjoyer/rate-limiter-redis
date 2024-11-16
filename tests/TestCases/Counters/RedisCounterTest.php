<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Counters;

use Redis;
use Silencenjoyer\RateLimit\Counters\RedisCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Rates\Rate;

/**
 * Class RedisCounterTest
 *
 * @package Counters
 */
class RedisCounterTest extends AbstractCounterTest
{
    /**
     * {@inheritDoc}
     * @return string
     */
    public function getClassName(): string
    {
        return RedisCounter::class;
    }

    /**
     * {@inheritDoc}
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
}
