<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

/**
 * `guidance-cannot-mislead` applied to the two union keys: every part of a
 * `$unionTags` or `$unionPins` entry is a claim about the document, and every
 * one of them fails the run when the document contradicts it.
 *
 * The acid test that goal names is "break each entry in turn and check the run
 * names the entry that is wrong", so each case here breaks exactly one field of
 * an otherwise-working entry.
 *
 * The staleness asymmetry is tested too, because it is the part a reader is
 * most likely to get backwards: a pin discards declared branches and is
 * stale-checked like `$skip`, while a tag only refines and is not.
 */
final class UnionGuidanceTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/union-selection-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\UnionGuidance';

    private const array WORKING_TAG = [
        'Habitat.resident' => ['field' => 'species', 'map' => ['cat' => 'Cat', 'dog' => 'Dog']],
    ];

    private const array WORKING_PIN = [
        'Reading.sample' => ['branch' => 'Celsius', 'reason' => 'this client reads metric sensors'],
    ];

    public function testTheWorkingProfileGenerates(): void
    {
        $plan = $this->plan(self::WORKING_TAG, self::WORKING_PIN);

        self::assertNotSame([], $plan->writes);
    }

    public function testATagNamingAComponentTheDocumentDoesNotCarryFails(): void
    {
        $this->assertRefused(
            ['Aviary.resident' => ['field' => 'species', 'map' => ['dog' => 'Dog']]],
            self::WORKING_PIN,
            "Profile::\$unionTags['Aviary.resident'] names no union in the document",
        );
    }

    public function testATagNamingAFieldTheEnclosingObjectDoesNotDeclareFails(): void
    {
        $this->assertRefused(
            ['Habitat.resident' => ['field' => 'genus', 'map' => ['cat' => 'Cat', 'dog' => 'Dog']]],
            self::WORKING_PIN,
            "names the tag field 'genus', which the enclosing component does not declare",
        );
    }

    public function testATagMappingABranchOutsideTheUnionFails(): void
    {
        $this->assertRefused(
            ['Habitat.resident' => ['field' => 'species', 'map' => ['cat' => 'Vacant', 'dog' => 'Dog']]],
            self::WORKING_PIN,
            "maps 'cat' to 'Vacant', which is not one of that union's branches",
        );
    }

    /**
     * The tag field enumerates its values, so a mapping key outside that enum
     * is a claim the document contradicts rather than a gap.
     */
    public function testATagValueOutsideTheFieldsEnumFails(): void
    {
        $this->assertRefused(
            ['Habitat.resident' => ['field' => 'species', 'map' => ['ferret' => 'Cat', 'dog' => 'Dog']]],
            self::WORKING_PIN,
            "maps the value 'ferret', which 'species' does not enumerate",
        );
    }

    public function testAPinNamingABranchOutsideTheUnionFails(): void
    {
        $this->assertRefused(
            self::WORKING_TAG,
            ['Reading.sample' => ['branch' => 'Dog', 'reason' => 'because']],
            "pins the branch 'Dog', which is not one of that union's branches",
        );
    }

    public function testAPinWithNoWrittenReasonFails(): void
    {
        $this->assertRefused(
            self::WORKING_TAG,
            ['Reading.sample' => ['branch' => 'Celsius', 'reason' => '   ']],
            "Profile::\$unionPins['Reading.sample'] carries no reason",
        );
    }

    /**
     * `Sighting.creature` resolves on its own, so pinning it discards a branch
     * for nothing. Same rule `$skip` has carried since
     * `skip-is-the-only-opt-out`: guidance that outlives its cause is a failure,
     * because nothing else surfaces it.
     */
    public function testAPinOnAUnionTheRunCanNowDecideIsStale(): void
    {
        $this->assertRefused(
            self::WORKING_TAG,
            [
                ...self::WORKING_PIN,
                'Sighting.creature' => ['branch' => 'Dog', 'reason' => 'kept from an older schema'],
            ],
            "Profile::\$unionPins['Sighting.creature'] is stale",
        );
    }

    /**
     * The other half of the asymmetry, on the one union that shows both sides.
     * `Habitat.resident`'s branches carry disjoint required fields, so the run
     * decides it with no guidance at all — and the tag entry for it is still
     * accepted rather than called stale. A tag refines where a pin suppresses,
     * and the claim it makes about the document stays true either way.
     */
    public function testATagOnAUnionTheRunCouldDecideAnywayIsNotStale(): void
    {
        $withoutTag = $this->plan([], self::WORKING_PIN);
        self::assertStringContainsString('BranchSelector(', $this->habitat($withoutTag));

        $withTag = $this->plan(self::WORKING_TAG, self::WORKING_PIN);
        self::assertStringContainsString('onParent: true', $this->habitat($withTag));
    }

    private function habitat(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, 'Habitat.php')) {
                return $source;
            }
        }

        self::fail('Habitat.php was not written');
    }

    /**
     * @param array<string,array{field:string,map:array<string,string>}>  $tags
     * @param array<string,array{branch:string,reason:string}>            $pins
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
     * @param array<string,array{field:string,map:array<string,string>}>  $tags
     * @param array<string,array{branch:string,reason:string}>            $pins
     */
    private function plan(array $tags, array $pins): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: sys_get_temp_dir() . '/paogen-union-guidance',
            namespace: self::NAMESPACE,
            unionTags: $tags,
            unionPins: $pins,
        ));
    }
}
