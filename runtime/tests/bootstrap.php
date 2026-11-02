<?php

declare(strict_types=1);

// The runtime is checked out in two shapes: its own repository, where
// `vendor/` sits beside `tests/`, and the monorepo, where the root `vendor/`
// is shared. Find whichever one is present.
$autoloaders = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
];

foreach ($autoloaders as $autoloader) {
    if (is_file($autoloader)) {
        require $autoloader;

        return;
    }
}

throw new RuntimeException('could not locate composer autoloader for the runtime tests');
