<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\InlinePayloadPlanAssertions;
use PHPUnit\Framework\TestCase;

/**
 * name-inline-schemas-by-operation-and-status: every response status earns a
 * class. typed-error-responses wires every one of them into the operation's
 * envelope — `getWidget` declares `200`, an exact `403`, a `4XX` range key
 * and a `default`, all inline objects, and all four now appear in the
 * method's body-type union rather than only the `200` that used to drive a
 * bare return type.
 *
 * The `4XX` key is also the only place in this repo's fixtures a range key
 * is declared at all: every real vendor document paogen ships (Petstore,
 * DigitalOcean, GitHub) sticks to exact statuses and `default`, so OpenAPI's
 * exact-then-range-then-default precedence — {@see EnvelopeResponsePlanner}
 * sorts a status into `exact`, `ranges` or `default` once, by key shape, and
 * {@see StatusResponseMap::match()} reads the three back in that order —
 * ships unproven against a real document parse without this fixture. This
 * operation declares both an exact `403` and a `4XX` range next to each
 * other for exactly that reason: on the wire, a `403` must still resolve to
 * `GetWidget403Content`, never to the range's `GetWidget4XXContent`.
 */
final class InlineMultiStatusResponseTest extends TestCase
{
    use GeneratedTreeSandbox;
    use InlinePayloadPlanAssertions;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payload-multi-status-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlineMultiStatus';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testEveryStatusDrivesTheEnvelopesBodyUnion(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringContainsString(
            '@return Envelope<GetWidget200Content|GetWidget403Content|GetWidget4XXContent|GetWidgetdefaultContent>',
            $client,
        );
        self::assertStringContainsString('public function getWidget(string $id): Envelope', $client);
    }

    public function testEveryStatusEarnsItsOwnClass(): void
    {
        $models = self::emittedNames($this->plan(), 'Model');

        self::assertContains('GetWidget200Content', $models);
        self::assertContains('GetWidget403Content', $models);
        self::assertContains('GetWidget4XXContent', $models);
        self::assertContains('GetWidgetdefaultContent', $models);
    }

    /**
     * The exact `403` and the `4XX` range are sorted into different
     * positions of the emitted `StatusResponseMap` literal — `exact` and
     * `ranges` respectively — which is what lets {@see StatusResponseMap::match()}
     * try the exact list first and never reach the range for a status the
     * exact list already answered.
     */
    public function testTheExactStatusAndTheRangeKeySortIntoDifferentPositions(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringContainsString(
            "exact: [['200', ResponseType::object(GetWidget200Content::class)], "
                . "['403', ResponseType::object(GetWidget403Content::class)]], "
                . "ranges: [['4XX', ResponseType::object(GetWidget4XXContent::class)]], "
                . 'default: ResponseType::object(GetWidgetdefaultContent::class)',
            $client,
        );
    }

    /**
     * @param array<string, string|list<string>> $inlineModels
     */
    private function plan(array $inlineModels = []): GenerationPlan
    {
        $output = self::makeSandboxDir('paogen-inline-multi-status-');

        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            inlineModels: $inlineModels,
        ));
    }
}
