<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Exception\ModelNameCollisionException;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use PHPUnit\Framework\TestCase;

/**
 * inline-body-and-response-schemas: a document that names no components still
 * produces a complete client.
 *
 * The model pipeline used to be rooted in `components.schemas` alone, so a
 * document declaring every payload at its use site emitted no models and
 * dropped the operations that needed them. These tests pin the four things
 * that make the replacement trustworthy rather than merely working: the
 * payloads are typed at both ends, nesting below them is reached too,
 * synthesised names are stable across runs, and a name claimed twice fails
 * the run instead of overwriting a file.
 */
final class InlinePayloadSynthesisTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payloads-3.0.yaml';
    private const string COLLISION_SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payload-collision-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlinePayloads';

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

    public function testEveryOperationIsEmittedFromADocumentWithNoComponents(): void
    {
        $client = $this->clientSource($this->plan());

        // Four operations declared, four methods emitted. A shrunken client is
        // the failure this whole feature exists to prevent.
        self::assertStringContainsString('public function placeOrder(', $client);
        self::assertStringContainsString('public function placeOrdersBulk(', $client);
        self::assertStringContainsString('public function ping(', $client);
        self::assertStringContainsString('public function health(', $client);
    }

    public function testAnInlineObjectBodyAndResponseAreBothTyped(): void
    {
        self::assertStringContainsString(
            'public function placeOrder(PlaceOrderRequest $body): PlaceOrderResponse',
            $this->clientSource($this->plan()),
        );
    }

    public function testAnArrayOfInlineObjectsIsTypedAtBothEnds(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('@param list<\\' . self::NAMESPACE . '\\Generated\\Model\\PlaceOrdersBulkRequestItem> $body', $client);
        self::assertStringContainsString('@return list<\\' . self::NAMESPACE . '\\Generated\\Model\\PlaceOrdersBulkResponseItem>', $client);
        self::assertStringContainsString('public function placeOrdersBulk(array $body): array', $client);
    }

    public function testNestingBelowASynthesisedPayloadIsReachedToo(): void
    {
        $models = $this->modelNames($this->plan());

        // The response root, an object nested one level under it, and the item
        // class of an array nested under it.
        self::assertContains('PlaceOrderResponse', $models);
        self::assertContains('PlaceOrderResponseShipping', $models);
        self::assertContains('PlaceOrderResponseLinesItem', $models);
    }

    public function testAnInlineEnumInAPayloadBecomesABackedEnum(): void
    {
        $enums = $this->emittedNames($this->plan(), 'Enum');

        // On a property, and on an array's items.
        self::assertContains('PlaceOrderRequestChannel', $enums);
        self::assertContains('PlaceOrderResponseTagsItem', $enums);
    }

    public function testAnUnconstrainedInlineObjectBodyIsPassedAsAMapRatherThanDroppingTheOperation(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('public function ping(array $body): void', $client);
        self::assertStringContainsString('@param array<string, mixed> $body', $client);
    }

    public function testSynthesisedNamesAreStableAcrossRuns(): void
    {
        // Compared as name → source so the two runs' distinct output
        // directories do not read as a difference. Emission order also has to
        // match, which is what `assertSame` on an ordered map buys over
        // comparing sorted name lists.
        self::assertSame($this->emittedSources($this->plan()), $this->emittedSources($this->plan()));
    }

    public function testAProfilePinRenamesASynthesisedPayloadClass(): void
    {
        $plan = $this->plan(['placeOrder.response' => 'PlacedOrder']);
        $models = $this->modelNames($plan);

        self::assertContains('PlacedOrder', $models);
        self::assertNotContains('PlaceOrderResponse', $models);
        self::assertStringContainsString(': PlacedOrder', $this->clientSource($plan));

        // The pin renames the root only; children still hang off it, so a
        // consumer who pins one name does not have to pin the whole subtree.
        self::assertContains('PlacedOrderShipping', $models);
    }

    public function testAPinNamingAnAbsentOperationIdFailsTheRun(): void
    {
        try {
            $this->plan(['noSuchOperation.response' => 'Whatever']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('noSuchOperation.response', $e->getMessage());
            self::assertStringContainsString('absent from the schema', $e->getMessage());
        }
    }

    public function testAPinNamingAnUnknownRoleFailsTheRun(): void
    {
        try {
            $this->plan(['placeOrder.payload' => 'Whatever']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('does not name a payload role', $e->getMessage());
        }
    }

    public function testTwoShapesClaimingOneClassNameFailTheRunAndNameBothOrigins(): void
    {
        try {
            $this->planFor(self::COLLISION_SCHEMA);
            self::fail('expected ModelNameCollisionException');
        } catch (ModelNameCollisionException $e) {
            self::assertStringContainsString('PlaceOrderResponse', $e->getMessage());
            self::assertStringContainsString('components.schemas/PlaceOrderResponse', $e->getMessage());
            self::assertStringContainsString('/paths/~1orders/post/responses/200', $e->getMessage());
        }
    }

    /**
     * @param array<string,string> $inlineModels
     */
    private function plan(array $inlineModels = []): GenerationPlan
    {
        return $this->planFor(self::SCHEMA, $inlineModels);
    }

    /**
     * @param array<string,string> $inlineModels
     */
    private function planFor(string $schema, array $inlineModels = []): GenerationPlan
    {
        $output = $this->makeTempDir();

        return new Generator(new AttributeScanner($this->composerLoader()))->plan(new Profile(
            schema: $schema,
            output: $output,
            namespace: self::NAMESPACE,
            inlineModels: $inlineModels,
        ));
    }

    private function clientSource(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, \DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }

    /**
     * The plan's writes keyed by class name instead of by absolute path.
     *
     * @return array<string,string>
     */
    private function emittedSources(GenerationPlan $plan): array
    {
        $out = [];

        foreach ($plan->writes as $path => $source) {
            $out[basename($path, '.php')] = $source;
        }

        return $out;
    }

    /**
     * @return list<string>
     */
    private function modelNames(GenerationPlan $plan): array
    {
        return $this->emittedNames($plan, 'Model');
    }

    /**
     * @return list<string>
     */
    private function emittedNames(GenerationPlan $plan, string $subdirectory): array
    {
        $needle = \DIRECTORY_SEPARATOR . $subdirectory . \DIRECTORY_SEPARATOR;
        $out = [];

        foreach (array_keys($plan->writes) as $path) {
            if (str_contains($path, $needle)) {
                $out[] = basename($path, '.php');
            }
        }

        sort($out, \SORT_STRING);

        return $out;
    }

    private function makeTempDir(): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'paogen-inline-');
        unlink($path);

        if (!mkdir($path, 0o755, true) && !is_dir($path)) {
            self::fail("failed to create temporary directory: {$path}");
        }

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
