<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Profile;

use function is_float;
use function is_int;

/**
 * Narrows the PHPDoc type of a scalar model property below its bare PHP type,
 * from what the OpenAPI schema already promised — and from what a profile
 * override forces where the document cannot say it.
 *
 * A `string` the document declared `minLength: 1` (or more) can never arrive
 * empty, so its PHPDoc reads `non-empty-string`; an `integer` whose lower
 * bound forces a value above zero reads `positive-int`. Both are strict
 * subtypes of the native type the emitted parameter still carries, so the
 * runtime is unchanged and only static analysis gets sharper
 * (`declared-shapes-become-types`, one level below the shape).
 *
 * The override is for the narrowing OpenAPI has no keyword for. A wire field
 * that is a decimal carried as a JSON string — Kilbil's money amounts — is
 * `type: string` in the document with nothing to distinguish it from free
 * text, yet a consumer wants `numeric-string`. `Profile::$phpDocTypes` supplies
 * that verbatim, keyed the same `'<RawComponentName>.<wirePropertyName>'` way
 * {@see Profile::$propertyRenames} is, and it wins
 * over anything the constraints would compute.
 *
 * Pure mapping, no I/O — {@see ModelEmitter} calls it while building each
 * property's `@param`. Returns null when nothing narrows the type, which is
 * the common case and leaves the emitter's existing PHPDoc untouched.
 *
 * {@see self::refineListItem()} reads the identical constraints one level
 * into a list property's own `items` schema, since `'Order.tags' =>
 * 'list<non-empty-string>'` is not missing from the document — it is missing
 * from the reader (`refine-list-item-types-from-the-item-schema-constraints`).
 *
 * @internal
 */
final readonly class PhpDocTypeRefiner
{
    /**
     * The refined PHPDoc type for a property, or null when none applies.
     *
     * @param string|null       $phpType  the native PHP type the emitter resolved (`string`, `int`, …)
     * @param Schema|Reference   $schema   the property's own schema node
     * @param string|null       $override the `Profile::$phpDocTypes` entry for this property, if any
     */
    public static function refine(?string $phpType, Schema|Reference $schema, ?string $override): ?string
    {
        // The override answers what the document cannot, so it is trusted
        // verbatim and wins over any constraint-derived reading. It is keyed
        // and validated against the document upstream ({@see PhpDocTypeValidator}),
        // so a stale one never reaches here.
        if ($override !== null && $override !== '') {
            return $override;
        }

        if (!$schema instanceof Schema) {
            return null;
        }

        return match ($phpType) {
            'string' => self::nonEmptyString($schema),
            'int' => self::positiveInt($schema),
            default => null,
        };
    }

    /**
     * Narrows a plain, single-level list's already-resolved structural
     * PHPDoc — `list<string>` or `list<int>`, the only two forms
     * {@see TypeResolver} produces for a scalar item with no format binding
     * — by reading the same `minLength` / `minimum` constraints
     * {@see nonEmptyString} and {@see positiveInt} already read on a bare
     * scalar property, one level into the property's own `items` schema.
     *
     * Any other structural shape comes back null and $structural is left
     * exactly as {@see TypeResolver} built it: a list of `$ref`s or inline
     * objects already prints its own name and carries nothing to narrow; a
     * list of lists (`list<list<string>>`) or a map whose value is a list
     * (`array<string, list<string>>`, {@see InlineObjectResolver::valueMapDoc()})
     * would need re-deriving what TypeResolver already computed recursively
     * for the nested node, and TypeResolver is out of this change's file
     * boundary — reconstructing that by hand here risks printing a string
     * that disagrees with what TypeResolver's own construction would say for
     * the same schema, so nested containers are deliberately left alone
     * rather than guessed at.
     *
     * @param  Schema|Reference $schema     the property's own schema node
     * @param  string           $structural the structural PHPDoc TypeResolver already resolved
     * @return string|null                  the refined structural type, or null to leave $structural as-is
     */
    public static function refineListItem(Schema|Reference $schema, string $structural): ?string
    {
        if (!$schema instanceof Schema) {
            return null;
        }

        /** @var Schema|Reference|null $items */
        $items = $schema->items;

        if (!$items instanceof Schema) {
            return null;
        }

        return match ($structural) {
            'list<string>' => self::wrapList(self::nonEmptyString($items)),
            'list<int>' => self::wrapList(self::positiveInt($items)),
            default => null,
        };
    }

    private static function wrapList(?string $itemDocType): ?string
    {
        return $itemDocType === null ? null : 'list<' . $itemDocType . '>';
    }

    private static function nonEmptyString(Schema $schema): ?string
    {
        $minLength = $schema->minLength;

        return is_int($minLength) && $minLength >= 1 ? 'non-empty-string' : null;
    }

    /**
     * True when the declared lower bound cannot admit a value of zero or below,
     * across both spellings OpenAPI uses:
     *
     *   - `minimum: 1` (inclusive) — the smallest integer allowed is 1;
     *   - `minimum: 0` with `exclusiveMinimum: true` (3.0) — 0 is excluded,
     *     so the smallest integer allowed is 1;
     *   - `exclusiveMinimum: 0` (3.1, a number) — same, one spelling newer.
     *
     * An inclusive `minimum: 0`, or an exclusive bound below zero, admits a
     * non-positive integer and does not narrow.
     */
    private static function positiveInt(Schema $schema): ?string
    {
        $minimum = $schema->minimum;
        $exclusive = $schema->exclusiveMinimum;

        // 3.1: `exclusiveMinimum` is the bound itself. A value strictly above a
        // bound of 0 or more is a positive integer.
        if ((is_int($exclusive) || is_float($exclusive)) && $exclusive >= 0) {
            return 'positive-int';
        }

        // 3.0: `exclusiveMinimum` is a boolean flag on `minimum`. Excluding a
        // bound of 0 or more leaves 1 as the smallest integer.
        if ($exclusive === true && (is_int($minimum) || is_float($minimum)) && $minimum >= 0) {
            return 'positive-int';
        }

        // Inclusive lower bound (no exclusive flag, or an explicit false one):
        // a minimum of 1 or more is already positive.
        if (($exclusive === false || $exclusive === null) && (is_int($minimum) || is_float($minimum)) && $minimum >= 1) {
            return 'positive-int';
        }

        return null;
    }
}
