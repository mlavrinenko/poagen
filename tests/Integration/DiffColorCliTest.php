<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Support\DiffOutputFixture;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * `--color=always|never|auto` wraps `poagen generate --diff`'s
 * additions/deletions/hunk headers in ANSI codes; `auto` (the default)
 * stays plain when stdout is not a real TTY
 * (coloured-and-path-filtered-diff-output).
 *
 * {@see GeneratedTreeSandbox::runGenerateCommand} always hands the command a
 * `php://memory` stream, never a real terminal, so a bare `--diff` here
 * doubles as the "piped to a file" case the task's byte-identical
 * requirement names. {@see DiffOutputFixture} is the sibling
 * `DiffPathFilterCliTest` shares this fixture setup with.
 */
final class DiffColorCliTest extends TestCase
{
    use DiffOutputFixture;

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testColorAlwaysEmitsAnsiCodesOnAdditionsAndDeletions(): void
    {
        [$exit, $stdout] = $this->diffAfterDirtying('--color=always');

        self::assertSame(1, $exit);
        self::assertStringContainsString("\e[32m+", $stdout);
        self::assertStringContainsString("\e[31m-", $stdout);
        self::assertStringContainsString("\e[36m@@ @@\e[0m", $stdout);
    }

    public function testColorNeverEmitsNoAnsiCodesAtAll(): void
    {
        [$exit, $stdout] = $this->diffAfterDirtying('--color=never');

        self::assertSame(1, $exit);
        self::assertStringNotContainsString("\e[", $stdout);
    }

    public function testColorAutoStaysPlainOnTheNonTtyMemoryStreamTheHarnessUses(): void
    {
        [$exit, $stdout] = $this->diffAfterDirtying('--color=auto');

        self::assertSame(1, $exit);
        self::assertStringNotContainsString("\e[", $stdout);
    }

    public function testBareDiffWithNoColorFlagDefaultsToAutoAndStaysPlain(): void
    {
        [$exit, $stdout] = $this->diffAfterDirtying(null);

        self::assertSame(1, $exit);
        self::assertStringNotContainsString("\e[", $stdout);
        self::assertStringContainsString('--- a/', $stdout);
        self::assertStringContainsString('+++ b/', $stdout);
    }

    public function testABogusColorValueExitsTwo(): void
    {
        $outputDir = self::makeSandboxDir('poagen-diff-color-bad-');
        $profilePath = $this->writeDiffOutputProfile($outputDir, 'Poagen\\\\Generator\\\\Tests\\\\Tmp\\\\DiffColorBad');

        [$exit, , $stderr] = self::runGenerateCommand([$profilePath, '--diff', '--color=rainbow']);

        self::assertSame(2, $exit);
        self::assertStringContainsString('--color', $stderr);
    }

    /**
     * Generates the fixture for real, then rewrites one property name in
     * the emitted `Widget.php` so a re-plan produces one hunk carrying both
     * a removed and an added line — a test needs both to prove `+` colours
     * green and `-` colours red independently of one another.
     *
     * @return array{0:int,1:string,2:string}
     */
    private function diffAfterDirtying(?string $colorFlag): array
    {
        $outputDir = self::makeSandboxDir('poagen-diff-color-');
        $profilePath = $this->writeDiffOutputProfile($outputDir, 'Poagen\\\\Generator\\\\Tests\\\\Tmp\\\\DiffColorCli');

        [$exit] = self::runGenerateCommand([$profilePath]);
        self::assertSame(0, $exit, 'fixture generation must succeed before it can be dirtied');

        $widgetPath = $outputDir . '/Generated/Model/Widget.php';
        $corrupted = str_replace('public string $name,', 'public string $nam,', (string) file_get_contents($widgetPath));
        file_put_contents($widgetPath, $corrupted);

        $args = [$profilePath, '--diff'];

        if ($colorFlag !== null) {
            $args[] = $colorFlag;
        }

        return self::runGenerateCommand($args);
    }
}
