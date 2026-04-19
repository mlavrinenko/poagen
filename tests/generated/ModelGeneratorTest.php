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
     * @source truth/specs/model-generator.typ:24
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
     * @source truth/specs/model-generator.typ:35
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
     * @source truth/specs/model-generator.typ:45
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
     * @source truth/specs/model-generator.typ:54
     *
     * Given Model Pet declares an inline property shipping with type: object and nested properties address: string, zip: string
     * When the model is emitted
     * Then a class Generated/Model/PetShipping.php is written
     *   And Pet has a promoted constructor parameter PetShipping $shipping
     *   And the property is not typed array<string, mixed>
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testAnInlineNestedObjectSchemaBecomesASynthesisedTypedClass(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }


    /**
     * Scenario: A schema with enum values becomes a PHP 8.1 backed enum
     * @source truth/specs/model-generator.typ:65
     *
     * Given Schema declares a named component Status with type: string and [available, pending, sold]
     * When Generator runs against Profile
     * Then a file Generated/Enum/Status.php is written
     *   And the emitted enum is enum Status: string with one case per declared value
     *   And operations and Models that reference #/components/schemas/Status are typed with the enum, not string
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testASchemaWithEnumValuesBecomesAPHP81BackedEnum(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }


    /**
     * Rule: Hydration and serialization contract (ADR-007)
     *
     * Scenario: A list-of-Model property hydrates each item into the declared class
     * @source truth/specs/model-generator.typ:78
     *
     * Given Model Pet has a property tags whose schema is type: array, items.$ref: #/components/schemas/Tag
     * When the generated ApiClient::hydrate(Pet::class, $data) runs against a payload whose tags is a list of two objects
     * Then $pet->tags[0] is an instance of Tag
     *   And $pet->tags[1] is an instance of Tag
     */
    public function testAListOfModelPropertyHydratesEachItemIntoTheDeclaredClass(): void
    {
        $this->steps->givenModelPetHasAPropertyTagsWhoseSchemaIsTypeArrayItemsRefComponentsSchemasTag();
        $this->steps->whenTheGeneratedApiClientHydratePetClassDataRunsAgainstAPayloadWhoseTagsIsAListOfTwoObjects();
        $this->steps->thenPetTags0IsAnInstanceOfTag();
        $this->steps->thenPetTags1IsAnInstanceOfTag();
    }


    /**
     * Scenario: A list-of-scalar property hydrates items untouched
     * @source truth/specs/model-generator.typ:89
     *
     * Given Model Pet has a property photoUrls whose schema is type: array, items.type: string
     * When the generated ApiClient::hydrate(Pet::class, $data) runs against a payload whose photoUrls is a list of plain strings
     * Then each $pet->photoUrls[$i] is the original string — no object wrapping
     */
    public function testAListOfScalarPropertyHydratesItemsUntouched(): void
    {
        $this->steps->givenModelPetHasAPropertyPhotoUrlsWhoseSchemaIsTypeArrayItemsTypeString();
        $this->steps->whenTheGeneratedApiClientHydratePetClassDataRunsAgainstAPayloadWhosePhotoUrlsIsAListOfPlainStrings();
        $this->steps->thenEachPetPhotoUrlsIIsTheOriginalStringNoObjectWrapping();
    }


    /**
     * Scenario: A property with a non-identifier schema key round-trips through PROPERTY_MAP
     * @source truth/specs/model-generator.typ:99
     *
     * Given Model Contact declares a required property whose schema key is display-name (kebab-case)
     * When the generator emits Contact.php and ApiClient::hydrate runs against a payload containing the wire key display-name
     * Then the constructor parameter is emitted as $displayName (camelCased PHP identifier)
     *   And Contact::PROPERTY_MAP pairs 'displayName' with wire key 'display-name'
     *   And hydration populates $contact->displayName from the display-name payload key
     *   And json_encode($contact) emits the key as display-name, not displayName
     */
    public function testAPropertyWithANonIdentifierSchemaKeyRoundTripsThroughPROPERTYMAP(): void
    {
        $this->steps->givenModelContactDeclaresARequiredPropertyWhoseSchemaKeyIsDisplayNameKebabCase();
        $this->steps->whenTheGeneratorEmitsContactPhpAndApiClientHydrateRunsAgainstAPayloadContainingTheWireKeyDisplayName();
        $this->steps->thenTheConstructorParameterIsEmittedAsDisplayNameCamelCasedPHPIdentifier();
        $this->steps->thenContactPROPERTYMAPPairsDisplayNameWithWireKeyDisplayName();
        $this->steps->thenHydrationPopulatesContactDisplayNameFromTheDisplayNamePayloadKey();
        $this->steps->thenJsonEncodeContactEmitsTheKeyAsDisplayNameNotDisplayName();
    }


    /**
     * Rule: User bindings replace generated types
     *
     * Scenario: A property with a format that has a BindsFormat binding uses the user class
     * @source truth/specs/model-generator.typ:114
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
     * @source truth/specs/model-generator.typ:125
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
     * @source truth/specs/model-generator.typ:140
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
     * Rule: Re-running the generator is byte-stable
     *
     * Scenario: Running the generator twice with the same inputs produces identical files
     * @source truth/specs/model-generator.typ:159
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
     * @source truth/specs/model-generator.typ:169
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
