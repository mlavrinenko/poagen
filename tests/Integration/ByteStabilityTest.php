<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\PetstoreFixture;

use function dirname;

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
 * Lifting `profile-driven-generation`'s byte-stability promise out of the
 * realm of "trust me, the scenario covers it" and into an integration test
 * closes pre-release review P2 #23.
 */
final class ByteStabilityTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string PETSTORE_NAMESPACE = 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\Petstore';

    /**
     * The golden tree is produced by running the CLI against this profile from
     * the repository root, and each emitted file's header names it. A profile
     * built in code here has no path of its own, so it has to say which file it
     * stands in for or the header alone would fail the comparison.
     */
    private const string PETSTORE_PROFILE = 'tests/fixtures/profiles/petstore.php';

    /**
     * Mirrors tests/fixtures/profiles/petstore.php, which carries no skip
     * list any more: `uploadFile`'s `application/octet-stream` body became a
     * `Psr\Http\Message\StreamInterface` parameter in
     * represent-non-json-request-and-response-bodies, and an entry for it
     * would now fail the run as stale rather than pass quietly.
     *
     * @var array<string,string>
     */
    private const array PETSTORE_SKIP = [];

    public function testPetstoreGeneratorRunsAreByteIdenticalToEachOtherAndToTheGoldenTree(): void
    {
        $schema = dirname(__DIR__, 2) . '/tests/fixtures/schemas/petstore-3.0.yaml';
        $goldenDir = dirname(__DIR__, 2) . '/tests/fixtures/generated/petstore';

        self::assertFileExists($schema, 'petstore schema must exist for this integration test');
        self::assertDirectoryExists($goldenDir, 'petstore golden tree must exist for this integration test');

        $firstOutputDir = self::makeSandboxDir('poagen-bytestab-a-');
        $secondOutputDir = self::makeSandboxDir('poagen-bytestab-b-');

        $generator = self::generator();

        // Use the same namespace as the golden tree so emitted source (which
        // embeds the namespace) is byte-comparable against it.
        $generator->generate(new Profile(
            schema: $schema,
            output: $firstOutputDir,
            namespace: self::PETSTORE_NAMESPACE,
            discoverIn: ['Poagen\\Generator\\Tests\\Fixtures\\ValueObject'],
            skip: self::PETSTORE_SKIP,
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
            source: self::PETSTORE_PROFILE,
        ));
        $firstSnapshot = self::snapshotPhpTree($firstOutputDir);

        $generator->generate(new Profile(
            schema: $schema,
            output: $secondOutputDir,
            namespace: self::PETSTORE_NAMESPACE,
            discoverIn: ['Poagen\\Generator\\Tests\\Fixtures\\ValueObject'],
            skip: self::PETSTORE_SKIP,
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
            source: self::PETSTORE_PROFILE,
        ));
        $secondSnapshot = self::snapshotPhpTree($secondOutputDir);

        self::assertNotEmpty($firstSnapshot, 'first generator run produced no files');
        self::assertSame(
            $firstSnapshot,
            $secondSnapshot,
            'two Petstore generator runs must produce byte-identical output (profile-driven-generation byte-stability)',
        );

        $goldenSnapshot = self::snapshotPhpTree($goldenDir);
        self::assertSame(
            $goldenSnapshot,
            $firstSnapshot,
            'generator output must match the committed Petstore golden tree',
        );
    }
}
