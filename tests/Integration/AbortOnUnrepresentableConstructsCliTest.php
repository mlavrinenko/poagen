<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Composer\Autoload\ClassLoader;
use FilesystemIterator;
use Mlavrinenko\Paogen\GenerateCommand;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function assert;
use function is_array;

use const DIRECTORY_SEPARATOR;

/**
 * abort-on-unrepresentable-constructs, CLI surface: `--dry-run`, `--diff`,
 * and a plain `generate` must all fail the same way — non-zero exit, the
 * collected problem report on stderr, nothing written — instead of the
 * `--dry-run` path's old "always exits 0" behaviour.
 *
 * Uses the same fixture as {@see AbortOnUnrepresentableConstructsTest}, via
 * a profile file written to a temp path per test (`GenerateCommand::run()`
 * takes a profile *file path*, not a `Profile` object).
 */
final class AbortOnUnrepresentableConstructsCliTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/unrepresentable-3.0.yaml';

    /** @var list<string> */
    private array $paths = [];

    protected function tearDown(): void
    {
        foreach ($this->paths as $path) {
            if (is_dir($path)) {
                $this->removeDirectory($path);

                continue;
            }
            if (is_file($path)) {
                unlink($path);
            }
        }

        parent::tearDown();
    }

    public function testDryRunFailsWithNonZeroExitAndReportsTheProblem(): void
    {
        [$exit, , $stderr] = $this->invokeGenerate(['--dry-run']);

        self::assertSame(1, $exit);
        self::assertStringContainsString('2 problems found', $stderr);
    }

    public function testDiffFailsTheSameWayAsGenerate(): void
    {
        [$exit, , $stderr] = $this->invokeGenerate(['--diff']);

        self::assertSame(1, $exit);
        self::assertStringContainsString('2 problems found', $stderr);
    }

    public function testPlainGenerateFailsWithNonZeroExitAndWritesNothing(): void
    {
        $outputDir = $this->makeOutputDir();
        [$exit, $stdout, $stderr] = $this->invokeGenerate([], $outputDir);

        self::assertSame(1, $exit);
        self::assertStringContainsString('2 problems found', $stderr);
        self::assertStringNotContainsString('generated into', $stdout);
        self::assertDirectoryDoesNotExist($outputDir . DIRECTORY_SEPARATOR . 'Generated');
    }

    /**
     * @param  list<string>              $extraArgs
     * @return array{0:int,1:string,2:string}
     */
    private function invokeGenerate(array $extraArgs, ?string $outputDir = null): array
    {
        $outputDir ??= $this->makeOutputDir();
        $profilePath = $this->writeProfile($outputDir);

        $stdout = fopen('php://memory', 'w+');
        $stderr = fopen('php://memory', 'w+');
        assert($stdout !== false && $stderr !== false);

        $exit = GenerateCommand::run([$profilePath, ...$extraArgs], $this->composerLoader(), $stdout, $stderr);

        rewind($stdout);
        rewind($stderr);
        $out = (string) stream_get_contents($stdout);
        $err = (string) stream_get_contents($stderr);
        fclose($stdout);
        fclose($stderr);

        return [$exit, $out, $err];
    }

    private function writeProfile(string $outputDir): string
    {
        $path = tempnam(sys_get_temp_dir(), 'paogen-unrepresentable-profile-') . '.php';
        $this->paths[] = $path;

        $schema = var_export(self::SCHEMA, true);
        $output = var_export($outputDir, true);

        file_put_contents($path, <<<PHP
            <?php
            declare(strict_types=1);
            use Mlavrinenko\\Paogen\\Generator\\Profile;
            return new Profile(
                schema: {$schema},
                output: {$output},
                namespace: 'Mlavrinenko\\\\Paogen\\\\Tests\\\\Tmp\\\\UnrepresentableCli',
            );
            PHP);

        return $path;
    }

    private function makeOutputDir(): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'paogen-unrepresentable-cli-');
        unlink($path);
        $this->paths[] = $path;

        return $path;
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        self::fail('Composer ClassLoader not found in autoload chain.');
    }

    private function removeDirectory(string $dir): void
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
