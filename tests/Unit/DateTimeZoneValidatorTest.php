<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\DateTimeZoneValidator;

use function array_diff;
use function array_values;

/**
 * `Profile::$dateTimeZone` is answerable from the profile alone, so like
 * `Profile::$formats` it is checked before the document is read. The check
 * earns its place because the alternative failure is silent at generation
 * time and thrown at run time, in the consumer's application, by
 * `DateTimeZone`'s own constructor.
 */
final class DateTimeZoneValidatorTest extends TestCase
{
    public function testStatingNothingPasses(): void
    {
        self::assertSame([], new DateTimeZoneValidator()->validate(null));
    }

    public function testAZonePhpKnowsPasses(): void
    {
        self::assertSame([], new DateTimeZoneValidator()->validate('Europe/Moscow'));
    }

    public function testUtcPasses(): void
    {
        self::assertSame([], new DateTimeZoneValidator()->validate('UTC'));
    }

    /**
     * A deprecated identifier still resolves in PHP, and a document pinned to
     * one is still telling the truth about what its vendor sends — refusing
     * it would refuse a fact. Pick the identifier from the system's own list:
     * some tzdata builds strip the backward-compatible links entirely, and a
     * hardcoded `US/Eastern` would then fail for a reason unrelated to the
     * validator.
     */
    public function testADeprecatedIdentifierStillPasses(): void
    {
        $deprecated = array_values(array_diff(
            DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC),
            DateTimeZone::listIdentifiers(DateTimeZone::ALL),
        ));

        if ($deprecated === []) {
            self::markTestSkipped('this tzdata build carries no deprecated identifiers');
        }

        self::assertSame([], new DateTimeZoneValidator()->validate($deprecated[0]));
    }

    public function testAnAbbreviationIsNotAZone(): void
    {
        $failures = new DateTimeZoneValidator()->validate('MSK');

        self::assertCount(1, $failures);
        self::assertStringContainsString("'MSK'", $failures[0]);
        self::assertStringContainsString('DateTimeZone::listIdentifiers()', $failures[0]);
    }

    /**
     * The near-miss this validator exists for: one letter away from a real
     * identifier, and indistinguishable from one to whoever typed it.
     */
    public function testANearMissFails(): void
    {
        $failures = new DateTimeZoneValidator()->validate('Europe/Moskow');

        self::assertCount(1, $failures);
        self::assertStringContainsString("'Europe/Moskow'", $failures[0]);
    }

    public function testAnOffsetIsNotAZoneIdentifier(): void
    {
        self::assertCount(1, new DateTimeZoneValidator()->validate('UTC+3'));
    }
}
