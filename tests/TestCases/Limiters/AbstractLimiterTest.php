<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Limiters;

use Closure;
use PHPUnit\Framework\TestCase;
use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Counters\LocalCounter;
use Silencenjoyer\RateLimit\Limiters\LimiterInterface;
use stdClass;

/**
 * Class AbstractLimiterTest
 *
 * @package Limiters
 */
abstract class AbstractLimiterTest extends TestCase
{
    abstract protected function createInstance(CounterInterface $counter, int $exec, int $interval): LimiterInterface;

    protected function createCounter(): CounterInterface
    {
        return new LocalCounter();
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
     */
    public function testControl(int $exec, int $iterations, int $interval): void
    {
        $limiter = $this->createInstance($this->createCounter(), $exec, $interval);

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
     */
    public function testStretch(int $exec, int $iterations, int $interval): void
    {
        $limiter = $this->createInstance($this->createCounter(), $exec, $interval);

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
