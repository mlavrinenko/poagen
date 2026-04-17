<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/bin'])
    // Generated fixtures are nette/php-generator's canonical output (ADR-004).
    // cs-fixer disagrees with nette on a few stylistic choices (e.g. empty
    // body collapse); excluding them keeps the generator deterministic.
    ->exclude(['fixtures/generated']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS2x0' => true,
        '@PER-CS2x0:risky' => true,
        '@PHP8x4Migration' => true,
        'declare_strict_types' => true,
        'native_function_invocation' => ['include' => ['@compiler_optimized']],
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
        'no_unused_imports' => true,
        'single_quote' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/build/cache/.php-cs-fixer.cache');
