<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

/**
 * `guidance-cannot-mislead` applied to a response-position key: bullet 4 of
 * `a-union-response-selects-its-branch` says `Profile::$unionPins` and
 * `$unionTags` both "accept a response-position key" and are stale-checked
 * "exactly as the property-position keys are" — the same asymmetry
 * {@see UnionGuidanceTest} proves for a property: a pin is stale-checked,
 * a tag is not, because a tag only refines what the branches already say
 * and a pin discards branches a tag never touches.
 *
 * A response has no enclosing object, so `$unionTags`' layer never
 * literally applies there; what "accepts the key" means for a tag is that
 * the run recognises the union and explains why the layer cannot fire,
 * rather than reporting the key as absent.
 */
final class ResponseUnionGuidanceTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/union-response-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ResponseUnionGuidance';

    private const array WORKING_PIN = [
        'getUndecidableCreature.response' => ['branch' => 'Celsius', 'reason' => 'this client reads metric sensors'],
    ];

    public function testTheWorkingProfileGenerates(): void
    {
        $plan = $this->plan([], self::WORKING_PIN);

        self::assertNotSame([], $plan->writes);
    }

    public function testAPinNamingAnOperationTheDocumentDoesNotCarryFails(): void
    {
        $this->assertRefused(
            [],
            ['noSuchOperation.response' => ['branch' => 'Dog', 'reason' => 'because']],
            "Profile::\$unionPins['noSuchOperation.response'] names no union in the document",
        );
    }

    public function testAPinNamingABranchOutsideTheUnionFails(): void
    {
        $this->assertRefused(
            [],
            ['getUndecidableCreature.response' => ['branch' => 'Dog', 'reason' => 'because']],
            "pins the branch 'Dog', which is not one of that union's branches",
        );
    }

    public function testAPinWithNoWrittenReasonFails(): void
    {
        $this->assertRefused(
            [],
            ['getUndecidableCreature.response' => ['branch' => 'Celsius', 'reason' => '   ']],
            "Profile::\$unionPins['getUndecidableCreature.response'] carries no reason",
        );
    }

    /**
     * `getCreature.response` resolves on its own — `Dog` and `Cat` declare
     * disjoint required fields — so pinning it discards a branch for
     * nothing, the same staleness rule an unnecessary property-level pin
     * fails under.
     */
    public function testAPinOnAResponseUnionTheRunCanDecideOnItsOwnIsStale(): void
    {
        $this->assertRefused(
            [],
            [
                ...self::WORKING_PIN,
                'getCreature.response' => ['branch' => 'Dog', 'reason' => 'kept from an older schema'],
            ],
            "Profile::\$unionPins['getCreature.response'] is stale",
        );
    }

    /**
     * A response body is the top of its own payload, so `$unionTags`' "tag
     * on the enclosing object" layer has nothing to be a sibling of there —
     * the key is still recognised (this is not the "names no union"
     * failure), and the run says why the layer cannot apply rather than
     * silently ignoring the entry.
     */
    public function testATagNamingAResponsePositionKeyExplainsWhyTheLayerCannotApply(): void
    {
        $this->assertRefused(
            ['getCreature.response' => ['field' => 'kind', 'map' => ['dog' => 'Dog', 'cat' => 'Cat']]],
            self::WORKING_PIN,
            "Profile::\$unionTags['getCreature.response'] names a response-position union",
        );
    }

    /**
     * @param array<string,array{field:string,map:array<string,string>}> $tags
     * @param array<string,array{branch:string,reason:string}>           $pins
     */
    private function assertRefused(array $tags, array $pins, string $expected): void
    {
        try {
            $this->plan($tags, $pins);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString($expected, $e->getMessage());
        }
    }

    /**
     * @param array<string,array{field:string,map:array<string,string>}> $tags
     * @param array<string,array{branch:string,reason:string}>           $pins
     */
    private function plan(array $tags, array $pins): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-response-union-guidance-'),
            namespace: self::NAMESPACE,
            unionTags: $tags,
            unionPins: $pins,
        ));
    }
}
