<?php

use \atoum\atoum;

$runner->addTestsFromDirectory(__DIR__ . '/src/');

// Exclude Recurrence classe, there is only getters and setters here
$script->noCodeCoverageForClasses(\Recurrence\Recurrence::class);

// Configure HTML code coverage report
$coverageHtmlField = new atoum\report\fields\runner\coverage\html('Recurrence', __DIR__ . '/var/code-coverage');
$coverageHtmlField->addSrcDirectory(__DIR__ . '/src');
$script
    ->addDefaultReport()
    ->addField($coverageHtmlField)
;

// Configure clover/xml code coverage report
$cloverWriter = new atoum\writers\file(__DIR__ . '/var/code-coverage/recurrence.coverage.xml');
$cloverReport = new atoum\reports\asynchronous\clover();
$cloverReport->addWriter($cloverWriter);
$runner->addReport($cloverReport);
