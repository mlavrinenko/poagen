<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\spec\OpenApi;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\SchemaReader;
use Poagen\Generator\Tests\Integration\JsonSchemaParityTest;

use function copy;
use function strlen;
use function substr;
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
        $upper = self::JSON_SCHEMA;
        $upper = substr($upper, 0, -strlen('.json')) . '.JSON';

        // No fixture actually sits at the upper-cased path; copy the JSON
        // document there for the length of this test rather than committing
        // a second fixture whose only distinction is its case.
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
