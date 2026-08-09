<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\DiffColorizer;

use function assert;
use function fclose;
use function fopen;

/**
 * Unit coverage for {@see DiffColorizer} — ANSI colouring for
 * `poagen generate --diff --color=<when>`.
 *
 * {@see DiffColorizer::autoDetect} is the pure core `--color=auto` reduces
 * to, tested directly with plain booleans/strings rather than through a
 * real TTY or by mutating the process environment — exactly why
 * {@see DiffColorizer::shouldColor} is split into an I/O edge and this core.
 */
final class DiffColorizerTest extends TestCase
{
    public function testAutoDetectIsFalseForANonTtyStream(): void
    {
        self::assertFalse(DiffColorizer::autoDetect(false, false, false));
    }

    public function testAutoDetectIsFalseWhenNoColorIsSetToANonEmptyValue(): void
    {
        self::assertFalse(DiffColorizer::autoDetect(true, '1', false));
    }

    public function testAutoDetectIsFalseWhenTermIsDumb(): void
    {
        self::assertFalse(DiffColorizer::autoDetect(true, false, 'dumb'));
    }

    public function testAutoDetectIsTrueOnATtyWithNoOverride(): void
    {
        self::assertTrue(DiffColorizer::autoDetect(true, false, 'xterm-256color'));
    }

    public function testAutoDetectIgnoresAnEmptyNoColorValue(): void
    {
        // NO_COLOR's own spec: only a non-empty value opts out.
        self::assertTrue(DiffColorizer::autoDetect(true, '', false));
    }

    public function testShouldColorAlwaysIgnoresTheStreamAndEnvironment(): void
    {
        $stream = $this->memoryStream();

        self::assertTrue(DiffColorizer::shouldColor('always', $stream));

        fclose($stream);
    }

    public function testShouldColorNeverIgnoresTheStreamAndEnvironment(): void
    {
        $stream = $this->memoryStream();

        self::assertFalse(DiffColorizer::shouldColor('never', $stream));

        fclose($stream);
    }

    public function testShouldColorAutoIsFalseForAMemoryStreamSinceItIsNeverATty(): void
    {
        $stream = $this->memoryStream();

        self::assertFalse(DiffColorizer::shouldColor('auto', $stream));

        fclose($stream);
    }

    public function testApplyColoursAdditionsGreen(): void
    {
        $colored = DiffColorizer::apply("+added line\n");

        self::assertStringContainsString("\e[32m+added line\e[0m", $colored);
    }

    public function testApplyColoursDeletionsRed(): void
    {
        $colored = DiffColorizer::apply("-removed line\n");

        self::assertStringContainsString("\e[31m-removed line\e[0m", $colored);
    }

    public function testApplyColoursHunkHeadersCyan(): void
    {
        $colored = DiffColorizer::apply("@@ @@\n");

        self::assertStringContainsString("\e[36m@@ @@\e[0m", $colored);
    }

    public function testApplyLeavesFileHeadersUncolouredAndNotMistakenForContentLines(): void
    {
        $rendered = "--- a/foo.php\n+++ b/foo.php\n@@ @@\n-old\n+new\n";

        $colored = DiffColorizer::apply($rendered);

        self::assertStringStartsWith("--- a/foo.php\n+++ b/foo.php\n", $colored);
    }

    public function testApplyLeavesContextLinesUncoloured(): void
    {
        self::assertSame(" unchanged line\n", DiffColorizer::apply(" unchanged line\n"));
    }

    /**
     * @return resource
     */
    private function memoryStream()
    {
        $stream = fopen('php://memory', 'w+');
        assert($stream !== false);

        return $stream;
    }
}
