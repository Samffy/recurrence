<?php

namespace Recurrence\Rrule;

use Recurrence\Model\Recurrence;
use Recurrence\Model\Exception\InvalidRruleException;
use Recurrence\Model\Exception\InvalidRruleExpressionException;

class RecurrenceProvider
{
    /**
     * Map extractor/transformer names with Recurrence parameters
     */
    private array $options = [
        'Count',
        'Interval',
        'Freq',
        'DtStartTimezoned',
        'DtStart',
        'UntilTimezoned',
        'Until',
    ];

    /**
     * @return Recurrence
     * @throws InvalidRruleException
     */
    public function create(string $rRule): Recurrence
    {
        $parameters = [];

        // Process all options supported
        foreach ($this->options as $option) {
            $parameters[$option] = null;

            // Create extractor
            $className = 'Recurrence\Rrule\Extractor\\'.$option.'Extractor';
            $extractor = new $className();

            if ($values = $extractor->extract($rRule)) {
                // Create corresponding transformer
                $className = 'Recurrence\Rrule\Transformer\\'.$option.'Transformer';
                $transformer = new $className();

                $parameters[$option] = $transformer->transform($values);
            }
        }

        if (empty($parameters['Freq'])) {
            throw new InvalidRruleExpressionException(sprintf('Missing [Freq] option.'));
        }

        if (empty($parameters['Interval'])) {
            throw new InvalidRruleExpressionException(sprintf('Missing [Interval] option.'));
        }

        if (empty($parameters['DtStart']) && empty($parameters['DtStartTimezoned'])) {
            throw new InvalidRruleExpressionException(sprintf('Missing [DtStart] or [DtStartTimezoned] option.'));
        }

        if (empty($parameters['UntilTimezoned']) && empty($parameters['Until']) && empty($parameters['Count'])) {
            throw new InvalidRruleExpressionException(sprintf('Recurrence required [COUNT] or [UNTIL] option.'));
        }

        if ((!empty($parameters['UntilTimezoned']) || !empty($parameters['Until'])) && !empty($parameters['Count'])) {
            throw new InvalidRruleExpressionException(sprintf('Recurrence cannot have [COUNT] and [UNTIL] option at the same time.'));
        }

        return new Recurrence(
            $parameters['Freq'],
            $parameters['Interval'],
            $parameters['DtStartTimezoned'] ?? $parameters['DtStart'],
            $parameters['UntilTimezoned'] ?? $parameters['Until'],
            $parameters['Count']
        );
    }
}
