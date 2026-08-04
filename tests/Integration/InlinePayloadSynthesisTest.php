<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\ModelNameCollisionException;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\InlinePayloadPlanAssertions;

use function basename;

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
    use GeneratedTreeSandbox;
    use InlinePayloadPlanAssertions;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payloads-3.0.yaml';
    private const string COLLISION_SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payload-collision-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\InlinePayloads';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
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
            'public function placeOrder(PlaceOrderRequestContent $body): Envelope',
            $this->clientSource($this->plan()),
        );
    }

    public function testAnArrayOfInlineObjectsIsTypedAtBothEnds(): void
    {
        $client = $this->clientSource($this->plan());

        // Both models are imported into the client's namespace, so a correct
        // emitter shortens the doc type to the imported alias (T-260730)
        // rather than repeating the FQCN nette already resolves in the signature.
        self::assertStringContainsString('@param list<PlaceOrdersBulkRequestContentItem> $body', $client);
        self::assertStringContainsString('@return Envelope<list<PlaceOrdersBulk200ContentItem>>', $client);
        self::assertStringContainsString('public function placeOrdersBulk(array $body): Envelope', $client);
    }

    public function testNestingBelowASynthesisedPayloadIsReachedToo(): void
    {
        $models = $this->modelNames($this->plan());

        // The response root, an object nested one level under it, and the item
        // class of an array nested under it.
        self::assertContains('PlaceOrder200Content', $models);
        self::assertContains('PlaceOrder200ContentShipping', $models);
        self::assertContains('PlaceOrder200ContentLinesItem', $models);
    }

    public function testAnInlineEnumInAPayloadBecomesABackedEnum(): void
    {
        $enums = self::emittedNames($this->plan(), 'Enum');

        // On a property, and on an array's items.
        self::assertContains('PlaceOrderRequestContentChannel', $enums);
        self::assertContains('PlaceOrder200ContentTagsItem', $enums);
    }

    public function testAnUnconstrainedInlineObjectBodyIsPassedAsAMapRatherThanDroppingTheOperation(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('public function ping(array $body): Envelope', $client);
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
        $plan = $this->plan(['PlacedOrder' => 'placeOrder.200']);
        $models = $this->modelNames($plan);

        self::assertContains('PlacedOrder', $models);
        self::assertNotContains('PlaceOrder200Content', $models);
        self::assertStringContainsString('@return Envelope<PlacedOrder>', $this->clientSource($plan));

        // The pin renames the root only; children still hang off it, so a
        // consumer who pins one name does not have to pin the whole subtree.
        self::assertContains('PlacedOrderShipping', $models);
    }

    /**
     * synthesise-a-model-for-inline-array-item-responses: a single-site pin
     * works the same way when the response is an array of inline objects, not
     * only when it is a single inline object — {@see
     * testAProfilePinRenamesASynthesisedPayloadClass} covers the latter. Both
     * go through the same `InlineModelClaim::named()` call, so one pin covers
     * both shapes; this pins that down for the list case specifically, since
     * nothing else did.
     */
    public function testAProfilePinRenamesAnArrayItemResponseModel(): void
    {
        $plan = $this->plan(['BulkOrderConfirmation' => 'placeOrdersBulk.200']);
        $models = $this->modelNames($plan);

        self::assertContains('BulkOrderConfirmation', $models);
        self::assertNotContains('PlaceOrdersBulk200ContentItem', $models);
        self::assertStringContainsString('@return Envelope<list<BulkOrderConfirmation>>', $this->clientSource($plan));
    }

    public function testAPinNamingAnAbsentOperationIdFailsTheRun(): void
    {
        try {
            $this->plan(['Whatever' => 'noSuchOperation.request']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('noSuchOperation.request', $e->getMessage());
            self::assertStringContainsString('absent from the schema', $e->getMessage());
        }
    }

    public function testAPinNamingAPositionTheOperationDoesNotDeclareFailsTheRun(): void
    {
        try {
            $this->plan(['Whatever' => 'placeOrder.payload']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('placeOrder.payload', $e->getMessage());
            self::assertStringContainsString('absent from the schema', $e->getMessage());
        }
    }

    public function testTwoShapesClaimingOneClassNameFailTheRunAndNameBothOrigins(): void
    {
        try {
            $this->planFor(self::COLLISION_SCHEMA);
            self::fail('expected ModelNameCollisionException');
        } catch (ModelNameCollisionException $e) {
            self::assertStringContainsString('PlaceOrder200Content', $e->getMessage());
            self::assertStringContainsString('components.schemas/PlaceOrder200Content', $e->getMessage());
            self::assertStringContainsString('/paths/~1orders/post/responses/200', $e->getMessage());
        }
    }

    /**
     * @param array<string, string|list<string>> $inlineModels
     */
    private function plan(array $inlineModels = []): GenerationPlan
    {
        return $this->planFor(self::SCHEMA, $inlineModels);
    }

    /**
     * @param array<string, string|list<string>> $inlineModels
     */
    private function planFor(string $schema, array $inlineModels = []): GenerationPlan
    {
        $output = self::makeSandboxDir('poagen-inline-');

        return self::generator()->plan(new Profile(
            schema: $schema,
            output: $output,
            namespace: self::NAMESPACE,
            inlineModels: $inlineModels,
        ));
    }

    private function clientSource(GenerationPlan $plan): string
    {
        return self::plannedSource($plan->writes, 'ApiClient');
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
        return self::emittedNames($plan, 'Model');
    }
}
