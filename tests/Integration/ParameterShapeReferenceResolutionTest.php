<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\ParameterShape;
use Poagen\Generator\Generator\Emit\ScalarOrListResolver;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * support-the-parameter-shapes-real-documents-use: the three mechanisms
 * that refused twenty-three real operations, proven independent of either
 * vendor document.
 *
 * `query` and `header` used to refuse any `$ref` schema outright, and a
 * `oneOf`/`anyOf` of a bare scalar and an array of one fell through to
 * `mixed`. {@see ParameterShape::resolvedSchema()}
 * follows the `$ref`; {@see ScalarOrListResolver}
 * resolves the `oneOf`/`anyOf`.
 *
 * Fixture: tests/fixtures/schemas/parameter-shape-references-3.0.yaml.
 */
final class ParameterShapeReferenceResolutionTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/parameter-shape-references-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\ParameterShapeReferenceResolution';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * A `$ref` to a scalar component resolves and is typed as the
     * component, in query and header position — positions that used to
     * refuse any `$ref` outright.
     */
    public function testARefToAScalarComponentResolvesInQueryAndHeader(): void
    {
        $sources = implode("\n", array_values($this->plan()->writes));

        self::assertStringContainsString('public function refQuery(?TagId $tag = null): Envelope', $sources);
        self::assertStringContainsString('public function refHeader(?TagId $xTagId = null): Envelope', $sources);
        self::assertStringNotContainsString('mixed $tag', $sources);
    }

    /**
     * DigitalOcean's `job_names` shape: a query array whose items are a
     * `$ref` to a scalar component. Emitted as a typed list, serialised as
     * repeated keys — one `toScalar()` per item, with no redundant `(string)`
     * cast now that the component's own declared type is already `string`.
     */
    public function testAnArrayOfRefToScalarItemsEmitsAsATypedList(): void
    {
        $sources = implode("\n", array_values($this->plan()->writes));

        self::assertStringContainsString('@param list<TagId> $tags', $sources);
        self::assertStringContainsString('public function refQueryItems(?array $tags = null): Envelope', $sources);
        self::assertStringContainsString(
            "->query('tags', \$tags === null ? null : array_map(static fn(TagId \$__v): string => \$__v->toScalar(), \$tags))",
            $sources,
        );
    }

    /**
     * GitHub's `fields`/`has` shape: a `oneOf` of a bare scalar and an
     * array of one. Ruling: both branches survive as the native union
     * `string|array`, and the PHPStan annotation carries the precision
     * native PHP cannot — `string|list<string>`. `Endpoint::query()`
     * already serialises either arm at runtime, so the value passes
     * through untouched.
     */
    public function testAScalarOrListQueryParameterEmitsTheNativeUnion(): void
    {
        $sources = implode("\n", array_values($this->plan()->writes));

        self::assertStringContainsString('@param string|list<string> $tags', $sources);
        self::assertStringContainsString('public function scalarOrList(string|array|null $tags = null): Envelope', $sources);
        self::assertStringContainsString("->query('tags', \$tags)", $sources);
    }

    /**
     * `support-the-parameter-shapes-real-documents-use`, second half of the
     * `job_names` criterion: the fixture declares neither `style` nor
     * `explode` for `refQueryItems`'s `tags` (job_names' own shape) or
     * `scalarOrList`'s `tags` (fields/has' shape), so the OpenAPI default
     * for `query` applies to both — and {@see QuerySerializationAdvisor}
     * says so, naming each by parameter and operation.
     */
    public function testAListValuedQueryParameterWithNoDeclaredStyleGetsANotice(): void
    {
        $notices = implode("\n", $this->plan()->notices);

        self::assertStringContainsString('style: form', $notices);
        self::assertStringContainsString('explode: true', $notices);
        self::assertStringContainsString('tags (refQueryItems)', $notices);
        self::assertStringContainsString('tags (scalarOrList)', $notices);
    }

    /**
     * The third mechanism: a required header parameter is a required
     * method argument now, positioned the same way a required query
     * parameter is — ahead of the optional query and header parameters
     * that follow it, so the signature stays valid PHP.
     */
    public function testARequiredHeaderIsAheadOfOptionalQueryAndHeader(): void
    {
        $sources = implode("\n", array_values($this->plan()->writes));

        self::assertStringContainsString(
            "public function dangerousOp(\n        string \$widgetId,\n        bool \$xConfirm,\n        "
                . "?bool \$verbose = null,\n        ?string \$xDebug = null,\n    ): Envelope",
            $sources,
        );
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-parameter-shape-references-'),
            namespace: self::NAMESPACE,
        ));
    }
}
