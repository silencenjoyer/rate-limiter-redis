<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Counters;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * Class AbstractCounterTest
 */
abstract class AbstractCounterTest extends TestCase
{
    /**
     * Specific tested class name.
     *
     * @return string
     */
    abstract public function getClassName(): string;

    /**
     * Data provider for {@see testIncrement}.
     * @return array
     */
    abstract public function incrementProvider(): array;

    /**
     * @throws ReflectionException
     */
    public function createInstance(array $args = []): CounterInterface
    {
        $reflection = new ReflectionClass($this->getClassName());
        if ($reflection->getConstructor() !== null) {
            return $reflection->newInstanceArgs($args);
        } else {
            return $reflection->newInstanceWithoutConstructor();
        }
    }

    /**
     * @covers
     * @dataProvider incrementProvider
     * @throws ReflectionException
     */
    public function testIncrement(
        array $args,
        RateInterface $rate,
        int $incr
    ): void {
        $counter = $this->createInstance($args);
        $counter->setRate($rate);
        $before = (int) $counter->current();

        $counter->increment($incr);

        $this->assertEquals($before + $incr, $counter->current());
    }
}
