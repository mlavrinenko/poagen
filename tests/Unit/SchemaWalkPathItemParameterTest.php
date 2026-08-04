<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Schema;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\FormatAdvisor;
use Poagen\Generator\Generator\Emit\SchemaScan;
use Poagen\Generator\Generator\Emit\SchemaType;
use Poagen\Generator\Generator\Emit\SchemaWalk;
use Poagen\Generator\Generator\Emit\TypeListScanner;
use Poagen\Generator\Generator\Emit\UnconstrainedFieldAdvisor;

/**
 * pathitem-level-parameters-are-invisible-to-the-document-wide-scan:
 * {@see SchemaWalk::operationRoots()} used to read `$operation->parameters`
 * only, so a parameter declared once on the enclosing PathItem and shared by
 * every operation under it never reached the document-wide walk —
 * {@see SchemaWalk::roots()} (what {@see FormatAdvisor}
 * and {@see UnconstrainedFieldAdvisor}
 * walk) and {@see SchemaScan} (what {@see TypeListScanner} and {@see
 * \Poagen\Generator\Generator\Emit\UnsupportedKeywordScanner} probe).
 *
 * Fixture: tests/fixtures/schemas/pathitem-shared-parameter-3.1.yaml.
 * `/shared` declares one query parameter on the PathItem, `type: [object,
 * string]` — a multi-member type list {@see TypeListScanner} refuses — and
 * neither of its two operations overrides it. `/overridden` declares the
 * identical PathItem-level parameter but its one operation redeclares the
 * same `(name, in)` pair with a plain scalar, which OpenAPI 3.1 4.8.9 says
 * wins over the inherited shape.
 */
final class SchemaWalkPathItemParameterTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/pathitem-shared-parameter-3.1.yaml';

    public function testOperationRootsSeesTheInheritedPathItemLevelParameter(): void
    {
        $openApi = $this->parse();
        [$pathItem, $get] = $this->operation($openApi, '/shared', 'get');

        $roots = SchemaWalk::operationRoots($get, $pathItem);
        $found = array_any(
            $roots,
            static fn(Schema $schema): bool => SchemaType::of($schema)->isUnrepresentable(),
        );

        self::assertTrue(
            $found,
            'operationRoots() should surface the PathItem-level parameter schema when given the PathItem',
        );
    }

    public function testOperationRootsWithNoPathItemStaysOperationOnly(): void
    {
        // Back-compat: a caller with no PathItem in hand (the default
        // parameter) sees only the operation's own parameters, exactly as
        // operationRoots() always has.
        $openApi = $this->parse();
        [, $get] = $this->operation($openApi, '/shared', 'get');

        $roots = SchemaWalk::operationRoots($get);
        $found = array_any(
            $roots,
            static fn(Schema $schema): bool => SchemaType::of($schema)->isUnrepresentable(),
        );

        self::assertFalse($found, 'without a PathItem, the inherited parameter must stay invisible');
    }

    public function testOperationLevelParameterOverridesTheInheritedOneOnNameAndLocation(): void
    {
        $openApi = $this->parse();
        [$pathItem, $get] = $this->operation($openApi, '/overridden', 'get');

        $roots = SchemaWalk::operationRoots($get, $pathItem);
        $found = array_any(
            $roots,
            static fn(Schema $schema): bool => SchemaType::of($schema)->isUnrepresentable(),
        );

        self::assertFalse(
            $found,
            'the operation-level `filter` (query) redeclaration should shadow the PathItem-level one entirely',
        );

        $scalarFilter = array_any($roots, static fn(Schema $schema): bool => $schema->type === 'string');
        self::assertTrue($scalarFilter, 'the operation\'s own scalar `filter` schema should still be present');
    }

    public function testTheDocumentWideRootsWalkYieldsTheSharedParameterOnceNotOncePerOperation(): void
    {
        // /shared and /overridden both declare `type: [object, string]` at
        // the PathItem level, so the document legitimately carries two
        // distinct unrepresentable schema objects — checking the total count
        // would not prove anything about duplication. What the fix promises
        // is that /shared's ONE declaration, shared by its two operations
        // (get, post), is not counted twice for being inherited twice.
        $openApi = $this->parse();
        $sharedPathItem = $openApi->paths?->getPath('/shared');
        self::assertInstanceOf(PathItem::class, $sharedPathItem);
        $sharedFilterParameter = $sharedPathItem->parameters[0];
        self::assertInstanceOf(Parameter::class, $sharedFilterParameter);
        $sharedFilterSchema = $sharedFilterParameter->schema;
        self::assertInstanceOf(Schema::class, $sharedFilterSchema);

        $roots = SchemaWalk::roots($openApi);
        $occurrences = array_filter($roots, static fn(Schema $schema): bool => $schema === $sharedFilterSchema);

        self::assertCount(
            1,
            $occurrences,
            '/shared declares the multi-member-type parameter once — its GET and POST both inherit it, but '
                . 'roots() must not report the same shared declaration once per operation',
        );
    }

    public function testTheTypeListScannerProbeRefusesBothOperationsThatInheritTheSharedParameter(): void
    {
        $openApi = $this->parse();

        $result = SchemaScan::run($openApi, [TypeListScanner::probe(...)]);
        $byOperationId = [];

        foreach ($result['operations'] as $skipped) {
            $byOperationId[$skipped->operationId] = $skipped->reason;
        }

        self::assertArrayHasKey('listShared', $byOperationId, 'the GET under /shared should be refused');
        self::assertStringContainsString('type: [object, string]', $byOperationId['listShared']);

        self::assertArrayHasKey('createShared', $byOperationId, 'the POST under /shared should be refused too');
        self::assertStringContainsString('type: [object, string]', $byOperationId['createShared']);

        self::assertArrayNotHasKey(
            'getOverridden',
            $byOperationId,
            'the operation-level scalar override must not be refused for the shadowed PathItem-level shape — '
                . 'this is the emitter\'s existing refusal, unchanged',
        );
    }

    private function parse(): OpenApi
    {
        $openApi = Reader::readFromYamlFile(self::SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);
        $openApi->setDocumentContext($openApi, new JsonPointer(''));

        return $openApi;
    }

    /**
     * @return array{PathItem, Operation}
     */
    private function operation(OpenApi $openApi, string $path, string $method): array
    {
        $item = $openApi->paths?->getPath($path);
        self::assertInstanceOf(PathItem::class, $item);

        $operation = $item->getOperations()[$method] ?? null;
        self::assertInstanceOf(Operation::class, $operation);

        return [$item, $operation];
    }
}
