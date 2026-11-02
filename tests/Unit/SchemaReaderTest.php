<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\spec\OpenApi;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\SchemaReader;
use Poagen\Generator\Tests\Integration\JsonSchemaParityTest;

use function bin2hex;
use function copy;
use function random_bytes;
use function sys_get_temp_dir;
use function unlink;

/**
 * generate-accepts-only-yaml-while-validate-accepts-json-too: before this,
 * `Cli::validate` chose a reader by extension and `Generator::plan` always
 * used the YAML reader, two independent copies of the same decision.
 * {@see SchemaReader} is now the one place that decision lives; both
 * callers route through it.
 *
 * Fixture: tests/fixtures/schemas/contact-3.0.{yaml,json}, the same
 * document hand-authored twice — see {@see JsonSchemaParityTest}
 * for the byte-identical-output proof over a full generator run.
 */
final class SchemaReaderTest extends TestCase
{
    private const string YAML_SCHEMA = __DIR__ . '/../fixtures/schemas/contact-3.0.yaml';
    private const string JSON_SCHEMA = __DIR__ . '/../fixtures/schemas/contact-3.0.json';

    public function testAYamlExtensionReadsThroughTheYamlReader(): void
    {
        $openApi = SchemaReader::read(self::YAML_SCHEMA);

        self::assertSame('3.0.3', $openApi->openapi);
        $this->assertHasContactSchema($openApi);
    }

    public function testAJsonExtensionReadsThroughTheJsonReader(): void
    {
        $openApi = SchemaReader::read(self::JSON_SCHEMA);

        self::assertSame('3.0.3', $openApi->openapi);
        $this->assertHasContactSchema($openApi);
    }

    public function testTheExtensionCheckIsCaseInsensitive(): void
    {
        // A temp file, not a fixture. On a case-insensitive filesystem a
        // sibling `contact-3.0.JSON` is the same file as `contact-3.0.json`,
        // and the cleanup would delete the fixture the next test needs.
        $upper = sys_get_temp_dir() . '/contact-' . bin2hex(random_bytes(8)) . '.JSON';
        copy(self::JSON_SCHEMA, $upper);

        try {
            $openApi = SchemaReader::read($upper);
            $this->assertHasContactSchema($openApi);
        } finally {
            unlink($upper);
        }
    }

    public function testBothExtensionsProduceTheSameSerialisedDocument(): void
    {
        $yaml = SchemaReader::read(self::YAML_SCHEMA);
        $json = SchemaReader::read(self::JSON_SCHEMA);

        // getSerializableData() returns a tree of stdClass + array, so two
        // independently-parsed documents are never the same *instance* —
        // assertEquals compares the tree's values, which is what "the same
        // document" means here.
        self::assertEquals($yaml->getSerializableData(), $json->getSerializableData());
    }

    private function assertHasContactSchema(OpenApi $openApi): void
    {
        $components = $openApi->components;

        self::assertNotNull($components, 'document must declare components');
        self::assertArrayHasKey('Contact', $components->schemas);
    }
}
