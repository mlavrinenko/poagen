<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: Model Generator
 *
 * Walks Schema's components.schemas and emits one Model per entry. Property types follow OpenAPI scalar semantics; $ref becomes a typed reference to the target Model #[BindsFormat] from the user side overrides the property type with Value Object.
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
     * @source truth/specs/model-generator.typ:27
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
        $this->steps->thenAFileGeneratedModelPetPhpIsWrittenUnderProfilesOutput();
        $this->steps->thenTheEmittedClassIsFinalReadonlyInProfilesNamespaceGeneratedModel();
    }


    /**
     * Scenario: Property types follow OpenAPI scalars and required-ness
     * @source truth/specs/model-generator.typ:38
     *
     * Given Model with required id: integer and optional name: string
     * When the model is emitted
     * Then the constructor has a promoted int $id parameter
     *   And the constructor has a promoted ?string $name = null parameter
     */
    public function testPropertyTypesFollowOpenAPIScalarsAndRequiredNess(): void
    {
        $this->steps->givenModelWithRequiredPropAndOptionalProp('id: integer', 'name: string');
        $this->steps->whenTheModelIsEmitted();
        $this->steps->thenTheConstructorHasAPromotedIntIdParameter();
        $this->steps->thenTheConstructorHasAPromotedStringNameNullParameter();
    }


    /**
     * Scenario: A `$ref` to another component becomes a typed property of that class
     * @source truth/specs/model-generator.typ:48
     *
     * Given Model Order has a required property pet that $ref #/components/schemas/Pet
     * When the model is emitted
     * Then Order has a promoted constructor parameter typed as Pet
     */
    public function testARefToAnotherComponentBecomesATypedPropertyOfThatClass(): void
    {
        $this->steps->givenModelParentHasARequiredPropertyPetThatRefTarget('Order', '$ref', '#/components/schemas/Pet');
        $this->steps->whenTheModelIsEmitted();
        $this->steps->thenOrderHasAPromotedConstructorParameterTypedAsPet();
    }


    /**
     * Scenario: An inline nested object schema becomes a synthesised typed class
     * @source truth/specs/model-generator.typ:57
     *
     * Given Model Pet declares an inline property shipping with type: object and nested properties address: string, zip: string
     * When the model is emitted
     * Then a class Generated/Model/PetShipping.php is written
     *   And Pet has a promoted constructor parameter PetShipping $shipping
     *   And the property is not typed array<string, mixed>
     */
    public function testAnInlineNestedObjectSchemaBecomesASynthesisedTypedClass(): void
    {
        $this->steps->givenModelParentDeclaresAnInlinePropertyShippingWithTypeObjectAndNestedPropertiesProps('Pet', 'address: string, zip: string');
        $this->steps->whenTheModelIsEmitted();
        $this->steps->thenAClassGeneratedModelPetShippingPhpIsWritten();
        $this->steps->thenPetHasAPromotedConstructorParameterPetShippingShipping();
        $this->steps->thenThePropertyIsNotTypedArrayStringMixed();
    }


    /**
     * Scenario: A schema with enum values becomes a PHP 8.1 backed enum
     * @source truth/specs/model-generator.typ:74
     *
     * Given Schema declares a named component Status with type: string and [placed, approved, delivered]
     * When Generator runs against Profile
     * Then a file Generated/Enum/Status.php is written
     *   And the emitted enum is enum Status: string with one PascalCased case per declared value
     *   And Model that references #/components/schemas/Status is typed with the enum, not string
     */
    public function testASchemaWithEnumValuesBecomesAPHP81BackedEnum(): void
    {
        $this->steps->givenSchemaDeclaresANamedComponentStatusWithTypeStringAndEnum('[placed, approved, delivered]');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedEnumStatusPhpIsWritten();
        $this->steps->thenTheEmittedEnumIsEnumStatusStringWithOnePascalCasedCasePerDeclaredValue();
        $this->steps->thenModelThatReferencesComponentsSchemasStatusIsTypedWithTheEnumNotString();
    }


    /**
     * Scenario: A `oneOf` of `$ref`-ed components becomes a PHP union type
     * @source truth/specs/model-generator.typ:91
     *
     * Given Schema declares components Dog and Cat and Model Animal with a required property creature whose schema is oneOf: [$ref Dog, $ref Cat] with no discriminator
     * When the model is emitted and ApiClient::hydrate(Animal::class, $data) runs against a payload whose creature structurally matches the Dog branch
     * Then Animal has a promoted constructor parameter typed Dog|Cat
     *   And $animal->creature is an instance of Dog, not Cat
     */
    public function testAOneOfOfRefEdComponentsBecomesAPHPUnionType(): void
    {
        $this->steps->givenSchemaDeclaresComponentsDogAndCatAndModelAnimalWithARequiredPropertyCreatureWhoseSchemaIsOneOfRefDogRefCatWithNoDiscriminator();
        $this->steps->whenTheModelIsEmittedAndApiClientHydrateAnimalClassDataRunsAgainstAPayloadWhoseCreatureStructurallyMatchesTheDogBranch();
        $this->steps->thenAnimalHasAPromotedConstructorParameterTypedDogCat();
        $this->steps->thenAnimalCreatureIsAnInstanceOfDogNotCat();
    }


    /**
     * Scenario: A `oneOf` with a `discriminator.propertyName` picks the branch by wire value
     * @source truth/specs/model-generator.typ:105
     *
     * Given Schema declares components Dog and Cat and Model Pet with a required property kind whose schema is oneOf: [$ref Dog, $ref Cat] with discriminator.propertyName: petType
     * When ApiClient::hydrate(Pet::class, $data) runs against a payload whose kind.petType is 'Cat'
     * Then $pet->kind is an instance of Cat, independent of whether the payload's keys structurally match Dog
     */
    public function testAOneOfWithADiscriminatorPropertyNamePicksTheBranchByWireValue(): void
    {
        $this->steps->givenSchemaDeclaresComponentsDogAndCatAndModelPetWithARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType();
        $this->steps->whenApiclientHydratePetClassDataRunsAgainstAPayloadWhoseKindPetTypeIsWire('\'Cat\'');
        $this->steps->thenPetKindIsAnInstanceOfCatIndependentOfWhetherThePayloadsKeysStructurallyMatchDog();
    }


    /**
     * Scenario: An `allOf` that merges two object schemas becomes a single Model with the union of properties
     * @source truth/specs/model-generator.typ:118
     *
     * Given Schema declares components BaseThing (required id: integer) and ExtraThing (required label: string) and Model MergedThing whose schema is allOf: [$ref BaseThing, $ref ExtraThing]
     * When Generator runs against Profile
     * Then a file Generated/Model/MergedThing.php is written
     *   And MergedThing has promoted constructor parameters int $id and string $label
     */
    public function testAnAllOfThatMergesTwoObjectSchemasBecomesASingleModelWithTheUnionOfProperties(): void
    {
        $this->steps->givenSchemaDeclaresComponentsBaseThingRequiredIdIntegerAndExtraThingRequiredLabelStringAndModelMergedThingWhoseSchemaIsAllOfRefBaseThingRefExtraThing();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedModelMergedThingPhpIsWritten();
        $this->steps->thenMergedthingHasPromotedConstructorParametersIntIdAndStringLabel();
    }


    /**
     * Rule: Hydration and serialization contract (ADR-010)
     *
     * Scenario: A list-of-Model property hydrates each item into the declared class
     * @source truth/specs/model-generator.typ:134
     *
     * Given Model Pet has a property tags whose schema is type: array, items.$ref: #/components/schemas/Tag
     * When the runtime Hydrator (ADR-010) runs against a payload whose tags is a list of two objects
     * Then $pet->tags[0] is an instance of Tag
     *   And $pet->tags[1] is an instance of Tag
     */
    public function testAListOfModelPropertyHydratesEachItemIntoTheDeclaredClass(): void
    {
        $this->steps->givenModelPetHasAPropertyTagsWhoseSchemaIsTypeArrayItemsRefComponentsSchemasTag();
        $this->steps->whenTheRuntimeHydratorADR010RunsAgainstAPayloadWhoseTagsIsAListOfTwoObjects();
        $this->steps->thenPetTags0IsAnInstanceOfTag();
        $this->steps->thenPetTags1IsAnInstanceOfTag();
    }


    /**
     * Scenario: A list-of-scalar property hydrates items untouched
     * @source truth/specs/model-generator.typ:148
     *
     * Given Model Pet has a property photoUrls whose schema is type: array, items.type: string
     * When the runtime Hydrator (ADR-010) runs against a payload whose photoUrls is a list of plain strings
     * Then each $pet->photoUrls[$i] is the original string — no object wrapping
     */
    public function testAListOfScalarPropertyHydratesItemsUntouched(): void
    {
        $this->steps->givenModelPetHasAPropertyPhotoUrlsWhoseSchemaIsTypeArrayItemsTypeString();
        $this->steps->whenTheRuntimeHydratorADR010RunsAgainstAPayloadWhosePhotoUrlsIsAListOfPlainStrings();
        $this->steps->thenEachPetPhotoUrlsIIsTheOriginalStringNoObjectWrapping();
    }


    /**
     * Scenario: A property with a non-identifier schema key round-trips via #[WireName]
     * @source truth/specs/model-generator.typ:157
     *
     * Given Model Contact declares a required property whose schema key is display-name (kebab-case)
     * When the generator emits Contact.php and the runtime Marshaller / Hydrator (ADR-010) process a payload containing the wire key display-name
     * Then the constructor parameter is emitted as $displayName (camelCased PHP identifier)
     *   And the property carries #[WireName('display-name')], and the class has no PROPERTY_MAP constant
     *   And (new Hydrator())->hydrate(Contact::class, ['display-name' => 'Ada']) populates $contact->displayName === 'Ada'
     *   And (new Marshaller())->marshal($contact) emits the key as display-name, not displayName
     */
    public function testAPropertyWithANonIdentifierSchemaKeyRoundTripsViaWireName(): void
    {
        $this->steps->givenModelContactDeclaresARequiredPropertyWhoseSchemaKeyIsDisplayNameKebabCase();
        $this->steps->whenTheGeneratorEmitsContactPhpAndTheRuntimeMarshallerHydratorADR010ProcessAPayloadContainingTheWireKeyDisplayName();
        $this->steps->thenTheConstructorParameterIsEmittedAsDisplayNameCamelCasedPHPIdentifier();
        $this->steps->thenThePropertyCarriesWireNameDisplayNameAndTheClassHasNoPROPERTYMAPConstant();
        $this->steps->thenNewHydratorHydrateContactClassDisplayNameAdaPopulatesContactDisplayNameAda();
        $this->steps->thenNewMarshallerMarshalContactEmitsTheKeyAsDisplayNameNotDisplayName();
    }


    /**
     * Scenario: Generated Models carry no PROPERTY_MAP and do not implement JsonSerializable
     * @source truth/specs/model-generator.typ:173
     *
     * Given Model Order is emitted by Generator under ADR-010
     * When Generated/Model/Order.php is read
     * Then the file contains no PROPERTY_MAP class constant and no implements JsonSerializable
     *   And the class is final readonly with constructor-promoted properties only
     *   And wire metadata (when needed) is carried by the small ADR-010 attribute set on each parameter
     */
    public function testGeneratedModelsCarryNoPROPERTYMAPAndDoNotImplementJsonSerializable(): void
    {
        $this->steps->givenModelOrderIsEmittedByGeneratorUnderADR010();
        $this->steps->whenGeneratedModelOrderPhpIsRead();
        $this->steps->thenTheFileContainsNoPROPERTYMAPClassConstantAndNoImplementsJsonSerializable();
        $this->steps->thenTheClassIsFinalReadonlyWithConstructorPromotedPropertiesOnly();
        $this->steps->thenWireMetadataWhenNeededIsCarriedByTheSmallADR010AttributeSetOnEachParameter();
    }


    /**
     * Scenario: A discriminated `oneOf` hydrates to the branch named by the wire tag via #[Discriminator]
     * @source truth/specs/model-generator.typ:190
     *
     * Given Model Pet declares a required property kind whose schema is oneOf: [$ref Dog, $ref Cat] with discriminator.propertyName: petType
     * When the generated Pet.php is read and the runtime Hydrator (ADR-010) runs against a payload whose kind.petType is 'Cat'
     * Then the kind parameter carries #[Discriminator(field: 'petType', map: ['Dog' => Dog::class, 'Cat' => Cat::class])]
     *   And $pet->kind is an instance of Cat, independent of structural overlap with Dog
     */
    public function testADiscriminatedOneOfHydratesToTheBranchNamedByTheWireTagViaDiscriminator(): void
    {
        $this->steps->givenModelPetDeclaresARequiredPropertyKindWhoseSchemaIsOneOfRefDogRefCatWithDiscriminatorPropertyNamePetType();
        $this->steps->whenTheGeneratedPetPhpIsReadAndTheRuntimeHydratorADR010RunsAgainstAPayloadWhoseKindPetTypeIsWire('\'Cat\'');
        $this->steps->thenTheKindParameterCarriesDiscriminatorFieldPetTypeMapDogDogClassCatCatClass();
        $this->steps->thenPetKindIsAnInstanceOfCatIndependentOfStructuralOverlapWithDog();
    }


    /**
     * Scenario: Hydration recovers phpdoc types when opcache strips comments (ADR-010)
     * @source truth/specs/model-generator.typ:201
     *
     * Given Model Pet declares a property tags with phpdoc @param list<Tag>|null $tags
     *   And PHP is running under opcache.save_comments=0, so ReflectionMethod::getDocComment() returns false
     * When (new Hydrator())->hydrate(Pet::class, ['tags' => [['id' => 1, 'name' => 'a']]]) runs
     * Then the runtime re-tokenises Pet.php via token_get_all, recovers the constructor's doc comment, and $pet->tags[0] is an instance of Tag — not a raw array
     */
    public function testHydrationRecoversPhpdocTypesWhenOpcacheStripsCommentsADR010(): void
    {
        $this->steps->givenModelPetDeclaresAPropertyTagsWithPhpdocParamListTagNullTags();
        $this->steps->givenPhpIsRunningUnderOpcacheSaveComments0SoReflectionMethodGetDocCommentReturnsFalse();
        $this->steps->whenNewHydratorHydratePetClassTagsId1NameARuns();
        $this->steps->thenTheRuntimeReTokenisesPetPhpViaTokenGetAllRecoversTheConstructorsDocCommentAndPetTags0IsAnInstanceOfTagNotARawArray();
    }


    /**
     * Rule: User bindings replace generated types
     *
     * Scenario: A property with a format that has a BindsFormat binding uses the user class
     * @source truth/specs/model-generator.typ:214
     *
     * Given Value Object App\\ValueObject\\Email is annotated with #[BindsFormat('email')]
     *   And Model has a required property contact: string with format: email
     * When the model is emitted
     * Then the property type in the generated constructor is \\App\\ValueObject\\Email, not string
     */
    public function testAPropertyWithAFormatThatHasABindsFormatBindingUsesTheUserClass(): void
    {
        $this->steps->givenValueObjectAppValueObjectEmailIsAnnotatedWithAttr('#[BindsFormat(\'email\')]');
        $this->steps->givenModelHasARequiredPropertyContactStringWithFormatEmail();
        $this->steps->whenTheModelIsEmitted();
        $this->steps->thenThePropertyTypeInTheGeneratedConstructorIsAppValueObjectEmailNotString();
    }


    /**
     * Scenario: A BindsFormat scalar value object round-trips through ScalarBinding
     * @source truth/specs/model-generator.typ:225
     *
     * Given Value Object App\\ValueObject\\Email is annotated with #[BindsFormat('email')] and implements ScalarBinding with a string $value
     *   And Model Contact declares a required property email with format: email
     * When json_encode($contact) runs against a Contact whose email is an Email('team@example')
     * Then the emitted JSON contains "email":"team@example", not a nested object
     *   And ApiClient::hydrate(Contact::class, ['email' => 'team@example', ...]) produces a Contact whose email is an Email instance with $value === 'team@example'
     */
    public function testABindsFormatScalarValueObjectRoundTripsThroughScalarBinding(): void
    {
        $this->steps->givenValueObjectAppValueObjectEmailIsAnnotatedWithAttrAndImplementsScalarBindingWithAStringValue('#[BindsFormat(\'email\')]');
        $this->steps->givenModelContactDeclaresARequiredPropertyEmailWithFormatEmail();
        $this->steps->whenJsonEncodeContactRunsAgainstAContactWhoseEmailIsAnEmailTeamExample();
        $this->steps->thenTheEmittedJSONContainsEmailTeamExampleNotANestedObject();
        $this->steps->thenApiclientHydrateContactClassEmailTeamExampleProducesAContactWhoseEmailIsAnEmailInstanceWithValueTeamExample();
    }


    /**
     * Scenario: A `format: date-time` property is emitted as DateTimeImmutable and round-trips through the wire string
     * @source truth/specs/model-generator.typ:240
     *
     * Given Model Order declares an optional property shipDate with type: string and format: date-time
     *   And no user #[BindsFormat('date-time')] binding is registered
     * When the model is emitted and the generated ApiClient::hydrate(Order::class, ...) runs against a payload whose shipDate is '2026-04-18T12:34:56+00:00'
     * Then the constructor parameter is typed ?\\DateTimeImmutable
     *   And the hydrated Order::$shipDate is an instance of \\DateTimeImmutable whose timestamp matches the parsed RFC-3339 string
     *   And json_encode($order) with that shipDate emits "shipDate":"2026-04-18T12:34:56+00:00" on the wire, not a nested object
     */
    public function testAFormatDateTimePropertyIsEmittedAsDateTimeImmutableAndRoundTripsThroughTheWireString(): void
    {
        $this->steps->givenModelOrderDeclaresAnOptionalPropertyShipDateWithTypeStringAndFormatDateTime();
        $this->steps->givenNoUserBindsFormatDateTimeBindingIsRegistered();
        $this->steps->whenTheModelIsEmittedAndTheGeneratedApiClientHydrateOrderClassRunsAgainstAPayloadWhoseShipDateIsWire('\'2026-04-18T12:34:56+00:00\'');
        $this->steps->thenTheConstructorParameterIsTypedDateTimeImmutable();
        $this->steps->thenTheHydratedOrderShipDateIsAnInstanceOfDateTimeImmutableWhoseTimestampMatchesTheParsedRFC3339String();
        $this->steps->thenJsonEncodeOrderWithThatShipDateEmitsShipDate20260418T1234560000OnTheWireNotANestedObject();
    }


    /**
     * Rule: Component names are normalised through a configurable pipeline (ADR-003, T-023)
     *
     * Scenario: A kebab-case component name becomes a PascalCase PHP class under the default pipeline
     * @source truth/specs/model-generator.typ:259
     *
     * Given Schema declares a component named security-advisory-ecosystems
     *   And Profile does not override nameNormaliser
     * When Generator runs against Profile
     * Then a file Generated/Model/SecurityAdvisoryEcosystems.php is written
     *   And every other component that $refs #/components/schemas/security-advisory-ecosystems resolves to the same PHP class
     */
    public function testAKebabCaseComponentNameBecomesAPascalCasePHPClassUnderTheDefaultPipeline(): void
    {
        $this->steps->givenSchemaDeclaresAComponentNamedRaw('security-advisory-ecosystems');
        $this->steps->givenProfileDoesNotOverrideNameNormaliser();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedModelSecurityAdvisoryEcosystemsPhpIsWritten();
        $this->steps->thenEveryOtherComponentThatRefsComponentsSchemasSecurityAdvisoryEcosystemsResolvesToTheSamePHPClass();
    }


    /**
     * Scenario: An explicit `renames` entry takes precedence over the auto-sanitiser
     * @source truth/specs/model-generator.typ:281
     *
     * Given Schema declares a component named version-2
     *   And Profile sets 'version-2' => 'Legacy_V2'
     * When Generator runs against Profile
     * Then a file Generated/Model/Legacy_V2.php is written
     *   And the file Generated/Model/Version2.php is not written
     *   And every $ref to #/components/schemas/version-2 resolves to Legacy_V2
     */
    public function testAnExplicitRenamesEntryTakesPrecedenceOverTheAutoSanitiser(): void
    {
        $this->steps->givenSchemaDeclaresAComponentNamedRaw('version-2');
        $this->steps->givenProfileSetsRenames('\'version-2\' => \'Legacy_V2\'');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedModelLegacyV2PhpIsWritten();
        $this->steps->thenTheFileGeneratedModelVersion2PhpIsNotWritten();
        $this->steps->thenEveryRefToComponentsSchemasVersion2ResolvesToLegacyV2();
    }


    /**
     * Scenario: A pattern-gated strategy only handles names matching its pattern and falls through otherwise
     * @source truth/specs/model-generator.typ:298
     *
     * Given Profile's nameNormaliser is CompositeNormaliser([LegacyUppercaser(pattern: /^legacy_/), PascalCaseSanitiser])
     *   And Schema declares components legacy_thing and modern-thing
     * When Generator runs against Profile
     * Then legacy_thing is emitted as LEGACY_THING by the first strategy
     *   And modern-thing falls through to PascalCaseSanitiser and is emitted as ModernThing
     */
    public function testAPatternGatedStrategyOnlyHandlesNamesMatchingItsPatternAndFallsThroughOtherwise(): void
    {
        $this->steps->givenProfilesNameNormaliserIsNormaliser('CompositeNormaliser([LegacyUppercaser(pattern: /^legacy_/), PascalCaseSanitiser])');
        $this->steps->givenSchemaDeclaresComponentsFirstAndSecond('legacy_thing', 'modern-thing');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenLegacyThingIsEmittedAsLEGACYTHINGByTheFirstStrategy();
        $this->steps->thenModernThingFallsThroughToPascalCaseSanitiserAndIsEmittedAsModernThing();
    }


    /**
     * Scenario: A custom pipeline that returns null for every name aborts with a pointed diagnostic
     * @source truth/specs/model-generator.typ:314
     *
     * Given Profile's nameNormaliser is an empty CompositeNormaliser (no strategies)
     *   And Schema declares any component, e.g. anything
     * When Generator runs against Profile
     * Then the run aborts with an error naming anything and pointing at the empty normaliser pipeline
     *   And no files are written under Profile's output
     */
    public function testACustomPipelineThatReturnsNullForEveryNameAbortsWithAPointedDiagnostic(): void
    {
        $this->steps->givenProfilesNameNormaliserIsAnEmptyCompositeNormaliserNoStrategies();
        $this->steps->givenSchemaDeclaresAnyComponentEGRaw('anything');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheRunAbortsWithAnErrorNamingAnythingAndPointingAtTheEmptyNormaliserPipeline();
        $this->steps->thenNoFilesAreWrittenUnderProfilesOutput();
    }


    /**
     * Scenario: Two raw component names that normalise to the same PHP class abort the run
     * @source truth/specs/model-generator.typ:330
     *
     * Given Schema declares components named foo-bar and foo_bar
     *   And Profile does not override nameNormaliser
     * When Generator runs against Profile
     * Then the run aborts with an error naming both raw keys and the shared PHP class FooBar
     *   And no files are written under Profile's output
     */
    public function testTwoRawComponentNamesThatNormaliseToTheSamePHPClassAbortTheRun(): void
    {
        $this->steps->givenSchemaDeclaresComponentsNamedFirstAndSecond('foo-bar', 'foo_bar');
        $this->steps->givenProfileDoesNotOverrideNameNormaliser();
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenTheRunAbortsWithAnErrorNamingBothRawKeysAndTheSharedPHPClassFooBar();
        $this->steps->thenNoFilesAreWrittenUnderProfilesOutput();
    }


    /**
     * Rule: Top-level components beyond `type: object` (T-026)
     *
     * Scenario: A scalar component emits a `ScalarBinding` VO that round-trips the raw scalar
     * @source truth/specs/model-generator.typ:347
     *
     * Given Schema declares a component urn with string (no enum, no properties)
     * When Generator runs against Profile
     * Then a file Generated/Model/Urn.php is written whose class is final readonly class Urn implements ScalarBinding
     *   And the constructor has a single promoted public string $value and the class emits matching fromScalar() / toScalar() methods
     *   And a sibling Model that $refs #/components/schemas/urn uses \Generated\Model\Urn as the property type and (new Marshaller())->marshal($model) emits the property as a plain string, not a nested object
     */
    public function testAScalarComponentEmitsAScalarBindingVOThatRoundTripsTheRawScalar(): void
    {
        $this->steps->givenSchemaDeclaresAComponentRawWithTypeNoEnumNoProperties('urn', 'string');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedModelUrnPhpIsWrittenWhoseClassIsFinalReadonlyClassUrnImplementsScalarBinding();
        $this->steps->thenTheConstructorHasASinglePromotedPublicStringValueAndTheClassEmitsMatchingFromScalarToScalarMethods();
        $this->steps->thenASiblingModelThatRefsComponentsSchemasUrnUsesGeneratedModelUrnAsThePropertyTypeAndNewMarshallerMarshalModelEmitsThePropertyAsAPlainStringNotANestedObject();
    }


    /**
     * Scenario: A top-level `oneOf` with inline object branches emits an interface and one Model per branch
     * @source truth/specs/model-generator.typ:365
     *
     * Given Schema declares a component floating_ip_create whose schema is oneOf: [<inline object A with title "Assign to Droplet">, <inline object B with title "Reserve to Region">]
     * When Generator runs against Profile
     * Then Generated/Model/FloatingIpCreate.php is an empty interface
     *   And Generated/Model/FloatingIpCreateAssignToDroplet.php and Generated/Model/FloatingIpCreateReserveToRegion.php are final readonly classes that implements FloatingIpCreate
     *   And operations that reference floating_ip_create as a request body type a method parameter FloatingIpCreate $body
     */
    public function testATopLevelOneOfWithInlineObjectBranchesEmitsAnInterfaceAndOneModelPerBranch(): void
    {
        $this->steps->givenSchemaDeclaresAComponentRawWhoseSchemaIsOneOfInlineObjectAWithTitleAssignToDropletInlineObjectBWithTitleReserveToRegion('floating_ip_create');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedModelFloatingIpCreatePhpIsAnEmptyInterface();
        $this->steps->thenGeneratedModelFloatingIpCreateAssignToDropletPhpAndGeneratedModelFloatingIpCreateReserveToRegionPhpAreFinalReadonlyClassesThatImplementsFloatingIpCreate();
        $this->steps->thenOperationsThatReferenceFloatingIpCreateAsARequestBodyTypeAMethodParameterFloatingIpCreateBody();
    }


    /**
     * Scenario: A top-level `oneOf` with `$ref` branches marks the branch Models as `implements <Interface>`
     * @source truth/specs/model-generator.typ:381
     *
     * Given Schema declares components LabeledIssueEvent and UnlabeledIssueEvent (both type: object) and a component issue_event_for_issue whose schema is anyOf: [$ref LabeledIssueEvent, $ref UnlabeledIssueEvent]
     * When Generator runs against Profile
     * Then Generated/Model/IssueEventForIssue.php is an empty interface
     *   And LabeledIssueEvent.php and UnlabeledIssueEvent.php both declare implements IssueEventForIssue in their class headers
     */
    public function testATopLevelOneOfWithRefBranchesMarksTheBranchModelsAsImplementsInterface(): void
    {
        $this->steps->givenSchemaDeclaresComponentsLabeledIssueEventAndUnlabeledIssueEventBothTypeObjectAndAComponentRawWhoseSchemaIsAnyOfRefLabeledIssueEventRefUnlabeledIssueEvent('issue_event_for_issue');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenGeneratedModelIssueEventForIssuePhpIsAnEmptyInterface();
        $this->steps->thenLabeledissueeventPhpAndUnlabeledIssueEventPhpBothDeclareImplementsIssueEventForIssueInTheirClassHeaders();
    }


    /**
     * Scenario: A top-level `type: array` component emits a typed wrapper class
     * @source truth/specs/model-generator.typ:395
     *
     * Given Schema declares a component tags_array whose schema is type: array, items.type: string
     * When Generator runs against Profile
     * Then a file Generated/Model/TagsArray.php is written whose class is final readonly class TagsArray
     *   And the constructor has a single promoted public array $items with phpdoc @param list<string> $items
     */
    public function testATopLevelTypeArrayComponentEmitsATypedWrapperClass(): void
    {
        $this->steps->givenSchemaDeclaresAComponentRawWhoseSchemaIsTypeArrayItemsTypeString('tags_array');
        $this->steps->whenGeneratorRunsAgainstProfile();
        $this->steps->thenAFileGeneratedModelTagsArrayPhpIsWrittenWhoseClassIsFinalReadonlyClassTagsArray();
        $this->steps->thenTheConstructorHasASinglePromotedPublicArrayItemsWithPhpdocParamListStringItems();
    }


    /**
     * Rule: Re-running the generator is byte-stable
     *
     * Scenario: Running the generator twice with the same inputs produces identical files
     * @source truth/specs/model-generator.typ:412
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
     * @source truth/specs/model-generator.typ:426
     *
     * Given Generator has produced Generated/Model/Pet.php from a prior schema that declared a Pet component
     * When Generator runs again with a schema from which the Pet component has been removed
     * Then Generated/Model/Pet.php is no longer on disk
     *   And files placed alongside Generated/ under the same output directory are untouched
     */
    public function testAComponentRemovedFromTheSchemaIsPrunedFromGeneratedOnTheNextRun(): void
    {
        $this->steps->givenGeneratorHasProducedGeneratedModelPetPhpFromAPriorSchemaThatDeclaredAPetComponent();
        $this->steps->whenGeneratorRunsAgainWithASchemaFromWhichThePetComponentHasBeenRemoved();
        $this->steps->thenGeneratedModelPetPhpIsNoLongerOnDisk();
        $this->steps->thenFilesPlacedAlongsideGeneratedUnderTheSameOutputDirectoryAreUntouched();
    }
}
