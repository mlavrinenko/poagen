<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use Composer\Autoload\ClassLoader;
use FilesystemIterator;
use Mlavrinenko\Paogen\GenerateCommand;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use PHPUnit\Framework\Assert;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function assert;
use function is_array;

/**
 * Scaffolding an integration test needs to generate a client into a scratch
 * directory, autoload it, and clean up afterwards.
 *
 * Every test under `tests/Integration/` grows its own copy of these four
 * helpers, which is a good share of the duplication `adopt-jscpd-duplication-gate`
 * measures in the suite. This is the shared one; `deduplicate-the-test-suite`
 * moves the remaining tests onto it.
 */
trait GeneratedTreeSandbox
{
    /** @var list<string> */
    private static array $sandboxDirs = [];

    /**
     * A `Generator` wired to the live autoload chain — the one piece of
     * `new Generator(new AttributeScanner(...))` every integration test
     * needs and none of them vary. What the generator is asked to produce
     * (the schema, the profile, the namespace) stays at the call site.
     */
    private static function generator(): Generator
    {
        return new Generator(new AttributeScanner(self::composerLoader()));
    }

    /**
     * Runs `paogen generate` against a profile file already on disk and
     * captures its exit code, stdout and stderr in memory rather than the
     * process's real streams. The profile path and any CLI flags — the
     * part that varies between a `--dry-run`, a `--diff` and a plain run —
     * stay the caller's; this only owns capturing what the command printed.
     *
     * @param  list<string>              $argv the profile path, then any CLI flags
     * @return array{0:int,1:string,2:string}
     */
    private static function runGenerateCommand(array $argv): array
    {
        $stdout = fopen('php://memory', 'w+');
        $stderr = fopen('php://memory', 'w+');
        assert($stdout !== false && $stderr !== false);

        $exit = GenerateCommand::run($argv, self::composerLoader(), $stdout, $stderr);

        rewind($stdout);
        rewind($stderr);
        $out = (string) stream_get_contents($stdout);
        $err = (string) stream_get_contents($stderr);
        fclose($stdout);
        fclose($stderr);

        return [$exit, $out, $err];
    }

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
