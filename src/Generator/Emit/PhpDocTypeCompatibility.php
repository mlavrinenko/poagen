<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Poagen\Generator\Generator\PhpDocTypeValidator;

use function in_array;
use function preg_match;
use function sprintf;
use function str_starts_with;
use function trim;

/**
 * Judges whether a `Profile::$phpDocTypes` override can actually reach the
 * property it names — the half {@see PhpDocTypeValidator} cannot answer.
 *
 * That validator reads the document, so it can only see whether the key still
 * resolves. Whether the *value* fits is a fact about the resolved PHP type,
 * which only exists once {@see TypeResolver} has run, and both ways it goes
 * wrong used to be silent:
 *
 *   - a `numeric-string` on an `int` property printed `@param numeric-string
 *     $quantity` over `public int $quantity`, which poagen accepted and PHPStan
 *     then rejected in the consumer's own analysis of code they did not write;
 *   - an override on a property the resolver already gave a structural PHPDoc
 *     (`list<Tag>`) was dropped without a word, because the refiner is only
 *     consulted where that slot is empty.
 *
 * Both are refused here instead, in the run that could still fix them
 * (abort-on-unrepresentable-constructs). Returns a failure line rather than
 * throwing, so one pass reports every bad entry.
 *
 * The structural refusal is not a gap waiting to close — `phpdoctypes-stays-scalar-only`
 * decided the channel stays scalar-only rather than widen to carry a
 * structural override, or gain a second key for one, and named why:
 * a structural override is an open grammar rather than a closed vocabulary,
 * and poagen cannot fully check what it would print. The recognised scalar
 * vocabulary below is deliberately a list, not a parser: an override poagen
 * cannot place on one side of the scalar divide is refused by name rather
 * than emitted on trust. Widening *that* list is a one-line change here;
 * emitting a `@param` nothing checked is not recoverable downstream.
 *
 * @internal
 */
