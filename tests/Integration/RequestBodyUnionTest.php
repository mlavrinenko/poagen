<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\GadgetByVolume;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\GadgetByWeight;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * a-union-request-body-takes-a-union-parameter: a request body whose whole
 * schema is a `oneOf`/`anyOf` emits one method parameter typed as the native
 * PHP union across the branches. No branch selection is computed or needed —
 * the caller already holds a concrete instance of one of them, and the
 * marshaller serialises whichever one it was handed.
 *
 * DigitalOcean and GitHub prove the successful paths (`examples/digitalocean`,
 * `examples/github`), but every real operation there is either a pure `$ref`
 * union or, once mixed, refuses on the very first unnameable branch — this
 * fixture is what proves the inline-branch-synthesis path, the "no branch
 * selection, just marshal whichever one was passed" behaviour end to end,
 * and the silent-widening fix, without a vendor document.
 */
final class RequestBodyUnionTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/union-request-body-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\RequestBodyUnion';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * `certificates_create`'s shape: a `oneOf` of two `$ref` components
     * resolves through the same `CompositionResolver::resolveUnion()` a
     * model property with the same shape already gets — no branch
     * synthesis needed, both branches are already named classes.
     */
    public function testARefOnlyOneOfEmitsANativePhpUnionParameter(): void
    {
        $plan = $this->plan(['unionMixed' => 'fixture-only refusal']);
        $client = $this->clientSource($plan);

        self::assertStringContainsString(
            'public function unionRefs(GadgetByWeight|GadgetByVolume $body): void',
            $client,
        );
        // No branch selection anywhere in the emitted call — the caller's
        // own choice of branch is what the marshaller serialises.
        self::assertStringContainsString('->json($body)', self::methodSlice($client, 'unionRefs'));
    }

    /**
     * The consumer constructs one branch and passes it; nothing is inferred
     * from a payload. Proven directly against {@see Marshaller} — the same
     * mechanism the emitted `->json($body)` call above invokes — with hand
     * fixtures mirroring `gadget_by_weight`/`gadget_by_volume` exactly, the
     * way {@see XmlRequestBodyTest::testTheMarshallerStaysInThePathSoBothContentTypesAgree()}
     * proves a generated body's wire shape without requiring the generated
     * file.
     */
    public function testEachRefBranchMarshalsToItsOwnWireShape(): void
    {
        $marshaller = new Marshaller();
        $byWeight = new GadgetByWeight(2.5);
        $byVolume = new GadgetByVolume(1.2);

        // The caller's own construction is what decides the branch — read
        // back here to prove it, not just inferred from the marshalled array.
        self::assertSame(2.5, $byWeight->weight);
        self::assertSame(1.2, $byVolume->volume);

        self::assertSame(['weight' => 2.5], $marshaller->marshal($byWeight));
        self::assertSame(['volume' => 1.2], $marshaller->marshal($byVolume));
    }

    /**
     * `orgs/delete-attestations-bulk`'s shape: `type: object` beside a
     * `oneOf` whose branches are inline objects. Before this task,
     * `RequestBodyAnalyzer` read the object with no declared properties of
     * its own and emitted a bare `array $body`, discarding the `oneOf`
     * silently. Now each branch is synthesised into its own model — named
     * the same way a whole inline body already is — and the parameter is
     * the union across them.
     */
    public function testAWholeBodyOneOfWithNoOwnPropertiesSynthesisesOneModelPerBranch(): void
    {
        $plan = $this->plan(['unionMixed' => 'fixture-only refusal']);
        $client = $this->clientSource($plan);

        self::assertStringContainsString(
            'public function unionWidened(UnionWidenedBranch1|UnionWidenedBranch2 $body): void',
            $client,
        );
        self::assertStringNotContainsString('unionWidened(array $body)', $client);

        $branch1 = $this->modelSource($plan, 'UnionWidenedBranch1');
        $branch2 = $this->modelSource($plan, 'UnionWidenedBranch2');

        self::assertStringContainsString('public array $alpha_items,', $branch1);
        self::assertStringContainsString('public array $beta_items,', $branch2);
    }

    /**
     * `issues/set-labels`'s known candidate: a branch set that mixes a
     * synthesisable object with a bare `array` — paogen cannot name a PHP
     * class across the two, so it refuses rather than silently dropping the
     * `array` branch or widening the whole parameter to `mixed`.
     */
    public function testAMixedBranchSetRefusesByNamingTheBranchIndexAndPointer(): void
    {
        $message = $this->refusalMessage([]);

        self::assertStringContainsString('unionMixed', $message);
        self::assertStringContainsString('request body branch 2', $message);
        self::assertStringContainsString('oneOf/1', $message);
        self::assertStringContainsString('bare `array`', $message);
        self::assertStringContainsString('not a named class', $message);
    }

    /**
     * Both resolving operations generate with no skip entry at all — only
     * `unionMixed`, the branch set paogen genuinely cannot name, needs one.
     */
    public function testOnlyTheMixedBranchSetIsSkipped(): void
    {
        $plan = $this->plan(['unionMixed' => 'fixture-only refusal']);

        self::assertCount(1, $plan->skippedOperations);
        self::assertSame('unionMixed', $plan->skippedOperations[0]->operationId);
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        $output = self::makeSandboxDir('paogen-union-body-');

        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }

    /**
     * @param array<string,string> $skip every refusal except the one under test —
     *                                    left unlisted so it surfaces in the exception
     */
    private function refusalMessage(array $skip): string
    {
        try {
            $this->plan($skip);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }
    }

    private function clientSource(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }

    private function modelSource(GenerationPlan $plan, string $className): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . $className . '.php')) {
                return $source;
            }
        }

        self::fail("the plan wrote no {$className}.php");
    }
}
