<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Emit\OperationReferencedComponents;
use PHPUnit\Framework\TestCase;

/**
 * Unit coverage for {@see OperationReferencedComponents}.
 *
 * The fixture's `getGadget` and `getWrapper` responses are a bare `$ref`
 * directly under `content.application/json.schema` — {@see
 * \Mlavrinenko\Paogen\Generator\Emit\SchemaWalk::operationRoots()} guards
 * `instanceof Schema` at exactly that position and would answer nothing for
 * either, which is the gap this class exists to close for
 * a-skipped-component-leaves-dangling-references-behind-it.
 */
final class OperationReferencedComponentsTest extends TestCase
{
    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/dangling-component-reference-3.0.yaml';

    public function testABareRefResponseIsFound(): void
    {
        [$operation, $pathItem] = $this->operation('/gadgets/{id}');

        self::assertSame(['Gadget'], OperationReferencedComponents::of($operation, $pathItem));
    }

    public function testABareRefResponseToADifferentComponentIsFound(): void
    {
        [$operation, $pathItem] = $this->operation('/wrappers/{id}');

        self::assertSame(['Wrapper'], OperationReferencedComponents::of($operation, $pathItem));
    }

    public function testAnOperationWithNoComponentReferenceFindsNothing(): void
    {
        [$operation, $pathItem] = $this->operation('/ping');

        self::assertSame([], OperationReferencedComponents::of($operation, $pathItem));
    }

    /**
     * @return array{0: Operation, 1: PathItem}
     */
    private function operation(string $path): array
    {
        $openApi = Reader::readFromYamlFile(self::SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);

        $item = $openApi->paths?->getPath($path);
        self::assertInstanceOf(PathItem::class, $item);
        self::assertInstanceOf(Operation::class, $item->get);

        return [$item->get, $item];
    }
}
