<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Intervals;

use PHPUnit\Framework\TestCase;
use Silencenjoyer\RateLimit\Intervals\IntervalInterface;

/**
 * Class BaseIntervalTest
 *
 * @package Silencenjoyer\tests
 */
abstract class AbstractIntervalTest extends TestCase
{
    abstract protected function createInstance(
        string $function,
        $duration
    ): IntervalInterface;

    /**
     * Data provider.
     * @return array
     */
    abstract public function getMicroseconds(): array;

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param mixed $duration
     * @param int $microseconds
     * @return void
     */
    public function testToMicroseconds($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $this->assertEquals($microseconds, $interval->toMicroseconds());
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToMilliseconds($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $this->assertEquals(
            $microseconds / IntervalInterface::MILLISECONDS_IN_SECOND,
            $interval->toMilliseconds()
        );
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToSeconds($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $this->assertEquals(
            $microseconds / IntervalInterface::MICROSECONDS_IN_SECOND,
            $interval->toSeconds()
        );
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToMinutes($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $divider = IntervalInterface::SEC_IN_MINUTE * IntervalInterface::MICROSECONDS_IN_SECOND;
        $this->assertEquals((int) ($microseconds / $divider), $interval->toMinutes());
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToHours($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $divider = IntervalInterface::SEC_IN_HOUR * IntervalInterface::MICROSECONDS_IN_SECOND;
        $this->assertEquals((int) ($microseconds / $divider), $interval->toHours());
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToDays($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $divider = IntervalInterface::SEC_IN_DAY * IntervalInterface::MICROSECONDS_IN_SECOND;
        $this->assertEquals((int) ($microseconds / $divider), $interval->toDays());
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToMonths($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $divider = IntervalInterface::SEC_IN_MOTH * IntervalInterface::MICROSECONDS_IN_SECOND;
        $this->assertEquals((int) ($microseconds / $divider), $interval->toMonths());
    }

    /**
     * @dataProvider getMicroseconds
     * @covers
     * @param $duration
     * @param int $microseconds
     * @return void
     */
    public function testToYears($duration, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, $duration);
        $divider = IntervalInterface::SEC_IN_YEAR * IntervalInterface::MICROSECONDS_IN_SECOND;
        $this->assertEquals((int) ($microseconds / $divider), $interval->toYears());
    }
}
