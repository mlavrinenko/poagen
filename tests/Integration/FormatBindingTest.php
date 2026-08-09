<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Fixtures\ValueObject\Slug;
use Poagen\Generator\Tests\Support\FormatBindingFixture;
use Poagen\Runtime\Format\RamseyUuidCodec;
use Poagen\Runtime\Marshal\Hydrator;
use Poagen\Runtime\Marshal\Marshaller;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function str_contains;

/**
 * `built-in-uuid-and-binary-format-bindings`: `Profile::$formats` binds a
 * value object — or, since `codec-bindings-for-foreign-value-types`, a codec
 * — to every property carrying one format, document-wide — the reach
 * `#[BindsFormat]` has, said in the profile instead of on a class the
 * consumer had to write first.
 *
 * That distinction is the whole point for `uuid`. Unlike `date-time`, which
 * PHP core already has a type for, any UUID type is a dependency decision, so
 * poagen ships bindings for the libraries people already use and binds none
 * of them by default. One profile line turns one on; editing that line swaps
 * libraries. `uuid` is bound to `RamseyUuidCodec`: the emitted property is
 * `ramsey/uuid`'s own `UuidInterface`, never a wrapper around it.
 *
 * `format-binding-3.0.yaml` spends `uuid` on five sites — a required
 * property, an optional one, a list of them, a second component, and a path
 * parameter — and carries `binary` and `email` unbound alongside them.
 * `format: byte`'s own coverage — a poagen built-in needing no profile line
 * at all — is {@see FormatBindingByteTest}, split off to keep this file
 * under linecop (`quality-gates-at-maximum-strictness`).
 */
final class FormatBindingTest extends TestCase
{
    use FormatBindingFixture;

    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\FormatBinding';
    private const string VALUE_OBJECTS = 'Poagen\\Generator\\Tests\\Fixtures\\ValueObject';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testOneEntryReachesEveryPropertyCarryingThatFormat(): void
    {
        $plan = $this->plan(['uuid' => RamseyUuidCodec::class]);
        $account = $this->formatBindingModelSource($plan, 'Account');

        // Required, optional, a list of them, and a property on a second
        // component — one entry, four sites, no per-property key anywhere.
        // The property is typed as the library's own `UuidInterface`
        // directly, never a wrapper around it.
        self::assertStringContainsString("#[Format(format: 'uuid', codec: RamseyUuidCodec::class)]", $account);
        self::assertStringContainsString('public UuidInterface $id,', $account);
        self::assertStringContainsString('public ?UuidInterface $ownerId = null,', $account);
        self::assertStringContainsString('@param ?list<UuidInterface> $previousIds', $account);
        self::assertStringContainsString('public UuidInterface $token,', $this->formatBindingModelSource($plan, 'Session'));
    }

    /**
     * The fifth site, and the one a per-property binding could never reach:
     * an operation parameter belongs to no model, so `$propertyFormats` has
     * no key to name it by. It is also the site that proves the binding is
     * carried through the wire boundary rather than only into a type — the
     * emitted call routes the value through the codec's static `encode()`
     * rather than through a method on the value itself, since
     * `UuidInterface` has no `toScalar()` of its own.
     */
    public function testTheBindingReachesAnOperationParameterAndUnwrapsItOnTheWire(): void
    {
        $source = $this->formatBindingClientSource($this->plan(['uuid' => RamseyUuidCodec::class]));

        self::assertStringContainsString('public function getAccount(UuidInterface $accountId)', $source);
        self::assertStringContainsString("->path('accountId', RamseyUuidCodec::encode(\$accountId))", $source);
    }

    public function testAnEmptyMapLeavesEveryFormatAtItsBaseType(): void
    {
        $source = $this->formatBindingModelSource($this->plan([]), 'Account');

        self::assertStringContainsString('public string $id,', $source);
        self::assertFalse(str_contains($source, 'UuidInterface'));
    }

    /**
     * `format: binary` on a plain property is deliberately not bound. On a
     * body's own content schema it already drives behaviour, but inside a
     * JSON document it means raw bytes, which `string` already is — see
     * `truth/decisions/binary-on-a-property-stays-advisory.decision-260809.typ`.
     */
    public function testBinaryOnAPlainPropertyStaysAStringAndStaysAdvisory(): void
    {
        $plan = $this->plan(['uuid' => RamseyUuidCodec::class]);

        self::assertStringContainsString('public ?string $avatar = null,', $this->formatBindingModelSource($plan, 'Account'));
        self::assertNotNull($this->formatBindingNoticeFor($plan, 'binary'));
    }

