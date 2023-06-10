<?php

namespace Recurrence\tests\units\Provider;

use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\OptimizedProvider as TestedOptimizedProvider;

class OptimizedProvider extends \atoum
{
    /**
     * @dataProvider datetimesWithoutIntervalProvider
     */
    public function testWithoutIntervalProvide(int $position, \DateTime $periodStartAt, int $countOption, \DateTime $expected): void
    {
        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            $periodStartAt,
            null,
            $countOption,
        );

        $provider = new TestedOptimizedProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo($countOption)
        ;

        $this->assert
            ->object($datetimes[$position])
            ->isEqualTo($expected)
        ;
    }

    /**
     * @dataProvider datetimesWithoutIntervalProvider
     */
    public function testWithoutIntervalAndWithoutCountProvide(int $position, \DateTime $periodStartAt, int $countOption, \DateTime $expected): void
    {
        $periodEndAt = clone $periodStartAt;
        $periodEndAt->modify(sprintf('+%d months', $countOption));

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            $periodStartAt,
            $periodEndAt,
        );

        $provider = new TestedOptimizedProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo($countOption)
        ;

        $this->assert
            ->object($datetimes[$position])
            ->isEqualTo($expected)
        ;
    }

    public function datetimesWithoutIntervalProvider(): array
    {
        return [
            [
                0,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-01-01'),
            ],
            [
                1,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-02-01'),
            ],
            [
                2,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-03-01'),
            ],
            [
                3,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-04-01'),
            ],
            [
                4,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-05-01'),
            ],
            [
                5,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-06-01'),
            ],
            [
                6,
                new \DateTime('2017-01-01'),
                10,
                new \DateTime('2017-07-01'),
            ],
        ];
    }

    /**
     * @dataProvider datetimesWithIntervalProvider
     */
    public function testWithIntervalProvide(int $position, \DateTime $periodStartAt, int $countOption, \DateTime $expected): void
    {
        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            2,
            $periodStartAt,
            null,
            $countOption,
        );

        $provider = new TestedOptimizedProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo($countOption)
        ;

        $this->assert
            ->object($datetimes[$position])
            ->isEqualTo($expected)
        ;
    }

    public function datetimesWithIntervalProvider(): array
    {
        return [
            [
                0,
                new \DateTime('2017-01-01'),
                4,
                new \DateTime('2017-01-01'),
            ],
            [
                1,
                new \DateTime('2017-01-01'),
                4,
                new \DateTime('2017-03-01'),
            ],
            [
                2,
                new \DateTime('2017-01-01'),
                4,
                new \DateTime('2017-05-01'),
            ],
            [
                3,
                new \DateTime('2017-01-01'),
                4,
                new \DateTime('2017-07-01'),
            ],
        ];
    }
}
