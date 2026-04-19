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
    private string $resolvedVersion = '';

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

    public function givenComposerHasNoInstalledVersionRecordForAQueriedPackage(): void
    {
        // Precondition marker: the `when` step passes a deliberately unknown
        // package name, so Composer's InstalledVersions cannot resolve it.
        // No runtime setup is required.
    }


    public function whenTheCLIResolvesAVersionForAPackagePackage(string $package): void
    {
        $this->resolvedVersion = Cli::version($package);
    }


    public function thenTheReturnedVersionTokenIsNonEmpty(): void
    {
        TestCase::assertNotSame('', $this->resolvedVersion);
    }


    private string $brokenYamlPath = '';
    private bool $spawnBinary = false;

    public function whenPaogenCLIIsInvokedWithArgumentsArgs(string $args): void
    {
        // The spec uses `<that-path>` as a placeholder for the tempfile
        // created in the matching `given` step; substitute when present.
        if ($this->brokenYamlPath !== '') {
            $args = str_replace('<that-path>', $this->brokenYamlPath, $args);
        }

        $parts = preg_split('/\s+/', trim($args));
        \assert(\is_array($parts));
        $parts = array_values(array_filter($parts, static fn($p) => $p !== ''));

        if ($this->spawnBinary) {
            $this->invokeBinary($parts);

            return;
        }

        $this->invokeCli(array_merge(['paogen'], $parts));
    }


    public function givenATemporaryFileThatIsNotValidYAML(): void
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'paogen-validate-');
        // Deliberately malformed YAML — unterminated flow sequence with
        // colons in an unquoted scalar is guaranteed to trip the parser.
        file_put_contents($path, "not: valid: yaml: [\n");

        $this->brokenYamlPath = $path;
    }


    public function thenStderrShouldContainAParseErrorSignal(): void
    {
        TestCase::assertStringContainsString('paogen validate: parse error:', $this->stderr);

        if ($this->brokenYamlPath !== '' && is_file($this->brokenYamlPath)) {
            unlink($this->brokenYamlPath);
        }
    }


    public function givenProfileAtPath(string $path): void
    {
        // Precondition marker. The matching `when` step runs the CLI and
        // the downstream `then` steps assert on its stdout / stderr /
        // exit code. For scenarios that assert on the *process-level*
        // stderr (PHP deprecation notices, which go to the engine's real
        // stderr, not any in-process captured stream), switch the step
        // to spawn `bin/paogen` as a subprocess.
        TestCase::assertFileExists(\dirname(__DIR__, 2) . '/' . $path);
        $this->spawnBinary = true;
    }


    public function thenNeitherStdoutNorStderrContainsNeedle(string $needle): void
    {
        TestCase::assertStringNotContainsString($needle, $this->stdout);
        TestCase::assertStringNotContainsString($needle, $this->stderr);
    }


    /**
     * @param list<string> $args
     */
    private function invokeBinary(array $args): void
    {
        $root = \dirname(__DIR__, 2);
        $bin = $root . '/bin/paogen';
        TestCase::assertFileExists($bin);

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $cmd = array_merge([\PHP_BINARY, $bin], $args);
        $process = proc_open($cmd, $descriptors, $pipes, $root);
        \assert(\is_resource($process));
        fclose($pipes[0]);

        $this->stdout = (string) stream_get_contents($pipes[1]);
        $this->stderr = (string) stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $this->exitCode = proc_close($process);
    }

}
