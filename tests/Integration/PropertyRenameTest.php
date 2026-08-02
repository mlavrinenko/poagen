<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * property-name-renaming-guidance (T-260730): `Profile::$propertyRenames` is
 * the property-level answer `$methodRenames` and `$tagRenames` already gave
 * operation ids and tags. `Contact.org_id` is already a valid PHP identifier,
 * so {@see ModelEmitter::defaultPropertyName()}
 * keeps it verbatim today — exactly the "reads like the wire" complaint this
 * field exists to fix.
 *
 * The round-trip test requires the actually-generated class and drives it
 * through the real runtime {@see Marshaller} / {@see Hydrator} rather than
 * inspecting the printed source: a rename that looked right in the emitted
 * text but broke hydration or marshalling would still pass a string match,
 * which is the gap `attribute-and-phpdoc-driven-serialization` closes.
 */
final class PropertyRenameTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/contact-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\PropertyRename';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testARenamedPropertyRoundTripsHydrationMarshallingAndThePhpSurface(): void
    {
        $output = self::makeSandboxDir('paogen-property-rename-');
        self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            propertyRenames: ['Contact.org_id' => 'orgId'],
        ));

        $path = $output . '/Generated/Model/Contact.php';
        self::assertFileExists($path);
        require $path;

        $class = self::declaredClassEnding(self::NAMESPACE . '\\Generated\\Model\\Contact');
        $reflection = new ReflectionClass($class);

        // The PHP surface: the promoted constructor parameter takes the
        // renamed name, not the wire one.
        $contact = $reflection->newInstanceArgs([
            'displayName' => 'Ada',
            'email' => 'ada@example',
            'orgId' => 7,
        ]);
        self::assertSame(7, $this->propertyValue($reflection, $contact, 'orgId'));

        // Marshalling: the wire still gets the vendor's spelling, not the
        // renamed one.
        $marshalled = new Marshaller()->marshal($contact);
        self::assertSame(7, $marshalled['org_id']);
        self::assertArrayNotHasKey('orgId', $marshalled);

        // Hydration: reading the wire name populates the renamed property.
        $hydrated = new Hydrator()->hydrate($class, [
            'display-name' => 'Grace',
            'email' => 'grace@example',
            'org_id' => 9,
        ]);
        self::assertSame(9, $this->propertyValue($reflection, $hydrated, 'orgId'));

        // An unrenamed property on the same model is untouched by any of this.
        self::assertSame('Grace', $this->propertyValue($reflection, $hydrated, 'displayName'));
    }

    public function testAKeyNamingAComponentAbsentFromTheDocumentFailsTheRun(): void
    {
        try {
            $this->plan(['NoSuchModel.org_id' => 'orgId']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$propertyRenames['NoSuchModel.org_id']", $e->getMessage());
            self::assertStringContainsString('component absent from the document', $e->getMessage());
        }
    }

    public function testAKeyNamingAPropertyAbsentFromThatComponentFailsTheRun(): void
    {
        try {
            $this->plan(['Contact.no_such_property' => 'whatever']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$propertyRenames['Contact.no_such_property']", $e->getMessage());
            self::assertStringContainsString("property absent from component 'Contact'", $e->getMessage());
        }
    }

    public function testARenameCollidingWithAnUnrenamedPropertyFailsTheRunAndNamesBoth(): void
    {
        try {
            // 'nickname' already emits as `$nickname`; pointing `org_id` at the
            // same PHP name is the "collides with an unrenamed property" case.
            $this->plan(['Contact.org_id' => 'nickname']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();
            self::assertStringContainsString("component 'Contact'", $message);
            self::assertStringContainsString("property 'org_id'", $message);
            self::assertStringContainsString("to 'nickname'", $message);
            self::assertStringContainsString("property 'nickname' already uses", $message);
        }
    }

    public function testRegenerationIsDeterministic(): void
    {
        // Compared by value only: the two runs write to distinct sandbox
        // directories, so the map's keys (absolute paths) legitimately
        // differ even though the source they produce must not.
        $renames = ['Contact.org_id' => 'orgId'];

        self::assertSame(array_values($this->plan($renames)->writes), array_values($this->plan($renames)->writes));
    }

    /**
     * @param array<string,string> $propertyRenames
     */
    private function plan(array $propertyRenames): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-property-rename-'),
            namespace: self::NAMESPACE,
            propertyRenames: $propertyRenames,
        ));
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function propertyValue(ReflectionClass $reflection, object $model, string $property): mixed
    {
        return $reflection->getProperty($property)->getValue($model);
    }
}
