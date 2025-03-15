<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Limiters;

use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Limiters\LimiterInterface;
use Silencenjoyer\RateLimit\Limiters\RateLimiter;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * Class RateLimiterTest
 *
 * @package Limiters
 */
class RateLimiterTest extends AbstractLimiterTest
{
    protected function createInstance(CounterInterface $counter, int $exec, int $interval): LimiterInterface
    {
        $rate = $this->createMock(RateInterface::class);
        $rate->expects(self::any())
            ->method('getMaxExecutions')
            ->willReturn($exec)
        ;
        $rate->expects(self::any())
            ->method('getInterval')
            ->willReturn(new Interval(sprintf('PT%dS', $interval)))
        ;

        return new RateLimiter($counter, $rate);
    }
}
