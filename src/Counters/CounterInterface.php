<?php

namespace Silencenjoyer\RateLimit\Counters;

use Silencenjoyer\RateLimit\Intervals\IntervalInterface;

/**
 * Interface CounterInterface
 *
 * @package Silencenjoyer\RateLimit
 */
interface CounterInterface
{
    /**
     * Current counter value.
     *
     * @return int|null current counter value or null if it has not yet been set.
     */
    public function current(): ?int;

    /**
     * Increment the counter.
     *
     * @param int $incr
     * @param IntervalInterface $interval
     * @return void
     */
    public function increment(int $incr, IntervalInterface $interval): void;

    /**
     * Indicates the remaining interval until the rate window is reset.
     *
     * @return IntervalInterface
     */
    public function getRemainingInterval(): IntervalInterface;
}
