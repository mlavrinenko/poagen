<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use Composer\Autoload\ClassLoader;
use FilesystemIterator;
use PHPUnit\Framework\Assert;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function is_array;

/**
 * Scaffolding an integration test needs to generate a client into a scratch
 * directory, autoload it, and clean up afterwards.
 *
 * Every test under `tests/Integration/` grows its own copy of these three
 * helpers, which is a good share of the duplication `adopt-jscpd-duplication-gate`
 * measures in the suite. This is the shared one; `deduplicate-the-test-suite`
 * moves the remaining tests onto it.
 */
trait GeneratedTreeSandbox
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

    /**
     * The live Composer loader, so a generated namespace can be mapped onto
     * the scratch directory it was just written to.
     */
    private static function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        Assert::fail('Composer ClassLoader not found in autoload chain.');
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
