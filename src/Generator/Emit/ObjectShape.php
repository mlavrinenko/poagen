<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function is_array;

/**
 * Whether a schema describes an object, whether or not it said `type: object`.
 *
 * `type` is optional in JSON Schema and plenty of real documents leave it off a
 * node that declares `properties` — the shape is already unambiguous, so the
 * keyword is redundant and authors drop it. {@see ComponentCatalog} has always
 * known that and checked for properties when the keyword was absent;
 * {@see TypeResolver} read the keyword alone and answered `mixed`, so one
 * schema was a class in the component position and a `mixed` in every other.
 * Reading the question in one place is what keeps the two answers the same.
 *
 * A value schema under `additionalProperties` says the same thing about the
 * node: the vendor described what its keys carry, so the node is a
 * string-keyed map of that type rather than an unknown. That is a collection,
 * not an evasion, and `declared-shapes-become-types` keeps collections as PHP
 * arrays.
 *
 * The keyword itself is still read only by {@see SchemaType}; this class asks
 * it that question and adds the two structural ones.
 *
 * @internal
 */
final readonly class ObjectShape
{
    /**
     * True when the document described an object here — by naming the type, by
     * declaring properties, or by typing the values of the extra keys.
     */
    public static function is(Schema $schema): bool
    {
        if (SchemaType::of($schema)->is('object')) {
            return true;
        }
        if (self::hasProperties($schema)) {
            return true;
        }
        return self::hasValueSchema($schema);
    }

    /**
     * True when the document declared at least one named property. An empty
     * `properties: {}` declares none, which is how GitHub's `empty-object`
     * spells a shape that carries nothing.
     */
    public static function hasProperties(Schema $schema): bool
    {
        return is_array($schema->properties) && $schema->properties !== [];
    }

    /**
     * True when `additionalProperties` carries a schema for the extra keys'
     * values, rather than the bare `true`/`false` that only permits or forbids
     * them. Only the schema form types anything.
     */
    public static function hasValueSchema(Schema $schema): bool
    {
        $additional = $schema->additionalProperties;

        return $additional instanceof Schema || $additional instanceof Reference;
    }
}
