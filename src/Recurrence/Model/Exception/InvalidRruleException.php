<?php

namespace Recurrence\Model\Exception;

/**
 * Class InvalidRruleException
 * @package Recurrence\Model
 */
class InvalidRruleException extends \InvalidArgumentException
{
    /**
     * @param string $rRuleName
     * @param string $value
     */
    public function __construct($rRuleName, $value = null)
    {
        $message = sprintf('Invalid RRULE [%s] option : [%s]', $rRuleName, $value);

        parent::__construct($message, 400);
    }
}
