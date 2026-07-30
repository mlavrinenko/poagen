<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Composer\Autoload\ClassLoader;
use FilesystemIterator;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function is_array;

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
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/type-lists-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\TypeLists';

    /** @var list<string> */
    private array $outputDirs = [];

    protected function tearDown(): void
    {
        foreach ($this->outputDirs as $dir) {
            if (is_dir($dir)) {
                $this->removeDirectory($dir);
            }
        }

        parent::tearDown();
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
        return new Generator(new AttributeScanner($this->composerLoader()))->plan(new Profile(
            schema: self::SCHEMA,
            output: $this->makeTempDir(),
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

    private function makeTempDir(): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), 'paogen-typelist-');
        unlink($path);

        if (!mkdir($path, 0o755, true) && !is_dir($path)) {
            self::fail("failed to create temporary directory: {$path}");
        }

        $this->outputDirs[] = $path;

        return $path;
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        self::fail('Composer ClassLoader not found in autoload chain.');
    }

    private function removeDirectory(string $dir): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        /** @var SplFileInfo $entry */
        foreach ($iterator as $entry) {
            if ($entry->isDir()) {
                rmdir($entry->getPathname());

                continue;
            }

            unlink($entry->getPathname());
        }

        rmdir($dir);
    }
}
