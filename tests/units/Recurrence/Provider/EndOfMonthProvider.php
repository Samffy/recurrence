<?php

namespace Recurrence\tests\units\Provider;

use Recurrence\Model\Frequency;
use Recurrence\Model\Recurrence;
use Recurrence\Provider\EndOfMonthProvider as TestedEndOfMonthProvider;

class EndOfMonthProvider extends \atoum
{
    public function testProvideWithCount(): void
    {
        $perioStartAt = new \DateTime('2017-01-01');

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            $perioStartAt,
            null,
            10,
        );

        $provider = new TestedEndOfMonthProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo(10)
        ;

        foreach ($datetimes as $datetime) {
            $this->assert
                ->object($datetime)
                ->isEqualTo($perioStartAt)
            ;

            $perioStartAt->modify('last day of next month');
        }
    }

    public function testProvideWithEndPeriod(): void
    {
        $perioStartAt = new \DateTime('2017-01-01');
        $periodEndAt = new \DateTime('2017-10-01');

        $recurrence = new Recurrence(
            new Frequency(Frequency::FREQUENCY_MONTHLY),
            1,
            $perioStartAt,
            $periodEndAt,
        );

        $provider = new TestedEndOfMonthProvider();
        $datetimes = $provider->provide($recurrence);

        $this->assert
            ->integer(count($datetimes))
            ->isEqualTo(9)
        ;

        foreach ($datetimes as $datetime) {
            $this->assert
                ->object($datetime)
                ->isEqualTo($perioStartAt)
            ;

            $perioStartAt->modify('last day of next month');
        }
    }
}
