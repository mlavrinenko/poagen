<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Emit\ModelEmission;
use Poagen\Generator\Generator\Emit\ModelEmitter;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Fixtures\ValueObject\Money;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Runtime\Marshal\Hydrator;
use Poagen\Runtime\Marshal\Marshaller;
use ReflectionClass;

/**
 * bind-a-format-per-property: `Profile::$propertyFormats` binds a value
 * object to one property of one model, unlike `#[BindsFormat]`, which keys
 * on the format string alone and applies document-wide — unusable the
 * moment a document spends one format on several meanings, exactly kilbil's
 * `double` (`examples/kilbil/README.md`).
 *
 * `scoped-format-3.0.yaml` carries two named components that both declare a
 * `price` property with `format: double` (`Product`, `Invoice`) and one
 * operation whose inline request body synthesises a third — no raw
 * component name reaches that one, only the class name poagen assigns it,
 * which is exactly why `$propertyFormats` keys on the class name rather than
 * the raw document name `$propertyRenames` / `$phpDocTypes` use — see
 * `Profile::$propertyFormats`'s own docblock.
 */
final class PropertyFormatTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/scoped-format-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\PropertyFormat';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAScopedBindingRoundTripsHydrationMarshallingAndThePhpSurface(): void
    {
        $output = self::makeSandboxDir('poagen-property-format-');
        self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            propertyFormats: ['Product.price' => Money::class],
        ));

        $path = $output . '/Generated/Model/Product.php';
        self::assertFileExists($path);
        require $path;

        $class = self::declaredClassEnding(self::NAMESPACE . '\\Generated\\Model\\Product');
        $reflection = new ReflectionClass($class);

        // The PHP surface: the promoted constructor parameter takes the
        // bound value object, not the base `float` the format would
        // otherwise resolve to.
        $product = $reflection->newInstanceArgs(['price' => new Money('12.50'), 'name' => 'Widget']);
        self::assertInstanceOf(Money::class, $this->propertyValue($reflection, $product, 'price'));

        // Marshalling: the wire still gets a bare number, not an object.
        $marshalled = new Marshaller()->marshal($product);
        self::assertSame(12.5, $marshalled['price']);

        // Hydration: the wire's bare number becomes the bound value object.
        $hydrated = new Hydrator()->hydrate($class, ['price' => 12.5, 'name' => 'Gadget']);
        $hydratedPrice = $this->propertyValue($reflection, $hydrated, 'price');
        self::assertInstanceOf(Money::class, $hydratedPrice);
        self::assertSame('12.50', $hydratedPrice->amount);
    }

    public function testAScopedBindingDoesNotReachASameNamedPropertyOnADifferentModel(): void
    {
        $plan = $this->plan(['Product.price' => Money::class]);

        self::assertStringContainsString('public Money $price,', $this->modelSource($plan, 'Product'));
        self::assertStringContainsString('public float $price,', $this->modelSource($plan, 'Invoice'));
    }

    public function testAScopedBindingReachesASynthesisedModelKeyedByItsClassName(): void
    {
        // No named component owns this one at all — `item` is an inline
        // object nested in `createOrder`'s request body, so the only name
        // it has is the one poagen assigned it.
        $plan = $this->plan(['CreateOrderRequestContentItem.price' => Money::class]);
        $source = $this->modelSource($plan, 'CreateOrderRequestContentItem');

        self::assertStringContainsString('public ?Money $price = null,', $source);
        // The sibling property on the very same synthesised model is untouched.
        self::assertStringContainsString('public ?float $quantity = null,', $source);
    }

    public function testAnUnscopedRunIsUnaffectedByAnEmptyPropertyFormatsMap(): void
    {
        $source = $this->modelSource($this->plan([]), 'Product');

        self::assertStringContainsString('public float $price,', $source);
    }

    public function testAKeyNamingAPropertyAbsentFromThatModelFailsTheRun(): void
    {
        try {
            $this->plan(['Product.no_such_property' => Money::class]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$propertyFormats['Product.no_such_property']", $e->getMessage());
            self::assertStringContainsString("property absent from model 'Product'", $e->getMessage());
        }
    }

    public function testAKeyNamingAClassThatDoesNotExistFailsTheRun(): void
    {
        try {
            $this->plan(['Product.price' => 'Totally\\Bogus\\ClassName']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$propertyFormats['Product.price']", $e->getMessage());
            self::assertStringContainsString("class 'Totally\\Bogus\\ClassName' that does not exist", $e->getMessage());
        }
    }

    /**
     * Recorded rather than hidden: a key naming a model this run never
     * emits at all is not refused today. `ModelPlanner`'s queue-drain
     * discards {@see ModelEmission::$failures} for every synthesised model,
     * and the only other check {@see ModelEmitter} can make runs solely for
     * a model this run actually produces — there is no name to compare a
     * stale entry against otherwise. See
     * `queue-drained-models-swallow-emission-failures`.
     */
    public function testAKeyNamingAModelThisRunNeverEmitsIsNotCaughtYet(): void
    {
        $plan = $this->plan(['NoSuchModel.price' => Money::class]);

        self::assertNotSame([], $plan->writes);
    }

    /**
     * @param  array<string,string> $propertyFormats
     */
    private function plan(array $propertyFormats): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-property-format-'),
            namespace: self::NAMESPACE,
            propertyFormats: $propertyFormats,
        ));
    }

    private function modelSource(GenerationPlan $plan, string $className): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, '/Model/' . $className . '.php')) {
                return $source;
            }
        }

        self::fail("no write found for model '{$className}'");
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function propertyValue(ReflectionClass $reflection, object $model, string $property): mixed
    {
        return $reflection->getProperty($property)->getValue($model);
    }
}