final readonly class PhpDocTypeCompatibility
{
    /**
     * PHPStan pseudo-types, each under the native type it narrows. Public so
     * {@see DocTypeSimplifier} can protect the same names from being
     * misread as class references inside a structural type
     * (`refine-list-item-types-from-the-item-schema-constraints`) without a
     * second, driftable copy of this vocabulary.
     */
    public const array BASE_OF = [
        'string' => 'string',
        'non-empty-string' => 'string',
        'non-falsy-string' => 'string',
        'truthy-string' => 'string',
        'numeric-string' => 'string',
        'literal-string' => 'string',
        'non-empty-literal-string' => 'string',
        'lowercase-string' => 'string',
        'uppercase-string' => 'string',
        'non-empty-lowercase-string' => 'string',
        'non-empty-uppercase-string' => 'string',
        'class-string' => 'string',
        'interface-string' => 'string',
        'trait-string' => 'string',
        'enum-string' => 'string',
        'callable-string' => 'string',
        'int' => 'int',
        'positive-int' => 'int',
        'negative-int' => 'int',
        'non-positive-int' => 'int',
        'non-negative-int' => 'int',
        'non-zero-int' => 'int',
        'float' => 'float',
        'bool' => 'bool',
        'true' => 'bool',
        'false' => 'bool',
    ];

    private const array NATIVE_SCALARS = ['string', 'int', 'float', 'bool'];

    /**
     * @param  string      $key        the `'<RawComponentName>.<wirePropertyName>'` entry being judged
     * @param  string|null $phpType    the native PHP type the emitter resolved, or null where it left none
     * @param  string|null $structural the structural PHPDoc the resolver produced, if it took the slot
     * @return string|null             a failure line, or null when the override may be emitted
     */
    public static function reject(string $key, string $override, ?string $phpType, ?string $structural): ?string
    {
        $entry = sprintf("Profile::\$phpDocTypes['%s']", $key);

        if ($structural !== null) {
            return sprintf(
                '%s names a property whose PHPDoc is already the structural type `%s`, which the override cannot '
                    . 'displace — it would be silently dropped. The channel stays scalar-only by decision, not by '
                    . 'gap: see `phpdoctypes-stays-scalar-only`. Remove this entry, or point it at a scalar '
                    . 'property.',
                $entry,
                $structural,
            );
        }

        if ($phpType === null || !in_array($phpType, self::NATIVE_SCALARS, true)) {
            return sprintf(
                '%s names a property whose native type is `%s`, not a scalar — a `@param` that disagrees with the '
                    . 'native type fails PHPStan. Remove this entry, or point it at a string / int / float / bool '
                    . 'property.',
                $entry,
                $phpType ?? 'untyped',
            );
        }

        return self::rejectValue($entry, $override, $phpType);
    }

    private static function rejectValue(string $entry, string $override, string $phpType): ?string
    {
        if (str_starts_with(trim($override), '?')) {
            return self::rejectNull($entry, $override);
        }

        $base = null;

        foreach (DocTypeSimplifier::topLevelMembers($override) as $member) {
            if (trim($member) === 'null') {
                return self::rejectNull($entry, $override);
            }

            $memberBase = self::baseOf($member);

            if ($memberBase === null) {
                return sprintf(
                    '%s is `%s`, and poagen does not recognise `%s` as a scalar PHPDoc type. Recognised: the PHPStan '
                        . 'string / int / float / bool pseudo-types (`non-empty-string`, `numeric-string`, '
                        . '`positive-int`, … — the full list is PhpDocTypeCompatibility::BASE_OF), an `int<a, b>` '
                        . 'range, a quoted string literal, an integer or float literal, and a `|` union of those '
                        . 'sharing one native type.',
                    $entry,
                    $override,
                    trim($member),
                );
            }

            if ($base !== null && $base !== $memberBase) {
                return sprintf(
                    '%s is `%s`, a union spanning both `%s` and `%s` — one property has one native type, so a '
                        . 'PHPDoc union across two of them cannot narrow it.',
                    $entry,
                    $override,
                    $base,
                    $memberBase,
                );
            }

            $base = $memberBase;
        }

        return $base === $phpType ? null : sprintf(
            '%s is `%s`, which narrows `%s`, but the property\'s native type is `%s` — PHPStan rejects a `@param` '
                . 'incompatible with the native type. Remove this entry, or point it at a `%s` property.',
            $entry,
            $override,
            $base ?? 'nothing',
            $phpType,
            $base ?? $phpType,
        );
    }

    /**
     * Nullability is the schema's to say and the emitter's to spell — it reads
     * `required` and `nullable` and prints `?T` or `T|null` itself. An override
     * that spells it a second time widens the PHPDoc past the native type of a
     * non-nullable property, and doubles the marker on a nullable one.
     */
    private static function rejectNull(string $entry, string $override): string
    {
        return sprintf(
            '%s is `%s`, which spells nullability the schema already decides — poagen adds `?` or `|null` from '
                . '`required` and `nullable`. Drop it and name the non-null type alone.',
            $entry,
            $override,
        );
    }

    /**
     * The native type a single (non-union) PHPDoc type narrows, or null when
     * poagen does not recognise it as one.
     */
    private static function baseOf(string $member): ?string
    {
        $member = trim($member);

        return match (true) {
            preg_match('~^int<[^<>]+>$~', $member) === 1 => 'int',
            preg_match('~^(?:class|interface|trait|enum)-string<[^<>]+>$~', $member) === 1 => 'string',
            preg_match('~^(?:\'[^\']*\'|"[^"]*")$~', $member) === 1 => 'string',
            preg_match('~^-?\d+$~', $member) === 1 => 'int',
            preg_match('~^-?\d+\.\d+$~', $member) === 1 => 'float',
            default => self::BASE_OF[$member] ?? null,
        };
    }
}
