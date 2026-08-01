<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

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
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/unrepresentable-3.0.yaml';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
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
        $outputDir = self::makeSandboxDir('paogen-unrepresentable-cli-');
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
        $outputDir ??= self::makeSandboxDir('paogen-unrepresentable-cli-');
        $profilePath = $this->writeProfile($outputDir);

        return self::runGenerateCommand([$profilePath, ...$extraArgs]);
    }

    private function writeProfile(string $outputDir): string
    {
        $dir = self::makeSandboxDir('paogen-unrepresentable-profile-');
        $path = $dir . '/profile.php';

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
}
