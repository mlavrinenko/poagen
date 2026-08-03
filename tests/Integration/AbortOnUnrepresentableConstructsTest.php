<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

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
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/unrepresentable-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\Unrepresentable';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
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
            self::assertStringContainsString('paogen emits application/json', $message);
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
        $outputDir = self::makeSandboxDir('paogen-unrepresentable-');

        try {
            self::generator()->generate(new Profile(
                schema: self::SCHEMA,
                output: $outputDir,
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException) {
            self::assertDirectoryDoesNotExist($outputDir . DIRECTORY_SEPARATOR . 'Generated');
        }
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-unrepresentable-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }
}
