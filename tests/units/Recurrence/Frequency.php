<?php

namespace Recurrence\tests\units;

require_once __DIR__ . '/../../../src/Recurrence/Frequency.php';

use atoum;

class Frequency extends atoum
{

    public function testConstructor ()
    {
        $this->assert
            ->exception(function() {
                new \Recurrence\Frequency('INVALID_FREQUENCY_NAME');
            })
            ->isInstanceOf('InvalidArgumentException')
        ;
    }

    public function testGetInterval()
    {
        $frequencies = [
            'YEARLY'   => 'P1Y',
            'MONTHLY'  => 'P1M',
            'WEEKLY'   => 'P1W',
            'DAILY'    => 'P1D',
            'HOURLY'   => 'PT1H',
            'MINUTELY' => 'PT1M',
            'SECONDLY' => 'PT1S',
        ];

        foreach ($frequencies as $freq => $interval) {
            $frequency = new \Recurrence\Frequency($freq);

            $this->assert
                ->string($frequency->getInterval())
                ->isEqualTo($interval);
        }
    }
}