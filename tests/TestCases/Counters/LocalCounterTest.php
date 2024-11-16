<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Counters;

use Silencenjoyer\RateLimit\Counters\LocalCounter;

/**
 * Class LocalCounterTest
 *
 * @package Counters
 */
class LocalCounterTest extends RedisCounterTest
{
    /**
     * {@inheritDoc}
     * @return string
     */
    public function getClassName(): string
    {
        return LocalCounter::class;
    }
}
