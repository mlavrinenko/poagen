<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use FilesystemIterator;
use PHPUnit\Framework\Assert;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * The scratch directories a generating test writes into, and taking them
 * away again afterwards.
 *
 * Split out of {@see GeneratedTreeSandbox}, which composes it, so no call
 * site changed: a test still writes one `use GeneratedTreeSandbox;` and
 * reaches every helper. The split is the linecop 250-line cap on PHP, and
 * this is the half of that trait with no opinion about generators, plans or
 * emitted classes — it makes a directory, remembers it, and deletes it.
 */
trait SandboxDirectories
{
    /** @var list<string> */
    private static array $sandboxDirs = [];

    /**
     * A fresh scratch directory, remembered so {@see removeSandboxDirs} can
     * take it away again.
     */
    private static function makeSandboxDir(string $prefix): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), $prefix);
        unlink($path);

        if (!mkdir($path, 0o755, true) && !is_dir($path)) {
            Assert::fail("failed to create temporary directory: {$path}");
        }

        self::$sandboxDirs[] = $path;

        return $path;
    }

    private static function removeSandboxDirs(): void
    {
        foreach (self::$sandboxDirs as $dir) {
            if (is_dir($dir)) {
                self::removeDirectory($dir);
            }
        }

        self::$sandboxDirs = [];
    }

    private static function removeDirectory(string $dir): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        /** @var SplFileInfo $entry */
        foreach ($iterator as $entry) {
            if ($entry->isDir()) {
                rmdir($entry->getPathname());

                continue;
            }

            unlink($entry->getPathname());
        }

        rmdir($dir);
    }
}
