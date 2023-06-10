<?php

declare(strict_types=1);

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        'strict_param' => true,
        'fopen_flags' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'native_constant_invocation' => [
            'include' => ['PNG_ALL_FILTERS'],
            'strict' => true,
        ],
        'array_indentation' => true,
        'static_lambda' => true,
        'return_assignment' => false,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters']
        ],
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => [],
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/src')
            ->in(__DIR__.'/tests')
    )
;
