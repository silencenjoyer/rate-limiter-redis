<?php

namespace Silencenjoyer\RateLimit\Counters;

use Silencenjoyer\RateLimit\Intervals\IntervalInterface;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * Interface CounterInterface
 *
 * @package Silencenjoyer\RateLimit
 */
interface CounterInterface
{
    /**
     * An {@see RateInterface} setter.
     *
     * @param RateInterface $rate
     * @return self
     */
    public function setRate(RateInterface $rate): self;

    /**
     * An {@see RateInterface} getter.
     *
     * @return RateInterface
     */
    public function getRate(): RateInterface;

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
     * @return void
     */
    public function increment(int $incr): void;

    /**
     * Indicates the remaining interval until the rate window is reset.
     *
     * @return IntervalInterface
     */
    public function getRemainingInterval(): IntervalInterface;
}
