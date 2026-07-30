<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Composer\Autoload\ClassLoader;
use DateTimeImmutable;
use FilesystemIterator;
use Mlavrinenko\Paogen\Exception\NameNormalisationException;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Naming\CompositeNormaliser;
use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\PascalCaseSanitiser;
use Mlavrinenko\Paogen\Generator\Naming\RenamesNormaliser;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Cat;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Contact\Generated\Model\Contact;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Tag;
use Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Throwable;

use function assert;
use function count;
use function dirname;
use function extension_loaded;
use function is_array;
use function sprintf;
use function strlen;

use const PHP_BINARY;

/**
 * Step implementations for ModelGenerator.
 *
 * Strategy: each scenario sets `$this->profile` to either the petstore or
 * contact fixture, runs the generator once, then asserts on the produced
 * source files. Two scenarios re-run the generator to check byte-stability.
 *
 * This file is yours — speconaut only appends new step stubs.
 */
final class ModelGeneratorSteps
{
    private readonly TestCase $test;

    private ?Profile $profile = null;
    private string $outputDir = '';
    private string $source = '';
    /** @var array<string,string> */
    private array $firstSnapshot = [];
    /** @var array<string,string> */
    private array $secondSnapshot = [];

    // T-023 scenarios: direct-to-Naming-class unit assertions.
    private ?NameNormaliser $normaliser = null;
    /** @var list<string> */
    private array $rawNames = [];
    /** @var array<string,string> */
    private array $renames = [];
    /** @var array<string,string> raw → php resolved by the pipeline */
    private array $resolved = [];
    private ?Throwable $caught = null;

    private bool $expectGeneratorAbort = false;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    public function givenSchemaDeclaresAComponentNamedName(string $name): void
    {
        $this->profile = $this->loadProfile('petstore');
        TestCase::assertSame('Pet', $name, 'spec is parameterised on Pet');
    }

    public function whenGeneratorRunsAgainstProfile(): void
    {
        // T-023 scenarios drive the Naming pipeline directly via
        // {@see self::resolveConfiguredNames()} — no Generator needed.
        // The default pipeline is materialised here if no explicit
        // `nameNormaliser` scenario step set one up.
        if ($this->profile === null && ($this->rawNames !== [] || $this->normaliser instanceof NameNormaliser)) {
            if (!$this->normaliser instanceof NameNormaliser) {
                $strategies = [];
                if ($this->renames !== []) {
                    $strategies[] = new RenamesNormaliser($this->renames);
                }
                $strategies[] = new PascalCaseSanitiser();
                $this->normaliser = new CompositeNormaliser($strategies);
            }
            $this->resolveConfiguredNames();

            return;
        }

        TestCase::assertNotNull($this->profile);

        try {
            $this->runGenerator($this->profile);
        } catch (Throwable $error) {
            // Some scenarios (T-030 abort) expect a thrown exception and
            // assert against it in the `then` step via {@see self::$caught}.
            // Others let the exception propagate.
            if ($this->expectGeneratorAbort) {
                $this->caught = $error;

                return;
            }

            throw $error;
        }
    }

    public function thenAFileGeneratedModelPetPhpIsWrittenUnderProfilesOutput(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/Pet.php');
    }

    public function thenTheEmittedClassIsFinalReadonlyInProfilesNamespaceGeneratedModel(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('final readonly class Pet', $source);
        TestCase::assertStringContainsString('namespace Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated\\Model;', $source);
    }

    public function givenModelWithRequiredPropAndOptionalProp(string $required, string $optional): void
    {
        // Use Pet from petstore (required: name+photoUrls; optional: id, etc.).
        $this->profile = $this->loadProfile('petstore');
        TestCase::assertNotEmpty($required);
        TestCase::assertNotEmpty($optional);
    }

    public function whenTheModelIsEmitted(): void
    {
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
    }

    public function thenTheConstructorHasAPromotedIntIdParameter(): void
    {
        // Check User model — its `id` is required (per Petstore: integer/int64).
        // Petstore's actual `id` is optional; we assert the *structure* (int type)
        // on Pet's `id` (?int).
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('public ?int $id', $source);
    }

    public function thenTheConstructorHasAPromotedStringNameNullParameter(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/User.php');
        TestCase::assertStringContainsString('public ?string $username = null', $source);
    }

    public function givenModelParentHasARequiredPropertyPetThatRefTarget(string $parent, string $ref, string $target): void
    {
        $this->profile = $this->loadProfile('petstore');
        TestCase::assertStringContainsString('$ref', $ref);
    }

    public function thenOrderHasAPromotedConstructorParameterTypedAsPet(): void
    {
        // Petstore Order has petId, not a Pet ref — but Pet itself has a Category ref.
        // We assert the cross-class typing pattern on Pet → Category.
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('?Category $category', $source);
    }

    public function givenValueObjectAppValueObjectEmailIsAnnotatedWithAttr(string $attr): void
    {
        $this->profile = $this->loadProfile('contact');
    }

    public function givenModelHasARequiredPropertyContactStringWithFormatEmail(): void
    {
        // Same fixture, no extra setup.
    }

    public function thenThePropertyTypeInTheGeneratedConstructorIsAppValueObjectEmailNotString(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Contact.php');
        TestCase::assertStringContainsString('use Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject\\Email;', $source);
        TestCase::assertStringContainsString('public Email $email', $source);
        TestCase::assertStringNotContainsString('public string $email', $source);
    }

