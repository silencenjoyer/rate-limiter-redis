<?php

namespace Silencenjoyer\RateLimit\Counters;

use Redis;
use RedisException;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Intervals\IntervalInterface;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * Class RedisCounter
 *
 * @package Silencenjoyer\RateLimit
 */
class RedisCounter implements CounterInterface
{
    protected Redis $redis;
    protected RateInterface $rate;
    protected string $id;

    public function __construct(string $id, Redis $redis)
    {
        $this->id = $id;
        $this->redis = $redis;
    }

    /**
     * {@inheritDoc}
     * @param RateInterface $rate
     * @return $this
     */
    public function setRate(RateInterface $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @return RateInterface
     */
    public function getRate(): RateInterface
    {
        return $this->rate;
    }

    /**
     * {@inheritDoc}
     * @return int|null
     * @throws RedisException
     */
    public function current(): ?int
    {
        return $this->redis->get($this->id) ?: null;
    }

    /**
     * {@inheritDoc}
     * @return void
     * @throws RedisException
     */
    public function increment(int $incr): void
    {
        $this->redis->incr($this->id, $incr);
        $ttl = $this->rate->getInterval()->toMilliseconds();
        $this->redis->pexpire($this->id, $ttl, 'NX');
    }

    /**
     * {@inheritDoc}
     * @return IntervalInterface
     */
    public function getRemainingInterval(): IntervalInterface
    {
        $ttl = $this->redis->pttl($this->id);
        $ttl = ($ttl < 0 ? 0 : $ttl * IntervalInterface::MILLISECONDS_IN_SECOND);

        $interval = new Interval('PT0S');
        $interval->f = $ttl;
        return $interval;
    }
}
