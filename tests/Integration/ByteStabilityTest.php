<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use FilesystemIterator;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function dirname;
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
    use GeneratedTreeSandbox;

    private const string PETSTORE_NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore';

    /**
     * The golden tree is produced by running the CLI against this profile from
     * the repository root, and each emitted file's header names it. A profile
     * built in code here has no path of its own, so it has to say which file it
     * stands in for or the header alone would fail the comparison.
     */
    private const string PETSTORE_PROFILE = 'tests/fixtures/profiles/petstore.php';

    /**
     * @var array<string,string>
     */
    private const array PETSTORE_SKIP = [
        // Mirrors tests/fixtures/profiles/petstore.php: uploadFile's
        // application/octet-stream body is unrepresentable — see
        // abort-on-unrepresentable-constructs.
        'uploadFile' => 'application/octet-stream request body — paogen does not support binary bodies',
    ];

    public function testPetstoreGeneratorRunsAreByteIdenticalToEachOtherAndToTheGoldenTree(): void
    {
        $schema = dirname(__DIR__, 2) . '/tests/fixtures/schemas/petstore-3.0.yaml';
        $goldenDir = dirname(__DIR__, 2) . '/tests/fixtures/generated/petstore';

        self::assertFileExists($schema, 'petstore schema must exist for this integration test');
        self::assertDirectoryExists($goldenDir, 'petstore golden tree must exist for this integration test');

        $firstOutputDir = self::makeSandboxDir('paogen-bytestab-a-');
        $secondOutputDir = self::makeSandboxDir('paogen-bytestab-b-');

        $generator = self::generator();

        // Use the same namespace as the golden tree so emitted source (which
        // embeds the namespace) is byte-comparable against it.
        $generator->generate(new Profile(
            schema: $schema,
            output: $firstOutputDir,
            namespace: self::PETSTORE_NAMESPACE,
            discoverIn: ['Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject'],
            skip: self::PETSTORE_SKIP,
            source: self::PETSTORE_PROFILE,
        ));
        $firstSnapshot = $this->snapshot($firstOutputDir);

        $generator->generate(new Profile(
            schema: $schema,
            output: $secondOutputDir,
            namespace: self::PETSTORE_NAMESPACE,
            discoverIn: ['Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject'],
            skip: self::PETSTORE_SKIP,
            source: self::PETSTORE_PROFILE,
        ));
        $secondSnapshot = $this->snapshot($secondOutputDir);

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
}
