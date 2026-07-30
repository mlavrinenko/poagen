<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;
use Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email;
use PHPUnit\Framework\TestCase;
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

    private string $boundFormat = '';
    private string $valueObjectFqcn = '';
    /** @var list<string> */
    private array $discoverIn = [];
    private ?Bindings $bindings = null;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    public function givenAPHPFileAtPathReturnsProfileForSchemaAtSchema(string $path, string $schema): void
    {
        $this->loaderPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $path;
        TestCase::assertFileExists($this->loaderPath, "fixture profile missing: {$path}");
        TestCase::assertFileExists(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $schema, "fixture schema missing: {$schema}");
    }

    public function whenTheLoaderIsInvokedWithThatPath(): void
    {
        try {
            $this->loadedProfile = new ProfileLoader()->load($this->loaderPath);
        } catch (Throwable $e) {
            $this->loaderError = $e;
        }
    }

    public function thenTheResultIsProfile(): void
    {
        TestCase::assertInstanceOf(Profile::class, $this->loadedProfile);
    }

    public function thenItsSchemaResolvesToTheFixturePath(): void
    {
        TestCase::assertNotNull($this->loadedProfile);
        TestCase::assertFileExists($this->loadedProfile->schema);
    }

    public function givenAPHPFileThatReturnsTheIntegerValue(int $value): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'paogen-bad-profile-') . '.php';
        file_put_contents($tmp, "<?php\nreturn {$value};\n");
        $this->tempFile = $tmp;
        $this->loaderPath = $tmp;
    }

    public function thenTheLoaderThrowsError(string $error): void
    {
        TestCase::assertNotNull($this->loaderError, 'expected loader error, got none');
        TestCase::assertSame(
            'Mlavrinenko\\Paogen\\Exception\\' . $error,
            $this->loaderError::class,
        );

        if ($this->tempFile !== null) {
            @unlink($this->tempFile);
            $this->tempFile = null;
        }
    }

    public function givenValueObjectClassIsAnnotatedWithAttr(string $attr): void
    {
        if (preg_match("/BindsFormat\\(['\"]([^'\"]+)['\"]\\)/", $attr, $m) === 1) {
            $this->boundFormat = $m[1];
        }
        $this->valueObjectFqcn = Email::class;
    }

    public function givenItsNamespaceIsListedInProfilesDiscoverIn(): void
    {
        $this->discoverIn = ['Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject'];
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

    public function thenTheResultingBindingMapContainsFormatThatClass(string $format): void
    {
        TestCase::assertNotNull($this->bindings);
        TestCase::assertSame($this->valueObjectFqcn, $this->bindings->formatType($format));
    }

    public function thenTheResultingBindingMapDoesNotContainFormat(string $format): void
    {
        TestCase::assertNotNull($this->bindings);
        TestCase::assertNull($this->bindings->formatType($format));
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
}
