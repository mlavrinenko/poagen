<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

/**
 * path-parameters-run-through-no-shape-gate-at-all: the path position was
 * the one of the three with no shape gate. `query` and `header` each refused
 * a schema outside their supported subset and named the parameter, the
 * operation and the shape; `path` accepted whatever the document declared and
 * handed it to `TypeResolver`, so an unreadable shape fell through to that
 * resolver's `mixed` default and the failure surfaced two layers downstream
 * as a PHPStan error against `Endpoint::path()` — inside generated code a
 * consumer reads as their own bug. `fail-loud-never-silent` makes that a
 * default-deny question: a construct the generator cannot represent stops the
 * run and names itself, and the same discipline applies uniformly across the
 * three positions.
 *
 * The refusal is proven by driving the fixture through a real plan and
 * watching it stop, not by reading the predicate.
 *
 * Fixture: tests/fixtures/schemas/parameter-shape-gate-3.0.yaml, one
 * operation per case. The query and header refusals are pinned here too:
 * all three positions now share one predicate, and a shared gate that
 * reported a vaguer message than the two that already existed would be a
 * regression.
 */
final class ParameterShapeGateTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/parameter-shape-gate-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ParameterShapeGate';

    /** Every operation the fixture declares that the gate refuses. */
    private const array REFUSED = [
        'getWidget' => 'inline object path parameter',
        'getWidgetTags' => 'path parameter with no declared type',
        'mergeWidget' => 'allOf path parameter',
        'searchWidgets' => 'inline object query parameter',
        'describeWidget' => 'required header parameter',
        'trackWidget' => 'cookie parameter',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnInlineObjectPathParameterStopsTheRun(): void
    {
        $message = $this->abortMessage();

        self::assertStringContainsString('6 problems found', $message);
        self::assertStringContainsString(
            "parameter 'selector' (in: path, type: object) "
                . 'at /paths/~1widgets~1{selector}/get/parameters/0 '
                . "is outside paogen's supported parameter shapes — a path parameter is interpolated into the URI, "
                . 'so its schema must name a scalar (string, integer, number or boolean), a union of scalars, '
                . 'or one or more $refs to component schemas',
            $message,
        );
        // The operation it belongs to, so the reader knows what to fix.
        self::assertStringContainsString('GET /widgets/{selector} (getWidget)', $message);
    }

    /**
     * The literal case acceptance asks about: a schema declaring nothing at
     * all is what reached `TypeResolver::resolve()`'s `mixed` default.
     */
    public function testAPathParameterWithNoDeclaredTypeStopsTheRun(): void
    {
        self::assertStringContainsString(
            "parameter 'widget_id' (in: path, type: unspecified) "
                . 'at /paths/~1widgets~1{widget_id}~1tags/get/parameters/0',
            $this->abortMessage(),
        );
    }

    /**
     * `allOf` is flattened for a component and not for a parameter, so a path
     * parameter spelled that way reached the same `mixed` default.
     */
    public function testAnAllOfPathParameterStopsTheRun(): void
    {
        self::assertStringContainsString(
            "parameter 'merged_id' (in: path, type: unspecified) "
                . 'at /paths/~1widgets~1{merged_id}~1merge/get/parameters/0',
            $this->abortMessage(),
        );
    }

    /**
     * Criterion the shared predicate has to keep: the two positions that
     * already refused still say which position it was and what would make
     * that position acceptable.
     */
    public function testTheQueryAndHeaderRefusalsStillNameThemselves(): void
    {
        $message = $this->abortMessage();

        self::assertStringContainsString(
            "parameter 'filter' (in: query, type: object) "
                . 'at /paths/~1widgets~1search/get/parameters/0 '
                . "is outside paogen's supported parameter shapes — a query parameter's schema must name a scalar, "
                . 'or an array whose items are scalars',
            $message,
        );
        self::assertStringContainsString(
            "parameter 'X-Trace-Id' (in: header, type: string) "
                . 'at /paths/~1widgets~1describe/get/parameters/0 '
                . "is outside paogen's supported parameter shapes — a header parameter must be optional "
                . '(paogen gives every header a nullable default) and its schema must name a scalar',
            $message,
        );
        self::assertStringContainsString(
            "parameter 'session' (in: cookie, type: string) "
                . 'at /paths/~1widgets~1track/get/parameters/0 '
                . "is outside paogen's supported parameter shapes — paogen emits path, query and header parameters "
                . '— no other `in` value',
            $message,
        );
    }

    /**
     * The gate is an allow-list, not a blanket refusal: a scalar path
     * parameter still emits, beside a scalar query one and an optional
     * scalar header one.
     */
    public function testRepresentablePathParametersStillEmit(): void
    {
        $sources = implode("\n", array_values($this->plan(self::REFUSED)->writes));

        self::assertStringContainsString(
            'public function listWidgets(string $catalogue, ?int $limit = null, ?string $xRequestId = null): void',
            $sources,
        );
        self::assertStringNotContainsString('mixed $catalogue', $sources);
    }

    /**
     * DigitalOcean's `ssh_key_identifier` shape — `anyOf` over two `$ref`s to
     * scalar components, an id-or-fingerprint. `CompositionResolver` turns it
     * into a union of the two scalar value objects, so the gate has to let it
     * through: refusing it would take away a shape that emits today.
     */
    public function testARefUnionPathParameterStillEmits(): void
    {
        $sources = implode("\n", array_values($this->plan(self::REFUSED)->writes));

        self::assertStringContainsString('public function getKey(WidgetId|WidgetSlug $keyIdentifier): void', $sources);
        self::assertStringNotContainsString('mixed $keyIdentifier', $sources);
    }

    private function abortMessage(): string
    {
        try {
            $this->plan([]);
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }

        self::fail('expected UnrepresentableConstructsException');
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-parameter-shape-gate-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }
}
