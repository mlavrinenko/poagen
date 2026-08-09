<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Emit\ParameterShape;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\SkipPlanFixture;

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
    use SkipPlanFixture;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/parameter-shape-gate-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\ParameterShapeGate';

    /** Every operation the fixture declares that the gate refuses. */
    private const array REFUSED = [
        'getWidget' => 'inline object path parameter',
        'getWidgetTags' => 'path parameter with no declared type',
        'mergeWidget' => 'allOf path parameter',
        'searchWidgets' => 'inline object query parameter',
        'trackWidget' => 'cookie parameter',
        'getWidgetByRef' => 'path parameter that is a $ref to a non-scalar component',
        'getWidgetsCommaSeparated' => 'array query parameter with a non-default explode',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnInlineObjectPathParameterStopsTheRun(): void
    {
        $message = $this->abortMessage();

        self::assertStringContainsString('7 problems found', $message);
        self::assertStringContainsString(
            "parameter 'selector' (in: path, type: object) "
                . 'at /paths/~1widgets~1{selector}/get/parameters/0 '
                . "is outside poagen's supported parameter shapes — a path parameter is interpolated into the URI, "
                . 'so its schema must name a scalar (string, integer, number or boolean), a union of scalars, '
                . 'or one or more $refs to scalar component schemas',
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
     * Criterion the shared predicate has to keep: the query and cookie
     * refusals still say which position it was and what would make that
     * position acceptable. Header has no refusal left to pin in this
     * fixture — a required header now emits, see
     * {@see testARequiredHeaderParameterEmitsAheadOfOptionalOnes()}.
     */
    public function testTheQueryAndCookieRefusalsStillNameThemselves(): void
    {
        $message = $this->abortMessage();

        self::assertStringContainsString(
            "parameter 'filter' (in: query, type: object) "
                . 'at /paths/~1widgets~1search/get/parameters/0 '
                . "is outside poagen's supported parameter shapes — a query parameter's schema must name a scalar, "
                . 'a $ref to a scalar component, an array whose items are scalars (directly or through a $ref), '
                . 'or a oneOf/anyOf of a scalar and a list of one',
            $message,
        );
        self::assertStringContainsString(
            "parameter 'session' (in: cookie, type: string) "
                . 'at /paths/~1widgets~1track/get/parameters/0 '
                . "is outside poagen's supported parameter shapes — poagen emits path, query and header parameters "
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
            'public function listWidgets(string $catalogue, ?int $limit = null, ?string $xRequestId = null): Envelope',
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

        self::assertStringContainsString('public function getKey(WidgetId|WidgetSlug $keyIdentifier): Envelope', $sources);
        self::assertStringNotContainsString('mixed $keyIdentifier', $sources);
    }

    /**
     * `support-the-parameter-shapes-real-documents-use`: a required header
     * parameter used to be refused whatever its schema; it is now a
     * required method argument, same as a required query parameter.
     */
    public function testARequiredHeaderParameterEmitsAheadOfOptionalOnes(): void
    {
        $sources = implode("\n", array_values($this->plan(self::REFUSED)->writes));

        self::assertStringContainsString('public function describeWidget(string $xTraceId): Envelope', $sources);
        self::assertStringNotContainsString("'X-Trace-Id' (in: header", $sources);
    }

    /**
     * `ref-path-parameter-to-a-non-scalar-component-is-ungated`: a path
     * parameter whose schema is a bare `$ref` to an object component used
     * to pass this gate unresolved — `supportsPath()` accepted any
     * `Reference` without asking what it named — and reach `TypeResolver`'s
     * blind `$ref`-to-FQCN resolution, emitting a Model class on
     * `Endpoint::path()`. It now resolves through the same
     * {@see ParameterShape::resolvedSchema()}
     * `query` and `header` use, and refuses by name.
     */
    public function testARefPathParameterToANonScalarComponentStopsTheRun(): void
    {
        $message = $this->abortMessage();

        self::assertStringContainsString(
            "parameter 'widget_ref' (in: path, type: unspecified) "
                . 'at /paths/~1widgets~1by-ref~1{widget_ref}/get/parameters/0 '
                . "is outside poagen's supported parameter shapes — a path parameter is interpolated into the URI, "
                . 'so its schema must name a scalar (string, integer, number or boolean), a union of scalars, '
                . 'or one or more $refs to scalar component schemas',
            $message,
        );
        self::assertStringContainsString('GET /widgets/by-ref/{widget_ref} (getWidgetByRef)', $message);
    }

    /**
     * `support-the-parameter-shapes-real-documents-use`: `Endpoint::query()`
     * implements exactly one list serialisation — a repeated key per item,
     * `style: form` / `explode: true`. A document declaring `explode: false`
     * (a single comma-joined value) is not that, so it refuses rather than
     * being silently sent as repeated keys anyway.
     */
    public function testAnArrayQueryParameterWithANonDefaultExplodeStopsTheRun(): void
    {
        $message = $this->abortMessage();

        self::assertStringContainsString(
            "parameter 'tags' (in: query, type: array) "
                . 'at /paths/~1widgets~1comma/get/parameters/0 '
                . "is outside poagen's supported parameter shapes",
            $message,
        );
        self::assertStringContainsString('GET /widgets/comma (getWidgetsCommaSeparated)', $message);
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
}
