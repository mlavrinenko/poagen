<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\PhpDocTypeRefiner;

/**
 * refined-phpdoc-types: the constraint-to-doc-type mapping in isolation, the
 * layer speconaut does not cover. Every branch of the reading — the two
 * narrowings OpenAPI can express, the override that wins over both, and the
 * bounds that legitimately narrow nothing — is pinned here so a change to the
 * predicate is a test change, not a silent shift in emitted types.
 */
final class PhpDocTypeRefinerTest extends TestCase
{
    public function testAStringWithMinLengthOneBecomesNonEmptyString(): void
    {
        self::assertSame(
            'non-empty-string',
            PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string', 'minLength' => 1]), null),
        );
    }

    public function testAStringWithMinLengthAboveOneStillBecomesNonEmptyString(): void
    {
        self::assertSame(
            'non-empty-string',
            PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string', 'minLength' => 8]), null),
        );
    }

    public function testAStringWithMinLengthZeroDoesNotNarrow(): void
    {
        self::assertNull(
            PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string', 'minLength' => 0]), null),
        );
    }

    public function testAStringWithNoMinLengthDoesNotNarrow(): void
    {
        self::assertNull(PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string']), null));
    }

    /**
     * @param array<string,mixed> $data
     */
    #[DataProvider('positiveIntegerBounds')]
    public function testAnIntegerLowerBoundAboveZeroBecomesPositiveInt(array $data): void
    {
        self::assertSame('positive-int', PhpDocTypeRefiner::refine('int', new Schema($data), null));
    }

    /**
     * @return iterable<string,array{array<string,mixed>}>
     */
    public static function positiveIntegerBounds(): iterable
    {
        yield 'inclusive minimum 1' => [['type' => 'integer', 'minimum' => 1]];
        yield 'inclusive minimum above 1' => [['type' => 'integer', 'minimum' => 42]];
        yield '3.0 exclusive minimum 0' => [['type' => 'integer', 'minimum' => 0, 'exclusiveMinimum' => true]];
        yield '3.0 exclusive minimum 1' => [['type' => 'integer', 'minimum' => 1, 'exclusiveMinimum' => true]];
        yield '3.1 exclusive minimum 0' => [['type' => 'integer', 'exclusiveMinimum' => 0]];
        yield '3.1 exclusive minimum 5' => [['type' => 'integer', 'exclusiveMinimum' => 5]];
    }

    /**
     * @param array<string,mixed> $data
     */
    #[DataProvider('nonPositiveIntegerBounds')]
    public function testAnIntegerLowerBoundThatAdmitsZeroOrLessDoesNotNarrow(array $data): void
    {
        self::assertNull(PhpDocTypeRefiner::refine('int', new Schema($data), null));
    }

    /**
     * @return iterable<string,array{array<string,mixed>}>
     */
    public static function nonPositiveIntegerBounds(): iterable
    {
        yield 'inclusive minimum 0' => [['type' => 'integer', 'minimum' => 0]];
        yield 'inclusive negative minimum' => [['type' => 'integer', 'minimum' => -5]];
        yield '3.1 exclusive minimum below zero' => [['type' => 'integer', 'exclusiveMinimum' => -1]];
        yield 'no bound at all' => [['type' => 'integer']];
    }

    public function testTheOverrideWinsOverEveryConstraintDerivedReading(): void
    {
        // A bare `type: string` the document says nothing narrowing about —
        // the numeric-string case this channel exists for.
        self::assertSame(
            'numeric-string',
            PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string']), 'numeric-string'),
        );

        // Even where a constraint would compute one, the override still wins.
        self::assertSame(
            'numeric-string',
            PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string', 'minLength' => 1]), 'numeric-string'),
        );
    }

    public function testAnEmptyOverrideIsIgnoredAndConstraintsStillApply(): void
    {
        self::assertSame(
            'non-empty-string',
            PhpDocTypeRefiner::refine('string', new Schema(['type' => 'string', 'minLength' => 1]), ''),
        );
    }

    public function testANonScalarPhpTypeNarrowsNothingFromConstraints(): void
    {
        // `number` / `bool` / `array` carry no refinement in this mapping.
        self::assertNull(PhpDocTypeRefiner::refine('float', new Schema(['type' => 'number', 'minimum' => 1]), null));
        self::assertNull(PhpDocTypeRefiner::refine('array', new Schema(['type' => 'array']), null));
        self::assertNull(PhpDocTypeRefiner::refine(null, new Schema([]), null));
    }

    public function testAReferenceNodeCarriesNoConstraintButStillHonoursAnOverride(): void
    {
        $ref = new Reference(['$ref' => '#/components/schemas/Whatever']);

        self::assertNull(PhpDocTypeRefiner::refine('string', $ref, null));
        self::assertSame('numeric-string', PhpDocTypeRefiner::refine('string', $ref, 'numeric-string'));
    }
}
