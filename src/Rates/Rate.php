<?php

namespace Silencenjoyer\RateLimit\Rates;

use Silencenjoyer\RateLimit\Intervals\IntervalInterface;

/**
 * Class Rate
 *
 * @package Silencenjoyer\RateLimit\Rates
 */
class Rate implements RateInterface
{
    protected int $executions;
    protected IntervalInterface $interval;

    public function __construct(int $executions, IntervalInterface $interval)
    {
        $this->executions = $executions;
        $this->interval = $interval;
    }

    public function getMaxExecutions(): int
    {
        return $this->executions;
    }

    public function getInterval(): IntervalInterface
    {
        return $this->interval;
    }
}
