<?php

namespace Silencenjoyer\RateLimit\Limiters;

use Closure;
use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Intervals\IntervalInterface;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * Class RateLimiter
 *
 * @package Silencenjoyer\RateLimit
 */
class RateLimiter implements LimiterInterface
{
    protected CounterInterface $counter;
    protected RateInterface $rate;

    public function __construct(CounterInterface $counter, RateInterface $rate)
    {
        $this->counter = $counter;
        $this->rate = $rate;
    }

    /**
     * @return void
     */
    protected function ensureRate(): void
    {
        if ($this->isExceed()) {
            $remaining = $this->counter->getRemainingInterval();
            usleep($remaining->toMicroseconds());
            $this->ensureRate();
        }
    }

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function isExceed(): bool
    {
        return $this->counter->current() >= $this->rate->getMaxExecutions();
    }

    /**
     * {@inheritDoc}
     * @param int $count
     * @return void
     */
    public function collectUsage(int $count = 1): void
    {
        $this->counter->increment($count, $this->rate->getInterval());
    }

    /**
     * {@inheritDoc}
     * @param Closure $closure
     * @return mixed
     */
    public function stretch(Closure $closure)
    {
        $this->ensureRate();

        $microseconds = $this->rate->getInterval()->toMicroseconds();
        $maxExecutions = $this->rate->getMaxExecutions();
        // Average interval between executions in microseconds
        $interval = $microseconds / $maxExecutions;

        static $nextExpectedTime = null;

        if ($nextExpectedTime === null) {
            $nextExpectedTime = microtime(true);
        }
        $nextExpectedTime += $interval / IntervalInterface::MICROSECONDS_IN_SECOND;

        $this->collectUsage();
        $result = call_user_func($closure);

        $sleepTime = $nextExpectedTime - microtime(true);

        if ($sleepTime > 0) {
            usleep((int) ($sleepTime * IntervalInterface::MICROSECONDS_IN_SECOND));
        } else {
            $nextExpectedTime = microtime(true);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     * @param Closure $closure
     * @return mixed
     */
    public function control(Closure $closure)
    {
        $this->ensureRate();
        $this->collectUsage();

        return call_user_func($closure);
    }
}
