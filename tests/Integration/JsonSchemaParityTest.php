<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * generate-accepts-only-yaml-while-validate-accepts-json-too: {@see
 * \Poagen\Generator\SchemaReader} is the one place that picks a reader by
 * file extension now, and both `Cli::validate` and `Generator::plan` go
 * through it. This proves the `generate` half of that by running the same
 * document through both extensions rather than by inspection — YAML 1.2 is
 * a JSON superset, so the two readers agreeing on this one document is not
 * itself the guarantee, but every emitted byte matching is.
 *
 * Fixture: tests/fixtures/schemas/contact-3.0.{yaml,json} — the same
 * document hand-authored twice. The YAML original is a small synthetic
 * fixture (tests/fixtures/profiles/contact.php's docblock), not a vendored
 * one, so a hand-kept JSON twin does not run against
 * `fixtures-are-unmodified-vendor-documents`.
 */
final class JsonSchemaParityTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string YAML_SCHEMA = __DIR__ . '/../fixtures/schemas/contact-3.0.yaml';
    private const string JSON_SCHEMA = __DIR__ . '/../fixtures/schemas/contact-3.0.json';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\JsonSchemaParity';

    // The header stamped onto every emitted file names the profile, not the
    // schema (see Emit\GeneratedFileHeader), so both runs sharing this
    // label is what makes a byte-for-byte comparison meaningful instead of
    // failing on the label alone.
    private const string PROFILE_SOURCE = 'tests/fixtures/profiles/contact.php';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAJsonDocumentGeneratesByteIdenticalOutputToItsYamlTwin(): void
    {
        self::assertFileExists(self::YAML_SCHEMA, 'YAML twin must exist for this parity test');
        self::assertFileExists(self::JSON_SCHEMA, 'JSON twin must exist for this parity test');

        $generator = self::generator();

        $yamlOutput = self::makeSandboxDir('poagen-json-parity-yaml-');
        $generator->generate(new Profile(
            schema: self::YAML_SCHEMA,
            output: $yamlOutput,
            namespace: self::NAMESPACE,
            discoverIn: ['Poagen\\Generator\\Tests\\Fixtures\\ValueObject'],
            source: self::PROFILE_SOURCE,
        ));
        $yamlSnapshot = self::snapshotPhpTree($yamlOutput);

        $jsonOutput = self::makeSandboxDir('poagen-json-parity-json-');
        $generator->generate(new Profile(
            schema: self::JSON_SCHEMA,
            output: $jsonOutput,
            namespace: self::NAMESPACE,
            discoverIn: ['Poagen\\Generator\\Tests\\Fixtures\\ValueObject'],
            source: self::PROFILE_SOURCE,
        ));
        $jsonSnapshot = self::snapshotPhpTree($jsonOutput);

        self::assertNotEmpty($yamlSnapshot, 'the YAML run produced no files');
        self::assertSame(
            $yamlSnapshot,
            $jsonSnapshot,
            'a .json OpenAPI document must generate a client identical to its .yaml equivalent',
        );
    }
}
