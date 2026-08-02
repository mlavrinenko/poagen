<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: Model Generator
 *
 * Walks Schema's components.schemas and emits one Model per entry. Property types follow OpenAPI scalar semantics; $ref becomes a typed reference to target Model #[BindsFormat] from the user side overrides the property type with Value Object.
 */
final class ModelGeneratorTest extends TestCase
{
    private ModelGeneratorSteps $steps;


    protected function setUp(): void
    {
        $this->steps = new ModelGeneratorSteps($this);
    }


    /**
     * Rule: Class emission
     *
     * Scenario: Each named schema component becomes a final readonly class
     * @source truth/specs/model-generator.feature-260418.typ:17
     *
     * Given Schema declares a component named Pet
     * When Generator runs against Profile
     * Then a file Generated/Model/Pet.php is written under Profile's output
     *   And the emitted class is final readonly in Profile's namespace \Generated\Model
     */
    public function testEachNamedSchemaComponentBecomesAFinalReadonlyClass(): void
    {
        $this->steps->givenSchemaDeclaresAComponentNamedName('Pet');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenFileGeneratedModelPetPhpIsWrittenUnderProfilesOutput();
        $this->steps->thenEmittedClassIsFinalReadonlyInProfilesNamespaceGeneratedModel();
    }


    /**
     * Scenario: Property types follow OpenAPI scalars and required-ness
     * @source truth/specs/model-generator.feature-260418.typ:27
     *
     * Given Model with required id: integer and optional name: string
     * When Model is emitted
     * Then Model's constructor has a promoted int $id parameter
     *   And Model's constructor has a promoted ?string $name = null parameter
     */
    public function testPropertyTypesFollowOpenAPIScalarsAndRequiredNess(): void
    {
        $this->steps->givenModelWithRequiredPropAndOptionalProp('id: integer', 'name: string');
        $this->steps->whenModelIsEmitted();
        $this->steps->thenModelsConstructorHasAPromotedIntIdParameter();
        $this->steps->thenModelsConstructorHasAPromotedStringNameNullParameter();
    }


    /**
     * Scenario: A `$ref` to another component becomes a typed property of that class
     * @source truth/specs/model-generator.feature-260418.typ:37
     *
     * Given Model Order has a required property pet that $ref #/components/schemas/Pet
     * When Model is emitted
     * Then Model Order has a promoted constructor parameter typed as Pet
     */
    public function testARefToAnotherComponentBecomesATypedPropertyOfThatClass(): void
    {
        $this->steps->givenModelParentHasARequiredPropertyPetThatRefTarget('Order', '$ref', '#/components/schemas/Pet');
        $this->steps->whenModelIsEmitted();
        $this->steps->thenModelOrderHasAPromotedConstructorParameterTypedAsPet();
    }


    /**
     * Scenario: An inline nested object schema becomes a synthesised typed class
     * @source truth/specs/model-generator.feature-260418.typ:46
     *
     * Given Model Pet declares an inline property shipping with type: object and nested properties address: string, zip: string
     * When Model is emitted
     * Then Generated File Generated/Model/PetShipping.php is written
     *   And Model Pet has a promoted constructor parameter PetShipping $shipping
     *   And Model's shipping property is not typed array<string, mixed>
     */
    public function testAnInlineNestedObjectSchemaBecomesASynthesisedTypedClass(): void
    {
        $this->steps->givenModelParentDeclaresAnInlinePropertyShippingWithTypeObjectAndNestedPropertiesProps('Pet', 'address: string, zip: string');
        $this->steps->whenModelIsEmitted();
        $this->steps->thenGeneratedFileGeneratedModelPetShippingPhpIsWritten();
        $this->steps->thenModelPetHasAPromotedConstructorParameterPetShippingShipping();
        $this->steps->thenModelsShippingPropertyIsNotTypedArrayStringMixed();
    }


