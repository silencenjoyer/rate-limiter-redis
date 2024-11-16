<?php

namespace Silencenjoyer\RateLimit\Intervals;

/**
 * Interface IntervalInterface
 *
 * @package Silencenjoyer\RateLimit
 */
interface IntervalInterface
{
    /**
     * Microseconds in second.
     */
    const MICROSECONDS_IN_SECOND = 1000000;
    /**
     * Milliseconds in second.
     */
    const MILLISECONDS_IN_SECOND = 1000;
    /**
     * Seconds in minute.
     */
    const SEC_IN_MINUTE = 60;
    /**
     * Seconds in hour.
     */
    const SEC_IN_HOUR = 3600;
    /**
     * Seconds in day.
     */
    const SEC_IN_DAY = 86400;
    /**
     * Seconds in month (average value for 30 days).
     */
    const SEC_IN_MOTH = 2592000;
    /**
     * Seconds in year (365 days).
     */
    const SEC_IN_YEAR = 31536000;

    /**
     * The value of the interval in microseconds.<br>
     * A microsecond is a unit of time equal to one millionth of a second.
     *
     * @return int
     */
    public function toMicroseconds(): int;

    /**
     * The value of the interval in milliseconds.<br>
     * A microsecond is a unit of time equal to one thousandth of a second.
     *
     * @return int
     */
    public function toMilliseconds(): int;

    /**
     * The value of the interval in seconds.
     *
     * @return int
     */
    public function toSeconds(): int;

    /**
     * The value of the interval in minutes.
     *
     * @return int
     */
    public function toMinutes(): int;

    /**
     * The value of the interval in hours.
     *
     * @return int
     */
    public function toHours(): int;

    /**
     * The value of the interval in days.
     *
     * @return int
     */
    public function toDays(): int;

    /**
     * The value of the interval in months.
     *
     * @return int
     */
    public function toMonths(): int;

    /**
     * The value of the interval in years.
     * @return int
     */
    public function toYears(): int;
}
