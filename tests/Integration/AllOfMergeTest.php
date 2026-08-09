<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Support\ApiClientSourceFixture;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\ModelSourceFixture;
use Poagen\Generator\Tests\Support\RefusalPlanFixture;

/**
 * merge-allof-members-into-one-model: `allOf` resolves by merging,
 * recursively, into one synthesised model — reading the node's own
 * `properties`/`required` plus every member's, recursing into a member
 * whose own target is itself `allOf`, refusing (never silently dropping) a
 * property collision, an un-unionable `anyOf` branch set, or a `required`
 * name nothing declares.
 *
 * DigitalOcean and GitHub prove the successful paths (`examples/digitalocean`,
 * `examples/github`) but drive zero collisions and only one un-unionable
 * branch set never occurs at all — this fixture is the only proof for
 * those two refusals, and for the third (a `required` name nothing
 * declares) alongside the corpus's own `uptime_create_check`.
 */
final class AllOfMergeTest extends TestCase
{
    use ApiClientSourceFixture;
    use GeneratedTreeSandbox;
    use ModelSourceFixture;
    use RefusalPlanFixture;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/allof-merge-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\AllOfMerge';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * `firewalls_update`'s shape: the node's own `required` and a member
     * whose `$ref` target is itself `allOf`, so the properties satisfying
     * that requirement sit two levels down.
     */
    public function testARecursiveMergeReadsTheNodesOwnRequiredAndAMemberTwoLevelsDown(): void
    {
        $client = $this->clientSource($this->plan([
            'mergeCollision' => 'fixture-only refusal',
            'mergeBranchNotObject' => 'fixture-only refusal',
            'mergeMissingRequired' => 'fixture-only refusal',
        ]));

        self::assertStringContainsString('public function mergeRecursive(MergeRecursiveRequestContent $body): Envelope', $client);
    }

    public function testARecursiveMergeModelCarriesBothLevelsProperties(): void
    {
        $plan = $this->plan([
            'mergeCollision' => 'fixture-only refusal',
            'mergeBranchNotObject' => 'fixture-only refusal',
            'mergeMissingRequired' => 'fixture-only refusal',
        ]);
        $model = $this->modelSource($plan, 'MergeRecursiveRequestContent');

        // sku sits on widget_core, color sits on widget_extra — both a $ref
        // away from `widget`, itself a $ref away from the request body.
        self::assertStringContainsString('public string $sku,', $model);
        self::assertStringContainsString('public string $color,', $model);
    }

    /**
     * The widening this task fixes: `type: object` beside `allOf` with no
     * properties of its own used to read as an unconstrained map
     * (`RequestBodyAnalyzer`/`ObjectShape::is()`), emitting `array $body`
     * for a schema that names every field through its `allOf` members.
     */
    public function testAWidenedTypeObjectAllOfBodyEmitsATypedModelNotArrayBody(): void
    {
        $client = $this->clientSource($this->plan([
            'mergeCollision' => 'fixture-only refusal',
            'mergeBranchNotObject' => 'fixture-only refusal',
            'mergeMissingRequired' => 'fixture-only refusal',
        ]));

        self::assertStringContainsString('public function mergeWidened(MergeWidenedRequestContent $body): Envelope', $client);
        self::assertStringNotContainsString('mergeWidened(array $body)', $client);
    }

    /**
     * `firewalls_create`'s ruling: an `anyOf` member of required-only
     * branches becomes one synthesised model per branch, each the full
     * merged shape, each carrying that branch's extra requirement, and the
     * body parameter is the native PHP union across them.
     */
    public function testAnAnyOfMemberOfAllOfBecomesAUnionOfBranchModels(): void
    {
        $plan = $this->plan([
            'mergeCollision' => 'fixture-only refusal',
            'mergeBranchNotObject' => 'fixture-only refusal',
            'mergeMissingRequired' => 'fixture-only refusal',
        ]);
        $client = $this->clientSource($plan);

        self::assertStringContainsString(
            'public function mergeUnion(MergeUnionByWeight|MergeUnionByVolume $body): Envelope',
            $client,
        );

        $byWeight = $this->modelSource($plan, 'MergeUnionByWeight');
        $byVolume = $this->modelSource($plan, 'MergeUnionByVolume');

        // Both branches carry the whole merged shape (sku from widget_core,
        // weight and volume from the node's own properties) — only which
        // field is mandatory differs between them.
        self::assertStringContainsString('public string $sku,', $byWeight);
        self::assertStringContainsString('public float $weight,', $byWeight);
        self::assertStringContainsString('public ?float $volume = null,', $byWeight);

        self::assertStringContainsString('public string $sku,', $byVolume);
        self::assertStringContainsString('public float $volume,', $byVolume);
        self::assertStringContainsString('public ?float $weight = null,', $byVolume);
    }

    public function testACollisionBetweenTwoAllOfMembersRefusesByNamingBothSitesAndTheProperty(): void
    {
        $message = $this->refusalMessage([
            'mergeBranchNotObject' => 'fixture-only refusal',
            'mergeMissingRequired' => 'fixture-only refusal',
        ]);

        self::assertStringContainsString('mergeCollision', $message);
        self::assertStringContainsString("property 'sku'", $message);
        self::assertStringContainsString('two different schemas', $message);
        self::assertStringContainsString('allOf/0', $message);
        self::assertStringContainsString('allOf/1', $message);
    }

    public function testABranchSetThatCannotBeExpressedAsAUnionRefusesByNamingTheMemberAndPointer(): void
    {
        $message = $this->refusalMessage([
            'mergeCollision' => 'fixture-only refusal',
            'mergeMissingRequired' => 'fixture-only refusal',
        ]);

        self::assertStringContainsString('mergeBranchNotObject', $message);
        self::assertStringContainsString('is a $ref, not an inline object shape', $message);
    }

    public function testARequiredNameNoMemberDeclaresRefusesByNamingTheNameAndTheMembersSearched(): void
    {
        $message = $this->refusalMessage([
            'mergeCollision' => 'fixture-only refusal',
            'mergeBranchNotObject' => 'fixture-only refusal',
        ]);

        self::assertStringContainsString('mergeMissingRequired', $message);
        self::assertStringContainsString("requires 'warehouse'", $message);
        self::assertStringContainsString('members searched', $message);
        self::assertStringContainsString('widget_core', $message);
    }
}
