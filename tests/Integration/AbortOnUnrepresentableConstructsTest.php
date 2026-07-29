<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use PHPUnit\Framework\TestCase;

/**
 * abort-on-unrepresentable-constructs: the generator plans fully, collects
 * every construct it cannot represent, and fails once with all of them —
 * instead of throwing on the first (undiscriminated unions), emitting a
 * throwing stub (multipart/octet-stream bodies), or silently dropping the
 * rest and exiting 0.
 *
 * Fixture: tests/fixtures/schemas/unrepresentable-3.0.yaml carries two
 * independent problems at once (an unsupported operation body and an
 * undiscriminated union component) plus one fully representable operation,
 * so a single run can prove both "collect more than one" and "a skip
 * entry only affects what it names".
 */
final class AbortOnUnrepresentableConstructsTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/unrepresentable-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\Unrepresentable';

    /** @var list<string> */
    private array $outputDirs = [];

    protected function tearDown(): void
    {
        foreach ($this->outputDirs as $dir) {
            if (is_dir($dir)) {
                $this->removeDirectory($dir);
            }
        }

        parent::tearDown();
    }

    public function testAbortsByDefaultWithACollectedMultiProblemReport(): void
    {
        try {
            $this->plan([]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('2 problems found', $e->getMessage());
            self::assertStringContainsString('createWidget', $e->getMessage());
            self::assertStringContainsString('Gadget', $e->getMessage());
        }
    }

    public function testMessageNamesConstructLocationAndRemedy(): void
    {
        try {
            $this->plan([]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            // Construct.
            self::assertStringContainsString('multipart/form-data request body', $message);
            // Location: operation id and the schema pointer.
            self::assertStringContainsString('createWidget', $message);
            self::assertStringContainsString('/paths/~1widgets/post/requestBody', $message);
            // Remedy.
            self::assertStringContainsString('paogen emits JSON', $message);
        }
    }

    public function testSkipHonouredOmitsFromOutputAndRunSucceeds(): void
    {
        $plan = $this->plan(['createWidget' => 'binary upload', 'Gadget' => 'no discriminator']);

        self::assertCount(1, $plan->skippedOperations);
        self::assertSame('createWidget', $plan->skippedOperations[0]->operationId);
        self::assertCount(1, $plan->skippedComponents);
        self::assertSame('Gadget', $plan->skippedComponents[0]->rawName);

        $sources = implode("\n", array_values($plan->writes));
        self::assertStringContainsString('function ping(', $sources);
        self::assertStringNotContainsString('function createWidget(', $sources);

        foreach (array_keys($plan->writes) as $path) {
            self::assertStringNotContainsString('Model/Gadget.php', $path);
        }
    }

    public function testStaleSkipEntryIsRefused(): void
    {
        try {
            $this->plan(['createWidget' => 'x', 'Gadget' => 'x', 'ping' => 'no longer needed']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$skip['ping']", $e->getMessage());
            self::assertStringContainsString('stale', $e->getMessage());
        }
    }

    public function testSkipNamingAnAbsentTargetIsRefused(): void
    {
        try {
            $this->plan(['doesNotExist' => 'x']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$skip['doesNotExist']", $e->getMessage());
            self::assertStringContainsString('absent from the schema', $e->getMessage());
        }
    }

    public function testNothingIsWrittenToTheOutputDirectoryOnAbort(): void
    {
        $outputDir = $this->makeOutputDir();

        try {
            new Generator(new AttributeScanner($this->composerLoader()))->generate(new Profile(
                schema: self::SCHEMA,
                output: $outputDir,
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException) {
            self::assertDirectoryDoesNotExist($outputDir . \DIRECTORY_SEPARATOR . 'Generated');
        }
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        $generator = new Generator(new AttributeScanner($this->composerLoader()));

        return $generator->plan(new Profile(
            schema: self::SCHEMA,
            output: $this->makeOutputDir(),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }

    private function makeOutputDir(): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'paogen-unrepresentable-');
        unlink($path);
        $this->outputDirs[] = $path;

        return $path;
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (\is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        self::fail('Composer ClassLoader not found in autoload chain.');
    }

    private function removeDirectory(string $dir): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );

        /** @var \SplFileInfo $entry */
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
