<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use FilesystemIterator;
use PHPUnit\Framework\Assert;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function file_get_contents;
use function ksort;
use function strlen;
use function substr;

/**
 * The scratch directories a generating test writes into, and taking them
 * away again afterwards.
 *
 * Split out of {@see GeneratedTreeSandbox}, which composes it, so no call
 * site changed: a test still writes one `use GeneratedTreeSandbox;` and
 * reaches every helper. The split is the linecop 250-line cap on PHP, and
 * this is the half of that trait with no opinion about generators, plans or
 * emitted classes — it makes a directory, remembers it, deletes it, and (via
 * {@see snapshotPhpTree}) reads back what landed in it.
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

    /**
     * Every `.php` file under `$dir`, keyed by its path relative to `$dir`
     * and holding its full text — a comparable snapshot of a generated
     * tree. {@see ByteStabilityTest} and {@see JsonSchemaParityTest} both
     * want this: "did two runs (or two input forms) write the same bytes?"
     * is a diff over this map, not over the filesystem directly.
     *
     * @return array<string,string>
     */
    private static function snapshotPhpTree(string $dir): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        );

        $out = [];

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($dir) + 1);
            $out[$relative] = (string) file_get_contents($file->getPathname());
        }

        ksort($out);

        return $out;
    }
}
