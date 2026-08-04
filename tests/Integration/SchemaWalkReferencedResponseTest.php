<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\FormatAdvisor;
use Poagen\Generator\Generator\Emit\SchemaScan;
use Poagen\Generator\Generator\Emit\SchemaWalk;
use Poagen\Generator\Generator\Emit\UnconstrainedFieldAdvisor;

use function array_map;
use function spl_object_id;

/**
 * a-referenced-response-component-is-invisible-to-the-schema-walk, proven
 * against the real document rather than a fixture alone.
 *
 * DigitalOcean's `GET /v2/customers/my/invoices/{invoice_uuid}/pdf` names
 * its 200 response by `$ref: '#/components/responses/invoice_pdf'`, whose
 * content is `application/pdf` over a `type: string, format: binary`
 * schema. Before the fix, {@see SchemaWalk::bodyContentSchemas()} required
 * an inline `Response` instance, so this schema never reached anything that
 * walks the document — {@see FormatAdvisor},
 * {@see UnconstrainedFieldAdvisor} and
 * {@see SchemaScan} were all blind to it,
 * silently, which is the shape of defect this task exists to close.
 *
 * The document is parsed once for the whole class (`setUpBeforeClass`)
 * rather than per test — it is 2.7 MB / ~80k lines and reparsing it three
 * times over would cost little correctness for real time, and every test
 * here reads the same `$openApi` object graph so schema identity comparisons
 * stay valid across tests.
 */
final class SchemaWalkReferencedResponseTest extends TestCase
{
    private const string DIGITALOCEAN_SCHEMA = __DIR__ . '/../../examples/digitalocean/schemas/DigitalOcean-public.v2.yaml';
    private const string OPERATION_ID = 'invoices_get_pdfByUUID';
    private const string PATH = '/v2/customers/my/invoices/{invoice_uuid}/pdf';

    private static ?OpenApi $openApi = null;

    public static function setUpBeforeClass(): void
    {
        $openApi = Reader::readFromYamlFile(self::DIGITALOCEAN_SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);
        self::$openApi = $openApi;
    }

    public static function tearDownAfterClass(): void
    {
        self::$openApi = null;
    }

    public function testInvoicePdfsResponseIsGenuinelyAReferenceInTheRealDocument(): void
    {
        // Establishes the premise against the artifact rather than assuming
        // it: if the vendor document ever inlined this response, the rest of
        // this test would be proving nothing.
        $operation = $this->operation();

        self::assertSame(self::OPERATION_ID, $operation->operationId);
        self::assertInstanceOf(Reference::class, $operation->responses?->getResponse('200'));
    }

    public function testTheWalkReachesInvoicePdfsContentSchemaThroughItsRefComponent(): void
    {
        $pdf = $this->pdfSchema();

        self::assertSame('string', $pdf->type);
        self::assertSame('binary', $pdf->format);
    }

    public function testTheSameSchemaObjectIsReachableFromTheDocumentWideRootsWalk(): void
    {
        // roots() is what FormatAdvisor and UnconstrainedFieldAdvisor walk
        // over the whole document, and operationRoots() is what SchemaScan
        // walks per operation — all three were blind to this node. Compared
        // by object identity, not merely by shape, so this proves roots()
        // reaches the very same schema node invoice_pdf declares rather than
        // some other unrelated `format: binary` schema elsewhere in a 2.7 MB
        // document that declares plenty of them.
        $pdf = $this->pdfSchema();

        $rootIds = array_map(spl_object_id(...), SchemaWalk::roots(self::$openApi ?? self::fail('setUpBeforeClass did not run')));

        self::assertContains(spl_object_id($pdf), $rootIds, "invoice_pdf's schema should be one of the document roots");
    }

    private function pdfSchema(): Schema
    {
        $operation = $this->operation();

        foreach (SchemaWalk::bodyContentSchemas($operation) as [$mediaType, $schema]) {
            if ($mediaType === 'application/pdf') {
                return $schema;
            }
        }

        self::fail('application/pdf should be reachable through the $ref response');
    }

    private function operation(): Operation
    {
        $openApi = self::$openApi ?? self::fail('setUpBeforeClass did not run');
        $item = $openApi->paths?->getPath(self::PATH);
        self::assertInstanceOf(PathItem::class, $item);
        self::assertInstanceOf(Operation::class, $item->get);

        return $item->get;
    }
}
