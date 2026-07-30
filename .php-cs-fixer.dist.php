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
        // Every symbol a file uses is named at the top of the file, not
        // re-qualified at each call site. `global_namespace_import` turns
        // `\json_decode(...)` into `use function json_decode;` plus a bare
        // call — the same direct resolution the leading backslash bought,
        // said once instead of everywhere. `fully_qualified_strict_types`
        // does the same for a class written out in full mid-file.
        //
        // This replaces `native_function_invocation`, which spells the
        // opposite convention. The two cannot both hold: one adds the
        // prefix the other removes.
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'fully_qualified_strict_types' => ['import_symbols' => true],
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
        'no_unused_imports' => true,
        'single_quote' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/build/cache/.php-cs-fixer.cache');
