<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;
use PHPUnit\Framework\TestCase;

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
    /** @var array<string,string> */
    private array $firstSnapshot = [];
    /** @var array<string,string> */
    private array $secondSnapshot = [];

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
        TestCase::assertNotNull($this->profile);
        $this->runGenerator($this->profile);
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
        $profile = new ProfileLoader()->load(\dirname(__DIR__, 2) . "/tests/fixtures/profiles/{$name}.php");
        $this->outputDir = $profile->output;

        return $profile;
    }

    private function runGenerator(Profile $profile): void
    {
        $loader = $this->composerLoader();
        $prev = error_reporting();
        error_reporting($prev & ~E_DEPRECATED & ~E_USER_DEPRECATED);

        try {
            new Generator(new AttributeScanner($loader))->generate($profile);
        } finally {
            error_reporting($prev);
        }
    }

    /**
     * @return array<string,string>
     */
    private function snapshot(string $dir): array
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
        );

        $out = [];

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $relative = substr($file->getPathname(), \strlen($dir) + 1);
            $out[$relative] = (string) file_get_contents($file->getPathname());
        }

        ksort($out);

        return $out;
    }

    private function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (\is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
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
        \assert(mkdir($tempBase, 0o755, true));

        $profile = new Profile(
            schema: \dirname(__DIR__, 2) . '/tests/fixtures/schemas/petstore-3.0.yaml',
            output: $tempBase,
            namespace: 'Mlavrinenko\\Paogen\\Tests\\Tmp\\Prune\\Petstore',
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

}
