<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Fixtures\ValueObject\Slug;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Runtime\Format\RamseyUuid;
use Poagen\Runtime\Marshal\Hydrator;
use Poagen\Runtime\Marshal\Marshaller;
use Ramsey\Uuid\Uuid;
use ReflectionClass;

use function str_contains;

/**
 * `built-in-uuid-and-binary-format-bindings`: `Profile::$formats` binds a
 * value object to every property carrying one format, document-wide — the
 * reach `#[BindsFormat]` has, said in the profile instead of on a class the
 * consumer had to write first.
 *
 * That distinction is the whole point for `uuid`. Unlike `date-time`, which
 * PHP core already has a type for, any UUID type is a dependency decision, so
 * poagen ships bindings for the libraries people already use and binds none
 * of them by default. One profile line turns one on; editing that line swaps
 * libraries.
 *
 * `format-binding-3.0.yaml` spends `uuid` on four sites — a required
 * property, an optional one, a second component, and a path parameter — and
 * carries `binary` and `email` unbound alongside them.
 */
final class FormatBindingTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/format-binding-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\FormatBinding';
    private const string VALUE_OBJECTS = 'Poagen\\Generator\\Tests\\Fixtures\\ValueObject';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testOneEntryReachesEveryPropertyCarryingThatFormat(): void
    {
        $plan = $this->plan(['uuid' => RamseyUuid::class]);

        // Required, optional, and a property on a second component — one
        // entry, three sites, no per-property key anywhere.
        self::assertStringContainsString('public RamseyUuid $id,', $this->modelSource($plan, 'Account'));
        self::assertStringContainsString('public ?RamseyUuid $ownerId = null,', $this->modelSource($plan, 'Account'));
        self::assertStringContainsString('public RamseyUuid $token,', $this->modelSource($plan, 'Session'));
    }

    /**
     * The fourth site, and the one a per-property binding could never reach:
     * an operation parameter belongs to no model, so `$propertyFormats` has
     * no key to name it by. It is also the site that proves the binding is
     * carried through the wire boundary rather than only into a type — the
     * emitted call has to unwrap it.
     */
    public function testTheBindingReachesAnOperationParameterAndUnwrapsItOnTheWire(): void
    {
        $source = $this->clientSource($this->plan(['uuid' => RamseyUuid::class]));

        self::assertStringContainsString('public function getAccount(RamseyUuid $accountId)', $source);
        self::assertStringContainsString("->path('accountId', \$accountId->toScalar())", $source);
    }

    public function testAnEmptyMapLeavesEveryFormatAtItsBaseType(): void
    {
        $source = $this->modelSource($this->plan([]), 'Account');

        self::assertStringContainsString('public string $id,', $source);
        self::assertFalse(str_contains($source, 'RamseyUuid'));
    }

    /**
     * `format: binary` on a plain property is deliberately not bound. On a
     * body's own content schema it already drives behaviour, but inside a
     * JSON document it means raw bytes, which `string` already is — see
     * `truth/decisions/binary-on-a-property-stays-advisory.decision-260809.typ`.
     */
    public function testBinaryOnAPlainPropertyStaysAStringAndStaysAdvisory(): void
    {
        $plan = $this->plan(['uuid' => RamseyUuid::class]);

        self::assertStringContainsString('public ?string $avatar = null,', $this->modelSource($plan, 'Account'));
        self::assertNotNull($this->noticeFor($plan, 'binary'));
    }

    public function testABoundFormatStopsBeingReportedAsUnrecognised(): void
    {
        self::assertNotNull($this->noticeFor($this->plan([]), 'uuid'));
        self::assertNull($this->noticeFor($this->plan(['uuid' => RamseyUuid::class]), 'uuid'));
    }

    /**
     * A notice for a format poagen already ships a binding for names the
     * binding and the package, rather than telling the consumer to go write a
     * value object poagen could have saved them.
     */
    public function testTheNoticeForAnUnboundUuidNamesTheReadyMadeBindings(): void
    {
        $notice = $this->noticeFor($this->plan([]), 'uuid');

        self::assertNotNull($notice);
        self::assertStringContainsString('poagen ships a binding for it', $notice);
        self::assertStringContainsString('\\Poagen\\Runtime\\Format\\RamseyUuid::class (ramsey/uuid)', $notice);
        self::assertStringContainsString('\\Poagen\\Runtime\\Format\\SymfonyUuid::class (symfony/uid)', $notice);
        self::assertStringContainsString('Profile::$formats', $notice);
    }

    /**
     * Nothing poagen ships a binding for gets one anyway: the generic advice
     * still points at both routes into the same map.
     */
    public function testTheNoticeForAFormatWithNoReadyMadeBindingKeepsTheGenericAdvice(): void
    {
        $notice = $this->noticeFor($this->plan([]), 'email');

        self::assertNotNull($notice);
        self::assertStringContainsString("['email' => YourValueObject::class]", $notice);
        self::assertStringContainsString("#[BindsFormat('email')]", $notice);
    }

    public function testAProfileEntryBeatsADiscoveredBindsFormatOnTheSameFormat(): void
    {
        // `Email` carries `#[BindsFormat('email')]` and is discoverable here;
        // `Slug` carries no attribute at all, so seeing it means the profile
        // won rather than the two agreeing.
        $plan = $this->plan(['email' => Slug::class], discoverIn: [self::VALUE_OBJECTS]);

        self::assertStringContainsString('public ?Slug $contact = null,', $this->modelSource($plan, 'Account'));
    }

    public function testADiscoveredBindsFormatStillAppliesToAFormatTheProfileSaysNothingAbout(): void
    {
        $plan = $this->plan(['uuid' => RamseyUuid::class], discoverIn: [self::VALUE_OBJECTS]);

        self::assertStringContainsString('public ?Email $contact = null,', $this->modelSource($plan, 'Account'));
    }

    public function testAProfileEntryBeatsABuiltIn(): void
    {
        $plan = $this->plan(['date-time' => Slug::class]);

        self::assertStringContainsString('public ?Slug $createdAt = null,', $this->modelSource($plan, 'Session'));
    }

    public function testAPerPropertyEntryBeatsAProfileEntryOnTheSameProperty(): void
    {
        $plan = $this->plan(
            ['uuid' => RamseyUuid::class],
            propertyFormats: ['Account.id' => Slug::class],
        );
        $source = $this->modelSource($plan, 'Account');

        // The scoped key answers for its one property; the document-wide
        // entry still answers for every other site.
        self::assertStringContainsString('public Slug $id,', $source);
        self::assertStringContainsString('public ?RamseyUuid $ownerId = null,', $source);
    }

    public function testAnEntryNamingAClassThatDoesNotExistFailsTheRun(): void
    {
        try {
            $this->plan(['uuid' => 'Totally\\Bogus\\ClassName']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$formats['uuid']", $e->getMessage());
            self::assertStringContainsString("class 'Totally\\Bogus\\ClassName' that does not exist", $e->getMessage());
        }
    }

    public function testAnEntryNamingAClassThatIsNotAScalarBindingFailsTheRun(): void
    {
        try {
            $this->plan(['uuid' => Profile::class]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$formats['uuid']", $e->getMessage());
            self::assertStringContainsString('does not implement', $e->getMessage());
        }
    }

    /**
     * The wire boundary, end to end: the payload carries the canonical
     * string, the model carries the library's own UUID one hop in, and
     * marshalling puts the string back.
     */
    public function testABoundUuidRoundTripsHydrationAndMarshalling(): void
    {
        $output = self::makeSandboxDir('poagen-format-binding-');
        self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            formats: ['uuid' => RamseyUuid::class],
        ));

        $path = $output . '/Generated/Model/Account.php';
        self::assertFileExists($path);
        require $path;

        $class = self::declaredClassEnding(self::NAMESPACE . '\\Generated\\Model\\Account');
        $reflection = new ReflectionClass($class);
        $raw = '2b1a7f60-4c2c-4a5b-9c6e-6a2f0d1e3b44';

        $hydrated = new Hydrator()->hydrate($class, ['id' => $raw]);
        $id = $reflection->getProperty('id')->getValue($hydrated);

        self::assertInstanceOf(RamseyUuid::class, $id);
        self::assertTrue($id->value->equals(Uuid::fromString($raw)));
        self::assertSame($raw, new Marshaller()->marshal($hydrated)['id']);
    }

    /**
     * @param array<string,string> $formats
     * @param list<string>         $discoverIn
     * @param array<string,string> $propertyFormats
     */
    private function plan(array $formats, array $discoverIn = [], array $propertyFormats = []): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-format-binding-'),
            namespace: self::NAMESPACE,
            discoverIn: $discoverIn,
            formats: $formats,
            propertyFormats: $propertyFormats,
        ));
    }

    private function modelSource(GenerationPlan $plan, string $className): string
    {
        return $this->writeEndingIn($plan, '/Model/' . $className . '.php');
    }

    private function clientSource(GenerationPlan $plan): string
    {
        return $this->writeEndingIn($plan, '/Generated/ApiClient.php');
    }

    private function writeEndingIn(GenerationPlan $plan, string $suffix): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, $suffix)) {
                return $source;
            }
        }

        self::fail("no write found ending in '{$suffix}'");
    }

    private function noticeFor(GenerationPlan $plan, string $format): ?string
    {
        foreach ($plan->notices as $notice) {
            if (str_contains($notice, "format '{$format}' is not one poagen recognises")) {
                return $notice;
            }
        }

        return null;
    }
}
