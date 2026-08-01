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
