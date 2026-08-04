<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\Reader;
use cebe\openapi\spec\Schema;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\InlineShapeFingerprint;

/**
 * Unit coverage for {@see InlineShapeFingerprint} — the structural-identity
 * check `name-inline-schemas-by-operation-and-status`'s merge feature runs
 * over a `Profile::$inlineModels` group's sites before letting them share a
 * class.
 */
final class InlineShapeFingerprintTest extends TestCase
{
    public function testTwoIdenticalObjectSchemasAreTheSame(): void
    {
        $a = $this->schema('type: object
required: [code, message]
properties:
  code: {type: integer}
  message: {type: string}');
        $b = $this->schema('type: object
required: [code, message]
properties:
  code: {type: integer}
  message: {type: string}');

        self::assertTrue(InlineShapeFingerprint::same($a, $b));
        self::assertNull(InlineShapeFingerprint::firstDifference($a, $b));
    }

    public function testTwoSchemasDifferingOnlyInDescriptionAreStillTheSame(): void
    {
        $a = $this->schema('type: object
properties:
  code: {type: integer, description: "a code"}');
        $b = $this->schema('type: object
properties:
  code: {type: integer, description: "a different code"}');

        self::assertTrue(InlineShapeFingerprint::same($a, $b));
    }

    public function testAPropertyWithADifferentTypeIsNamedInTheDifference(): void
    {
        $a = $this->schema('type: object
required: [code, message]
properties:
  code: {type: integer}
  message: {type: string}');
        $b = $this->schema('type: object
required: [code, message]
properties:
  code: {type: string}
  message: {type: string}');

        self::assertFalse(InlineShapeFingerprint::same($a, $b));
        self::assertStringContainsString('code', (string) InlineShapeFingerprint::firstDifference($a, $b));
    }

    public function testAPropertyPresentOnOneAndAbsentOnTheOtherIsNamedInTheDifference(): void
    {
        $a = $this->schema('type: object
properties:
  code: {type: integer}
  message: {type: string}');
        $b = $this->schema('type: object
properties:
  code: {type: integer}');

        $diff = InlineShapeFingerprint::firstDifference($a, $b);
        self::assertNotNull($diff);
        self::assertStringContainsString('message', $diff);
    }

    public function testANestedPropertyDifferenceIsNamedWithADottedPath(): void
    {
        $a = $this->schema('type: object
properties:
  shipping:
    type: object
    properties:
      city: {type: string}');
        $b = $this->schema('type: object
properties:
  shipping:
    type: object
    properties:
      city: {type: integer}');

        $diff = InlineShapeFingerprint::firstDifference($a, $b);
        self::assertNotNull($diff);
        self::assertStringContainsString('shipping.city', $diff);
    }

    private function schema(string $yaml): Schema
    {
        $schema = Reader::readFromYaml($yaml, Schema::class);
        self::assertInstanceOf(Schema::class, $schema);

        return $schema;
    }
}
