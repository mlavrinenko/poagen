<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Composer\Autoload\ClassLoader;
use FilesystemIterator;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function dirname;
use function is_array;
use function strlen;

/**
 * T-022: independent byte-stability check against the Petstore golden tree.
 *
 * The Model Generator feature specs already assert a "run twice, diff"
 * scenario, but that lives inside generated PHPUnit stubs and only exercises
 * the `tests/fixtures/generated/petstore/` output directory. This test:
 *
 * - runs {@see Generator::generate()} twice into two fresh temporary
 *   directories (leaving the committed golden tree untouched);
 * - asserts the two runs produce byte-identical output;
 * - asserts both runs match the committed golden tree under
 *   `tests/fixtures/generated/petstore/`.
 *
 * Lifting ADR-001's byte-stability promise out of the realm of
 * "trust me, the scenario covers it" and into an integration test
 * closes pre-release review P2 #23.
 */
final class ByteStabilityTest extends TestCase
{
    private const string PETSTORE_NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore';

    /**
     * @var array<string,string>
     */
    private const array PETSTORE_SKIP = [
        // Mirrors tests/fixtures/profiles/petstore.php: uploadFile's
        // application/octet-stream body is unrepresentable — see
        // abort-on-unrepresentable-constructs.
        'uploadFile' => 'application/octet-stream request body — paogen does not support binary bodies',
    ];

    private string $firstOutputDir = '';
    private string $secondOutputDir = '';

    protected function tearDown(): void
    {
        foreach ([$this->firstOutputDir, $this->secondOutputDir] as $dir) {
            if ($dir !== '' && is_dir($dir)) {
                $this->removeDirectory($dir);
            }
        }

        parent::tearDown();
    }

    public function testPetstoreGeneratorRunsAreByteIdenticalToEachOtherAndToTheGoldenTree(): void
    {
        $schema = dirname(__DIR__, 2) . '/tests/fixtures/schemas/petstore-3.0.yaml';
        $goldenDir = dirname(__DIR__, 2) . '/tests/fixtures/generated/petstore';

        self::assertFileExists($schema, 'petstore schema must exist for this integration test');
        self::assertDirectoryExists($goldenDir, 'petstore golden tree must exist for this integration test');

        $this->firstOutputDir = $this->makeTempDir('paogen-bytestab-a-');
        $this->secondOutputDir = $this->makeTempDir('paogen-bytestab-b-');

        $generator = new Generator(new AttributeScanner($this->composerLoader()));

        // Use the same namespace as the golden tree so emitted source (which
        // embeds the namespace) is byte-comparable against it.
        $generator->generate(new Profile(
            schema: $schema,
            output: $this->firstOutputDir,
            namespace: self::PETSTORE_NAMESPACE,
            discoverIn: ['Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject'],
            skip: self::PETSTORE_SKIP,
        ));
        $firstSnapshot = $this->snapshot($this->firstOutputDir);

        $generator->generate(new Profile(
            schema: $schema,
            output: $this->secondOutputDir,
            namespace: self::PETSTORE_NAMESPACE,
            discoverIn: ['Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject'],
            skip: self::PETSTORE_SKIP,
        ));
        $secondSnapshot = $this->snapshot($this->secondOutputDir);

        self::assertNotEmpty($firstSnapshot, 'first generator run produced no files');
        self::assertSame(
            $firstSnapshot,
            $secondSnapshot,
            'two Petstore generator runs must produce byte-identical output (ADR-001 byte-stability)',
        );

        $goldenSnapshot = $this->snapshot($goldenDir);
        self::assertSame(
            $goldenSnapshot,
            $firstSnapshot,
            'generator output must match the committed Petstore golden tree',
        );
    }

    private function makeTempDir(string $prefix): string
    {
        $path = (string) tempnam(sys_get_temp_dir(), $prefix);

        // `tempnam` creates a file — swap it for a directory of the same name.
        unlink($path);

        if (!mkdir($path, 0o755, true) && !is_dir($path)) {
            self::fail("failed to create temporary directory: {$path}");
        }

        return $path;
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
            if (!$file->isFile()) {
                continue;
            }
            if ($file->getExtension() !== 'php') {
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
            if (is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        self::fail('Composer ClassLoader not found in autoload chain.');
    }

    private function removeDirectory(string $dir): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        /** @var SplFileInfo $entry */
        foreach ($iterator as $entry) {
            if ($entry->isDir()) {
                rmdir($entry->getPathname());

                continue;
            }

            unlink($entry->getPathname());
        }

        rmdir($dir);
    }
}
