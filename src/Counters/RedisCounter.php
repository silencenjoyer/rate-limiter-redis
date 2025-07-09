<?php

namespace Silencenjoyer\RateLimitRedis\Counters;

use Redis;
use RedisException;
use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Intervals\IntervalInterface;

/**
 * Class RedisCounter
 *
 * @package Silencenjoyer\RateLimit
 */
class RedisCounter implements CounterInterface
{
    protected Redis $redis;
    protected string $id;

    public function __construct(string $id, Redis $redis)
    {
        $this->id = $id;
        $this->redis = $redis;
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
     * @param int $incr
     * @param IntervalInterface $interval
     * @return void
     * @throws RedisException
     */
    public function increment(int $incr, IntervalInterface $interval): void
    {
        $this->redis->incr($this->id, $incr);
        $ttl = $interval->toMilliseconds();
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