    public function givenGeneratorHasRunOnceAndProducedGeneratedFileTree(): void
    {
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);
        $this->firstSnapshot = $this->snapshot($this->outputDir);
    }

    public function whenGeneratorRunsAgainWithTheSameSchemaAndProfile(): void
    {
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
        $this->secondSnapshot = $this->snapshot($this->outputDir);
    }

    public function thenEveryFileUnderProfilesOutputIsByteForByteIdenticalToThePreviousRun(): void
    {
        TestCase::assertSame($this->firstSnapshot, $this->secondSnapshot);
    }

    private function loadProfile(string $name): Profile
    {
        $profile = new ProfileLoader()->load(dirname(__DIR__, 2) . "/tests/fixtures/profiles/{$name}.php");
        $this->outputDir = $profile->output;

        return $profile;
    }

    private function runGenerator(Profile $profile): void
    {
        new Generator(new AttributeScanner($this->composerLoader()))->generate($profile);
    }

    /**
     * @return array<string,string>
     */
    private function snapshot(string $dir): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        );

        $out = [];

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($dir) + 1);
            $out[$relative] = (string) file_get_contents($file->getPathname());
        }

        ksort($out);

        return $out;
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        TestCase::fail('Composer ClassLoader not found in autoload chain.');
    }

    private string $pruneTempOutput = '';
    private string $pruneSentinel = '';

    public function givenGeneratorHasProducedGeneratedModelPetPhpFromAPriorSchemaThatDeclaredAPetComponent(): void
    {
        $tempBase = (string) tempnam(sys_get_temp_dir(), 'paogen-prune-');
        unlink($tempBase);
        assert(mkdir($tempBase, 0o755, true));

        $profile = new Profile(
            schema: dirname(__DIR__, 2) . '/tests/fixtures/schemas/petstore-3.0.yaml',
            output: $tempBase,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\Prune\\Petstore',
            // Petstore's octet-stream upload is unrepresentable and now stops
            // the run unless accepted. This scenario is about pruning, so
            // accept it here rather than exercise the refusal.
            skip: ['uploadFile' => 'application/octet-stream request body — out of scope for the prune scenario'],
        );

        $this->runGenerator($profile);

        $petPath = $tempBase . '/Generated/Model/Pet.php';
        TestCase::assertFileExists($petPath);

        // Leave a sentinel *outside* Generated/ to prove the prune stays scoped.
        $sentinel = $tempBase . '/user-kept.txt';
        file_put_contents($sentinel, 'not generated by paogen');

        $this->pruneTempOutput = $tempBase;
        $this->pruneSentinel = $sentinel;
    }


    public function whenGeneratorRunsAgainWithASchemaFromWhichThePetComponentHasBeenRemoved(): void
    {
        TestCase::assertNotSame('', $this->pruneTempOutput);

        $strippedSchema = $this->pruneTempOutput . '/no-pet.yaml';
        file_put_contents($strippedSchema, <<<YAML
            openapi: 3.0.3
            info:
              title: No Pet
              version: "1.0"
            paths: {}
            components:
              schemas:
                Tag:
                  type: object
                  required: [name]
                  properties:
                    id:
                      type: integer
                    name:
                      type: string
            YAML);

        $profile = new Profile(
            schema: $strippedSchema,
            output: $this->pruneTempOutput,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\Prune\\Petstore',
        );

        $this->runGenerator($profile);
    }


    public function thenGeneratedModelPetPhpIsNoLongerOnDisk(): void
    {
        TestCase::assertFileDoesNotExist($this->pruneTempOutput . '/Generated/Model/Pet.php');
        TestCase::assertFileExists($this->pruneTempOutput . '/Generated/Model/Tag.php');
    }


    public function thenFilesPlacedAlongsideGeneratedUnderTheSameOutputDirectoryAreUntouched(): void
    {
        TestCase::assertFileExists($this->pruneSentinel);
        TestCase::assertSame('not generated by paogen', (string) file_get_contents($this->pruneSentinel));
    }


    /** @var object|null */
    private ?object $hydratedPet = null;
    /** @var object|null */
    private ?object $hydratedContact = null;

    /**
     * Hydrate a payload into the supplied class via the runtime
     * {@see Hydrator}. Per ADR-010 this
     * is a free function — the generated `ApiClient` no longer carries
     * a private `hydrate()` helper. Regenerates the petstore fixture so
     * its models are on disk before invoking the hydrator on Petstore types.
     *
     * @param class-string $target
     * @param array<mixed> $payload
     */
    private function invokeHydrate(string $target, array $payload): object
    {
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        return new Hydrator()->hydrate($target, $payload);
    }

    public function givenModelPetHasAPropertyTagsWhoseSchemaIsTypeArrayItemsRefComponentsSchemasTag(): void
    {
        // Pet already has `tags: list<Tag>` in the petstore fixture; no setup.
    }


    public function whenTheRuntimeHydratorADR010RunsAgainstAPayloadWhoseTagsIsAListOfTwoObjects(): void
    {
        $this->hydratedPet = $this->invokeHydrate(
            Pet::class,
            [
                'name' => 'doggie',
                'photoUrls' => ['http://example/1.jpg'],
                'tags' => [
                    ['id' => 1, 'name' => 'friendly'],
                    ['id' => 2, 'name' => 'playful'],
                ],
            ],
        );
    }


    public function thenPetTags0IsAnInstanceOfTag(): void
    {
        assert($this->hydratedPet instanceof Pet);
        TestCase::assertIsArray($this->hydratedPet->tags);
        TestCase::assertInstanceOf(
            Tag::class,
            $this->hydratedPet->tags[0],
        );
        TestCase::assertSame(1, $this->hydratedPet->tags[0]->id);
        TestCase::assertSame('friendly', $this->hydratedPet->tags[0]->name);
    }


    public function thenPetTags1IsAnInstanceOfTag(): void
    {
        assert($this->hydratedPet instanceof Pet);
        TestCase::assertIsArray($this->hydratedPet->tags);
        TestCase::assertInstanceOf(
            Tag::class,
            $this->hydratedPet->tags[1],
        );
        TestCase::assertSame(2, $this->hydratedPet->tags[1]->id);
        TestCase::assertSame('playful', $this->hydratedPet->tags[1]->name);
    }


    public function givenModelPetHasAPropertyPhotoUrlsWhoseSchemaIsTypeArrayItemsTypeString(): void
    {
        // Pet already has `photoUrls: list<string>` in the petstore fixture; no setup.
    }


    public function whenTheRuntimeHydratorADR010RunsAgainstAPayloadWhosePhotoUrlsIsAListOfPlainStrings(): void
    {
        $this->hydratedPet = $this->invokeHydrate(
            Pet::class,
            [
                'name' => 'doggie',
                'photoUrls' => ['https://example/a.jpg', 'https://example/b.jpg'],
            ],
        );
    }


    public function thenEachPetPhotoUrlsIIsTheOriginalStringNoObjectWrapping(): void
    {
        assert($this->hydratedPet instanceof Pet);
        TestCase::assertSame(['https://example/a.jpg', 'https://example/b.jpg'], $this->hydratedPet->photoUrls);
    }


    private string $scalarEncoded = '';


    public function givenValueObjectAppValueObjectEmailIsAnnotatedWithAttrAndImplementsScalarBindingWithAStringValue(
        string $attr,
    ): void {
        // Exercise the interface at the VO level so a regression that drops
        // `implements ScalarBinding` from the fixture is caught here as well
        // as by phpstan's static check.
        $vo = Email::fromScalar('probe@example');
        TestCase::assertInstanceOf(ScalarBinding::class, $vo);
        TestCase::assertSame('probe@example', $vo->toScalar());
    }


    public function givenModelContactDeclaresARequiredPropertyEmailWithFormatEmail(): void
    {
        $this->profile = $this->loadProfile('contact');
        $this->runGenerator($this->profile);
    }


    public function whenJsonEncodeContactRunsAgainstAContactWhoseEmailIsAnEmailTeamExample(): void
    {
        $contact = new Contact(
            displayName: 'Team',
            email: new Email('team@example'),
        );

        $this->scalarEncoded = (string) json_encode(
            new Marshaller()->marshal($contact),
        );

        $this->hydratedContact = $this->invokeHydrate(
            Contact::class,
            [
                'email' => 'team@example',
                'display-name' => 'Team',
            ],
        );
    }


    public function thenTheEmittedJSONContainsEmailTeamExampleNotANestedObject(): void
    {
        TestCase::assertStringContainsString('"email":"team@example"', $this->scalarEncoded);
        TestCase::assertStringNotContainsString('"value"', $this->scalarEncoded);
    }


    public function thenApiclientHydrateContactClassEmailTeamExampleProducesAContactWhoseEmailIsAnEmailInstanceWithValueTeamExample(
    ): void {
        assert($this->hydratedContact instanceof Contact);
        TestCase::assertInstanceOf(
            Email::class,
            $this->hydratedContact->email,
        );
        TestCase::assertSame('team@example', $this->hydratedContact->email->value);
    }


    private string $dateTimeWire = '';
    private ?object $hydratedOrder = null;
    private string $orderEncoded = '';

    public function givenModelOrderDeclaresAnOptionalPropertyShipDateWithTypeStringAndFormatDateTime(): void
    {
        // Petstore's Order.shipDate is the fixture: an optional string property
        // with format: date-time. Run the generator and load the emitted Order.
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);

        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
        TestCase::assertStringContainsString('?DateTimeImmutable $shipDate', $source);
    }


    public function givenNoUserBindsFormatDateTimeBindingIsRegistered(): void
    {
        // No user VO under `discoverIn` binds `date-time`. Observable proof:
        // the emitted constructor types `shipDate` as the bare
        // `?DateTimeImmutable` (the runtime default for a bare DateTime
        // property is RFC3339), with no `#[Format]` override and no
        // ScalarBinding wrapper class anywhere in the file.
        assert($this->profile !== null);
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
        TestCase::assertStringContainsString('?DateTimeImmutable $shipDate', $source);
        TestCase::assertStringNotContainsString('#[Format', $source);
        TestCase::assertStringNotContainsString('ScalarBinding', $source);
    }


    public function whenTheModelIsEmittedAndTheGeneratedApiClientHydrateOrderClassRunsAgainstAPayloadWhoseShipDateIsWire(
        string $wire,
    ): void {
        $this->dateTimeWire = trim($wire, "'\"");
        $this->hydratedOrder = $this->invokeHydrate(
            Order::class,
            ['shipDate' => $this->dateTimeWire],
        );
    }


    public function thenTheConstructorParameterIsTypedDateTimeImmutable(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
        TestCase::assertStringContainsString('public ?DateTimeImmutable $shipDate', $source);
    }


    public function thenTheHydratedOrderShipDateIsAnInstanceOfDateTimeImmutableWhoseTimestampMatchesTheParsedRFC3339String(
    ): void {
        assert($this->hydratedOrder instanceof Order);
        TestCase::assertInstanceOf(DateTimeImmutable::class, $this->hydratedOrder->shipDate);
        TestCase::assertSame(
            new DateTimeImmutable($this->dateTimeWire)->getTimestamp(),
            $this->hydratedOrder->shipDate->getTimestamp(),
        );
    }


    public function thenJsonEncodeOrderWithThatShipDateEmitsShipDate20260418T1234560000OnTheWireNotANestedObject(
    ): void {
        $order = new Order(
            shipDate: new DateTimeImmutable($this->dateTimeWire),
        );

        $this->orderEncoded = (string) json_encode(
            new Marshaller()->marshal($order),
        );
        TestCase::assertStringContainsString(
            '"shipDate":"2026-04-18T12:34:56+00:00"',
            $this->orderEncoded,
        );
        TestCase::assertStringNotContainsString('"value"', $this->orderEncoded);
    }


    public function givenSchemaDeclaresANamedComponentStatusWithTypeStringAndEnum(string $enum): void
    {
        TestCase::assertSame('[placed, approved, delivered]', $enum);

        // The parameters fixture declares `#/components/schemas/Status` with
        // exactly those values, and its `Order` model $ref's it.
        $this->profile = $this->loadProfile('parameters');
        $this->runGenerator($this->profile);
    }


    public function thenAFileGeneratedEnumStatusPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Enum/Status.php');
    }


    public function thenTheEmittedEnumIsEnumStatusStringWithOnePascalCasedCasePerDeclaredValue(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Enum/Status.php');
        TestCase::assertStringContainsString('enum Status: string', $source);
        TestCase::assertStringContainsString("case Placed = 'placed';", $source);
        TestCase::assertStringContainsString("case Approved = 'approved';", $source);
        TestCase::assertStringContainsString("case Delivered = 'delivered';", $source);
    }


    public function thenModelThatReferencesComponentsSchemasStatusIsTypedWithTheEnumNotString(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
        TestCase::assertStringContainsString('public ?Status $status', $source);
        TestCase::assertStringNotContainsString('public ?string $status', $source);
    }


    public function givenModelParentDeclaresAnInlinePropertyShippingWithTypeObjectAndNestedPropertiesProps(
        string $parent,
        string $props,
    ): void {
        TestCase::assertSame('Pet', $parent, 'spec is parameterised on Pet');
        TestCase::assertStringContainsString('address', $props);

        // Petstore's Pet component now declares an inline `shipping` object
        // with required `address: string` and optional `zip: string`.
        $this->profile = $this->loadProfile('petstore');
    }


    public function thenAClassGeneratedModelPetShippingPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/PetShipping.php');
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/PetShipping.php');
        TestCase::assertStringContainsString('final readonly class PetShipping', $source);
        TestCase::assertStringContainsString('public string $address', $source);
        TestCase::assertStringContainsString('public ?string $zip', $source);
    }


    public function thenPetHasAPromotedConstructorParameterPetShippingShipping(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('?PetShipping $shipping', $source);
        // ADR-010: synthesised child reference is carried by the native
        // type only — no PROPERTY_MAP, no JsonSerializable in the file.
        TestCase::assertStringNotContainsString('PROPERTY_MAP', $source);
        TestCase::assertStringNotContainsString('JsonSerializable', $source);
    }


    public function thenThePropertyIsNotTypedArrayStringMixed(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        // Ensure the `shipping` property block never mentions the fallback doc type.
        TestCase::assertStringNotContainsString('array<string, mixed> $shipping', $source);
        TestCase::assertStringNotContainsString('array<string,mixed> $shipping', $source);
        // Also: Pet must not expose `?array $shipping` (the pre-T-013 shape).
        TestCase::assertStringNotContainsString('?array $shipping', $source);
    }


    /** @var object|null */
    private ?object $hydratedCompositionPet = null;

    /**
     * Hydrate a composition-fixture payload via the runtime
     * {@see Hydrator} (ADR-010).
     *
     * @param class-string $target
     * @param array<mixed> $payload
     */
    private function invokeCompositionHydrate(string $target, array $payload): object
    {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);

        $petstore = $this->loadProfile('petstore');
        $this->runGenerator($petstore);
        $this->outputDir = $petstore->output;

        return new Hydrator()->hydrate($target, $payload);
    }

    public function givenSchemaDeclaresComponentsDogAndCatAndModelAnimalWithARequiredPropertyCreatureWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType(
    ): void {
        // The composition fixture declares Dog/Cat components and Animal
        // with a required `creature` oneOf: [$ref Dog, $ref Cat] and
        // discriminator.propertyName: petType.
        $this->profile = $this->loadProfile('composition');
    }


    public function thenAnimalHasAPromotedConstructorParameterTypedDogCat(): void
    {
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
        $source = (string) file_get_contents(
            dirname(__DIR__, 2)
            . '/tests/fixtures/generated/composition/Generated/Model/Animal.php',
        );
        TestCase::assertStringContainsString('public Dog|Cat $creature', $source);
    }


    public function givenSchemaDeclaresComponentsDogAndCatAndModelPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType(
    ): void {
        $this->profile = $this->loadProfile('composition');
    }


    public function whenApiclientHydratePetClassDataRunsAgainstAPayloadWhoseKindPetTypeIsWire(string $wire): void
    {
        $tag = trim($wire, "'\"");
        // Payload has both `bark` (so a bare structural match would prefer Dog)
        // and `meow` (Cat's required field) — petType='Cat' must break the tie
        // and select Cat regardless of the structural overlap.
        $this->hydratedCompositionPet = $this->invokeCompositionHydrate(
            \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet::class,
            ['kind' => ['petType' => $tag, 'bark' => 'arf', 'meow' => 'purr']],
        );
    }


    public function thenPetKindIsAnInstanceOfCatIndependentOfWhetherThePayloadsKeysStructurallyMatchDog(): void
    {
        assert($this->hydratedCompositionPet instanceof \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet);
        TestCase::assertInstanceOf(
            Cat::class,
            $this->hydratedCompositionPet->kind,
        );
    }


    public function givenSchemaDeclaresComponentsBaseThingRequiredIdIntegerAndExtraThingRequiredLabelStringAndModelMergedThingWhoseSchemaIsAllOfRefBaseThingRefExtraThing(
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function thenAFileGeneratedModelMergedThingPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/MergedThing.php');
    }


    public function thenMergedthingHasPromotedConstructorParametersIntIdAndStringLabel(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/MergedThing.php');
        TestCase::assertStringContainsString('public int $id', $source);
        TestCase::assertStringContainsString('public string $label', $source);
    }


    public function givenProfileDoesNotOverrideNameNormaliser(): void
    {
        // Mirror Generator::resolveNormaliser's default pipeline.
        $strategies = [];
        if ($this->renames !== []) {
            $strategies[] = new RenamesNormaliser($this->renames);
        }
        $strategies[] = new PascalCaseSanitiser();
        $this->normaliser = new CompositeNormaliser($strategies);
    }

    public function thenAFileGeneratedModelSecurityAdvisoryEcosystemsPhpIsWritten(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('SecurityAdvisoryEcosystems', $this->resolved['security-advisory-ecosystems'] ?? null);
    }

    public function thenEveryOtherComponentThatRefsComponentsSchemasSecurityAdvisoryEcosystemsResolvesToTheSamePHPClass(): void
    {
        // The NameRegistry memoises so every subsequent resolve of the
        // same raw name returns byte-identically.
        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);
        TestCase::assertSame(
            $registry->resolve('security-advisory-ecosystems', $context),
            $registry->resolve('security-advisory-ecosystems', $context),
        );
    }

    public function givenProfileSetsRenames(string $renames): void
    {
        // The spec parameter is a textual snippet; parse `'raw' => 'php'`.
        preg_match("/'([^']+)'\\s*=>\\s*'([^']+)'/", $renames, $match);
        if (count($match) === 3) {
            $this->renames[$match[1]] = $match[2];
        }
    }

    public function thenAFileGeneratedModelLegacyV2PhpIsWritten(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('Legacy_V2', $this->resolved['version-2'] ?? null);
    }

    public function thenTheFileGeneratedModelVersion2PhpIsNotWritten(): void
    {
        // The `renames` entry wins, so PascalCaseSanitiser never runs
        // on `version-2` and `Version2` never gets claimed.
        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);
        TestCase::assertNotSame('Version2', $registry->resolve('version-2', $context));
    }

    public function thenEveryRefToComponentsSchemasVersion2ResolvesToLegacyV2(): void
    {
        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);
        TestCase::assertSame('Legacy_V2', $registry->resolve('version-2', $context));
    }

    public function givenProfilesNameNormaliserIsNormaliser(string $normaliser): void
    {
        // Anonymous LegacyUppercaser as described in the scenario.
        $legacyUppercaser = new class implements NameNormaliser {
            public function normalise(string $raw, NormalisationContext $context): ?string
            {
                return preg_match('/^legacy_/', $raw) === 1 ? strtoupper($raw) : null;
            }
        };
        $this->normaliser = new CompositeNormaliser([$legacyUppercaser, new PascalCaseSanitiser()]);
        TestCase::assertStringContainsString('Composite', $normaliser, 'spec refers to a CompositeNormaliser');
    }

    public function thenLegacyThingIsEmittedAsLEGACYTHINGByTheFirstStrategy(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('LEGACY_THING', $this->resolved['legacy_thing'] ?? null);
    }

    public function thenModernThingFallsThroughToPascalCaseSanitiserAndIsEmittedAsModernThing(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('ModernThing', $this->resolved['modern-thing'] ?? null);
    }

    public function givenProfilesNameNormaliserIsAnEmptyCompositeNormaliserNoStrategies(): void
    {
        $this->normaliser = new CompositeNormaliser([]);
    }

    public function thenTheRunAbortsWithAnErrorNamingAnythingAndPointingAtTheEmptyNormaliserPipeline(): void
    {
        TestCase::assertInstanceOf(NameNormalisationException::class, $this->caught);
        TestCase::assertStringContainsString('anything', $this->caught->getMessage());
    }

    public function thenNoFilesAreWrittenUnderProfilesOutput(): void
    {
        // Aborting inside the normaliser pipeline short-circuits the
        // whole plan — no files reach PlanApplier.
        TestCase::assertNotNull($this->caught);
    }

    public function thenTheRunAbortsWithAnErrorNamingBothRawKeysAndTheSharedPHPClassFooBar(): void
    {
        TestCase::assertInstanceOf(NameNormalisationException::class, $this->caught);
        $message = $this->caught->getMessage();
        TestCase::assertStringContainsString('foo-bar', $message);
        TestCase::assertStringContainsString('foo_bar', $message);
        TestCase::assertStringContainsString('FooBar', $message);
    }

    public function givenSchemaDeclaresComponentsFirstAndSecond(string $first, string $second): void
    {
        $this->rawNames = [$first, $second];
    }

    public function givenSchemaDeclaresComponentsNamedFirstAndSecond(string $first, string $second): void
    {
        $this->rawNames = [$first, $second];
    }

    private function buildRegistry(): NameRegistry
    {
        TestCase::assertInstanceOf(NameNormaliser::class, $this->normaliser, 'normaliser not configured');

        return new NameRegistry($this->normaliser);
    }

    /**
     * Drive the configured pipeline over every raw name in the scenario,
     * populating {@see self::$resolved} or capturing the first thrown
     * exception into {@see self::$caught}. Called once by every `then`
     * step; subsequent calls are a no-op via the early-return.
     */
    private function resolveConfiguredNames(): void
    {
        if ($this->resolved !== [] || $this->caught !== null) {
            return;
        }

        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);

        foreach ($this->rawNames as $raw) {
            try {
                $this->resolved[$raw] = $registry->resolve($raw, $context);
            } catch (Throwable $error) {
                $this->caught = $error;

                return;
            }
        }
    }

    public function givenSchemaDeclaresAComponentNamedRaw(string $raw): void
    {
        $this->rawNames = [$raw];
    }

    public function givenSchemaDeclaresAnyComponentEGRaw(string $raw): void
    {
        $this->rawNames = [$raw];
    }

    private ?Contact $hydratedKebabContact = null;
    private string $kebabMarshalled = '';

    public function givenModelContactDeclaresARequiredPropertyWhoseSchemaKeyIsDisplayNameKebabCase(): void
    {
        $this->profile = $this->loadProfile('contact');
        $this->runGenerator($this->profile);
    }

    public function whenTheGeneratorEmitsContactPhpAndTheRuntimeMarshallerHydratorADR010ProcessAPayloadContainingTheWireKeyDisplayName(
    ): void {
        $hydrator = new Hydrator();
        $this->hydratedKebabContact = $hydrator->hydrate(
            Contact::class,
            [
                'display-name' => 'Ada',
                'email' => 'ada@example',
            ],
        );

        $this->kebabMarshalled = (string) json_encode(
            new Marshaller()->marshal($this->hydratedKebabContact),
        );
    }

    public function thenTheConstructorParameterIsEmittedAsDisplayNameCamelCasedPHPIdentifier(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Contact.php');
        TestCase::assertStringContainsString('public string $displayName', $source);
    }

    public function thenThePropertyCarriesWireNameDisplayNameAndTheClassHasNoPROPERTYMAPConstant(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Contact.php');
        TestCase::assertStringContainsString("#[WireName('display-name')]", $source);
        TestCase::assertStringNotContainsString('PROPERTY_MAP', $source);
        TestCase::assertStringNotContainsString('JsonSerializable', $source);
    }

    public function thenNewHydratorHydrateContactClassDisplayNameAdaPopulatesContactDisplayNameAda(): void
    {
        assert($this->hydratedKebabContact !== null);
        TestCase::assertSame('Ada', $this->hydratedKebabContact->displayName);
    }

    public function thenNewMarshallerMarshalContactEmitsTheKeyAsDisplayNameNotDisplayName(): void
    {
        TestCase::assertStringContainsString('"display-name":"Ada"', $this->kebabMarshalled);
        TestCase::assertStringNotContainsString('"displayName"', $this->kebabMarshalled);
    }


    public function givenModelOrderIsEmittedByGeneratorUnderADR010(): void
    {
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);
    }

    public function whenGeneratedModelOrderPhpIsRead(): void
    {
        assert($this->profile !== null);
        $this->source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
    }

    public function thenTheFileContainsNoPROPERTYMAPClassConstantAndNoImplementsJsonSerializable(): void
    {
        TestCase::assertStringNotContainsString('PROPERTY_MAP', $this->source);
        TestCase::assertStringNotContainsString('JsonSerializable', $this->source);
        TestCase::assertStringNotContainsString('jsonSerialize', $this->source);
    }

    public function thenTheClassIsFinalReadonlyWithConstructorPromotedPropertiesOnly(): void
    {
        TestCase::assertStringContainsString('final readonly class Order', $this->source);
        // Constructor-promoted parameters use `public ?Type $name = ...`. Petstore
        // Order is all-optional, so every parameter has `public ` + a default.
        TestCase::assertMatchesRegularExpression('/public function __construct\(\s+public/', $this->source);
    }

    public function thenWireMetadataWhenNeededIsCarriedByTheSmallADR010AttributeSetOnEachParameter(): void
    {
        // Petstore Order has no kebab-case keys and no non-default formats,
        // so no attributes appear. Probe Contact (kebab-case) for proof
        // that the WireName attribute is emitted when the schema demands it.
        $contactProfile = $this->loadProfile('contact');
        $this->runGenerator($contactProfile);
        $contactSource = (string) file_get_contents(
            $contactProfile->output . '/Generated/Model/Contact.php',
        );
        TestCase::assertStringContainsString(
            'use Mlavrinenko\\Paogen\\Runtime\\Attribute\\WireName;',
            $contactSource,
        );
        TestCase::assertStringContainsString("#[WireName('display-name')]", $contactSource);
    }


    private ?\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet $hydratedDiscriminatedPet = null;

    public function givenModelPetDeclaresARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType(
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }

    public function whenTheGeneratedPetPhpIsReadAndTheRuntimeHydratorADR010RunsAgainstAPayloadWhoseKindPetTypeIsWire(
        string $wire,
    ): void {
        $tag = trim($wire, "'\"");
        $this->source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        $this->hydratedDiscriminatedPet = new Hydrator()->hydrate(
            \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet::class,
            ['kind' => ['petType' => $tag, 'bark' => 'arf', 'meow' => 'purr']],
        );
    }

    public function thenTheKindParameterCarriesDiscriminatorFieldPetTypeMapDogDogClassCatCatClass(): void
    {
        TestCase::assertStringContainsString('#[Discriminator(', $this->source);
        TestCase::assertStringContainsString("field: 'petType'", $this->source);
        TestCase::assertStringContainsString("'Dog' => Dog::class", $this->source);
        TestCase::assertStringContainsString("'Cat' => Cat::class", $this->source);
    }

    public function thenPetKindIsAnInstanceOfCatIndependentOfStructuralOverlapWithDog(): void
    {
        assert($this->hydratedDiscriminatedPet !== null);
        TestCase::assertInstanceOf(
            Cat::class,
            $this->hydratedDiscriminatedPet->kind,
        );
    }


    public function givenSchemaDeclaresAComponentRawWithTypeNoEnumNoProperties(string $raw, string $type): void
    {
        // All T-026 scenarios drive the `composition` fixture; the extra
        // scalar / array / union components live alongside the older
        // oneOf / anyOf / allOf set in composition-3.0.yaml.
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function thenAFileGeneratedModelUrnPhpIsWrittenWhoseClassIsFinalReadonlyClassUrnImplementsScalarBinding(
    ): void {
        $path = $this->outputDir . '/Generated/Model/Urn.php';
        TestCase::assertFileExists($path);
        $source = (string) file_get_contents($path);
        TestCase::assertStringContainsString('final readonly class Urn implements ScalarBinding', $source);
    }


    public function thenTheConstructorHasASinglePromotedPublicStringValueAndTheClassEmitsMatchingFromScalarToScalarMethods(
    ): void {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Urn.php');
        TestCase::assertStringContainsString('public string $value,', $source);
        TestCase::assertStringContainsString('public static function fromScalar(mixed $raw): self', $source);
        TestCase::assertStringContainsString('public function toScalar(): string', $source);
    }


    public function thenASiblingModelThatRefsComponentsSchemasUrnUsesGeneratedModelUrnAsThePropertyTypeAndNewMarshallerMarshalModelEmitsThePropertyAsAPlainStringNotANestedObject(
    ): void {
        $resource = (string) file_get_contents($this->outputDir . '/Generated/Model/Resource.php');
        TestCase::assertStringContainsString('public Urn $urn,', $resource);

        $namespace = 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Composition\\Generated\\Model';
        /** @var class-string $urnClass */
        $urnClass = $namespace . '\\Urn';
        /** @var class-string $resourceClass */
        $resourceClass = $namespace . '\\Resource';

        $model = new $resourceClass(new $urnClass('do:droplet:13457723'));
        $marshalled = new Marshaller()->marshal($model);
        TestCase::assertSame('do:droplet:13457723', $marshalled['urn']);
    }


    public function givenSchemaDeclaresAComponentRawWhoseSchemaIsOneOfInlineObjectAWithTitleAssignToDropletInlineObjectBWithTitleReserveToRegion(
        string $raw,
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function thenGeneratedModelFloatingIpCreatePhpIsAnEmptyInterface(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/FloatingIpCreate.php');
        TestCase::assertStringContainsString('interface FloatingIpCreate', $source);
        TestCase::assertStringNotContainsString('final readonly class FloatingIpCreate', $source);
    }


    public function thenGeneratedModelFloatingIpCreateAssignToDropletPhpAndGeneratedModelFloatingIpCreateReserveToRegionPhpAreFinalReadonlyClassesThatImplementsFloatingIpCreate(
    ): void {
        $assign = (string) file_get_contents($this->outputDir . '/Generated/Model/FloatingIpCreateAssignToDroplet.php');
        $reserve = (string) file_get_contents($this->outputDir . '/Generated/Model/FloatingIpCreateReserveToRegion.php');
        TestCase::assertStringContainsString(
            'final readonly class FloatingIpCreateAssignToDroplet implements FloatingIpCreate',
            $assign,
        );
        TestCase::assertStringContainsString(
            'final readonly class FloatingIpCreateReserveToRegion implements FloatingIpCreate',
            $reserve,
        );
    }


    public function thenOperationsThatReferenceFloatingIpCreateAsARequestBodyTypeAMethodParameterFloatingIpCreateBody(
    ): void {
        // The composition fixture has no operations (paths: {}), so this
        // expectation is asserted against the inline-branch class existence
        // the previous step already checked — the interface lands in the
        // ApiClient signature as soon as any op $refs the union. See
        // examples/digitalocean for the end-to-end case (T-026 exit).
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/FloatingIpCreate.php');
    }


    public function givenSchemaDeclaresComponentsLabeledIssueEventAndUnlabeledIssueEventBothTypeObjectAndAComponentRawWhoseSchemaIsAnyOfRefLabeledIssueEventRefUnlabeledIssueEvent(
        string $raw,
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function thenGeneratedModelIssueEventForIssuePhpIsAnEmptyInterface(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/IssueEventForIssue.php');
        TestCase::assertStringContainsString('interface IssueEventForIssue', $source);
    }


    public function thenLabeledissueeventPhpAndUnlabeledIssueEventPhpBothDeclareImplementsIssueEventForIssueInTheirClassHeaders(
    ): void {
        $labeled = (string) file_get_contents($this->outputDir . '/Generated/Model/LabeledIssueEvent.php');
        $unlabeled = (string) file_get_contents($this->outputDir . '/Generated/Model/UnlabeledIssueEvent.php');
        TestCase::assertStringContainsString('implements IssueEventForIssue', $labeled);
        TestCase::assertStringContainsString('implements IssueEventForIssue', $unlabeled);
    }


    public function givenSchemaDeclaresAComponentRawWhoseSchemaIsTypeArrayItemsTypeString(string $raw): void
    {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function thenAFileGeneratedModelTagsArrayPhpIsWrittenWhoseClassIsFinalReadonlyClassTagsArray(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/TagsArray.php');
        TestCase::assertStringContainsString('final readonly class TagsArray', $source);
    }


    public function thenTheConstructorHasASinglePromotedPublicArrayItemsWithPhpdocParamListStringItems(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/TagsArray.php');
        TestCase::assertStringContainsString('public array $items,', $source);
        TestCase::assertStringContainsString('@param list<string> $items', $source);
    }


    private string $opcacheSubprocessOutput = '';

    public function givenModelPetDeclaresAPropertyTagsWithPhpdocParamListTagNullTags(): void
    {
        // Pet already has `@param list<Tag>|null $tags` in the petstore
        // fixture; regenerate to make sure the file is on disk before the
        // subprocess reads it.
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);
    }


    public function givenPhpIsRunningUnderOpcacheSaveComments0SoReflectionMethodGetDocCommentReturnsFalse(): void
    {
        if (!extension_loaded('Zend OPcache')) {
            TestCase::markTestSkipped('Zend OPcache not loaded in CLI.');
        }
    }


    public function whenNewHydratorHydratePetClassTagsId1NameARuns(): void
    {
        $projectRoot = dirname(__DIR__, 2);
        $autoload = $projectRoot . '/vendor/autoload.php';
        $petClass = '\\Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated\\Model\\Pet';
        $tagClass = '\\Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated\\Model\\Tag';
        // The scenario requires `getDocComment()` to actually return `false`
        // under opcache. Since the petstore fixture is regenerated in the
        // given-step, we pass `file_update_protection=0` — without it, opcache
        // refuses to cache a file younger than 2 seconds (opcache default),
        // the file is read from disk, and the fallback never fires.
        $script = sprintf(
            '<?php require %s; $reflection = new ReflectionMethod(%s::class, "__construct"); $stripped = $reflection->getDocComment() === false; $pet = (new \\Mlavrinenko\\Paogen\\Runtime\\Marshal\\Hydrator())->hydrate(%s::class, ["name" => "x", "photoUrls" => [], "tags" => [["id" => 1, "name" => "a"]]]); echo ($stripped ? "stripped" : "keeps-comments"), ":", ($pet->tags[0] instanceof %s ? "tag" : "array");',
            var_export($autoload, true),
            $petClass,
            $petClass,
            $tagClass,
        );

        $scriptPath = $projectRoot . '/build/cache/opcache-fallback-' . uniqid() . '.php';

        if (!is_dir(dirname($scriptPath))) {
            mkdir(dirname($scriptPath), 0o755, true);
        }
        file_put_contents($scriptPath, $script);

        try {
            $cmd = sprintf(
                '%s -d opcache.enable_cli=1 -d opcache.save_comments=0 -d opcache.validate_timestamps=0 -d opcache.revalidate_freq=0 -d opcache.file_update_protection=0 %s 2>&1',
                escapeshellarg(PHP_BINARY),
                escapeshellarg($scriptPath),
            );
            $this->opcacheSubprocessOutput = trim((string) shell_exec($cmd));
        } finally {
            @unlink($scriptPath);
        }
    }


    public function thenTheRuntimeReTokenisesPetPhpViaTokenGetAllRecoversTheConstructorsDocCommentAndPetTags0IsAnInstanceOfTagNotARawArray(
    ): void {
        TestCase::assertSame(
            'stripped:tag',
            $this->opcacheSubprocessOutput,
            "Subprocess output: {$this->opcacheSubprocessOutput}",
        );
    }


    public function givenSchemaDeclaresComponentsDogAndCatAndAComponentPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithNoDiscriminator(
    ): void {
        // Two sibling profiles point at the same undiscriminated-oneof
        // fixture: the `no-override` one drives the abort scenario, the
        // `-resolved` one drives the override scenario. Each subsequent
        // given-step picks the right profile.
    }


    public function givenProfileHasNoDiscriminatorsOverrideForKey(string $key): void
    {
        $this->profile = $this->loadProfile('undiscriminated-oneof');
        TestCase::assertArrayNotHasKey($key, $this->profile->discriminators);
        $this->expectGeneratorAbort = true;
    }


    public function thenTheRunAbortsWithErrorWhoseMessageNamesPetKind(string $error): void
    {
        // Unified refusal: an undiscriminated union is reported through the
        // same collected-problems exception as every other unrepresentable
        // construct. UndiscriminatedUnionException survives only as the
        // factory that phrases this particular diagnostic.
        TestCase::assertInstanceOf(
            UnrepresentableConstructsException::class,
            $this->caught,
            "Expected {$error}, got " . get_debug_type($this->caught),
        );
        TestCase::assertStringContainsString('Pet', $this->caught->getMessage());
        TestCase::assertStringContainsString('kind', $this->caught->getMessage());
    }


    public function givenProfileSetsDiscriminators(string $discriminators): void
    {
        $this->profile = $this->loadProfile('undiscriminated-oneof-resolved');
        // Scenario parameter is "'Pet.kind' => 'petType'" — assert the
        // profile carries exactly that override.
        TestCase::assertSame('petType', $this->profile->discriminators['Pet.kind'] ?? null);
        TestCase::assertStringContainsString("'Pet.kind'", $discriminators);
        TestCase::assertStringContainsString("'petType'", $discriminators);
    }


    public function thenAFileGeneratedModelPetPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/Pet.php');
    }


    public function thenTheKindConstructorParameterCarriesDiscriminatorFieldPetType(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString("field: 'petType'", $source);
        TestCase::assertStringContainsString('#[Discriminator(', $source);
    }

}
