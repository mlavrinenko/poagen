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
     * Rule: User bindings replace generated types
     *
     * Scenario: A property with a format that has a BindsFormat binding uses the user class
     * @source truth/specs/model-generator.typ:78
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
     * Rule: Re-running the generator is byte-stable
     *
     * Scenario: Running the generator twice with the same inputs produces identical files
     * @source truth/specs/model-generator.typ:91
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
}
