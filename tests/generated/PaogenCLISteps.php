<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Mlavrinenko\Paogen\Cli;
use PHPUnit\Framework\TestCase;

/**
 * Step implementations for PaogenCLI.
 * This file is yours — speconaut only appends new step stubs.
 */
final class PaogenCLISteps
{
    private readonly TestCase $test;

    private string $stdout = '';
    private string $stderr = '';
    private int $exitCode = 0;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    /**
     * @param list<string> $argv
     */
    private function invokeCli(array $argv): void
    {
        $outStream = fopen('php://memory', 'w+');
        $errStream = fopen('php://memory', 'w+');
        \assert($outStream !== false && $errStream !== false);

        $this->exitCode = Cli::run($argv, $outStream, $errStream);

        rewind($outStream);
        rewind($errStream);
        $this->stdout = (string) stream_get_contents($outStream);
        $this->stderr = (string) stream_get_contents($errStream);

        fclose($outStream);
        fclose($errStream);
    }

    public function whenPaogenCLIIsInvokedWithNoArguments(): void
    {
        $this->invokeCli(['paogen']);
    }

    public function thenStdoutShouldContainUSAGE(): void
    {
        TestCase::assertStringContainsString('USAGE', $this->stdout);
    }

    public function thenPaogenCLIShouldExitWithCodeCode(int $code): void
    {
        TestCase::assertSame($code, $this->exitCode);
    }

    public function whenPaogenCLIIsInvokedWithArgumentArg(string $arg): void
    {
        $this->invokeCli(['paogen', $arg]);
    }

    public function thenStdoutShouldStartWithPrefix(string $prefix): void
    {
        if ($prefix === '') {
            TestCase::fail('prefix must be non-empty');
        }
        TestCase::assertStringStartsWith($prefix, $this->stdout);
    }

    public function thenStderrShouldContainNeedle(string $needle): void
    {
        TestCase::assertStringContainsString($needle, $this->stderr);
    }
}
