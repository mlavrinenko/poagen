<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\FormatBindingValidator;
use Poagen\Generator\Tests\Fixtures\ValueObject\Slug;
use Poagen\Runtime\Format\RamseyUuid;
use Poagen\Runtime\ScalarBinding;
use stdClass;

/**
 * `built-in-uuid-and-binary-format-bindings`: both halves of a
 * `Profile::$formats` entry are checked before the document is read, because
 * both are answerable from the class alone.
 */
final class FormatBindingValidatorTest extends TestCase
{
    public function testAnEntryNamingAScalarBindingPasses(): void
    {
        self::assertSame([], new FormatBindingValidator()->validate([
            'uuid' => RamseyUuid::class,
            'slug' => Slug::class,
        ]));
    }

    public function testAnEmptyMapPasses(): void
    {
        self::assertSame([], new FormatBindingValidator()->validate([]));
    }

    public function testAnEntryNamingAClassThatDoesNotExistFails(): void
    {
        $failures = new FormatBindingValidator()->validate(['uuid' => 'Totally\\Bogus\\ClassName']);

        self::assertCount(1, $failures);
        self::assertStringContainsString("Profile::\$formats['uuid']", $failures[0]);
        self::assertStringContainsString("class 'Totally\\Bogus\\ClassName' that does not exist", $failures[0]);
    }

    /**
     * The silent case the existence check alone would let through: a real
     * class that never opted into the scalar contract reads to
     * `Bindings::scalarFormat()` as a deliberate whole-object binding, so the
     * property would emit as an object the payload never carries and nothing
     * would say so.
     */
    public function testAnEntryNamingAClassThatIsNotAScalarBindingFails(): void
    {
        $failures = new FormatBindingValidator()->validate(['uuid' => stdClass::class]);

        self::assertCount(1, $failures);
        self::assertStringContainsString("Profile::\$formats['uuid']", $failures[0]);
        self::assertStringContainsString('does not implement ' . ScalarBinding::class, $failures[0]);
    }

    /**
     * Every problem in one pass, the discipline every guidance validator here
     * shares (abort-on-unrepresentable-constructs) — a run does not stop at
     * the first bad entry and make the author find the rest one at a time.
     */
    public function testEveryBadEntryIsReportedInOnePass(): void
    {
        $failures = new FormatBindingValidator()->validate([
            'uuid' => 'Totally\\Bogus\\ClassName',
            'email' => stdClass::class,
            'slug' => Slug::class,
        ]);

        self::assertCount(2, $failures);
    }
}
