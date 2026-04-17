<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/bin',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        // Managed by speconaut-phpunit. The *Test.php files are fully
        // regenerated; the *Steps.php files are append-only but keep a
        // $test property that's part of the adapter contract.
        __DIR__ . '/tests/generated',
    ])
    ->withCache(cacheDirectory: __DIR__ . '/build/cache/rector')
    ->withSets([
        LevelSetList::UP_TO_PHP_84,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
    ]);
