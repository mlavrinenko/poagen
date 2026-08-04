<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Generated;

use Composer\Autoload\ClassLoader;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\AttributeScanner;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Generator\ProfileLoader;
use Poagen\Generator\Tests\Fixtures\ValueObject\Email;
use Throwable;

use function dirname;
use function is_array;

use const DIRECTORY_SEPARATOR;

/**
 * Step implementations for Profile.
 * This file is yours — speconaut only appends new step stubs.
 */
final class ProfileSteps
{
    private readonly TestCase $test;

    private string $loaderPath = '';
    private ?Profile $loadedProfile = null;
    private ?Throwable $loaderError = null;
    private ?string $tempFile = null;

    private string $valueObjectFqcn = '';
    /** @var list<string> */
    private array $discoverIn = [];
    private ?Bindings $bindings = null;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    public function givenValueObjectClassIsAnnotatedWithAttr(string $attr): void
    {
        // The `#[BindsFormat(...)]` value itself is not read here — the
        // `Then` step gets its own `$format` argument straight from the
        // spec's placeholder, so parsing it a second time into a property
        // would just be a second source of the same fact.
        TestCase::assertMatchesRegularExpression("/BindsFormat\\(['\"][^'\"]+['\"]\\)/", $attr);
        $this->valueObjectFqcn = Email::class;
    }

    public function givenItsNamespaceIsListedInProfilesDiscoverIn(): void
    {
        $this->discoverIn = ['Poagen\\Generator\\Tests\\Fixtures\\ValueObject'];
    }

    public function givenItsNamespaceIsNotListedInProfilesDiscoverIn(): void
    {
        $this->discoverIn = ['Some\\Namespace\\That\\Does\\Not\\Exist'];
    }

    public function whenAttributeScanRunsOverProfile(): void
    {
        $profile = new Profile(
            schema: dirname(__DIR__, 2) . '/tests/fixtures/schemas/contact-3.0.yaml',
            output: '/tmp',
            namespace: 'Anything',
            discoverIn: $this->discoverIn,
        );
        $this->bindings = new AttributeScanner($this->composerLoader())->scan($profile);
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

    public function givenPhpFileAtPathReturnsProfileForSchemaAtSchema(string $path, string $schema): void
    {
        // The spec writes `<profile-path>` / `<schema-path>` rather than
        // naming fixtures, so the binding to real files lives here.
        $fixtures = [
            '<profile-path>' => 'tests/fixtures/profiles/petstore.php',
            '<schema-path>' => 'tests/fixtures/schemas/petstore-3.0.yaml',
        ];
        TestCase::assertArrayHasKey($path, $fixtures, "unbound profile placeholder: {$path}");
        TestCase::assertArrayHasKey($schema, $fixtures, "unbound schema placeholder: {$schema}");

        $root = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
        $this->loaderPath = $root . $fixtures[$path];
        TestCase::assertFileExists($this->loaderPath, "fixture profile missing: {$path}");
        TestCase::assertFileExists($root . $fixtures[$schema], "fixture schema missing: {$schema}");
    }


    public function whenProfileIsLoadedFromThatPath(): void
    {
        try {
            $this->loadedProfile = new ProfileLoader()->load($this->loaderPath);
        } catch (Throwable $e) {
            $this->loaderError = $e;
        }
    }


    public function thenResultIsProfile(): void
    {
        TestCase::assertInstanceOf(Profile::class, $this->loadedProfile);
    }


    public function thenProfilesSchemaResolvesToTheFixturePath(): void
    {
        TestCase::assertNotNull($this->loadedProfile);
        TestCase::assertFileExists($this->loadedProfile->schema);
    }


    public function givenPhpFileThatReturnsTheIntegerValueInsteadOfProfile(int $value): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'poagen-bad-profile-') . '.php';
        file_put_contents($tmp, "<?php\nreturn {$value};\n");
        $this->tempFile = $tmp;
        $this->loaderPath = $tmp;
    }


    public function whenLoadingProfileFromThatPathIsAttempted(): void
    {
        // "is attempted" rather than "is loaded": this scenario's path is the
        // rejecting one, so the throw is the outcome under test and the `then`
        // step reads it off {@see self::$loaderError}.
        $this->whenProfileIsLoadedFromThatPath();
    }


    public function thenLoadingProfileThrowsError(string $error): void
    {
        TestCase::assertNotNull($this->loaderError, 'expected loader error, got none');
        TestCase::assertSame(
            'Poagen\\Generator\\Exception\\' . $error,
            $this->loaderError::class,
        );

        if ($this->tempFile !== null) {
            @unlink($this->tempFile);
            $this->tempFile = null;
        }
    }


    public function thenResultingBindingMapContainsFormatThatValueObject(string $format): void
    {
        TestCase::assertNotNull($this->bindings);
        TestCase::assertSame($this->valueObjectFqcn, $this->bindings->formatType($format));
    }


    public function thenResultingBindingMapDoesNotContainFormatForThatValueObject(string $format): void
    {
        TestCase::assertNotNull($this->bindings);
        TestCase::assertNull($this->bindings->formatType($format));
    }

}
