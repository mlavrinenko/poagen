<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Support\DiffOutputFixture;

/**
 * `--diff=<glob>` scopes `poagen generate --diff` to a subtree of the
 * generated output; a bare `--diff` keeps rendering everything, exactly as
 * before T-019 shipped it (coloured-and-path-filtered-diff-output).
 *
 * {@see DiffOutputFixture} generates one fixture with both a Generated/Model
 * file and a top-level Generated/ file, which is what a glob test needs: one
 * match and one non-match, to prove a filter narrows anything at all.
 */
final class DiffPathFilterCliTest extends TestCase
{
    use DiffOutputFixture;

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testALiteralPrefixGlobNarrowsTheDiffToThatSubtree(): void
    {
        [, $profilePath] = $this->generateOnceAndDirty();

        [$exit, $stdout] = self::runGenerateCommand([$profilePath, '--diff=Generated/Model']);

        self::assertSame(1, $exit);
        self::assertStringContainsString('Generated/Model/Widget.php', $stdout);
        self::assertStringNotContainsString('Generated/ApiClient.php', $stdout);
    }

    public function testADoubleStarGlobIsEquivalentToTheLiteralPrefixForm(): void
    {
        [, $profilePath] = $this->generateOnceAndDirty();

        [$exit, $stdout] = self::runGenerateCommand([$profilePath, '--diff=Generated/Model/**']);

        self::assertSame(1, $exit);
        self::assertStringContainsString('Generated/Model/Widget.php', $stdout);
        self::assertStringNotContainsString('Generated/ApiClient.php', $stdout);
    }

    public function testASingleStarGlobDoesNotCrossIntoASubdirectory(): void
    {
        [, $profilePath] = $this->generateOnceAndDirty();

        [$exit, $stdout] = self::runGenerateCommand([$profilePath, '--diff=Generated/*.php']);

        self::assertSame(1, $exit);
        self::assertStringContainsString('Generated/ApiClient.php', $stdout);
        self::assertStringNotContainsString('Generated/Model/Widget.php', $stdout);
    }

    public function testAGlobMatchingNothingExitsZeroWithNoOutput(): void
    {
        [, $profilePath] = $this->generateOnceAndDirty();

        [$exit, $stdout] = self::runGenerateCommand([$profilePath, '--diff=NoSuchDirectory/**']);

        self::assertSame(0, $exit);
        self::assertSame('', $stdout);
    }

    public function testABareDiffOutputIsUnchangedAndStillRendersEverything(): void
    {
        [, $profilePath] = $this->generateOnceAndDirty();

        [$exit, $stdout] = self::runGenerateCommand([$profilePath, '--diff']);

        self::assertSame(1, $exit);
        self::assertStringContainsString('Generated/Model/Widget.php', $stdout);
        self::assertStringContainsString('Generated/ApiClient.php', $stdout);
    }

    public function testAnEmptyDiffValueExitsTwo(): void
    {
        $outputDir = self::makeSandboxDir('poagen-diff-filter-empty-');
        $profilePath = $this->writeDiffOutputProfile($outputDir, 'Poagen\\\\Generator\\\\Tests\\\\Tmp\\\\DiffPathFilterEmpty');

        [$exit, , $stderr] = self::runGenerateCommand([$profilePath, '--diff=']);

        self::assertSame(2, $exit);
        self::assertStringContainsString('--diff', $stderr);
    }

    /**
     * Generates the fixture for real into a fresh sandbox, then dirties two
     * files on disk (one under Generated/Model/, one a top-level Generated/
     * file) so a subsequent `--diff` run has something to report for both.
     * Hands back the same profile path used for the first generate, so a
     * caller's second (--diff) invocation targets the exact tree just
     * dirtied rather than a fresh, unrelated one.
     *
     * @return array{0:string,1:string} [$outputDir, $profilePath]
     */
    private function generateOnceAndDirty(): array
    {
        $outputDir = self::makeSandboxDir('poagen-diff-filter-');
        $profilePath = $this->writeDiffOutputProfile($outputDir, 'Poagen\\\\Generator\\\\Tests\\\\Tmp\\\\DiffPathFilterCli');

        [$exit] = self::runGenerateCommand([$profilePath]);
        self::assertSame(0, $exit, 'fixture generation must succeed before it can be dirtied');

        file_put_contents($outputDir . '/Generated/Model/Widget.php', "\n// dirtied for the test\n", FILE_APPEND);
        file_put_contents($outputDir . '/Generated/ApiClient.php', "\n// dirtied for the test\n", FILE_APPEND);

        return [$outputDir, $profilePath];
    }
}
