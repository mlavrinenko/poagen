<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function assert;

/**
 * Lists every file under `Generated/` that the current run did not emit.
 *
 * Guarded strictly to the `Generated/` subtree so user code alongside it is
 * never touched, and empty when the root does not yet exist — the first-ever
 * run has nothing to prune.
 *
 * @internal
 */
final readonly class PrunePlanner
{
    /**
     * @param  array<string,string> $writes
     * @return list<string>
     */
    public function plan(string $rootDir, array $writes): array
    {
        if (!is_dir($rootDir)) {
            return [];
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootDir, FilesystemIterator::SKIP_DOTS),
        );

        /** @var list<string> $prunes */
        $prunes = [];

        foreach ($iterator as $entry) {
            assert($entry instanceof SplFileInfo);

            if (!$entry->isFile()) {
                continue;
            }

            $path = $entry->getPathname();

            if (!isset($writes[$path])) {
                $prunes[] = $path;
            }
        }

        return $prunes;
    }
}
