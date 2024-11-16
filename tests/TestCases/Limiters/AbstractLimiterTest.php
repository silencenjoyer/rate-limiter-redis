<?php

namespace Limiters;

use Closure;
use DateMalformedIntervalStringException;
use PHPUnit\Framework\TestCase;
use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Counters\LocalCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Limiters\LimiterInterface;
use Silencenjoyer\RateLimit\Rates\RateInterface;
use stdClass;

/**
 * Class AbstractLimiterTest
 *
 * @package Limiters
 */
abstract class AbstractLimiterTest extends TestCase
{
    abstract protected function createInstance(CounterInterface $counter): LimiterInterface;

    /**
     * @throws DateMalformedIntervalStringException
     */
    protected function createCounter(int $exec, int $interval): CounterInterface
    {
        $counter = new LocalCounter();

        $rate = $this->createMock(RateInterface::class);
        $rate->expects(self::any())
            ->method('getMaxExecutions')
            ->willReturn($exec)
        ;
        $rate->expects(self::any())
            ->method('getInterval')
            ->willReturn(new Interval(sprintf('PT%dS', $interval)))
        ;

        $counter->setRate($rate);

        return $counter;
    }

    /**
     * Data provider for {@see testControl}.
     *
     * @return array[]
     */
    public function configProvider(): array
    {
        return [
            [
                5, 25, 1,
            ],
            [
                25, 25, 1,
            ],
            [
                25, 50, 3,
            ],
            [
                15, 20, 2,
            ],
        ];
    }

    /**
     * @covers
     * @dataProvider configProvider
     * @param int $exec
     * @param int $iterations
     * @param int $interval
     * @return void
     * @throws DateMalformedIntervalStringException
     */
    public function testControl(int $exec, int $iterations, int $interval): void
    {
        $limiter = $this->createInstance(
            $this->createCounter($exec, $interval)
        );

        $mock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['__invoke'])
            ->getMock()
        ;
        $mock->expects(self::exactly($iterations))
            ->method('__invoke')
        ;

        $before = (int) microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $limiter->control(Closure::fromCallable([$mock, '__invoke']));
        }
        $after = (int) microtime(true);

        $this->assertGreaterThanOrEqual(
            ceil($iterations / $exec) * $interval - $interval,
            $after - $before + 1
        );
    }

    /**
     * @covers
     * @dataProvider configProvider
     * @param int $exec
     * @param int $iterations
     * @param int $interval
     * @return void
     * @throws DateMalformedIntervalStringException
     */
    public function testStretch(int $exec, int $iterations, int $interval): void
    {
        $limiter = $this->createInstance(
            $this->createCounter($exec, $interval)
        );

        $mock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['__invoke'])
            ->getMock()
        ;
        $mock->expects(self::exactly($iterations))
            ->method('__invoke')
        ;

        $before = (int) microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $limiter->stretch(Closure::fromCallable([$mock, '__invoke']));
        }
        $after = (int) microtime(true);

        $this->assertGreaterThanOrEqual(
            ceil($iterations / $exec * $interval),
            $after - $before + 1
        );
    }
}
