<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Intervals;

use Exception;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Intervals\IntervalInterface;

/**
 * Class TestInterval
 *
 * @package Silencenjoyer\RateLimit\Tests
 */
class IntervalTest extends AbstractIntervalTest
{
    /**
     * @throws Exception
     */
    protected function createInstance(string $function, $duration): IntervalInterface
    {
        return new Interval($duration);
    }

    /**
     * {@inheritDoc}
     * @return array[]
     */
    public function getMicroseconds(): array
    {
        return [
            [
                'PT1S',
                1000000,
            ],
            [
                'PT2S',
                2000000,
            ],
            [
                'PT15S',
                15000000,
            ],
            [
                'PT1M',
                60000000,
            ],
            [
                'P1D',
                86400000000,
            ],
            [
                'P1DT1M15S',
                86475000000,
            ],
        ];
    }

    /**
     * Data provider.
     *
     * @return array[]
     */
    public function getSpecificMicroseconds(): array
    {
        return [
            [
                [
                    'f' => 500
                ],
                500,
            ],
            [
                [
                    's' => 1,
                    'f' => 200,
                ],
                1000200,
            ],
        ];
    }

    /**
     * @dataProvider getSpecificMicroseconds
     * @covers
     *
     * @throws Exception
     */
    public function testSpecificMicroseconds(array $properties, int $microseconds): void
    {
        $interval = $this->createInstance(__FUNCTION__, 'PT0S');
        foreach ($properties as $property => $val) {
            $interval->$property = $val;
        }
        $this->assertEquals($microseconds, $interval->toMicroseconds());
    }
}
