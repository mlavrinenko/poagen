<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use FilesystemIterator;
use Mlavrinenko\Paogen\Cli;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function assert;
use function dirname;
use function is_array;
use function is_resource;
use function strlen;

use const DIRECTORY_SEPARATOR;
use const PHP_BINARY;
use const SORT_STRING;

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
        assert($outStream !== false && $errStream !== false);

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

    public function thenPaogenCLIShouldExitWithCodeCode(int $code): void
    {
        TestCase::assertSame($code, $this->exitCode);
    }

    public function whenPaogenCLIIsInvokedWithArgumentArg(string $arg): void
    {
        $this->invokeCli(['paogen', $arg]);
    }

    private string $brokenYamlPath = '';
    private bool $spawnBinary = false;
    private string $tmpDir = '';

    /**
     * The profile the CLI scenarios drive. The spec writes `<profile-path>`
     * rather than naming a fixture, so the binding lives here.
     */
    private const PROFILE_FIXTURE = 'tests/fixtures/profiles/petstore.php';

    /** Likewise for `<schema-path>`, which the validate scenarios use. */
    private const SCHEMA_FIXTURE = 'tests/fixtures/schemas/petstore-3.0.yaml';

    private function profileFixturePath(): string
    {
        return dirname(__DIR__, 2) . '/' . self::PROFILE_FIXTURE;
    }

    private function schemaFixturePath(): string
    {
        return dirname(__DIR__, 2) . '/' . self::SCHEMA_FIXTURE;
    }

    public function whenPaogenCLIIsInvokedWithArgumentsArgs(string $args): void
    {
        // The spec uses `<that-path>` / `<tmp-dir>` / `<profile-path>` as
        // placeholders for the scratch paths created in the matching
        // `given` step; substitute when present.
        if ($this->brokenYamlPath !== '') {
            $args = str_replace('<that-path>', $this->brokenYamlPath, $args);
        }

        if ($this->tmpDir !== '') {
            $args = str_replace('<tmp-dir>', $this->tmpDir, $args);
        }

        $args = str_replace('<profile-path>', $this->profileFixturePath(), $args);
        $args = str_replace('<schema-path>', $this->schemaFixturePath(), $args);

        $parts = preg_split('/\s+/', trim($args));
        assert(is_array($parts));
        $parts = array_values(array_filter($parts, static fn($p) => $p !== ''));

        if ($this->spawnBinary) {
            $this->invokeBinary($parts);

            return;
        }

        $this->invokeCli(array_merge(['paogen'], $parts));
    }


    public function givenProfileAtPath(string $path): void
    {
        // Precondition marker. The matching `when` step runs the CLI and
        // the downstream `then` steps assert on its stdout / stderr /
        // exit code. For scenarios that assert on the *process-level*
        // stderr (PHP deprecation notices, which go to the engine's real
        // stderr, not any in-process captured stream), switch the step
        // to spawn `bin/paogen` as a subprocess.
        TestCase::assertSame('<profile-path>', $path);
        TestCase::assertFileExists($this->profileFixturePath());
        $this->spawnBinary = true;
    }


    /**
     * @param list<string> $args
     */
    private function invokeBinary(array $args): void
    {
        $root = dirname(__DIR__, 2);
        $bin = $root . '/bin/paogen';
        TestCase::assertFileExists($bin);

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $cmd = array_merge([PHP_BINARY, $bin], $args);
        $process = proc_open($cmd, $descriptors, $pipes, $root);
        assert(is_resource($process));
        fclose($pipes[0]);

        $this->stdout = (string) stream_get_contents($pipes[1]);
        $this->stderr = (string) stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $this->exitCode = proc_close($process);
    }


    private function makeScratchDir(string $prefix): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), $prefix);
        unlink($path);
        mkdir($path, 0o755, true);
        return $path;
    }


    private function copyTree(string $from, string $to): void
    {
        TestCase::assertDirectoryExists($from);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        );

        foreach ($iterator as $entry) {
            assert($entry instanceof SplFileInfo);
            $relative = substr($entry->getPathname(), strlen($from) + 1);
            $target = $to . DIRECTORY_SEPARATOR . $relative;

            if ($entry->isDir()) {
                if (!is_dir($target)) {
                    mkdir($target, 0o755, true);
                }
                continue;
            }

            @mkdir(dirname($target), 0o755, true);
            copy($entry->getPathname(), $target);
        }
    }


    /**
     * @return list<string>
     */
    private function listFilesRecursive(string $dir): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        );

        $out = [];
        foreach ($iterator as $entry) {
            assert($entry instanceof SplFileInfo);
            if ($entry->isFile()) {
                $out[] = $entry->getPathname();
            }
        }
        return $out;
    }


    public function thenPaogenCLIsStdoutShouldContainUSAGE(): void
    {
        TestCase::assertStringContainsString('USAGE', $this->stdout);
    }


    public function thenPaogenCLIsStdoutShouldStartWithPrefix(string $prefix): void
    {
        if ($prefix === '') {
            TestCase::fail('prefix must be non-empty');
        }
        TestCase::assertStringStartsWith($prefix, $this->stdout);
    }


    public function givenPaogenCLIsComposerMetadataHasNoInstalledVersionRecordForAQueriedPackage(): void
    {
        // Precondition marker: the `when` step passes a deliberately unknown
        // package name, so Composer's InstalledVersions cannot resolve it.
        // No runtime setup is required.
    }


    public function whenPaogenCLIResolvesAVersionForAPackagePackage(string $package): void
    {
        $this->resolvedVersion = Cli::version($package);
    }


    public function thenVersionTokenPaogenCLIReturnsIsNonEmpty(): void
    {
        TestCase::assertNotSame('', $this->resolvedVersion);
    }


    public function thenPaogenCLIsStderrShouldContainNeedle(string $needle): void
    {
        TestCase::assertStringContainsString($needle, $this->stderr);
    }


    public function givenSyntacticallyValidSchemaDocumentAtPath(string $path): void
    {
        // Petstore parses cleanly, which is the whole precondition. The
        // matching `when` step substitutes the same placeholder into the
        // argument string it hands the CLI.
        TestCase::assertSame('<schema-path>', $path);
        TestCase::assertFileExists($this->schemaFixturePath());
    }


    public function givenTemporaryMalformedSchemaFileThatIsNotValidYAML(): void
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'paogen-validate-');
        // Deliberately malformed YAML — unterminated flow sequence with
        // colons in an unquoted scalar is guaranteed to trip the parser.
        file_put_contents($path, "not: valid: yaml: [\n");

        $this->brokenYamlPath = $path;
    }


    public function thenPaogenCLIsStderrShouldContainAParseErrorSignal(): void
    {
        TestCase::assertStringContainsString('paogen validate: parse error:', $this->stderr);

        if ($this->brokenYamlPath !== '' && is_file($this->brokenYamlPath)) {
            unlink($this->brokenYamlPath);
        }
    }


    /**
     * Both of this Given's placeholders are keyed `path`, so the derived
     * signature folds them into one parameter while the call site still passes
     * both positionally. Widened to name them, the way
     * `givenTwoOperationEntriesUnderIt...` is on the operation-generator side.
     */
    public function givenProfileAtPathWhoseDeclaredOutputIsPath(string $path, string $declaredOutput): void
    {
        TestCase::assertSame('<profile-path>', $path);
        TestCase::assertSame('<declared-output-dir>', $declaredOutput);
        TestCase::assertFileExists($this->profileFixturePath());
        $this->tmpDir = $this->makeScratchDir('paogen-output-');
    }


    public function thenGeneratedTreeIsWrittenUnderPathInsteadOfProfilesDeclaredOutput(string $path): void
    {
        // $path is the spec placeholder literal; we check the resolved
        // directory captured in the `given` step.
        TestCase::assertNotSame('', $this->tmpDir);
        TestCase::assertDirectoryExists($this->tmpDir . '/Generated');
        TestCase::assertFileExists($this->tmpDir . '/Generated/ApiClient.php');
    }


    public function givenFreshDirectoryAtPathAsPaogenCLIsOutputTarget(string $path): void
    {
        $this->tmpDir = $this->makeScratchDir('paogen-dryrun-');
    }


    public function thenPaogenCLIsStdoutShouldContainNeedle(string $needle): void
    {
        TestCase::assertStringContainsString($needle, $this->stdout);
    }


    public function thenPaogenCLIsOutputDirectoryAtPathContainsNoFiles(string $path): void
    {
        TestCase::assertNotSame('', $this->tmpDir);
        TestCase::assertSame([], $this->listFilesRecursive($this->tmpDir));
    }


    public function givenTemporaryCopyOfMatchingGeneratedFileTreeAtPathForPaogenCLIToDiffAgainst(string $path): void
    {
        // Spec names the tree only as "matching": the fixture the profile
        // under test regenerates byte-for-byte. `$path` is the `<tmp-dir>`
        // placeholder, so the real directory is made here.
        $this->tmpDir = $this->makeScratchDir('paogen-diff-match-');
        $this->copyTree(dirname(__DIR__, 2) . '/tests/fixtures/generated/petstore', $this->tmpDir);
    }


    public function thenPaogenCLIsStdoutIsEmpty(): void
    {
        TestCase::assertSame('', $this->stdout);
    }


    public function givenTemporaryCopyOfGeneratedFileTreeAtPathForPaogenCLIToDiffAgainstWithOneFileTruncated(
        string $path,
    ): void {
        $this->tmpDir = $this->makeScratchDir('paogen-diff-corrupt-');
        $this->copyTree(dirname(__DIR__, 2) . '/tests/fixtures/generated/petstore', $this->tmpDir);

        $files = $this->listFilesRecursive($this->tmpDir);
        TestCase::assertNotEmpty($files, 'copied tree must have at least one file');

        // Pick the lexicographically-first file to keep the test byte-stable.
        sort($files, SORT_STRING);
        file_put_contents($files[0], '');
    }


    public function thenNeitherPaogenCLIsStdoutNorStderrContainsNeedle(string $needle): void
    {
        TestCase::assertStringNotContainsString($needle, $this->stdout);
        TestCase::assertStringNotContainsString($needle, $this->stderr);
    }

}
