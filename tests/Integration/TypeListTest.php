<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

/**
 * nullable-type-arrays: `type` written as a list is read, not discarded.
 *
 * `type: [integer, "null"]` is how JSON Schema — and OpenAPI 3.1 with it — says
 * what a 3.0 document said with `nullable: true`. Every `is_string($schema->type)`
 * guard in the generator missed that spelling and fell through to `mixed`, so a
 * property the vendor had typed reached the consumer untyped, silently. The
 * kilbil loyalty document does it 87 times.
 *
 * The interesting cases are at the edges of the reading: a list is not always a
 * nullable single type, and one shape of list is a refusal.
 */
final class TypeListTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/type-lists-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\TypeLists';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testASingleMemberPlusNullBecomesThatTypeNullable(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        self::assertStringContainsString('public ?int $requiredButNullable,', $model);
        self::assertStringContainsString('public ?string $optionalNullableString = null,', $model);
    }

    public function testARequiredButNullablePropertyTakesNoDefaultSoTheOrderingStaysLegal(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        // `required` and `nullable` are separate facts. Conflating them gave the
        // required-and-nullable property a default, which pushed a required
        // parameter after an optional one — deprecated since PHP 8.0 and a
        // finding at max level.
        self::assertStringContainsString('public ?int $requiredButNullable,', $model);
        self::assertStringNotContainsString('public ?int $requiredButNullable = null', $model);
    }

    public function testANullableArrayKeepsTheItemPhpdocAPlainArrayWouldGet(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        self::assertStringContainsString('@param ?list<string> $nullableList', $model);
        self::assertStringContainsString('public ?array $nullableList = null,', $model);
    }

    public function testASingleElementListReadsAsThatTypeWithoutNullability(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        // Optional, so nullable — but from required-ness, not from the list.
        self::assertStringContainsString('public ?string $singleMemberList = null,', $model);
    }

    public function testAnEnumWrittenWithAListTypeIsStillBacked(): void
    {
        $plan = $this->plan(['refusedShapes' => 'out of scope for this assertion']);
        $model = $this->sourceOf($plan, 'NullableShapesRequest');

        self::assertStringContainsString('public ?NullableShapesRequestNullableEnum $nullableEnum = null,', $model);
        self::assertStringContainsString(
            "case Draft = 'draft';",
            $this->sourceOf($plan, 'NullableShapesRequestNullableEnum'),
        );
    }

    /**
     * nullable-type-array-lost-in-property-synthesis: the three branches
     * PropertySynthesiser resolves itself — synthesised enum, synthesised
     * object, array item — each used to read only the 3.0 `nullable` flag
     * and miss the 3.1 `type: [T, "null"]` array TypeResolver already
     * honoured. A required property stayed non-nullable despite its schema
     * saying otherwise; only an optional property's blanket `?` masked it
     * (see testASingleElementListReadsAsThatTypeWithoutNullability above).
     * These three properties are required and nullable, so the mask does not
     * apply and the bug would otherwise surface as a missing `?`.
     */
    public function testARequiredNullableEnumSynthesisedInlineStaysNullable(): void
    {
        $plan = $this->plan(['refusedShapes' => 'out of scope for this assertion']);
        $model = $this->sourceOf($plan, 'NullableShapesRequest');

        self::assertStringContainsString(
            'public ?NullableShapesRequestRequiredNullableEnum $requiredNullableEnum,',
            $model,
        );
        self::assertStringContainsString(
            "case Draft = 'draft';",
            $this->sourceOf($plan, 'NullableShapesRequestRequiredNullableEnum'),
        );
    }

    public function testARequiredNullableObjectSynthesisedInlineStaysNullable(): void
    {
        $plan = $this->plan(['refusedShapes' => 'out of scope for this assertion']);
        $model = $this->sourceOf($plan, 'NullableShapesRequest');

        self::assertStringContainsString(
            'public ?NullableShapesRequestRequiredNullableObject $requiredNullableObject,',
            $model,
        );
        self::assertStringContainsString(
            'public ?string $inner = null,',
            $this->sourceOf($plan, 'NullableShapesRequestRequiredNullableObject'),
        );
    }

    public function testARequiredNullableArrayOfSynthesisedObjectsStaysNullable(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        self::assertStringContainsString(
            '@param ?list<NullableShapesRequestRequiredNullableObjectArrayItem> $requiredNullableObjectArray',
            $model,
        );
        self::assertStringContainsString('public ?array $requiredNullableObjectArray,', $model);
    }

    /**
     * three-more-sites-read-only-the-30-nullable-flag: an inline object with
     * no declared `properties` types as a string-keyed map rather than a
     * synthesised class, so it never reaches PropertySynthesiser's own
     * nullability read — it goes through TypeResolver's `object` branch
     * straight into InlineObjectResolver::resolve(), which used to read
     * only the 3.0 `nullable` flag. Required, so the optional-property `?`
     * blanket cannot mask the bug.
     */
    public function testARequiredNullableTypedMapWithNoDeclaredPropertiesStaysNullable(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        self::assertStringContainsString(
            '@param ?array<string, string> $requiredNullableTypedMap',
            $model,
        );
        self::assertStringContainsString('public ?array $requiredNullableTypedMap,', $model);
    }

    /**
     * three-more-sites-read-only-the-30-nullable-flag: a ref-only
     * `oneOf` union resolved by CompositionResolver::resolveUnion(), which
     * used to read only the 3.0 `nullable` flag. Required, so the
     * optional-property `?` blanket cannot mask the bug.
     */
    public function testARequiredNullableRefOnlyUnionStaysNullable(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        self::assertStringContainsString(
            'public NullableUnionBranchOne|NullableUnionBranchTwo|null $requiredNullableRefUnion,',
            $model,
        );
    }

    /**
     * three-more-sites-read-only-the-30-nullable-flag: an `anyOf` of inline
     * scalar branches resolved by CompositionResolver::resolveScalarUnion(),
     * which used to read only the 3.0 `nullable` flag. Required, so the
     * optional-property `?` blanket cannot mask the bug.
     */
    public function testARequiredNullableComposedScalarUnionStaysNullable(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        self::assertStringContainsString(
            'public int|string|null $requiredNullableComposedScalarUnion,',
            $model,
        );
    }

    public function testSeveralScalarMembersBecomeAPhpUnionRatherThanMixed(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        // PHP can say this, and a union is strictly more of the schema
        // represented than `mixed` is. Optional, so `|null` joins the union
        // rather than becoming `?string|int`, which is not a type.
        self::assertStringContainsString('public string|int|null $scalarUnion = null,', $model);
    }

    public function testASchemaWithNoTypeAtAllDeclaresMixedRatherThanNothing(): void
    {
        $model = $this->modelSource('NullableShapesRequest');

        // An untyped promoted readonly property is a finding at max level, so
        // the absence of a type has to be spelled rather than left off.
        self::assertStringContainsString('public mixed $untyped = null,', $model);
        self::assertStringNotContainsString('?mixed', $model);
    }

    public function testAListMixingANonScalarWithSomethingElseIsRefused(): void
    {
        try {
            $this->plan();
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('refusedShapes', $message);
            self::assertStringContainsString('type: [object, string]', $message);
            // Names where it sits and what would make it acceptable.
            self::assertStringContainsString('/paths/~1refused/post/requestBody', $message);
            self::assertStringContainsString('oneOf', $message);
        }
    }

    public function testTheRefusalIsAcceptableByNameFromTheProfile(): void
    {
        // Accepting the one named operation leaves the rest of the document
        // generating, which is what `Profile::$skip` is for.
        $plan = $this->plan(['refusedShapes' => 'a `type: [object, string]` body — narrowing it needs the vendor']);

        self::assertStringContainsString('public function nullableShapes(', $this->clientSource($plan));
        self::assertStringNotContainsString('public function refusedShapes(', $this->clientSource($plan));
    }

    /**
     * skipped-operation-still-emits-its-payload-model: `refusedShapes` is the
     * only operation that names this schema, so accepting its skip has to
     * drop the request model along with the method — otherwise the emitted
     * tree carries a class nothing calls, referencing nothing else either.
     * The nested branch class `InlinePayloadPlanner` would have queued while
     * draining `RefusedShapesRequest` — `RefusedShapesRequestEitherObjectOrString`
     * — never gets discovered once the root itself is never queued.
     */
    public function testTheSkippedOperationsPayloadModelDoesNotEmitEither(): void
    {
        $plan = $this->plan(['refusedShapes' => 'a `type: [object, string]` body — narrowing it needs the vendor']);
        $classNames = array_map(
            static fn(string $path): string => basename($path, '.php'),
            array_keys($plan->writes),
        );

        self::assertNotContains('RefusedShapesRequest', $classNames);
        self::assertNotContains('RefusedShapesRequestEitherObjectOrString', $classNames);
    }

    private function modelSource(string $class): string
    {
        return $this->sourceOf($this->plan(['refusedShapes' => 'out of scope for this assertion']), $class);
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip = []): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-typelist-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }

    private function sourceOf(GenerationPlan $plan, string $class): string
    {
        foreach ($plan->writes as $path => $source) {
            if (basename($path, '.php') === $class) {
                return $source;
            }
        }

        self::fail("the plan wrote no {$class}.php");
    }

    private function clientSource(GenerationPlan $plan): string
    {
        return $this->sourceOf($plan, 'ApiClient');
    }
}
