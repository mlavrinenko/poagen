<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\AdditionalPropertyBag;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\AdditionalPropertiesRoundTripTest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

use function substr_count;

use const DIRECTORY_SEPARATOR;

/**
 * declared-shapes-become-types: `additionalProperties: true` beside declared
 * `properties` carries the extras in a runtime bag, and the other two states
 * of the keyword carry on meaning exactly what they meant.
 *
 * The boundary is the subject here, not the bag. JSON Schema defaults the
 * keyword to `true` and the parser substitutes that default, so an omitted
 * keyword reads back through `Schema::$additionalProperties` exactly as an
 * explicit one does. Reading it that way would put a bag on every object
 * paogen has ever emitted, for a permission nobody granted — so the three
 * states are generated from one document here, and the assertions are as much
 * about the two classes that must NOT change as about the one that does.
 *
 * This asserts on what the generator emits. That the bag is then filled from a
 * payload and emptied back into one is
 * {@see AdditionalPropertiesRoundTripTest}'s half, against the runtime
 * directly.
 */
final class OpenShapesTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/open-shapes-3.0.yaml';

    /** @var array<string, string> emitted model basename → its source */
    private static array $models = [];

    private static string $output = '';

    public static function setUpBeforeClass(): void
    {
        // `generate`, not `plan`: one test below loads the emitted classes and
        // runs a real payload through them, which needs them on disk.
        self::$output = self::makeSandboxDir('paogen-open-');

        $plan = self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: self::$output,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\OpenShapes',
        ));

        $needle = DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR;

        foreach ($plan->writes as $path => $source) {
            if (str_contains($path, $needle)) {
                self::$models[basename($path, '.php')] = $source;
            }
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$models = [];
        self::$output = '';
        self::removeSandboxDirs();
    }

    /**
     * The two halves together: the class the generator emitted, loaded and run
     * through the runtime it names. Everything else here reads emitted text,
     * which cannot catch an emitted property the runtime declines to fill.
     */
    public function testTheEmittedClassRoundTripsThroughTheRuntimeItNames(): void
    {
        require self::$output . '/Generated/Model/Part.php';
        require self::$output . '/Generated/Model/Open.php';

        $class = self::declaredClassEnding('\\Generated\\Model\\Open');
        $model = new Hydrator()->hydrate($class, [
            'name' => 'widget',
            'parts' => [['sku' => 'a1']],
            'colour' => 'red',
            'depth' => 2,
        ]);

        $bag = new ReflectionClass($model)->getProperty('additionalProperties')->getValue($model);

        self::assertInstanceOf(AdditionalPropertyBag::class, $bag);
        self::assertSame(['colour', 'depth'], $bag->keys());
        self::assertSame('red', $bag->get('colour'));

        // `parts` stayed typed off the docblock while the bag was typed off
        // its native type, and both came back out on the wire.
        self::assertSame(
            ['name' => 'widget', 'parts' => [['sku' => 'a1']], 'size' => null, 'colour' => 'red', 'depth' => 2],
            new Marshaller()->marshal($model),
        );
    }

    public function testAnExplicitTrueCarriesTheExtrasInABag(): void
    {
        $open = $this->model('Open');

        // Declared properties keep their own types, and the extras arrive
        // beside them in an object rather than an `array<string, mixed>` the
        // consumer would have to guard before asking anything.
        self::assertStringContainsString('public string $name,', $open);
        self::assertStringContainsString('public ?int $size = null,', $open);
        self::assertStringContainsString('#[AdditionalProperties]', $open);
        self::assertStringContainsString(
            'public AdditionalPropertyBag $additionalProperties = new AdditionalPropertyBag(),',
            $open,
        );
        self::assertStringNotContainsString('mixed', $open);
    }

    public function testTheBagWritesNoDocLineAndLeavesTheOnesAroundItAlone(): void
    {
        $open = $this->model('Open');

        // The bag's native type says everything there is to say, so it gets no
        // `@param`. A declared property that does need one still gets it —
        // they share the one constructor docblock, and only `parts` is in it.
        self::assertStringContainsString('@param ?list<Part> $parts', $open);
        self::assertSame(1, substr_count($open, '@param'));
    }

    /**
     * The claim the whole task rests on, and the one that cannot be checked by
     * looking at the bag: a document that wrote nothing about extras, and one
     * that closed the shape, emit what they always emitted.
     */
    #[DataProvider('unchangedModels')]
    public function testAKeywordNobodyOpenedEmitsNoBag(string $model): void
    {
        $source = $this->model($model);

        self::assertStringContainsString('public ?string $name = null,', $source);
        self::assertStringNotContainsString('AdditionalPropertyBag', $source);
        self::assertStringNotContainsString('AdditionalProperties', $source);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function unchangedModels(): iterable
    {
        yield 'an omitted keyword is the document saying nothing' => ['Silent'];
        yield 'an explicit false still closes the shape' => ['Closed'];
    }

    public function testOmissionAndClosureAreNotMerelySimilarButIdentical(): void
    {
        // Same declared property, two different keywords, one emitted body.
        // Anything that made omission mean `true` would separate these.
        self::assertSame(
            str_replace('Silent', 'X', $this->model('Silent')),
            str_replace('Closed', 'X', $this->model('Closed')),
        );
    }

    public function testAValueSchemaStillEmitsATypedMapRatherThanABag(): void
    {
        $typed = $this->model('Typed');

        // A map of a declared shape is a collection, and
        // `declared-shapes-become-types` keeps collections as PHP arrays.
        // Only the untyped case needs an object.
        self::assertStringContainsString('@param array<string, Part> $additionalProperties', $typed);
        self::assertStringContainsString('public array $additionalProperties = [],', $typed);
        self::assertStringNotContainsString('AdditionalPropertyBag', $typed);
    }

    public function testTheBagStepsAsideForADeclaredPropertyOfTheSameName(): void
    {
        $colliding = $this->model('Colliding');

        // The declared property is the one with a wire name behind it, so it
        // keeps the name; the bag takes an underscore rather than colliding,
        // which nette would print as a duplicate parameter.
        self::assertStringContainsString('public ?string $additionalProperties = null,', $colliding);
        self::assertStringContainsString(
            'public AdditionalPropertyBag $additionalProperties_ = new AdditionalPropertyBag(),',
            $colliding,
        );
    }

    /**
     * A required property has no default, so PHP forbids it after one that
     * has. The bag defaults to an empty bag and must therefore stay last.
     */
    public function testTheBagNeverDisplacesARequiredParameter(): void
    {
        $open = $this->model('Open');
        $bagAt = strpos($open, '$additionalProperties');

        self::assertIsInt($bagAt);
        self::assertGreaterThan(strpos($open, 'public string $name,'), $bagAt);
        self::assertGreaterThan(strpos($open, 'public ?int $size = null,'), $bagAt);
    }

    /**
     * Same shape, different position. A generator that types one and not the
     * other has no contract a reader can rely on.
     */
    #[DataProvider('payloadModels')]
    public function testAPayloadCarriesItsExtrasTheSameWayAComponentDoes(string $model, string $declared): void
    {
        $source = $this->model($model);

        self::assertStringContainsString($declared, $source);
        self::assertStringContainsString(
            'public AdditionalPropertyBag $additionalProperties = new AdditionalPropertyBag(),',
            $source,
        );
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function payloadModels(): iterable
    {
        yield 'an inline request body' => ['SaveOpenRequest', 'public string $handle,'];
        yield 'an inline response body' => ['SaveOpenResponse', 'public ?bool $saved = null,'];
    }

    private function model(string $basename): string
    {
        self::assertArrayHasKey($basename, self::$models, "the plan wrote no {$basename}.php");

        return self::$models[$basename];
    }
}