    public function testABoundFormatStopsBeingReportedAsUnrecognised(): void
    {
        self::assertNotNull($this->formatBindingNoticeFor($this->plan([]), 'uuid'));
        self::assertNull($this->formatBindingNoticeFor($this->plan(['uuid' => RamseyUuidCodec::class]), 'uuid'));
    }

    /**
     * A notice for a format poagen already ships a binding for names the
     * binding and the package, rather than telling the consumer to go write a
     * value object poagen could have saved them.
     */
    public function testTheNoticeForAnUnboundUuidNamesTheReadyMadeBindings(): void
    {
        $notice = $this->formatBindingNoticeFor($this->plan([]), 'uuid');

        self::assertNotNull($notice);
        self::assertStringContainsString('poagen ships a binding for it', $notice);
        self::assertStringContainsString('\\Poagen\\Runtime\\Format\\RamseyUuidCodec::class (ramsey/uuid)', $notice);
        self::assertStringContainsString('\\Poagen\\Runtime\\Format\\SymfonyUuidCodec::class (symfony/uid)', $notice);
        self::assertStringContainsString('Profile::$formats', $notice);
    }

    /**
     * Nothing poagen ships a binding for gets one anyway: the generic advice
     * still points at both routes into the same map.
     */
    public function testTheNoticeForAFormatWithNoReadyMadeBindingKeepsTheGenericAdvice(): void
    {
        $notice = $this->formatBindingNoticeFor($this->plan([]), 'email');

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

        self::assertStringContainsString('public ?Slug $contact = null,', $this->formatBindingModelSource($plan, 'Account'));
    }

    public function testADiscoveredBindsFormatStillAppliesToAFormatTheProfileSaysNothingAbout(): void
    {
        $plan = $this->plan(['uuid' => RamseyUuidCodec::class], discoverIn: [self::VALUE_OBJECTS]);

        self::assertStringContainsString('public ?Email $contact = null,', $this->formatBindingModelSource($plan, 'Account'));
    }

    public function testAProfileEntryBeatsABuiltIn(): void
    {
        $plan = $this->plan(['date-time' => Slug::class]);

        self::assertStringContainsString('public ?Slug $createdAt = null,', $this->formatBindingModelSource($plan, 'Session'));
    }

    public function testAPerPropertyEntryBeatsAProfileEntryOnTheSameProperty(): void
    {
        $plan = $this->plan(
            ['uuid' => RamseyUuidCodec::class],
            propertyFormats: ['Account.id' => Slug::class],
        );
        $source = $this->formatBindingModelSource($plan, 'Account');

        // The scoped key answers for its one property; the document-wide
        // entry still answers for every other site.
        self::assertStringContainsString('public Slug $id,', $source);
        self::assertStringContainsString('public ?UuidInterface $ownerId = null,', $source);
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

    public function testAnEntryNamingAClassThatIsNeitherContractFailsTheRun(): void
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
     * string, the model carries the library's own `UuidInterface` directly —
     * no wrapper hop — and marshalling routes it back through the codec's
     * `encode()`.
     */
    public function testABoundUuidRoundTripsHydrationAndMarshalling(): void
    {
        $reflection = $this->formatBindingRequireAccount(self::NAMESPACE, ['uuid' => RamseyUuidCodec::class]);
        $raw = '2b1a7f60-4c2c-4a5b-9c6e-6a2f0d1e3b44';

        $hydrated = new Hydrator()->hydrate($reflection->getName(), ['id' => $raw]);
        $id = $reflection->getProperty('id')->getValue($hydrated);

        self::assertInstanceOf(UuidInterface::class, $id);
        self::assertTrue($id->equals(Uuid::fromString($raw)));
        self::assertSame($raw, new Marshaller()->marshal($hydrated)['id']);
    }

    /**
     * @param array<string,string> $formats
     * @param list<string>         $discoverIn
     * @param array<string,string> $propertyFormats
     */
    private function plan(array $formats, array $discoverIn = [], array $propertyFormats = []): GenerationPlan
    {
        return $this->formatBindingPlan(self::NAMESPACE, $formats, $discoverIn, $propertyFormats);
    }
}
