<?php

namespace Silencenjoyer\RateLimit\Rates;

use Silencenjoyer\RateLimit\Intervals\IntervalInterface;

/**
 * Interface RateInterface
 */
interface RateInterface
{
    public function __construct(int $executions, IntervalInterface $interval);

    public function getMaxExecutions(): int;

    public function getInterval(): IntervalInterface;
}
