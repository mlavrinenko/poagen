<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\PhpDocTypeCompatibility;

/**
 * refuse-a-phpdoctypes-override-the-property-cannot-carry: the judgement in
 * isolation. What a property can carry is decided here and nowhere else, so
 * every branch — the two silent drops this replaces, the vocabulary it
 * recognises, and the shapes it refuses — is pinned rather than inferred from
 * a generated file.
 */
final class PhpDocTypeCompatibilityTest extends TestCase
{
    #[DataProvider('compatibleOverrides')]
    public function testAnOverrideTheNativeTypeCanCarryIsAccepted(string $override, string $phpType): void
    {
        self::assertNull(PhpDocTypeCompatibility::reject('Model.prop', $override, $phpType, null));
    }

    /**
     * @return iterable<string,array{string,string}>
     */
    public static function compatibleOverrides(): iterable
    {
        yield 'numeric-string on a string' => ['numeric-string', 'string'];
        yield 'non-empty-string on a string' => ['non-empty-string', 'string'];
        yield 'class-string with an argument' => ['class-string<Foo>', 'string'];
        yield 'positive-int on an int' => ['positive-int', 'int'];
        yield 'an int range' => ['int<1, 100>', 'int'];
        yield 'an open int range' => ['int<min, 0>', 'int'];
        yield 'a float on a float' => ['float', 'float'];
        yield 'true on a bool' => ['true', 'bool'];
        yield 'a union of string literals' => ["'RUB'|'USD'", 'string'];
        yield 'a union of int literals' => ['1|2|3', 'int'];
        yield 'a union of int forms' => ['positive-int|0', 'int'];
        yield 'a float literal' => ['1.5', 'float'];
        yield 'a padded union' => ['non-empty-string | numeric-string', 'string'];
    }

    public function testAnOverrideWhoseBaseTypeDiffersFromTheNativeTypeIsRefused(): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.quantity', 'numeric-string', 'int', null);

        self::assertIsString($failure);
        self::assertStringContainsString("Profile::\$phpDocTypes['LineItem.quantity']", $failure);
        self::assertStringContainsString('native type is `int`', $failure);
    }

    public function testAnOverrideOnAStructuralPropertyIsRefusedRatherThanDropped(): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.tags', 'list<non-empty-string>', 'array', 'list<string>');

        self::assertIsString($failure);
        self::assertStringContainsString('structural type `list<string>`', $failure);
    }

    /**
     * decide-whether-an-override-may-narrow-a-structural-property: the
     * refusal names the decision that settled it, so the next reader lands on
     * the answer rather than re-deriving it from the code.
     */
    public function testTheStructuralRefusalNamesTheDecisionThatSettledIt(): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.tags', 'list<non-empty-string>', 'array', 'list<string>');

        self::assertIsString($failure);
        self::assertStringContainsString('phpdoctypes-stays-scalar-only', $failure);
    }

    public function testAnOverrideOnANonScalarPropertyIsRefused(): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.sku', 'numeric-string', '\\App\\Model\\Sku', null);

        self::assertIsString($failure);
        self::assertStringContainsString('native type is `\\App\\Model\\Sku`, not a scalar', $failure);
    }

    public function testAnOverrideOnAnUntypedPropertyIsRefused(): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.anything', 'numeric-string', null, null);

        self::assertIsString($failure);
        self::assertStringContainsString('native type is `untyped`', $failure);
    }

    /**
     * The emitter spells nullability itself, from `required` and `nullable`, so
     * an override that spells it again widens the PHPDoc past the native type.
     */
    #[DataProvider('nullableOverrides')]
    public function testAnOverrideThatSpellsNullabilityIsRefused(string $override): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.amount', $override, 'string', null);

        self::assertIsString($failure);
        self::assertStringContainsString('spells nullability the schema already decides', $failure);
    }

    /**
     * @return iterable<string,array{string}>
     */
    public static function nullableOverrides(): iterable
    {
        yield 'the question-mark form' => ['?numeric-string'];
        yield 'the union form' => ['numeric-string|null'];
        yield 'the padded union form' => ['numeric-string | null'];
    }

    public function testAUnionSpanningTwoNativeTypesIsRefused(): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.amount', 'numeric-string|positive-int', 'string', null);

        self::assertIsString($failure);
        self::assertStringContainsString('a union spanning both `string` and `int`', $failure);
    }

    #[DataProvider('unrecognisedOverrides')]
    public function testAnOverridePoagenCannotPlaceIsRefused(string $override): void
    {
        $failure = PhpDocTypeCompatibility::reject('LineItem.amount', $override, 'string', null);

        self::assertIsString($failure);
        self::assertStringContainsString('does not recognise', $failure);
    }

    /**
     * @return iterable<string,array{string}>
     */
    public static function unrecognisedOverrides(): iterable
    {
        yield 'a class name' => ['Money'];
        yield 'a structural type' => ['list<string>'];
        yield 'an array shape' => ['array{a: int}'];
        yield 'a typo' => ['non-empty-strng'];
        yield 'an unclosed range' => ['int<1, 100'];
        yield 'an unquoted literal' => ['RUB'];
    }
}
