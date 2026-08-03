<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Composer\Autoload\ClassLoader;
use DateTimeImmutable;
use FilesystemIterator;
use Mlavrinenko\Paogen\Exception\ModelNameCollisionException;
use Mlavrinenko\Paogen\Exception\NameNormalisationException;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Emit\SkippedOperation;
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
use Mlavrinenko\Paogen\Tests\Support\PetstoreFixture;
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

    public function givenModelWithRequiredPropAndOptionalProp(string $required, string $optional): void
    {
        // Use Pet from petstore (required: name+photoUrls; optional: id, etc.).
        $this->profile = $this->loadProfile('petstore');
        TestCase::assertNotEmpty($required);
        TestCase::assertNotEmpty($optional);
    }

    public function givenModelParentHasARequiredPropertyPetThatRefTarget(string $parent, string $ref, string $target): void
    {
        $this->profile = $this->loadProfile('petstore');
        TestCase::assertStringContainsString('$ref', $ref);
    }

    public function givenValueObjectAppValueObjectEmailIsAnnotatedWithAttr(string $attr): void
    {
        $this->profile = $this->loadProfile('contact');
    }

    public function givenModelHasARequiredPropertyContactStringWithFormatEmail(): void
    {
        // Same fixture, no extra setup.
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

    // ---- inline-body-and-response-schemas ------------------------------
    //
    // These scenarios run against documents whose payloads are declared at
    // the use site, so there is no committed golden tree to read: each one
    // generates into a scratch directory and asserts on what landed there.

    /** Scratch output directory for the inline-payload scenarios. */
    private string $inlineOutputDir = '';

    /**
     * A profile over one of the inline-payload fixtures, writing to a scratch
     * tree so the run cannot disturb a committed fixture.
     *
     * @param array<string,string> $inlineModels
     */
    private function inlinePayloadProfile(string $schema, array $inlineModels = []): Profile
    {
        $this->inlineOutputDir = $this->makeScratchOutputDir('paogen-inline-');
        $this->outputDir = $this->inlineOutputDir;

        return new Profile(
            schema: dirname(__DIR__, 2) . '/tests/fixtures/schemas/' . $schema,
            output: $this->inlineOutputDir,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlineSteps',
            inlineModels: $inlineModels,
        );
    }

    /**
     * The emitted root client. The inline-payload fixtures carry no tags, so
     * every operation lands on `ApiClient` itself.
     */
    private function inlineClientSource(): string
    {
        $path = $this->inlineOutputDir . '/Generated/ApiClient.php';
        TestCase::assertFileExists($path);

        return (string) file_get_contents($path);
    }

    /**
     * The operation ids the plan reports as skipped.
     *
     * Asked of the planner rather than inferred from the emitted tree: a skip
     * is a thing the run reports, and an operation missing for some other
     * reason would leave an identical hole on disk.
     *
     * @return list<string>
     */
    private function inlineSkippedOperationIds(): array
    {
        TestCase::assertNotNull($this->profile);

        $plan = new Generator(new AttributeScanner($this->composerLoader()))->plan($this->profile);

        return array_map(
            static fn(SkippedOperation $skipped): string => $skipped->operationId,
            $plan->skippedOperations,
        );
    }

    private function makeScratchOutputDir(string $prefix): string
    {
        $base = (string) tempnam(sys_get_temp_dir(), $prefix);
        unlink($base);
        assert(mkdir($base, 0o755, true));

        return $base;
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
            // No skip list: petstore's octet-stream upload became
            // representable in represent-non-json-request-and-response-bodies,
            // and an entry accepting it would now fail the run as stale.
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
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


    /** @var object|null */
    private ?object $hydratedPet = null;
    /** @var object|null */
    private ?object $hydratedContact = null;

    /**
     * Hydrate a payload into the supplied class via the runtime
     * {@see Hydrator}. Per `attribute-and-phpdoc-driven-serialization`
     * this is a free function — the generated `ApiClient` no longer carries
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


    public function givenModelPetHasAPropertyPhotoUrlsWhoseSchemaIsTypeArrayItemsTypeString(): void
    {
        // Pet already has `photoUrls: list<string>` in the petstore fixture; no setup.
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


    public function givenSchemaDeclaresANamedComponentStatusWithTypeStringAndEnum(string $enum): void
    {
        TestCase::assertSame('[placed, approved, delivered]', $enum);

        // The parameters fixture declares `#/components/schemas/Status` with
        // exactly those values, and its `Order` model $ref's it.
        $this->profile = $this->loadProfile('parameters');
        $this->runGenerator($this->profile);
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


    /** @var object|null */
    private ?object $hydratedCompositionPet = null;

    /**
     * Hydrate a composition-fixture payload via the runtime
     * {@see Hydrator} (`attribute-and-phpdoc-driven-serialization`).
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


    public function givenSchemaDeclaresComponentsDogAndCatAndModelPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType(
    ): void {
        $this->profile = $this->loadProfile('composition');
    }


    public function givenSchemaDeclaresComponentsBaseThingRequiredIdIntegerAndExtraThingRequiredLabelStringAndModelMergedThingWhoseSchemaIsAllOfRefBaseThingRefExtraThing(
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
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

    public function givenProfileSetsRenames(string $renames): void
    {
        // The spec parameter is a textual snippet; parse `'raw' => 'php'`.
        preg_match("/'([^']+)'\\s*=>\\s*'([^']+)'/", $renames, $match);
        if (count($match) === 3) {
            $this->renames[$match[1]] = $match[2];
        }
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

    public function givenProfilesNameNormaliserIsAnEmptyCompositeNormaliserNoStrategies(): void
    {
        $this->normaliser = new CompositeNormaliser([]);
    }

    public function thenNoFilesAreWrittenUnderProfilesOutput(): void
    {
        // Aborting inside the normaliser pipeline short-circuits the
        // whole plan — no files reach PlanApplier.
        TestCase::assertNotNull($this->caught);
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

    private ?\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet $hydratedDiscriminatedPet = null;

    public function givenModelPetDeclaresARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType(
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }

    public function givenSchemaDeclaresAComponentRawWithTypeNoEnumNoProperties(string $raw, string $type): void
    {
        // All T-026 scenarios drive the `composition` fixture; the extra
        // scalar / array / union components live alongside the older
        // oneOf / anyOf / allOf set in composition-3.0.yaml.
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function givenSchemaDeclaresAComponentRawWhoseSchemaIsOneOfInlineObjectAWithTitleAssignToDropletInlineObjectBWithTitleReserveToRegion(
        string $raw,
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function givenSchemaDeclaresComponentsLabeledIssueEventAndUnlabeledIssueEventBothTypeObjectAndAComponentRawWhoseSchemaIsAnyOfRefLabeledIssueEventRefUnlabeledIssueEvent(
        string $raw,
    ): void {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
    }


    public function givenSchemaDeclaresAComponentRawWhoseSchemaIsTypeArrayItemsTypeString(string $raw): void
    {
        $this->profile = $this->loadProfile('composition');
        $this->runGenerator($this->profile);
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


    public function givenProfileSetsDiscriminators(string $discriminators): void
    {
        $this->profile = $this->loadProfile('undiscriminated-oneof-resolved');
        // Scenario parameter is "'Pet.kind' => 'petType'" — assert the
        // profile carries exactly that override.
        TestCase::assertSame('petType', $this->profile->discriminators['Pet.kind'] ?? null);
        TestCase::assertStringContainsString("'Pet.kind'", $discriminators);
        TestCase::assertStringContainsString("'petType'", $discriminators);
    }


    public function thenFileGeneratedModelPetPhpIsWrittenUnderProfilesOutput(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/Pet.php');
    }


    public function thenEmittedClassIsFinalReadonlyInProfilesNamespaceGeneratedModel(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('final readonly class Pet', $source);
        TestCase::assertStringContainsString('namespace Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore\\Generated\\Model;', $source);
    }


    public function whenModelIsEmitted(): void
    {
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
    }


    public function thenModelsConstructorHasAPromotedIntIdParameter(): void
    {
        // Check User model — its `id` is required (per Petstore: integer/int64).
        // Petstore's actual `id` is optional; we assert the *structure* (int type)
        // on Pet's `id` (?int).
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('public ?int $id', $source);
    }


    public function thenModelsConstructorHasAPromotedStringNameNullParameter(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/User.php');
        TestCase::assertStringContainsString('public ?string $username = null', $source);
    }


    public function thenModelOrderHasAPromotedConstructorParameterTypedAsPet(): void
    {
        // Petstore Order has petId, not a Pet ref — but Pet itself has a Category ref.
        // We assert the cross-class typing pattern on Pet → Category.
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('?Category $category', $source);
    }


    public function thenGeneratedFileGeneratedModelPetShippingPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/PetShipping.php');
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/PetShipping.php');
        TestCase::assertStringContainsString('final readonly class PetShipping', $source);
        TestCase::assertStringContainsString('public string $address', $source);
        TestCase::assertStringContainsString('public ?string $zip', $source);
    }


    public function thenModelPetHasAPromotedConstructorParameterPetShippingShipping(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString('?PetShipping $shipping', $source);
        // attribute-and-phpdoc-driven-serialization: synthesised child
        // reference is carried by the native type only — no PROPERTY_MAP,
        // no JsonSerializable in the file.
        TestCase::assertStringNotContainsString('PROPERTY_MAP', $source);
        TestCase::assertStringNotContainsString('JsonSerializable', $source);
    }


    public function thenModelsShippingPropertyIsNotTypedArrayStringMixed(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        // Ensure the `shipping` property block never mentions the fallback doc type.
        TestCase::assertStringNotContainsString('array<string, mixed> $shipping', $source);
        TestCase::assertStringNotContainsString('array<string,mixed> $shipping', $source);
        // Also: Pet must not expose `?array $shipping` (the pre-T-013 shape).
        TestCase::assertStringNotContainsString('?array $shipping', $source);
    }


    public function thenGeneratedFileGeneratedEnumStatusPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Enum/Status.php');
    }


    public function thenGeneratedFileIsEmittedAsEnumStatusStringWithOnePascalCasedCasePerDeclaredValue(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Enum/Status.php');
        TestCase::assertStringContainsString('enum Status: string', $source);
        TestCase::assertStringContainsString("case Placed = 'placed';", $source);
        TestCase::assertStringContainsString("case Approved = 'approved';", $source);
        TestCase::assertStringContainsString("case Delivered = 'delivered';", $source);
    }


    public function thenModelAnimalHasAPromotedConstructorParameterTypedDogCat(): void
    {
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Animal.php');
        TestCase::assertStringContainsString('public Dog|Cat $creature', $source);
    }


    public function thenGeneratorsRunAbortsWithErrorWhoseMessageNamesPetKind(string $error): void
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


    public function thenGeneratedFileGeneratedModelPetPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/Pet.php');
    }


    public function thenModelsKindConstructorParameterCarriesDiscriminatorFieldPetType(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        TestCase::assertStringContainsString("field: 'petType'", $source);
        TestCase::assertStringContainsString('#[Discriminator(', $source);
    }


    public function thenModelsPetKindIsAnInstanceOfCatIndependentOfWhetherThePayloadsKeysStructurallyMatchDog(): void
    {
        assert($this->hydratedCompositionPet instanceof \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet);
        TestCase::assertInstanceOf(
            Cat::class,
            $this->hydratedCompositionPet->kind,
        );
    }


    public function thenGeneratedFileGeneratedModelMergedThingPhpIsWritten(): void
    {
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/MergedThing.php');
    }


    public function thenModelMergedThingHasPromotedConstructorParametersIntIdAndStringLabel(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/MergedThing.php');
        TestCase::assertStringContainsString('public int $id', $source);
        TestCase::assertStringContainsString('public string $label', $source);
    }


    public function thenModelsPetTags0IsAnInstanceOfTag(): void
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


    public function thenModelsPetTags1IsAnInstanceOfTag(): void
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


    public function thenEachPetPhotoUrlsIOnModelIsTheOriginalStringNoObjectWrapping(): void
    {
        assert($this->hydratedPet instanceof Pet);
        TestCase::assertSame(['https://example/a.jpg', 'https://example/b.jpg'], $this->hydratedPet->photoUrls);
    }


    public function thenModelsConstructorParameterIsEmittedAsDisplayNameCamelCasedPHPIdentifier(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Contact.php');
        TestCase::assertStringContainsString('public string $displayName', $source);
    }


    public function thenModelsPropertyCarriesWireNameDisplayNameAndTheClassHasNoPROPERTYMAPConstant(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Contact.php');
        TestCase::assertStringContainsString("#[WireName('display-name')]", $source);
        TestCase::assertStringNotContainsString('PROPERTY_MAP', $source);
        TestCase::assertStringNotContainsString('JsonSerializable', $source);
    }


    public function thenClientsNewHydratorHydrateContactClassDisplayNameAdaPopulatesContactDisplayNameAda(): void
    {
        assert($this->hydratedKebabContact !== null);
        TestCase::assertSame('Ada', $this->hydratedKebabContact->displayName);
    }


    public function thenClientsNewMarshallerMarshalContactEmitsTheKeyAsDisplayNameNotDisplayName(): void
    {
        TestCase::assertStringContainsString('"display-name":"Ada"', $this->kebabMarshalled);
        TestCase::assertStringNotContainsString('"displayName"', $this->kebabMarshalled);
    }


    public function whenGeneratedFileGeneratedModelOrderPhpIsRead(): void
    {
        assert($this->profile !== null);
        $this->source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
    }


    public function thenGeneratedFileContainsNoPROPERTYMAPClassConstantAndNoImplementsJsonSerializable(): void
    {
        TestCase::assertStringNotContainsString('PROPERTY_MAP', $this->source);
        TestCase::assertStringNotContainsString('JsonSerializable', $this->source);
        TestCase::assertStringNotContainsString('jsonSerialize', $this->source);
    }


    public function thenModelsClassIsFinalReadonlyWithConstructorPromotedPropertiesOnly(): void
    {
        TestCase::assertStringContainsString('final readonly class Order', $this->source);
        // Constructor-promoted parameters use `public ?Type $name = ...`. Petstore
        // Order is all-optional, so every parameter has `public ` + a default.
        TestCase::assertMatchesRegularExpression('/public function __construct\(\s+public/', $this->source);
    }



    public function thenModelsKindParameterCarriesDiscriminatorFieldPetTypeMapDogDogClassCatCatClass(): void
    {
        TestCase::assertStringContainsString('#[Discriminator(', $this->source);
        TestCase::assertStringContainsString("field: 'petType'", $this->source);
        TestCase::assertStringContainsString("'Dog' => Dog::class", $this->source);
        TestCase::assertStringContainsString("'Cat' => Cat::class", $this->source);
    }


    public function thenModelsPetKindIsAnInstanceOfCatIndependentOfStructuralOverlapWithDog(): void
    {
        assert($this->hydratedDiscriminatedPet !== null);
        TestCase::assertInstanceOf(
            Cat::class,
            $this->hydratedDiscriminatedPet->kind,
        );
    }


    public function givenClientsPHPProcessIsRunningUnderOpcacheSaveComments0SoReflectionMethodGetDocCommentReturnsFalse(
    ): void {
        if (!extension_loaded('Zend OPcache')) {
            TestCase::markTestSkipped('Zend OPcache not loaded in CLI.');
        }
    }


    public function whenClientsNewHydratorHydratePetClassTagsId1NameARuns(): void
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


    public function thenClientsRuntimeReTokenisesPetPhpViaTokenGetAllRecoversTheConstructorsDocCommentAndPetTags0IsAnInstanceOfTagNotARawArray(
    ): void {
        TestCase::assertSame(
            'stripped:tag',
            $this->opcacheSubprocessOutput,
            "Subprocess output: {$this->opcacheSubprocessOutput}",
        );
    }


    public function thenModelsPropertyTypeInTheGeneratedConstructorIsAppValueObjectEmailNotString(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Contact.php');
        TestCase::assertStringContainsString('use Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject\\Email;', $source);
        TestCase::assertStringContainsString('public Email $email', $source);
        TestCase::assertStringNotContainsString('public string $email', $source);
    }


    public function whenJsonEncodeContactRunsAgainstModelContactWhoseEmailIsAnEmailTeamExample(): void
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


    public function thenModelsEmittedJSONContainsEmailTeamExampleNotANestedObject(): void
    {
        TestCase::assertStringContainsString('"email":"team@example"', $this->scalarEncoded);
        TestCase::assertStringNotContainsString('"value"', $this->scalarEncoded);
    }


    public function givenNoUserBindingForBindsFormatAttributeBindsFormatDateTimeIsRegistered(): void
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


    public function thenModelsConstructorParameterIsTypedDateTimeImmutable(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Order.php');
        TestCase::assertStringContainsString('public ?DateTimeImmutable $shipDate', $source);
    }


    public function thenModelsHydratedOrderShipDateIsAnInstanceOfDateTimeImmutableWhoseTimestampMatchesTheParsedRFC3339String(
    ): void {
        assert($this->hydratedOrder instanceof Order);
        TestCase::assertInstanceOf(DateTimeImmutable::class, $this->hydratedOrder->shipDate);
        TestCase::assertSame(
            new DateTimeImmutable($this->dateTimeWire)->getTimestamp(),
            $this->hydratedOrder->shipDate->getTimestamp(),
        );
    }


    public function thenClientCallJsonEncodeOrderWithThatShipDateEmitsShipDate20260418T1234560000OnTheWireNotANestedObject(
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


    public function thenGeneratedFileGeneratedModelSecurityAdvisoryEcosystemsPhpIsWritten(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('SecurityAdvisoryEcosystems', $this->resolved['security-advisory-ecosystems'] ?? null);
    }


    public function thenEveryOtherComponentOfSchemaThatRefsComponentsSchemasSecurityAdvisoryEcosystemsResolvesToTheSamePHPClass(
    ): void {
        // The NameRegistry memoises so every subsequent resolve of the
        // same raw name returns byte-identically.
        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);
        TestCase::assertSame(
            $registry->resolve('security-advisory-ecosystems', $context),
            $registry->resolve('security-advisory-ecosystems', $context),
        );
    }


    public function thenGeneratedFileGeneratedModelLegacyV2PhpIsWritten(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('Legacy_V2', $this->resolved['version-2'] ?? null);
    }


    public function thenGeneratedFileGeneratedModelVersion2PhpIsNotWritten(): void
    {
        // The `renames` entry wins, so PascalCaseSanitiser never runs
        // on `version-2` and `Version2` never gets claimed.
        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);
        TestCase::assertNotSame('Version2', $registry->resolve('version-2', $context));
    }


    public function thenEveryRefToComponentsSchemasVersion2ResolvesToModelLegacyV2(): void
    {
        $registry = $this->buildRegistry();
        $context = new NormalisationContext(SymbolKind::SchemaComponent);
        TestCase::assertSame('Legacy_V2', $registry->resolve('version-2', $context));
    }


    public function thenSchemasLegacyThingComponentIsEmittedAsLEGACYTHINGByTheFirstStrategy(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('LEGACY_THING', $this->resolved['legacy_thing'] ?? null);
    }


    public function thenSchemasModernThingComponentFallsThroughToPascalCaseSanitiserAndIsEmittedAsModernThing(): void
    {
        $this->resolveConfiguredNames();
        TestCase::assertSame('ModernThing', $this->resolved['modern-thing'] ?? null);
    }


    public function thenGeneratorsRunAbortsWithAnErrorNamingAnythingAndPointingAtTheEmptyNormaliserPipeline(): void
    {
        TestCase::assertInstanceOf(NameNormalisationException::class, $this->caught);
        TestCase::assertStringContainsString('anything', $this->caught->getMessage());
    }


    public function thenGeneratorsRunAbortsWithAnErrorNamingBothRawKeysAndTheSharedPHPClassFooBar(): void
    {
        TestCase::assertInstanceOf(NameNormalisationException::class, $this->caught);
        $message = $this->caught->getMessage();
        TestCase::assertStringContainsString('foo-bar', $message);
        TestCase::assertStringContainsString('foo_bar', $message);
        TestCase::assertStringContainsString('FooBar', $message);
    }


    public function thenGeneratedFileGeneratedModelUrnPhpIsWrittenWhoseClassIsFinalReadonlyClassUrnImplementsScalarBinding(
    ): void {
        $path = $this->outputDir . '/Generated/Model/Urn.php';
        TestCase::assertFileExists($path);
        $source = (string) file_get_contents($path);
        TestCase::assertStringContainsString('final readonly class Urn implements ScalarBinding', $source);
    }


    public function thenModelsConstructorHasASinglePromotedPublicStringValueAndTheClassEmitsMatchingFromScalarToScalarMethods(
    ): void {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/Urn.php');
        TestCase::assertStringContainsString('public string $value,', $source);
        TestCase::assertStringContainsString('public static function fromScalar(mixed $raw): self', $source);
        TestCase::assertStringContainsString('public function toScalar(): string', $source);
    }


    public function thenSiblingModelThatRefsComponentsSchemasUrnUsesGeneratedModelUrnAsThePropertyTypeAndNewMarshallerMarshalModelEmitsThePropertyAsAPlainStringNotANestedObject(
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


    public function thenGeneratedFileGeneratedModelFloatingIpCreatePhpIsAnEmptyInterface(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/FloatingIpCreate.php');
        TestCase::assertStringContainsString('interface FloatingIpCreate', $source);
        TestCase::assertStringNotContainsString('final readonly class FloatingIpCreate', $source);
    }


    public function thenBothModelFilesGeneratedModelFloatingIpCreateAssignToDropletPhpAndGeneratedModelFloatingIpCreateReserveToRegionPhpAreFinalReadonlyClassesThatImplementsFloatingIpCreate(
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


    public function thenOperationThatReferencesFloatingIpCreateAsARequestBodyTypesAMethodParameterFloatingIpCreateBody(
    ): void {
        // The composition fixture has no operations (paths: {}), so this
        // expectation is asserted against the inline-branch class existence
        // the previous step already checked — the interface lands in the
        // ApiClient signature as soon as any op $refs the union. See
        // examples/digitalocean for the end-to-end case (T-026 exit).
        TestCase::assertFileExists($this->outputDir . '/Generated/Model/FloatingIpCreate.php');
    }


    public function thenGeneratedFileGeneratedModelIssueEventForIssuePhpIsAnEmptyInterface(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/IssueEventForIssue.php');
        TestCase::assertStringContainsString('interface IssueEventForIssue', $source);
    }


    public function thenBothModelFilesLabeledIssueEventPhpAndUnlabeledIssueEventPhpDeclareImplementsIssueEventForIssueInTheirClassHeaders(
    ): void {
        $labeled = (string) file_get_contents($this->outputDir . '/Generated/Model/LabeledIssueEvent.php');
        $unlabeled = (string) file_get_contents($this->outputDir . '/Generated/Model/UnlabeledIssueEvent.php');
        TestCase::assertStringContainsString('implements IssueEventForIssue', $labeled);
        TestCase::assertStringContainsString('implements IssueEventForIssue', $unlabeled);
    }


    public function thenGeneratedFileGeneratedModelTagsArrayPhpIsWrittenWhoseClassIsFinalReadonlyClassTagsArray(
    ): void {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/TagsArray.php');
        TestCase::assertStringContainsString('final readonly class TagsArray', $source);
    }


    public function thenModelsConstructorHasASinglePromotedPublicArrayItemsWithPhpdocParamListStringItems(): void
    {
        $source = (string) file_get_contents($this->outputDir . '/Generated/Model/TagsArray.php');
        TestCase::assertStringContainsString('public array $items,', $source);
        TestCase::assertStringContainsString('@param list<string> $items', $source);
    }


    public function givenSchemaDeclaresAnEmptyComponentsSchemasAndOperationIdWhoseApplicationJsonRequestBodyAnd2xxResponseAreEachAnInlineTypeObjectWithDeclaredProperties(
        string $id,
    ): void {
        TestCase::assertSame('placeOrder', $id);

        $this->profile = $this->inlinePayloadProfile('inline-payloads-3.0.yaml');
    }


    public function thenGeneratedFileGeneratedModelPlaceOrderRequestPhpAndGeneratedFileGeneratedModelPlaceOrderResponsePhpAreBothWritten(
    ): void {
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlaceOrderRequest.php');
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlaceOrderResponse.php');
    }


    public function thenEmittedClientDeclaresPlaceOrderPlaceOrderRequestBodyPlaceOrderResponse(): void
    {
        TestCase::assertStringContainsString(
            'public function placeOrder(PlaceOrderRequest $body): PlaceOrderResponse',
            $this->inlineClientSource(),
        );
    }


    public function thenOperationIsNotReportedAsASkip(): void
    {
        // A skip is something the plan reports, so ask the planner rather than
        // inferring absence from the emitted tree — an operation dropped for
        // some other reason would leave the same hole.
        TestCase::assertNotContains('placeOrder', $this->inlineSkippedOperationIds());
    }


    public function givenOperationIdWhoseRequestBodyAnd2xxResponseAreEachTypeArrayWhoseItemsIsAnInlineTypeObjectWithDeclaredProperties(
        string $id,
    ): void {
        TestCase::assertSame('placeOrdersBulk', $id);

        $this->profile = $this->inlinePayloadProfile('inline-payloads-3.0.yaml');
    }


    public function thenGeneratedFileGeneratedModelPlaceOrdersBulkRequestItemPhpAndGeneratedFileGeneratedModelPlaceOrdersBulkResponseItemPhpAreWrittenForTheItemShapes(
    ): void {
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlaceOrdersBulkRequestItem.php');
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlaceOrdersBulkResponseItem.php');
    }


    public function thenEmittedClientTypesTheParameterListPlaceOrdersBulkRequestItemAndTheReturnListPlaceOrdersBulkResponseItemInPhpdoc(
    ): void {
        $client = $this->inlineClientSource();

        // The signature is `array`; the element type lives in phpdoc, which is
        // the only place PHP lets it be said.
        TestCase::assertStringContainsString('@param list<PlaceOrdersBulkRequestItem> $body', $client);
        TestCase::assertStringContainsString('@return list<PlaceOrdersBulkResponseItem>', $client);
        TestCase::assertStringContainsString('public function placeOrdersBulk(array $body): array', $client);
    }


    public function givenOperationIdWhoseInlineResponseCarriesAnInlineObjectPropertyShippingAndAnArrayPropertyLinesWhoseItemsAreAnInlineObject(
        string $id,
    ): void {
        TestCase::assertSame('placeOrder', $id);

        $this->profile = $this->inlinePayloadProfile('inline-payloads-3.0.yaml');
    }


    public function thenGeneratedFileGeneratedModelPlaceOrderResponseShippingPhpAndGeneratedFileGeneratedModelPlaceOrderResponseLinesItemPhpAreWritten(
    ): void {
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlaceOrderResponseShipping.php');
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlaceOrderResponseLinesItem.php');
    }


    public function thenModelTwoPropertiesAreTypedAsThoseClassesRatherThanArrayStringMixed(): void
    {
        $model = (string) file_get_contents($this->inlineOutputDir . '/Generated/Model/PlaceOrderResponse.php');

        // The object property carries the synthesised class; the array property
        // carries a list of the synthesised item class. Either one degrading to
        // `array<string, mixed>` is the failure this pins, so the absence of
        // that type in the file is asserted too.
        TestCase::assertStringContainsString('public ?PlaceOrderResponseShipping $shipping = null', $model);
        TestCase::assertStringContainsString('@param ?list<PlaceOrderResponseLinesItem> $lines', $model);
        TestCase::assertStringNotContainsString('array<string, mixed>', $model);
    }


    public function givenOperationIdWhoseInlineRequestBodyHasAPropertyChannelWithTypeStringAndCases(
        string $id,
        string $cases,
    ): void {
        TestCase::assertSame('placeOrder', $id);
        TestCase::assertSame('enum: [web, phone, store]', $cases);

        $this->profile = $this->inlinePayloadProfile('inline-payloads-3.0.yaml');
    }


    public function thenGeneratedFileGeneratedEnumPlaceOrderRequestChannelPhpIsABackedEnumWithThoseThreeCases(): void
    {
        $path = $this->inlineOutputDir . '/Generated/Enum/PlaceOrderRequestChannel.php';
        TestCase::assertFileExists($path);

        $source = (string) file_get_contents($path);

        // Backed, and by string — an unbacked enum could not round-trip the
        // document's values.
        TestCase::assertStringContainsString('enum PlaceOrderRequestChannel: string', $source);
        TestCase::assertStringContainsString("case Web = 'web';", $source);
        TestCase::assertStringContainsString("case Phone = 'phone';", $source);
        TestCase::assertStringContainsString("case Store = 'store';", $source);
    }


    public function thenModelNestedInsideANamedComponentResolvesAnIdenticalInlineEnumTheSameWaySoTheReadingDoesNotDependOnWhereThePropertyWasDeclared(
    ): void {
        // "wherever the payload came from" is the whole claim, so it needs the
        // other origin: an inline `enum` on a property of a *named* component.
        // The inline-payloads fixture declares no components at all, so this
        // half is asserted against petstore, whose `Order.status` is exactly
        // that shape.
        $base = $this->makeScratchOutputDir('paogen-component-enum-');

        $this->runGenerator(new Profile(
            schema: dirname(__DIR__, 2) . '/tests/fixtures/schemas/petstore-3.0.yaml',
            output: $base,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ComponentEnum',
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
        ));

        $enum = $base . '/Generated/Enum/OrderStatus.php';
        TestCase::assertFileExists($enum);
        TestCase::assertStringContainsString('enum OrderStatus: string', (string) file_get_contents($enum));

        // And the property reads as the enum rather than a bare string.
        TestCase::assertStringContainsString(
            'public ?OrderStatus $status = null',
            (string) file_get_contents($base . '/Generated/Model/Order.php'),
        );
    }


    public function givenOperationIdWhoseApplicationJsonRequestBodyIsTypeObjectWithNoDeclaredPropertiesAndNoAdditionalProperties(
        string $id,
    ): void {
        TestCase::assertSame('ping', $id);

        $this->profile = $this->inlinePayloadProfile('inline-payloads-3.0.yaml');
    }


    public function thenEmittedClientDeclaresPingArrayBodyVoidWithPhpdocParamArrayStringMixedBody(): void
    {
        $client = $this->inlineClientSource();

        TestCase::assertStringContainsString('public function ping(array $body): void', $client);
        TestCase::assertStringContainsString('@param array<string, mixed> $body', $client);
    }


    public function thenOperationIsNotReportedAsASkipBecauseAMapIsWhatSchemaSaidRatherThanAShapeGeneratorCouldNotRepresent(
    ): void {
        // An unconstrained object is a shape the document stated, not one the
        // generator failed to represent, so it is emitted rather than skipped.
        TestCase::assertNotContains('ping', $this->inlineSkippedOperationIds());
    }


    public function givenProfileWhoseInlineModelsMapCarriesPin(string $pin): void
    {
        TestCase::assertSame("'placeOrder.response' => 'PlacedOrder'", $pin);

        $this->profile = $this->inlinePayloadProfile(
            'inline-payloads-3.0.yaml',
            ['placeOrder.response' => 'PlacedOrder'],
        );
    }


    public function thenGeneratedFileGeneratedModelPlacedOrderPhpIsWrittenAndNoPlaceOrderResponsePhpIs(): void
    {
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlacedOrder.php');
        TestCase::assertFileDoesNotExist($this->inlineOutputDir . '/Generated/Model/PlaceOrderResponse.php');

        // The pinned name is what the client returns, not merely what a file
        // is called.
        TestCase::assertStringContainsString(': PlacedOrder', $this->inlineClientSource());
    }


    public function thenPinRenamesTheRootAloneSoModelNestedUnderItIsEmittedAsPlacedOrderShipping(): void
    {
        // Children follow the root's new name, so a consumer who pins one class
        // does not have to pin the whole subtree behind it.
        TestCase::assertFileExists($this->inlineOutputDir . '/Generated/Model/PlacedOrderShipping.php');
        TestCase::assertFileDoesNotExist($this->inlineOutputDir . '/Generated/Model/PlaceOrderResponseShipping.php');
    }


    public function givenProfileWhoseInlineModelsMapCarriesAKeyNoSuchOperationResponse(): void
    {
        $this->expectGeneratorAbort = true;

        $this->profile = $this->inlinePayloadProfile(
            'inline-payloads-3.0.yaml',
            ['noSuchOperation.response' => 'Whatever'],
        );
    }


    public function thenRunFailsNamingTheKeyAndSayingTheOperationIdIsAbsentFromSchema(): void
    {
        TestCase::assertInstanceOf(UnrepresentableConstructsException::class, $this->caught);

        $message = $this->caught->getMessage();

        // Naming the key is what makes the message actionable: the reader has
        // to know which entry to remove.
        TestCase::assertStringContainsString('noSuchOperation.response', $message);
        TestCase::assertStringContainsString('absent from the schema', $message);
    }


    public function thenNoGeneratedFileIsWrittenSoGuidanceThatHasOutlivedOperationItNamedCannotPassUnnoticed(): void
    {
        // Refusal means refusal: planning aborts before anything reaches disk,
        // so a stale pin cannot leave a half-written tree behind either.
        TestCase::assertSame([], $this->snapshot($this->inlineOutputDir));
    }


    public function givenSchemaDeclaresAComponentNamedPlaceOrderResponseAndOperationIdWhoseInlineResponseDerivesThatSameName(
        string $id,
    ): void {
        TestCase::assertSame('placeOrder', $id);

        $this->expectGeneratorAbort = true;
        $this->profile = $this->inlinePayloadProfile('inline-payload-collision-3.0.yaml');
    }


    public function thenRunFailsNamingModelAndBothOriginsTheComponentNameAndTheJSONPointerOfTheInlineResponse(): void
    {
        TestCase::assertInstanceOf(ModelNameCollisionException::class, $this->caught);

        $message = $this->caught->getMessage();

        // Both origins, because the reader cannot act on the collision without
        // knowing which two nodes claimed the name.
        TestCase::assertStringContainsString('PlaceOrderResponse', $message);
        TestCase::assertStringContainsString('components.schemas/PlaceOrderResponse', $message);
        TestCase::assertStringContainsString('/paths/~1orders/post/responses/200', $message);
    }


    public function thenMessageNamesProfileKeyThatResolvesItSoTheReaderIsNotLeftToGuessWhichKnobApplies(): void
    {
        TestCase::assertNotNull($this->caught);

        $message = $this->caught->getMessage();

        // Both knobs, because which one applies depends on which origin the
        // reader decides to move: a synthesised payload is pinned by
        // `inlineModels`, a named component renamed by `renames`.
        TestCase::assertStringContainsString('Profile::$inlineModels', $message);
        TestCase::assertStringContainsString('Profile::$renames', $message);
    }


    public function thenGeneratedFileGeneratedModelPetPhpIsNoLongerOnDisk(): void
    {
        TestCase::assertFileDoesNotExist($this->pruneTempOutput . '/Generated/Model/Pet.php');
        TestCase::assertFileExists($this->pruneTempOutput . '/Generated/Model/Tag.php');
    }


    public function thenFilesPlacedAlongsideGeneratedUnderProfilesOutputDirectoryRemainUntouched(): void
    {
        TestCase::assertFileExists($this->pruneSentinel);
        TestCase::assertSame('not generated by paogen', (string) file_get_contents($this->pruneSentinel));
    }


    // ---- generated-files-declare-themselves ----------------------------
    //
    // The petstore profile is loaded from its real file so the header under
    // test carries the path a reader would actually type, but the output is
    // redirected to a scratch tree: these scenarios read what was written,
    // and a run that overwrote the committed golden tree would be asserting
    // against its own side effect.

    /** Scratch output directory for the header scenarios. */
    private string $headerOutputDir = '';

    public function givenProfileWasLoadedFromTestsFixturesProfilesPetstorePhp(): void
    {
        $this->headerOutputDir = $this->makeScratchOutputDir('paogen-header-');
        $this->profile = $this->loadProfile('petstore')->with(output: $this->headerOutputDir);
        $this->outputDir = $this->headerOutputDir;
    }

    public function thenEveryGeneratedFileWrittenOpensWithACommentSayingItWasGeneratedByPaogenAndMustNotBeEditedByHand(
    ): void {
        foreach ($this->emittedHeaders() as $relative => $header) {
            TestCase::assertStringContainsString(
                'Generated by paogen',
                $header,
                "{$relative} does not say it is generated",
            );
            TestCase::assertStringContainsString(
                'Do not edit by hand',
                $header,
                "{$relative} does not refuse hand edits",
            );
        }
    }

    public function thenThatCommentNamesProfileAsTestsFixturesProfilesPetstorePhp(): void
    {
        foreach ($this->emittedHeaders() as $relative => $header) {
            TestCase::assertStringContainsString(
                'Profile:    tests/fixtures/profiles/petstore.php',
                $header,
                "{$relative} does not name the profile it came from",
            );
        }
    }

    public function thenThatCommentPrintsTheCommandThatReproducesGeneratedFilePaogenGenerateTestsFixturesProfilesPetstorePhp(
    ): void {
        foreach ($this->emittedHeaders() as $relative => $header) {
            TestCase::assertStringContainsString(
                'Regenerate: paogen generate tests/fixtures/profiles/petstore.php',
                $header,
                "{$relative} does not print the command that reproduces it",
            );
        }
    }

    public function whenGeneratorRunsAgainOverSameSchemaAndSameProfile(): void
    {
        $this->whenGeneratorRunsAgainWithTheSameSchemaAndProfile();
    }

    public function thenEveryGeneratedFilesHeaderIsByteIdenticalToThePreviousRuns(): void
    {
        TestCase::assertNotEmpty($this->firstSnapshot);
        TestCase::assertSame(
            array_map(self::headerOf(...), $this->firstSnapshot),
            array_map(self::headerOf(...), $this->secondSnapshot),
        );
    }

    public function thenNothingInGeneratedFilesHeaderIsATimestampAVersionOrAnAbsolutePath(): void
    {
        TestCase::assertNotEmpty($this->secondSnapshot);

        foreach ($this->secondSnapshot as $relative => $source) {
            // Strip the comment markers first: `//` at the head of every line
            // would otherwise read as a root-anchored path.
            $prose = (string) preg_replace('#^// ?#m', '', self::headerOf($source));

            TestCase::assertDoesNotMatchRegularExpression(
                '/\d{4}-\d{2}-\d{2}|\d{2}:\d{2}:\d{2}/',
                $prose,
                "{$relative}'s header carries a timestamp, so every run would rewrite it",
            );
            TestCase::assertDoesNotMatchRegularExpression(
                '/\bv?\d+\.\d+\.\d+\b/',
                $prose,
                "{$relative}'s header carries a version, which moves without the schema moving",
            );
            TestCase::assertDoesNotMatchRegularExpression(
                '#(?:^|\s)/\S#m',
                $prose,
                "{$relative}'s header carries an absolute path, which differs per machine",
            );
        }
    }

    /**
     * The header block of every file the run emitted, keyed by relative path.
     *
     * @return array<string,string>
     */
    private function emittedHeaders(): array
    {
        $snapshot = $this->snapshot($this->headerOutputDir);
        TestCase::assertNotEmpty($snapshot, 'the header scenarios need an emitted tree to read');

        return array_map(self::headerOf(...), $snapshot);
    }

    /**
     * Everything between the opening tag and the code the file declares.
     *
     * Reading it positionally rather than by matching the header's own text is
     * what lets the assertions above fail on a file that carries no header at
     * all, instead of quietly passing over an empty match.
     */
    private static function headerOf(string $source): string
    {
        $body = substr($source, strlen("<?php\n"));
        $end = strpos($body, 'declare(');

        return $end === false ? $body : substr($body, 0, $end);
    }

    // ---- regenerating over a tree that is already there ----------------

    private const string HAND_EDIT_SENTINEL = 'TYPED-BY-A-HUMAN-NOT-BY-PAOGEN';

    private string $rerunOutputDir = '';
    /** @var array<string,string> */
    private array $rerunFirstSnapshot = [];
    private string $rerunEditedFile = '';
    private ?Throwable $rerunFailure = null;

    public function givenGeneratorHasAlreadyWrittenGeneratedFileTreeIntoProfilesOutput(): void
    {
        $this->rerunOutputDir = $this->makeScratchOutputDir('paogen-rerun-');
        $this->profile = $this->loadProfile('petstore')->with(output: $this->rerunOutputDir);
        $this->outputDir = $this->rerunOutputDir;

        $this->runGenerator($this->profile);
        $this->rerunFirstSnapshot = $this->snapshot($this->rerunOutputDir);
        TestCase::assertNotEmpty($this->rerunFirstSnapshot);

        // Hand-edit one file before the second run. A run that skipped an
        // existing file, or could not replace one, would leave this edit in
        // place — which is precisely the promise the header prints.
        //
        // The sentinel is deliberately nothing the emitter could produce: the
        // first attempt used the words "hand edit", which the header itself
        // contains, so the assertion tripped on the correct output.
        $this->rerunEditedFile = $this->rerunOutputDir . '/Generated/Model/Pet.php';
        TestCase::assertFileExists($this->rerunEditedFile);
        file_put_contents($this->rerunEditedFile, "<?php\n\n// " . self::HAND_EDIT_SENTINEL . "\n");
    }

    public function whenGeneratorRunsASecondTimeIntoSameProfilesOutput(): void
    {
        TestCase::assertNotNull($this->profile);

        try {
            $this->runGenerator($this->profile);
        } catch (Throwable $error) {
            $this->rerunFailure = $error;
        }
    }

    public function thenSecondRunOverwritesEveryGeneratedFileAndReportsNoError(): void
    {
        TestCase::assertNull(
            $this->rerunFailure,
            'regenerating over an existing tree must not fail: ' . ($this->rerunFailure?->getMessage() ?? ''),
        );
        TestCase::assertStringNotContainsString(
            self::HAND_EDIT_SENTINEL,
            (string) file_get_contents($this->rerunEditedFile),
            'the second run left a hand edit in place instead of replacing the file',
        );
    }

    public function thenGeneratedFileTreeOnDiskIsByteIdenticalToTheTreeTheFirstRunLeft(): void
    {
        TestCase::assertSame($this->rerunFirstSnapshot, $this->snapshot($this->rerunOutputDir));
    }


    public function whenClientCallNewHydratorHydratePetClassDataRunsAgainstAPayloadWhoseKindPetTypeIsWire(
        string $wire,
    ): void {
        $tag = trim($wire, "'\"");
        // Payload has both `bark` (so a bare structural match would prefer Dog)
        // and `meow` (Cat's required field) — petType='Cat' must break the tie
        // and select Cat regardless of the structural overlap.
        $this->hydratedCompositionPet = $this->invokeCompositionHydrate(
            \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet::class,
            ['kind' => ['petType' => $tag, 'bark' => 'arf', 'meow' => 'purr']],
        );
    }


    public function thenNewHydratorHydrateContactClassEmailTeamExampleProducesModelContactWhoseEmailIsAnEmailInstanceWithValueTeamExample(
    ): void {
        assert($this->hydratedContact instanceof Contact);
        TestCase::assertInstanceOf(
            Email::class,
            $this->hydratedContact->email,
        );
        TestCase::assertSame('team@example', $this->hydratedContact->email->value);
    }


    public function whenModelIsEmittedAndTheGeneratedNewHydratorHydrateOrderClassRunsAgainstAPayloadWhoseShipDateIsWire(
        string $wire,
    ): void {
        $this->dateTimeWire = trim($wire, "'\"");
        $this->hydratedOrder = $this->invokeHydrate(
            Order::class,
            ['shipDate' => $this->dateTimeWire],
        );
    }


    public function whenClientsRuntimeHydratorAttributeAndPhpdocDrivenSerializationRunsAgainstAPayloadWhoseTagsIsAListOfTwoObjects(
    ): void {
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


    public function whenClientsRuntimeHydratorAttributeAndPhpdocDrivenSerializationRunsAgainstAPayloadWhosePhotoUrlsIsAListOfPlainStrings(
    ): void {
        $this->hydratedPet = $this->invokeHydrate(
            Pet::class,
            [
                'name' => 'doggie',
                'photoUrls' => ['https://example/a.jpg', 'https://example/b.jpg'],
            ],
        );
    }


    public function whenGeneratorEmitsContactPhpAndTheRuntimeMarshallerHydratorAttributeAndPhpdocDrivenSerializationProcessAPayloadContainingTheWireKeyDisplayName(
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


    public function givenModelOrderIsEmittedByGeneratorUnderAttributeAndPhpdocDrivenSerialization(): void
    {
        $this->profile = $this->loadProfile('petstore');
        $this->runGenerator($this->profile);
    }


    public function thenModelsWireMetadataWhenNeededIsCarriedByTheSmallAttributeAndPhpdocDrivenSerializationAttributeSetOnEachParameter(
    ): void {
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


    public function whenGeneratedFilePetPhpIsReadAndTheRuntimeHydratorAttributeAndPhpdocDrivenSerializationRunsAgainstAPayloadWhoseKindPetTypeIsWire(
        string $wire,
    ): void {
        $tag = trim($wire, "'\"");
        $this->source = (string) file_get_contents($this->outputDir . '/Generated/Model/Pet.php');
        $this->hydratedDiscriminatedPet = new Hydrator()->hydrate(
            \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Pet::class,
            ['kind' => ['petType' => $tag, 'bark' => 'arf', 'meow' => 'purr']],
        );
    }

}