    /**
     * Scenario: A schema with enum values becomes a PHP 8.1 backed enum
     * @source truth/specs/model-generator.feature-260418.typ:57
     *
     * Given Schema declares a named component Status with type: string and [placed, approved, delivered]
     * When Generator runs against Profile
     * Then Generated File Generated/Enum/Status.php is written
     *   And Generated File is emitted as enum Status: string with one PascalCased case per declared value
     *   And Model that references #/components/schemas/Status is typed with the enum, not string
     */
    public function testASchemaWithEnumValuesBecomesAPHP81BackedEnum(): void
    {
        $this->steps->givenSchemaDeclaresANamedComponentStatusWithTypeStringAndEnum('[placed, approved, delivered]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedEnumStatusPhpIsWritten();
        $this->steps->thenGeneratedFileIsEmittedAsEnumStatusStringWithOnePascalCasedCasePerDeclaredValue();
        $this->steps->thenModelThatReferencesComponentsSchemasStatusIsTypedWithTheEnumNotString();
    }


    /**
     * Scenario: A `oneOf` of `$ref`-ed components with a `discriminator` becomes a PHP union type
     * @source truth/specs/model-generator.feature-260418.typ:68
     *
     * Given Schema declares components Dog and Cat and Model Animal with a required property creature whose schema is oneOf: [$ref Dog, $ref Cat] with discriminator.propertyName: petType
     * When Generator runs against Profile
     * Then Model Animal has a promoted constructor parameter typed Dog|Cat
     */
    public function testAOneOfOfRefEdComponentsWithADiscriminatorBecomesAPHPUnionType(): void
    {
        $this->steps->givenSchemaDeclaresComponentsDogAndCatAndModelAnimalWithARequiredPropertyCreatureWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenModelAnimalHasAPromotedConstructorParameterTypedDogCat();
    }


    /**
     * Scenario: An undiscriminated `oneOf` aborts the run with a pointed diagnostic
     * @source truth/specs/model-generator.feature-260418.typ:77
     *
     * Given Schema declares components Dog and Cat and a component Pet with a required property kind whose schema is oneOf: [$ref Dog, $ref Cat] with no discriminator
     *   And Profile has no discriminators override for Pet.kind
     * When Generator runs against Profile
     * Then Generator's run aborts with UnrepresentableConstructsException whose message names Pet.kind
     *   And no files are written under Profile's output
     */
    public function testAnUndiscriminatedOneOfAbortsTheRunWithAPointedDiagnostic(): void
    {
        $this->steps->givenSchemaDeclaresComponentsDogAndCatAndAComponentPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithNoDiscriminator();
        $this->steps->givenProfileHasNoDiscriminatorsOverrideForKey('Pet.kind');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratorsRunAbortsWithErrorWhoseMessageNamesPetKind('UnrepresentableConstructsException');
        $this->steps->thenNoFilesAreWrittenUnderProfilesOutput();
    }


    /**
     * Scenario: A profile-level `discriminators` override resolves an otherwise-undiscriminated `oneOf`
     * @source truth/specs/model-generator.feature-260418.typ:88
     *
     * Given Schema declares components Dog and Cat and a component Pet with a required property kind whose schema is oneOf: [$ref Dog, $ref Cat] with no discriminator
     *   And Profile sets 'Pet.kind' => 'petType'
     * When Generator runs against Profile
     * Then Generated File Generated/Model/Pet.php is written
     *   And Model's kind constructor parameter carries #[Discriminator(field: 'petType', ...)]
     */
    public function testAProfileLevelDiscriminatorsOverrideResolvesAnOtherwiseUndiscriminatedOneOf(): void
    {
        $this->steps->givenSchemaDeclaresComponentsDogAndCatAndAComponentPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithNoDiscriminator();
        $this->steps->givenProfileSetsDiscriminators('\'Pet.kind\' => \'petType\'');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelPetPhpIsWritten();
        $this->steps->thenModelsKindConstructorParameterCarriesDiscriminatorFieldPetType();
    }


    /**
     * Scenario: A `oneOf` with a `discriminator.propertyName` picks the branch by wire value
     * @source truth/specs/model-generator.feature-260418.typ:99
     *
     * Given Schema declares components Dog and Cat and Model Pet with a required property kind whose schema is oneOf: [$ref Dog, $ref Cat] with discriminator.propertyName: petType
     * When Client call (new Hydrator())->hydrate(Pet::class, $data) runs against a payload whose kind.petType is 'Cat'
     * Then Model's $pet->kind is an instance of Cat, independent of whether the payload's keys structurally match Dog
     */
    public function testAOneOfWithADiscriminatorPropertyNamePicksTheBranchByWireValue(): void
    {
        $this->steps->givenSchemaDeclaresComponentsDogAndCatAndModelPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType();
        $this->steps->whenClientCallNewHydratorHydratePetClassDataRunsAgainstAPayloadWhoseKindPetTypeIsWire('\'Cat\'');
        $this->steps->thenModelsPetKindIsAnInstanceOfCatIndependentOfWhetherThePayloadsKeysStructurallyMatchDog();
    }


    /**
     * Scenario: An `allOf` that merges two object schemas becomes a single Model with the union of properties
     * @source truth/specs/model-generator.feature-260418.typ:108
     *
     * Given Schema declares components BaseThing (required id: integer) and ExtraThing (required label: string) and Model MergedThing whose schema is allOf: [$ref BaseThing, $ref ExtraThing]
     * When Generator runs against Profile
     * Then Generated File Generated/Model/MergedThing.php is written
     *   And Model MergedThing has promoted constructor parameters int $id and string $label
     */
    public function testAnAllOfThatMergesTwoObjectSchemasBecomesASingleModelWithTheUnionOfProperties(): void
    {
        $this->steps->givenSchemaDeclaresComponentsBaseThingRequiredIdIntegerAndExtraThingRequiredLabelStringAndModelMergedThingWhoseSchemaIsAllOfRefBaseThingRefExtraThing();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelMergedThingPhpIsWritten();
        $this->steps->thenModelMergedThingHasPromotedConstructorParametersIntIdAndStringLabel();
    }


    /**
     * Rule: Hydration and serialization contract (ADR-010)
     *
     * Scenario: A list-of-Model property hydrates each item into the declared class
     * @source truth/specs/model-generator.feature-260418.typ:120
     *
     * Given Model Pet has a property tags whose schema is type: array, items.$ref: #/components/schemas/Tag
     * When Client's runtime Hydrator (ADR-010) runs against a payload whose tags is a list of two objects
     * Then Model's $pet->tags[0] is an instance of Tag
     *   And Model's $pet->tags[1] is an instance of Tag
     */
    public function testAListOfModelPropertyHydratesEachItemIntoTheDeclaredClass(): void
    {
        $this->steps->givenModelPetHasAPropertyTagsWhoseSchemaIsTypeArrayItemsRefComponentsSchemasTag();
        $this->steps->whenClientsRuntimeHydratorADR010RunsAgainstAPayloadWhoseTagsIsAListOfTwoObjects();
        $this->steps->thenModelsPetTags0IsAnInstanceOfTag();
        $this->steps->thenModelsPetTags1IsAnInstanceOfTag();
    }


    /**
     * Scenario: A list-of-scalar property hydrates items untouched
     * @source truth/specs/model-generator.feature-260418.typ:130
     *
     * Given Model Pet has a property photoUrls whose schema is type: array, items.type: string
     * When Client's runtime Hydrator (ADR-010) runs against a payload whose photoUrls is a list of plain strings
     * Then each $pet->photoUrls[$i] on Model is the original string — no object wrapping
     */
    public function testAListOfScalarPropertyHydratesItemsUntouched(): void
    {
        $this->steps->givenModelPetHasAPropertyPhotoUrlsWhoseSchemaIsTypeArrayItemsTypeString();
        $this->steps->whenClientsRuntimeHydratorADR010RunsAgainstAPayloadWhosePhotoUrlsIsAListOfPlainStrings();
        $this->steps->thenEachPetPhotoUrlsIOnModelIsTheOriginalStringNoObjectWrapping();
    }


    /**
     * Scenario: A property with a non-identifier schema key round-trips via #[WireName]
     * @source truth/specs/model-generator.feature-260418.typ:139
     *
     * Given Model Contact declares a required property whose schema key is display-name (kebab-case)
     * When Generator emits Contact.php and the runtime Marshaller / Hydrator (ADR-010) process a payload containing the wire key display-name
     * Then Model's constructor parameter is emitted as $displayName (camelCased PHP identifier)
     *   And Model's property carries #[WireName('display-name')], and the class has no PROPERTY_MAP constant
     *   And Client's (new Hydrator())->hydrate(Contact::class, ['display-name' => 'Ada']) populates $contact->displayName === 'Ada'
     *   And Client's (new Marshaller())->marshal($contact) emits the key as display-name, not displayName
     */
    public function testAPropertyWithANonIdentifierSchemaKeyRoundTripsViaWireName(): void
    {
        $this->steps->givenModelContactDeclaresARequiredPropertyWhoseSchemaKeyIsDisplayNameKebabCase();
        $this->steps->whenGeneratorEmitsContactPhpAndTheRuntimeMarshallerHydratorADR010ProcessAPayloadContainingTheWireKeyDisplayName();
        $this->steps->thenModelsConstructorParameterIsEmittedAsDisplayNameCamelCasedPHPIdentifier();
        $this->steps->thenModelsPropertyCarriesWireNameDisplayNameAndTheClassHasNoPROPERTYMAPConstant();
        $this->steps->thenClientsNewHydratorHydrateContactClassDisplayNameAdaPopulatesContactDisplayNameAda();
        $this->steps->thenClientsNewMarshallerMarshalContactEmitsTheKeyAsDisplayNameNotDisplayName();
    }


    /**
     * Scenario: Generated Models carry no PROPERTY_MAP and do not implement JsonSerializable
     * @source truth/specs/model-generator.feature-260418.typ:151
     *
     * Given Model Order is emitted by Generator under ADR-010
     * When Generated File Generated/Model/Order.php is read
     * Then Generated File contains no PROPERTY_MAP class constant and no implements JsonSerializable
     *   And Model's class is final readonly with constructor-promoted properties only
     *   And Model's wire metadata (when needed) is carried by the small ADR-010 attribute set on each parameter
     */
    public function testGeneratedModelsCarryNoPROPERTYMAPAndDoNotImplementJsonSerializable(): void
    {
        $this->steps->givenModelOrderIsEmittedByGeneratorUnderADR010();
        $this->steps->whenGeneratedFileGeneratedModelOrderPhpIsRead();
        $this->steps->thenGeneratedFileContainsNoPROPERTYMAPClassConstantAndNoImplementsJsonSerializable();
        $this->steps->thenModelsClassIsFinalReadonlyWithConstructorPromotedPropertiesOnly();
        $this->steps->thenModelsWireMetadataWhenNeededIsCarriedByTheSmallADR010AttributeSetOnEachParameter();
    }


    /**
     * Scenario: A discriminated `oneOf` hydrates to the branch named by the wire tag via #[Discriminator]
     * @source truth/specs/model-generator.feature-260418.typ:162
     *
     * Given Model Pet declares a required property kind whose schema is oneOf: [$ref Dog, $ref Cat] with discriminator.propertyName: petType
     * When Generated File Pet.php is read and the runtime Hydrator (ADR-010) runs against a payload whose kind.petType is 'Cat'
     * Then Model's kind parameter carries #[Discriminator(field: 'petType', map: ['Dog' => Dog::class, 'Cat' => Cat::class])]
     *   And Model's $pet->kind is an instance of Cat, independent of structural overlap with Dog
     */
    public function testADiscriminatedOneOfHydratesToTheBranchNamedByTheWireTagViaDiscriminator(): void
    {
        $this->steps->givenModelPetDeclaresARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType();
        $this->steps->whenGeneratedFilePetPhpIsReadAndTheRuntimeHydratorADR010RunsAgainstAPayloadWhoseKindPetTypeIsWire('\'Cat\'');
        $this->steps->thenModelsKindParameterCarriesDiscriminatorFieldPetTypeMapDogDogClassCatCatClass();
        $this->steps->thenModelsPetKindIsAnInstanceOfCatIndependentOfStructuralOverlapWithDog();
    }


    /**
     * Scenario: Hydration recovers phpdoc types when opcache strips comments (ADR-010)
     * @source truth/specs/model-generator.feature-260418.typ:172
     *
     * Given Model Pet declares a property tags with phpdoc @param list<Tag>|null $tags
     *   And Client's PHP process is running under opcache.save_comments=0, so ReflectionMethod::getDocComment() returns false
     * When Client's (new Hydrator())->hydrate(Pet::class, ['tags' => [['id' => 1, 'name' => 'a']]]) runs
     * Then Client's runtime re-tokenises Pet.php via token_get_all, recovers the constructor's doc comment, and $pet->tags[0] is an instance of Tag — not a raw array
     */
    public function testHydrationRecoversPhpdocTypesWhenOpcacheStripsCommentsADR010(): void
    {
        $this->steps->givenModelPetDeclaresAPropertyTagsWithPhpdocParamListTagNullTags();
        $this->steps->givenClientsPHPProcessIsRunningUnderOpcacheSaveComments0SoReflectionMethodGetDocCommentReturnsFalse();
        $this->steps->whenClientsNewHydratorHydratePetClassTagsId1NameARuns();
        $this->steps->thenClientsRuntimeReTokenisesPetPhpViaTokenGetAllRecoversTheConstructorsDocCommentAndPetTags0IsAnInstanceOfTagNotARawArray();
    }


    /**
     * Rule: User bindings replace generated types
     *
     * Scenario: A property with a format that has a BindsFormat binding uses the user class
     * @source truth/specs/model-generator.feature-260418.typ:184
     *
     * Given Value Object App\\ValueObject\\Email is annotated with #[BindsFormat('email')]
     *   And Model has a required property contact: string with format: email
     * When Model is emitted
     * Then Model's property type in the generated constructor is \\App\\ValueObject\\Email, not string
     */
    public function testAPropertyWithAFormatThatHasABindsFormatBindingUsesTheUserClass(): void
    {
        $this->steps->givenValueObjectAppValueObjectEmailIsAnnotatedWithAttr('#[BindsFormat(\'email\')]');
        $this->steps->givenModelHasARequiredPropertyContactStringWithFormatEmail();
        $this->steps->whenModelIsEmitted();
        $this->steps->thenModelsPropertyTypeInTheGeneratedConstructorIsAppValueObjectEmailNotString();
    }


    /**
     * Scenario: A BindsFormat scalar value object round-trips through ScalarBinding
     * @source truth/specs/model-generator.feature-260418.typ:194
     *
     * Given Value Object App\\ValueObject\\Email is annotated with #[BindsFormat('email')] and implements ScalarBinding with a string $value
     *   And Model Contact declares a required property email with format: email
     * When json_encode($contact) runs against Model Contact whose email is an Email('team@example')
     * Then Model's emitted JSON contains "email":"team@example", not a nested object
     *   And (new Hydrator())->hydrate(Contact::class, ['email' => 'team@example', ...]) produces Model Contact whose email is an Email instance with $value === 'team@example'
     */
    public function testABindsFormatScalarValueObjectRoundTripsThroughScalarBinding(): void
    {
        $this->steps->givenValueObjectAppValueObjectEmailIsAnnotatedWithAttrAndImplementsScalarBindingWithAStringValue('#[BindsFormat(\'email\')]');
        $this->steps->givenModelContactDeclaresARequiredPropertyEmailWithFormatEmail();
        $this->steps->whenJsonEncodeContactRunsAgainstModelContactWhoseEmailIsAnEmailTeamExample();
        $this->steps->thenModelsEmittedJSONContainsEmailTeamExampleNotANestedObject();
        $this->steps->thenNewHydratorHydrateContactClassEmailTeamExampleProducesModelContactWhoseEmailIsAnEmailInstanceWithValueTeamExample();
    }


    /**
     * Scenario: A `format: date-time` property is emitted as DateTimeImmutable and round-trips through the wire string
     * @source truth/specs/model-generator.feature-260418.typ:205
     *
     * Given Model Order declares an optional property shipDate with type: string and format: date-time
     *   And no user binding for BindsFormat attribute #[BindsFormat('date-time')] is registered
     * When Model is emitted and the generated (new Hydrator())->hydrate(Order::class, ...) runs against a payload whose shipDate is '2026-04-18T12:34:56+00:00'
     * Then Model's constructor parameter is typed ?\\DateTimeImmutable
     *   And Model's hydrated Order::$shipDate is an instance of \\DateTimeImmutable whose timestamp matches the parsed RFC-3339 string
     *   And Client call json_encode($order) with that shipDate emits "shipDate":"2026-04-18T12:34:56+00:00" on the wire, not a nested object
     */
    public function testAFormatDateTimePropertyIsEmittedAsDateTimeImmutableAndRoundTripsThroughTheWireString(): void
    {
        $this->steps->givenModelOrderDeclaresAnOptionalPropertyShipDateWithTypeStringAndFormatDateTime();
        $this->steps->givenNoUserBindingForBindsFormatAttributeBindsFormatDateTimeIsRegistered();
        $this->steps->whenModelIsEmittedAndTheGeneratedNewHydratorHydrateOrderClassRunsAgainstAPayloadWhoseShipDateIsWire('\'2026-04-18T12:34:56+00:00\'');
        $this->steps->thenModelsConstructorParameterIsTypedDateTimeImmutable();
        $this->steps->thenModelsHydratedOrderShipDateIsAnInstanceOfDateTimeImmutableWhoseTimestampMatchesTheParsedRFC3339String();
        $this->steps->thenClientCallJsonEncodeOrderWithThatShipDateEmitsShipDate20260418T1234560000OnTheWireNotANestedObject();
    }


    /**
     * Rule: Component names are normalised through a configurable pipeline (ADR-003, T-023)
     *
     * Scenario: A kebab-case component name becomes a PascalCase PHP class under the default pipeline
     * @source truth/specs/model-generator.feature-260418.typ:219
     *
     * Given Schema declares a component named security-advisory-ecosystems
     *   And Profile does not override nameNormaliser
     * When Generator runs against Profile
     * Then Generated File Generated/Model/SecurityAdvisoryEcosystems.php is written
     *   And every other component of Schema that $refs #/components/schemas/security-advisory-ecosystems resolves to the same PHP class
     */
    public function testAKebabCaseComponentNameBecomesAPascalCasePHPClassUnderTheDefaultPipeline(): void
    {
        $this->steps->givenSchemaDeclaresAComponentNamedRaw('security-advisory-ecosystems');
        $this->steps->givenProfileDoesNotOverrideNameNormaliser();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelSecurityAdvisoryEcosystemsPhpIsWritten();
        $this->steps->thenEveryOtherComponentOfSchemaThatRefsComponentsSchemasSecurityAdvisoryEcosystemsResolvesToTheSamePHPClass();
    }


    /**
     * Scenario: An explicit `renames` entry takes precedence over the auto-sanitiser
     * @source truth/specs/model-generator.feature-260418.typ:232
     *
     * Given Schema declares a component named version-2
     *   And Profile sets 'version-2' => 'Legacy_V2'
     * When Generator runs against Profile
     * Then Generated File Generated/Model/Legacy_V2.php is written
     *   And Generated File Generated/Model/Version2.php is not written
     *   And every $ref to #/components/schemas/version-2 resolves to Model Legacy_V2
     */
    public function testAnExplicitRenamesEntryTakesPrecedenceOverTheAutoSanitiser(): void
    {
        $this->steps->givenSchemaDeclaresAComponentNamedRaw('version-2');
        $this->steps->givenProfileSetsRenames('\'version-2\' => \'Legacy_V2\'');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelLegacyV2PhpIsWritten();
        $this->steps->thenGeneratedFileGeneratedModelVersion2PhpIsNotWritten();
        $this->steps->thenEveryRefToComponentsSchemasVersion2ResolvesToModelLegacyV2();
    }


    /**
     * Scenario: A pattern-gated strategy only handles names matching its pattern and falls through otherwise
     * @source truth/specs/model-generator.feature-260418.typ:244
     *
     * Given Profile's nameNormaliser is CompositeNormaliser([LegacyUppercaser(pattern: /^legacy_/), PascalCaseSanitiser])
     *   And Schema declares components legacy_thing and modern-thing
     * When Generator runs against Profile
     * Then Schema's legacy_thing component is emitted as LEGACY_THING by the first strategy
     *   And Schema's modern-thing component falls through to PascalCaseSanitiser and is emitted as ModernThing
     */
    public function testAPatternGatedStrategyOnlyHandlesNamesMatchingItsPatternAndFallsThroughOtherwise(): void
    {
        $this->steps->givenProfilesNameNormaliserIsNormaliser('CompositeNormaliser([LegacyUppercaser(pattern: /^legacy_/), PascalCaseSanitiser])');
        $this->steps->givenSchemaDeclaresComponentsFirstAndSecond('legacy_thing', 'modern-thing');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenSchemasLegacyThingComponentIsEmittedAsLEGACYTHINGByTheFirstStrategy();
        $this->steps->thenSchemasModernThingComponentFallsThroughToPascalCaseSanitiserAndIsEmittedAsModernThing();
    }


    /**
     * Scenario: A custom pipeline that returns null for every name aborts with a pointed diagnostic
     * @source truth/specs/model-generator.feature-260418.typ:257
     *
     * Given Profile's nameNormaliser is an empty CompositeNormaliser (no strategies)
     *   And Schema declares any component, e.g. anything
     * When Generator runs against Profile
     * Then Generator's run aborts with an error naming anything and pointing at the empty normaliser pipeline
     *   And no files are written under Profile's output
     */
    public function testACustomPipelineThatReturnsNullForEveryNameAbortsWithAPointedDiagnostic(): void
    {
        $this->steps->givenProfilesNameNormaliserIsAnEmptyCompositeNormaliserNoStrategies();
        $this->steps->givenSchemaDeclaresAnyComponentEGRaw('anything');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratorsRunAbortsWithAnErrorNamingAnythingAndPointingAtTheEmptyNormaliserPipeline();
        $this->steps->thenNoFilesAreWrittenUnderProfilesOutput();
    }


    /**
     * Scenario: Two raw component names that normalise to the same PHP class abort the run
     * @source truth/specs/model-generator.feature-260418.typ:268
     *
     * Given Schema declares components named foo-bar and foo_bar
     *   And Profile does not override nameNormaliser
     * When Generator runs against Profile
     * Then Generator's run aborts with an error naming both raw keys and the shared PHP class FooBar
     *   And no files are written under Profile's output
     */
    public function testTwoRawComponentNamesThatNormaliseToTheSamePHPClassAbortTheRun(): void
    {
        $this->steps->givenSchemaDeclaresComponentsNamedFirstAndSecond('foo-bar', 'foo_bar');
        $this->steps->givenProfileDoesNotOverrideNameNormaliser();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratorsRunAbortsWithAnErrorNamingBothRawKeysAndTheSharedPHPClassFooBar();
        $this->steps->thenNoFilesAreWrittenUnderProfilesOutput();
    }


    /**
     * Rule: Top-level components beyond `type: object` (T-026)
     *
     * Scenario: A scalar component emits a `ScalarBinding` VO that round-trips the raw scalar
     * @source truth/specs/model-generator.feature-260418.typ:281
     *
     * Given Schema declares a component urn with string (no enum, no properties)
     * When Generator runs against Profile
     * Then Generated File Generated/Model/Urn.php is written whose class is final readonly class Urn implements ScalarBinding
     *   And Model's constructor has a single promoted public string $value and the class emits matching fromScalar() / toScalar() methods
     *   And a sibling Model that $refs #/components/schemas/urn uses \Generated\Model\Urn as the property type and (new Marshaller())->marshal($model) emits the property as a plain string, not a nested object
     */
    public function testAScalarComponentEmitsAScalarBindingVOThatRoundTripsTheRawScalar(): void
    {
        $this->steps->givenSchemaDeclaresAComponentRawWithTypeNoEnumNoProperties('urn', 'string');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelUrnPhpIsWrittenWhoseClassIsFinalReadonlyClassUrnImplementsScalarBinding();
        $this->steps->thenModelsConstructorHasASinglePromotedPublicStringValueAndTheClassEmitsMatchingFromScalarToScalarMethods();
        $this->steps->thenSiblingModelThatRefsComponentsSchemasUrnUsesGeneratedModelUrnAsThePropertyTypeAndNewMarshallerMarshalModelEmitsThePropertyAsAPlainStringNotANestedObject();
    }


    /**
     * Scenario: A top-level `oneOf` with inline object branches emits an interface and one Model per branch
     * @source truth/specs/model-generator.feature-260418.typ:292
     *
     * Given Schema declares a component floating_ip_create whose schema is oneOf: [<inline object A with title "Assign to Droplet">, <inline object B with title "Reserve to Region">]
     * When Generator runs against Profile
     * Then Generated File Generated/Model/FloatingIpCreate.php is an empty interface
     *   And Both Model files Generated/Model/FloatingIpCreateAssignToDroplet.php and Generated/Model/FloatingIpCreateReserveToRegion.php are final readonly classes that implements FloatingIpCreate
     *   And Operation that references floating_ip_create as a request body types a method parameter FloatingIpCreate $body
     */
    public function testATopLevelOneOfWithInlineObjectBranchesEmitsAnInterfaceAndOneModelPerBranch(): void
    {
        $this->steps->givenSchemaDeclaresAComponentRawWhoseSchemaIsOneOfInlineObjectAWithTitleAssignToDropletInlineObjectBWithTitleReserveToRegion('floating_ip_create');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelFloatingIpCreatePhpIsAnEmptyInterface();
        $this->steps->thenBothModelFilesGeneratedModelFloatingIpCreateAssignToDropletPhpAndGeneratedModelFloatingIpCreateReserveToRegionPhpAreFinalReadonlyClassesThatImplementsFloatingIpCreate();
        $this->steps->thenOperationThatReferencesFloatingIpCreateAsARequestBodyTypesAMethodParameterFloatingIpCreateBody();
    }


    /**
     * Scenario: A top-level `oneOf` with `$ref` branches marks the branch Models as `implements <Interface>`
     * @source truth/specs/model-generator.feature-260418.typ:303
     *
     * Given Schema declares components LabeledIssueEvent and UnlabeledIssueEvent (both type: object) and a component issue_event_for_issue whose schema is anyOf: [$ref LabeledIssueEvent, $ref UnlabeledIssueEvent]
     * When Generator runs against Profile
     * Then Generated File Generated/Model/IssueEventForIssue.php is an empty interface
     *   And Both Model files LabeledIssueEvent.php and UnlabeledIssueEvent.php declare implements IssueEventForIssue in their class headers
     */
    public function testATopLevelOneOfWithRefBranchesMarksTheBranchModelsAsImplementsInterface(): void
    {
        $this->steps->givenSchemaDeclaresComponentsLabeledIssueEventAndUnlabeledIssueEventBothTypeObjectAndAComponentRawWhoseSchemaIsAnyOfRefLabeledIssueEventRefUnlabeledIssueEvent('issue_event_for_issue');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelIssueEventForIssuePhpIsAnEmptyInterface();
        $this->steps->thenBothModelFilesLabeledIssueEventPhpAndUnlabeledIssueEventPhpDeclareImplementsIssueEventForIssueInTheirClassHeaders();
    }


    /**
     * Scenario: A top-level `type: array` component emits a typed wrapper class
     * @source truth/specs/model-generator.feature-260418.typ:313
     *
     * Given Schema declares a component tags_array whose schema is type: array, items.type: string
     * When Generator runs against Profile
     * Then Generated File Generated/Model/TagsArray.php is written whose class is final readonly class TagsArray
     *   And Model's constructor has a single promoted public array $items with phpdoc @param list<string> $items
     */
    public function testATopLevelTypeArrayComponentEmitsATypedWrapperClass(): void
    {
        $this->steps->givenSchemaDeclaresAComponentRawWhoseSchemaIsTypeArrayItemsTypeString('tags_array');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelTagsArrayPhpIsWrittenWhoseClassIsFinalReadonlyClassTagsArray();
        $this->steps->thenModelsConstructorHasASinglePromotedPublicArrayItemsWithPhpdocParamListStringItems();
    }


    /**
     * Rule: Payloads the document declared inline become models too (inline-body-and-response-schemas)
     *
     * Scenario: A document declaring no components still emits a model for every payload
     * @source truth/specs/model-generator.feature-260418.typ:325
     *
     * Given Schema declares an empty components.schemas and Operation placeOrder whose application/json request body and 2xx response are each an inline type: object with declared properties
     * When Generator runs against Profile
     * Then Generated File Generated/Model/PlaceOrderRequest.php and Generated File Generated/Model/PlaceOrderResponse.php are both written
     *   And the emitted Client declares placeOrder(PlaceOrderRequest $body): PlaceOrderResponse
     *   And Operation is not reported as a skip
     */
    public function testADocumentDeclaringNoComponentsStillEmitsAModelForEveryPayload(): void
    {
        $this->steps->givenSchemaDeclaresAnEmptyComponentsSchemasAndOperationIdWhoseApplicationJsonRequestBodyAnd2xxResponseAreEachAnInlineTypeObjectWithDeclaredProperties('placeOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelPlaceOrderRequestPhpAndGeneratedFileGeneratedModelPlaceOrderResponsePhpAreBothWritten();
        $this->steps->thenEmittedClientDeclaresPlaceOrderPlaceOrderRequestBodyPlaceOrderResponse();
        $this->steps->thenOperationIsNotReportedAsASkip();
    }


    /**
     * Scenario: An inline array of inline objects is typed at both ends
     * @source truth/specs/model-generator.feature-260418.typ:336
     *
     * Given Operation placeOrdersBulk whose request body and 2xx response are each type: array whose items is an inline type: object with declared properties
     * When Generator runs against Profile
     * Then Generated File Generated/Model/PlaceOrdersBulkRequestItem.php and Generated File Generated/Model/PlaceOrdersBulkResponseItem.php are written for the item shapes
     *   And the emitted Client types the parameter list<PlaceOrdersBulkRequestItem> and the return list<PlaceOrdersBulkResponseItem> in phpdoc
     */
    public function testAnInlineArrayOfInlineObjectsIsTypedAtBothEnds(): void
    {
        $this->steps->givenOperationIdWhoseRequestBodyAnd2xxResponseAreEachTypeArrayWhoseItemsIsAnInlineTypeObjectWithDeclaredProperties('placeOrdersBulk');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelPlaceOrdersBulkRequestItemPhpAndGeneratedFileGeneratedModelPlaceOrdersBulkResponseItemPhpAreWrittenForTheItemShapes();
        $this->steps->thenEmittedClientTypesTheParameterListPlaceOrdersBulkRequestItemAndTheReturnListPlaceOrdersBulkResponseItemInPhpdoc();
    }


    /**
     * Scenario: Nesting below a synthesised payload is reached by the same queue as nesting below a component
     * @source truth/specs/model-generator.feature-260418.typ:346
     *
     * Given Operation placeOrder whose inline response carries an inline object property shipping and an array property lines whose items are an inline object
     * When Generator runs against Profile
     * Then Generated File Generated/Model/PlaceOrderResponseShipping.php and Generated File Generated/Model/PlaceOrderResponseLinesItem.php are written
     *   And Model two properties are typed as those classes rather than array<string, mixed>
     */
    public function testNestingBelowASynthesisedPayloadIsReachedByTheSameQueueAsNestingBelowAComponent(): void
    {
        $this->steps->givenOperationIdWhoseInlineResponseCarriesAnInlineObjectPropertyShippingAndAnArrayPropertyLinesWhoseItemsAreAnInlineObject('placeOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelPlaceOrderResponseShippingPhpAndGeneratedFileGeneratedModelPlaceOrderResponseLinesItemPhpAreWritten();
        $this->steps->thenModelTwoPropertiesAreTypedAsThoseClassesRatherThanArrayStringMixed();
    }


    /**
     * Scenario: An inline enum inside a payload becomes a backed enum, wherever the payload came from
     * @source truth/specs/model-generator.feature-260418.typ:356
     *
     * Given Operation placeOrder whose inline request body has a property channel with type: string and enum: [web, phone, store]
     * When Generator runs against Profile
     * Then Generated File Generated/Enum/PlaceOrderRequestChannel.php is a backed enum with those three cases
     *   And Model nested inside a named component resolves an identical inline enum the same way, so the reading does not depend on where the property was declared
     */
    public function testAnInlineEnumInsideAPayloadBecomesABackedEnumWhereverThePayloadCameFrom(): void
    {
        $this->steps->givenOperationIdWhoseInlineRequestBodyHasAPropertyChannelWithTypeStringAndCases('placeOrder', 'enum: [web, phone, store]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedEnumPlaceOrderRequestChannelPhpIsABackedEnumWithThoseThreeCases();
        $this->steps->thenModelNestedInsideANamedComponentResolvesAnIdenticalInlineEnumTheSameWaySoTheReadingDoesNotDependOnWhereThePropertyWasDeclared();
    }


    /**
     * Scenario: An inline object the document left unconstrained is passed as a map rather than dropping the operation
     * @source truth/specs/model-generator.feature-260418.typ:366
     *
     * Given Operation ping whose application/json request body is type: object with no declared properties and no additionalProperties
     * When Generator runs against Profile
     * Then the emitted Client declares ping(array $body): void with phpdoc @param array<string, mixed> $body
     *   And Operation is not reported as a skip, because a map is what Schema said rather than a shape Generator could not represent
     */
    public function testAnInlineObjectTheDocumentLeftUnconstrainedIsPassedAsAMapRatherThanDroppingTheOperation(): void
    {
        $this->steps->givenOperationIdWhoseApplicationJsonRequestBodyIsTypeObjectWithNoDeclaredPropertiesAndNoAdditionalProperties('ping');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEmittedClientDeclaresPingArrayBodyVoidWithPhpdocParamArrayStringMixedBody();
        $this->steps->thenOperationIsNotReportedAsASkipBecauseAMapIsWhatSchemaSaidRatherThanAShapeGeneratorCouldNotRepresent();
    }


    /**
     * Scenario: The profile pins the class name for a synthesised payload
     * @source truth/specs/model-generator.feature-260418.typ:376
     *
     * Given Profile whose inlineModels map carries 'placeOrder.response' => 'PlacedOrder'
     * When Generator runs against Profile
     * Then Generated File Generated/Model/PlacedOrder.php is written and no PlaceOrderResponse.php is
     *   And the pin renames the root alone, so Model nested under it is emitted as PlacedOrderShipping
     */
    public function testTheProfilePinsTheClassNameForASynthesisedPayload(): void
    {
        $this->steps->givenProfileWhoseInlineModelsMapCarriesPin('\'placeOrder.response\' => \'PlacedOrder\'');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedFileGeneratedModelPlacedOrderPhpIsWrittenAndNoPlaceOrderResponsePhpIs();
        $this->steps->thenPinRenamesTheRootAloneSoModelNestedUnderItIsEmittedAsPlacedOrderShipping();
    }


    /**
     * Scenario: A pin naming an operation absent from the document fails the run
     * @source truth/specs/model-generator.feature-260418.typ:386
     *
     * Given Profile whose inlineModels map carries a key 'noSuchOperation.response'
     * When Generator runs against Profile
     * Then the run fails naming the key and saying the operation id is absent from Schema
     *   And no Generated File is written, so guidance that has outlived Operation it named cannot pass unnoticed
     */
    public function testAPinNamingAnOperationAbsentFromTheDocumentFailsTheRun(): void
    {
        $this->steps->givenProfileWhoseInlineModelsMapCarriesAKeyNoSuchOperationResponse();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenRunFailsNamingTheKeyAndSayingTheOperationIdIsAbsentFromSchema();
        $this->steps->thenNoGeneratedFileIsWrittenSoGuidanceThatHasOutlivedOperationItNamedCannotPassUnnoticed();
    }


    /**
     * Scenario: Two shapes deriving one class name fail the run rather than overwriting a file
     * @source truth/specs/model-generator.feature-260418.typ:396
     *
     * Given Schema declares a component named PlaceOrderResponse and Operation placeOrder whose inline response derives that same name
     * When Generator runs against Profile
     * Then the run fails naming Model and both origins — the component name, and the JSON pointer of the inline response
     *   And the message names Profile key that resolves it, so the reader is not left to guess which knob applies
     */
    public function testTwoShapesDerivingOneClassNameFailTheRunRatherThanOverwritingAFile(): void
    {
        $this->steps->givenSchemaDeclaresAComponentNamedPlaceOrderResponseAndOperationIdWhoseInlineResponseDerivesThatSameName('placeOrder');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenRunFailsNamingModelAndBothOriginsTheComponentNameAndTheJSONPointerOfTheInlineResponse();
        $this->steps->thenMessageNamesProfileKeyThatResolvesItSoTheReaderIsNotLeftToGuessWhichKnobApplies();
    }


    /**
     * Rule: Re-running the generator is byte-stable
     *
     * Scenario: Running the generator twice with the same inputs produces identical files
     * @source truth/specs/model-generator.feature-260418.typ:408
     *
     * Given Generator has run once and produced Generated File tree
     * When Generator runs again with the same Schema and Profile
     * Then every file under Profile's output is byte-for-byte identical to the previous run
     */
    public function testRunningTheGeneratorTwiceWithTheSameInputsProducesIdenticalFiles(): void
    {
        $this->steps->givenGeneratorHasRunOnceAndProducedGeneratedFileTree();
        $this->steps->whenGeneratorRunsAgainWithTheSameSchemaAndProfile();
        $this->steps->thenEveryFileUnderProfilesOutputIsByteForByteIdenticalToThePreviousRun();
    }


    /**
     * Scenario: A component removed from the schema is pruned from Generated/ on the next run
     * @source truth/specs/model-generator.feature-260418.typ:417
     *
     * Given Generator has produced Generated/Model/Pet.php from a prior schema that declared a Pet component
     * When Generator runs again with a schema from which the Pet component has been removed
     * Then Generated File Generated/Model/Pet.php is no longer on disk
     *   And files placed alongside Generated/ under Profile's output directory remain untouched
     */
    public function testAComponentRemovedFromTheSchemaIsPrunedFromGeneratedOnTheNextRun(): void
    {
        $this->steps->givenGeneratorHasProducedGeneratedModelPetPhpFromAPriorSchemaThatDeclaredAPetComponent();
        $this->steps->whenGeneratorRunsAgainWithASchemaFromWhichThePetComponentHasBeenRemoved();
        $this->steps->thenGeneratedFileGeneratedModelPetPhpIsNoLongerOnDisk();
        $this->steps->thenFilesPlacedAlongsideGeneratedUnderProfilesOutputDirectoryRemainUntouched();
    }


    /**
     * Rule: Every emitted file declares itself generated
     *
     * Scenario: An emitted file opens with a header naming the profile and the command that reproduces it
     * @source truth/specs/model-generator.feature-260418.typ:429
     *
     * Given Profile was loaded from tests/fixtures/profiles/petstore.php
     * When Generator runs against Profile
     * Then every Generated File written opens with a comment saying it was generated by paogen and must not be edited by hand
     *   And that comment names Profile as tests/fixtures/profiles/petstore.php
     *   And that comment prints the command that reproduces Generated File: paogen generate tests/fixtures/profiles/petstore.php
     */
    public function testAnEmittedFileOpensWithAHeaderNamingTheProfileAndTheCommandThatReproducesIt(): void
    {
        $this->steps->givenProfileWasLoadedFromTestsFixturesProfilesPetstorePhp();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenEveryGeneratedFileWrittenOpensWithACommentSayingItWasGeneratedByPaogenAndMustNotBeEditedByHand();
        $this->steps->thenThatCommentNamesProfileAsTestsFixturesProfilesPetstorePhp();
        $this->steps->thenThatCommentPrintsTheCommandThatReproducesGeneratedFilePaogenGenerateTestsFixturesProfilesPetstorePhp();
    }


    /**
     * Scenario: The header carries nothing that moves between runs
     * @source truth/specs/model-generator.feature-260418.typ:440
     *
     * Given Generator has run once and produced Generated File tree
     * When Generator runs again over same Schema and same Profile
     * Then every Generated File's header is byte-identical to the previous run's
     *   And nothing in Generated File's header is a timestamp, a version, or an absolute path
     */
    public function testTheHeaderCarriesNothingThatMovesBetweenRuns(): void
    {
        $this->steps->givenGeneratorHasRunOnceAndProducedGeneratedFileTree();
        $this->steps->whenGeneratorRunsAgainOverSameSchemaAndSameProfile();
        $this->steps->thenEveryGeneratedFilesHeaderIsByteIdenticalToThePreviousRuns();
        $this->steps->thenNothingInGeneratedFilesHeaderIsATimestampAVersionOrAnAbsolutePath();
    }


    /**
     * Scenario: Regenerating over an existing tree replaces it rather than failing on it
     * @source truth/specs/model-generator.feature-260418.typ:450
     *
     * Given Generator has already written Generated File tree into Profile's output
     * When Generator runs a second time into same Profile's output
     * Then the second run overwrites every Generated File and reports no error
     *   And Generated File tree on disk is byte-identical to the tree the first run left
     */
    public function testRegeneratingOverAnExistingTreeReplacesItRatherThanFailingOnIt(): void
    {
        $this->steps->givenGeneratorHasAlreadyWrittenGeneratedFileTreeIntoProfilesOutput();
        $this->steps->whenGeneratorRunsASecondTimeIntoSameProfilesOutput();
        $this->steps->thenSecondRunOverwritesEveryGeneratedFileAndReportsNoError();
        $this->steps->thenGeneratedFileTreeOnDiskIsByteIdenticalToTheTreeTheFirstRunLeft();
    }
}
