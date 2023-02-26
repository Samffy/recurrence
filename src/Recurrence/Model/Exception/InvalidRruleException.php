<?php

namespace Recurrence\Model\Exception;

class InvalidRruleException extends \InvalidArgumentException
{
    public function __construct(string $rRuleName, string $value = null)
    {
        $message = sprintf('Invalid RRULE [%s] option : [%s]', $rRuleName, $value);

        parent::__construct($message, 400);
    }
}
