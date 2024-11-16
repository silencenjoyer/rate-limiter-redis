<?php

namespace Silencenjoyer\RateLimit\Intervals;

use DateInterval;

/**
 * Class Interval
 *
 * @package Silencenjoyer\RateLimit
 */
class Interval extends DateInterval implements IntervalInterface
{
    /**
     * {@inheritDoc}
     */
    public function toMicroseconds(): int
    {
        return $this->toSeconds() * self::MICROSECONDS_IN_SECOND + (int) $this->f;
    }

    /**
     * {@inheritDoc}
     */
    public function toMilliseconds(): int
    {
        return $this->toSeconds() * self::MILLISECONDS_IN_SECOND + (int) ($this->f / self::MILLISECONDS_IN_SECOND);
    }

    /**
     * {@inheritDoc}
     */
    public function toSeconds(): int
    {
        $seconds = $this->s;
        $seconds += $this->i * self::SEC_IN_MINUTE;
        $seconds += $this->h * self::SEC_IN_HOUR;
        $seconds += $this->d * self::SEC_IN_DAY;
        $seconds += $this->m * self::SEC_IN_MOTH;
        $seconds += $this->y * self::SEC_IN_YEAR;

        return $seconds;
    }

    /**
     * {@inheritDoc}
     */
    public function toMinutes(): int
    {
        return floor($this->toSeconds() / self::SEC_IN_MINUTE);
    }

    /**
     * {@inheritDoc}
     */
    public function toHours(): int
    {
        return floor($this->toSeconds() / self::SEC_IN_HOUR);
    }

    /**
     * {@inheritDoc}
     */
    public function toDays(): int
    {
        return floor($this->toSeconds() / self::SEC_IN_DAY);
    }

    /**
     * {@inheritDoc}
     */
    public function toMonths(): int
    {
        return floor($this->toSeconds() / self::SEC_IN_MOTH);
    }

    /**
     * {@inheritDoc}
     */
    public function toYears(): int
    {
        return floor($this->toSeconds() / self::SEC_IN_YEAR);
    }
}
