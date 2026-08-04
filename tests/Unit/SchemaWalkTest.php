<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\RequestBodyAnalyzer;
use Poagen\Generator\Generator\Emit\SchemaWalk;

/**
 * a-referenced-response-component-is-invisible-to-the-schema-walk:
 * {@see SchemaWalk::bodyContentSchemas()} used to require an inline
 * `Response` instance, so a `$ref` to a named `#/components/responses/*`
 * entry never reached it — a `$ref` request body already resolved through
 * {@see RequestBodyAnalyzer::resolveBody()},
 * but a `$ref` response had no equivalent.
 *
 * Fixture: tests/fixtures/schemas/response-ref-parity-3.0.yaml, whose two
 * operations declare byte-identical `application/pdf` + `format: binary`
 * response content — DigitalOcean's `invoice_pdf` shape — one inline and one
 * through a component `$ref`. {@see SchemaWalkReferencedResponseTest} proves
 * the same gap on the real DigitalOcean document.
 */
final class SchemaWalkTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/response-ref-parity-3.0.yaml';

    public function testAReferencedResponseYieldsTheSameContentSchemaAsTheIdenticalInlineOne(): void
    {
        $openApi = $this->parse();

        $inline = $this->operation($openApi, '/inline');
        $referenced = $this->operation($openApi, '/referenced');

        // The fixture's whole point: the referenced operation's response is
        // genuinely a Reference, not an inline Response — otherwise this
        // test would not exercise the bug at all.
        self::assertInstanceOf(Reference::class, $referenced->responses?->getResponse('200'));

        $inlinePairs = SchemaWalk::bodyContentSchemas($inline);
        $referencedPairs = SchemaWalk::bodyContentSchemas($referenced);

        self::assertCount(1, $inlinePairs, 'the inline response should contribute one (media type, schema) pair');
        self::assertCount(
            1,
            $referencedPairs,
            'the $ref response should contribute the same one (media type, schema) pair — it did not before the fix',
        );

        [$inlineMediaType, $inlineSchema] = $inlinePairs[0];
        [$referencedMediaType, $referencedSchema] = $referencedPairs[0];

        self::assertSame('application/pdf', $inlineMediaType);
        self::assertSame($inlineMediaType, $referencedMediaType);
        self::assertSame('string', $inlineSchema->type);
        self::assertSame($inlineSchema->type, $referencedSchema->type);
        self::assertSame('binary', $inlineSchema->format);
        self::assertSame($inlineSchema->format, $referencedSchema->format);
    }

    public function testTheReferencedResponseSchemaAlsoReachesTheDocumentWideRootsWalk(): void
    {
        // roots() is what FormatAdvisor and UnconstrainedFieldAdvisor walk
        // over the whole document. Before the fix, the referenced response's
        // schema was absent from this list entirely — not merely
        // unrecognised, invisible.
        $openApi = $this->parse();
        $found = array_any(SchemaWalk::roots($openApi), fn(Schema $schema): bool => $schema->format === 'binary');

        self::assertTrue($found, 'the referenced response schema should be one of the document roots');
    }

    private function parse(): OpenApi
    {
        $openApi = Reader::readFromYamlFile(self::SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);

        return $openApi;
    }

    private function operation(OpenApi $openApi, string $path): Operation
    {
        $item = $openApi->paths?->getPath($path);
        self::assertInstanceOf(PathItem::class, $item);
        self::assertInstanceOf(Operation::class, $item->get);

        return $item->get;
    }
}
