<?php

namespace Recurrence\Rrule;

use Recurrence\Model\Exception\InvalidRecurrenceException;
use Recurrence\Model\Exception\InvalidRruleExpressionException;
use Recurrence\Model\Recurrence;
use Recurrence\Rrule\Extractor\CountExtractor;
use Recurrence\Rrule\Extractor\FreqExtractor;
use Recurrence\Rrule\Extractor\UntilExtractor;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Validator\RecurrenceValidator;

/**
 * Class RecurrenceProvider
 * @package Recurrence\Rrule
 */
class RecurrenceProvider
{

    /**
     * Map extractor/transformer names with Recurrence attributes
     * @var array
     */
    private $options = [
        'Count'            => 'count',
        'Interval'         => 'interval',
        'Freq'             => 'frequency',
        'DtStartTimezoned' => 'periodStartAt',
        'DtStart'          => 'periodStartAt',
        'UntilTimezoned'   => 'periodEndAt',
        'Until'            => 'periodEndAt',
    ];

    /**
     * @param string $rRule
     * @return Recurrence
     * @throws InvalidRruleException
     */
    public function create($rRule)
    {
        $recurrence = new Recurrence();

        // Process all options supported
        foreach ($this->options as $option => $attribute) {
            // Create extractor
            $className = 'Recurrence\Rrule\Extractor\\'.$option.'Extractor';
            $extractor = new $className();

            if ($values = $extractor->extract($rRule)) {

                // Create corresponding transformer
                $className = 'Recurrence\Rrule\Transformer\\'.$option.'Transformer';
                $transformer = new $className();

                // Set Recurrence attribute
                $recurrence = $this->setAttribute($recurrence, $attribute, $transformer->transform($values));
            }
        }

        try {
            RecurrenceValidator::validate($recurrence);
        } catch (InvalidRecurrenceException $e)  {
            throw new InvalidRruleExpressionException($e->getMessage());
        }

        return $recurrence;
    }

    /**
     * @param Recurrence $recurrence
     * @param string     $attribute
     * @param mixed      $value
     * @return Recurrence
     */
    private function setAttribute(Recurrence $recurrence, $attribute, $value)
    {
        $method = sprintf('set%s', ucfirst($attribute));

        if ($value && method_exists($recurrence, $method)) {
            $recurrence->$method($value);
        }

        return $recurrence;
    }
}
