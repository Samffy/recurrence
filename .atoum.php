<?php

use \mageekguy\atoum;

$runner->addTestsFromDirectory(__DIR__ . '/src/');

$coverageHtmlField = new atoum\report\fields\runner\coverage\html('Recurrence', __DIR__ . '/var/code-coverage');
$coverageHtmlField->addSrcDirectory(__DIR__ . '/src');
//$coverageHtmlField->setRootUrl('http://localhost');

$script->noCodeCoverageForClasses(\Recurrence\Recurrence::class);

$script
    ->addDefaultReport()
        ->addField($coverageHtmlField)
;
