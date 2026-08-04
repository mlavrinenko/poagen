<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use cebe\openapi\Reader;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\DanglingReferenceScanner;
use Mlavrinenko\Paogen\Generator\Emit\ReferencedComponents;
use PHPUnit\Framework\TestCase;

/**
 * Unit coverage for {@see ReferencedComponents} —
 * a-skipped-component-leaves-dangling-references-behind-it's building block,
 * answering "what does this schema node point at by `$ref`" so {@see
 * DanglingReferenceScanner} can find every component still reaching one the
 * generator refused to emit.
 */
final class ReferencedComponentsTest extends TestCase
{
    public function testFindsARefOnAProperty(): void
    {
        $schema = $this->schema('
type: object
properties:
  owner:
    $ref: "#/components/schemas/Person"
');

        self::assertSame(['Person'], ReferencedComponents::of($schema));
    }

    public function testFindsARefInArrayItems(): void
    {
        $schema = $this->schema('
type: array
items:
  $ref: "#/components/schemas/Person"
');

        self::assertSame(['Person'], ReferencedComponents::of($schema));
    }

    public function testFindsARefInAdditionalProperties(): void
    {
        $schema = $this->schema('
type: object
additionalProperties:
  $ref: "#/components/schemas/Person"
');

        self::assertSame(['Person'], ReferencedComponents::of($schema));
    }

    public function testABooleanAdditionalPropertiesFindsNothing(): void
    {
        $schema = $this->schema('
type: object
additionalProperties: true
');

        self::assertSame([], ReferencedComponents::of($schema));
    }

    public function testFindsEveryBranchOfAOneOf(): void
    {
        $schema = $this->schema('
oneOf:
  - $ref: "#/components/schemas/A"
  - $ref: "#/components/schemas/B"
');

        self::assertSame(['A', 'B'], ReferencedComponents::of($schema));
    }

    public function testFindsARefNestedTwoLevelsDeep(): void
    {
        $schema = $this->schema('
type: object
properties:
  shipping:
    type: object
    properties:
      address:
        $ref: "#/components/schemas/Address"
');

        self::assertSame(['Address'], ReferencedComponents::of($schema));
    }

    public function testDeduplicatesARepeatedReference(): void
    {
        $schema = $this->schema('
type: object
properties:
  billTo:
    $ref: "#/components/schemas/Address"
  shipTo:
    $ref: "#/components/schemas/Address"
');

        self::assertSame(['Address'], ReferencedComponents::of($schema));
    }

    public function testAScalarSchemaWithNoRefFindsNothing(): void
    {
        $schema = $this->schema('
type: object
properties:
  name:
    type: string
');

        self::assertSame([], ReferencedComponents::of($schema));
    }

    private function schema(string $yaml): Schema
    {
        $schema = Reader::readFromYaml($yaml, Schema::class);
        self::assertInstanceOf(Schema::class, $schema);

        return $schema;
    }
}
