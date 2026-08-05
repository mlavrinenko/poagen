<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Runtime\Tests\AdditionalPropertiesRoundTripTest;

use const DIRECTORY_SEPARATOR;
use const SORT_STRING;

/**
 * declared-shapes-become-types: the three paths that answered a declared shape
 * with `mixed` or a bare array.
 *
 * Neither committed example document reaches any of them, so this fixture is
 * what does. Each of the three has both halves asserted — the shape resolves
 * to a type, *and* nothing the vendor declared is dropped on the way — because
 * the first defect of the three was fixed in one position and left in another,
 * and only comparing positions catches that.
 *
 * The fourth assertion is the exception the goal keeps: where a `mixed`
 * survives, the document genuinely declared nothing, and the run names the
 * position so the silence is the vendor's and visible.
 *
 * This asserts on what the generator emits. That the extras map is then filled
 * and emptied again on the wire is
 * {@see AdditionalPropertiesRoundTripTest}'s
 * half, against the runtime directly.
 */
final class WidenedShapesTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/widened-shapes-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\WidenedShapes';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testPropertiesWithoutATypeKeywordBecomeAClassNotAMixed(): void
    {
        $plan = $this->plan();

        // The component catalogue always read `properties` without `type` as an
        // object; the type resolver read the keyword alone and answered `mixed`.
        self::assertContains('WidgetDimensions', $this->modelNames($plan));
        self::assertStringContainsString(
            'public WidgetDimensions $dimensions,',
            $this->sourceOf($plan, 'Widget.php'),
        );
        self::assertStringContainsString('public ?int $width = null,', $this->sourceOf($plan, 'WidgetDimensions.php'));
    }

    public function testPropertiesWithoutATypeKeywordBecomeAClassAtPayloadGranularityToo(): void
    {
        // Same schema shape, different position. One answer, or the generator
        // has no contract a reader can rely on.
        $plan = $this->plan();

        self::assertContains('SaveProfile200Content', $this->modelNames($plan));
        self::assertStringContainsString(
            'public function saveProfile(SaveProfileRequestContent $body): Envelope',
            $this->clientSource($plan),
        );
    }

    public function testDeclaredPropertiesAndExtraValuesAreBothCarried(): void
    {
        $labels = $this->sourceOf($this->plan(), 'WidgetLabels.php');

        // Both halves the document declared. The old answer was
        // `array<string, mixed>` plus a `@todo`, which kept neither.
        self::assertStringContainsString('public ?string $primary = null,', $labels);
        self::assertStringContainsString('@param array<string, string> $additionalProperties', $labels);
        self::assertStringContainsString('#[AdditionalProperties]', $labels);
        self::assertStringNotContainsString('@todo', $labels);
    }

    public function testDeclaredPropertiesAndExtraValuesAreBothCarriedAtPayloadGranularityToo(): void
    {
        // At payload granularity this shape emitted nothing at all: the
        // properties vanished with no comment anywhere in the client.
        $request = $this->sourceOf($this->plan(), 'SaveProfileRequestContent.php');

        self::assertStringContainsString('public ?string $handle = null,', $request);
        self::assertStringContainsString('@param array<string, Part> $additionalProperties', $request);
    }

    public function testAResponseMapResolvesARefTheSameWayTheRequestSideDoes(): void
    {
        $client = $this->clientSource($this->plan());

        // The request side has resolved a `$ref` value since it was written;
        // the response side collapsed the identical construct to `mixed`.
        self::assertStringContainsString('@return Envelope<array<string, Part>>', $client);
        self::assertStringContainsString('ResponseType::mapOf(ResponseType::object(Part::class))', $client);
    }

    public function testAResponseMapResolvesANonScalarValueSchema(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('@return Envelope<array<string, list<Part>>>', $client);
        self::assertStringContainsString('ResponseType::mapOf(ResponseType::listOf(Part::class))', $client);
        self::assertStringContainsString('@return Envelope<array<string, array<string, string>>>', $client);
        self::assertStringContainsString('ResponseType::mapOf(ResponseType::mapOf(ResponseType::string()))', $client);
    }

    public function testTheOnlySurvivingMixedIsTheOneTheVendorLeftUnconstrained(): void
    {
        $plan = $this->plan();
        $models = '';

        foreach ($plan->writes as $path => $source) {
            if (str_contains($path, DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR)) {
                $models .= $source;
            }
        }

        // `notes` declares no type, no properties and no items. Every other
        // property in the fixture declares something, and none of them is
        // `mixed` any more.
        self::assertStringContainsString('public mixed $notes = null,', $models);
        self::assertSame(1, substr_count($models, 'mixed'));
    }

    public function testEveryUnconstrainedPositionIsReportedOnTheRun(): void
    {
        $notices = $this->unconstrainedNotices($this->plan());

        self::assertCount(2, $notices);
        self::assertStringContainsString(
            'unconstrained value at /components/schemas/Widget/properties/notes — the document declares no type, '
                . 'properties or items here, so poagen emits `mixed`.',
            $notices[0],
        );
        self::assertStringContainsString(
            'unconstrained value at /paths/~1opaque/get/responses/200/content/application~1json/schema — the '
                . "document declares no properties and no schema for this object's values, so poagen emits "
                . '`array<string, mixed>`.',
            $notices[1],
        );
    }

    public function testTheReportDoesNotMoveTheExitStatus(): void
    {
        // A notice names an opportunity, never an omission — nothing here was
        // left out of the emitted tree.
        $plan = $this->plan();

        self::assertNotSame([], $plan->writes);
        self::assertSame([], $plan->skippedOperations);
        self::assertSame([], $plan->skippedComponents);
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-widened-'),
            namespace: self::NAMESPACE,
        ));
    }

    /**
     * @return list<string>
     */
    private function unconstrainedNotices(GenerationPlan $plan): array
    {
        return array_values(array_filter(
            $plan->notices,
            static fn(string $n): bool => str_starts_with($n, 'unconstrained value at '),
        ));
    }

    private function clientSource(GenerationPlan $plan): string
    {
        return $this->sourceOf($plan, 'ApiClient.php');
    }

    private function sourceOf(GenerationPlan $plan, string $basename): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . $basename)) {
                return $source;
            }
        }

        self::fail("the plan wrote no {$basename}");
    }

    /**
     * @return list<string>
     */
    private function modelNames(GenerationPlan $plan): array
    {
        $needle = DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR;
        $out = [];

        foreach (array_keys($plan->writes) as $path) {
            if (str_contains($path, $needle)) {
                $out[] = basename($path, '.php');
            }
        }

        sort($out, SORT_STRING);

        return $out;
    }
}
