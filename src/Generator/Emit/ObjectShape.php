<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use stdClass;

use function get_object_vars;
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

    /**
     * True only when the document itself wrote `additionalProperties: true`.
     *
     * A fourth accessor that does not mean what it says, alongside the three
     * in AGENT.md. JSON Schema defaults the keyword to `true` and the parser
     * substitutes that default in `attributeDefaults()`, so
     * `$schema->additionalProperties` reads back `true` for a document that
     * declared nothing exactly as it does for one that wrote the word —
     * measured against `devizzent/cebe-php-openapi`'s `spec/Schema.php`, which
     * lists `'additionalProperties' => true` among its defaults.
     *
     * Reading it through the accessor would therefore put an extras bag on
     * every object paogen has ever emitted — 107 models in the kilbil example
     * alone — for a permission nobody granted. `getSerializableData()` reflects
     * only what the document set, before the substitution, and is how
     * {@see ServerCatalog} tells the same two states apart for `servers:`.
     *
     * An author who wrote nothing said nothing. `false` is a third state again
     * and stays the signal that closes a shape.
     */
    public static function declaresOpenExtras(Schema $schema): bool
    {
        // Rules out `false` and the schema form only. It does *not* spare the
        // serialisation below on the common node, and an earlier version of
        // this comment claimed it did: the defaulted case is the vast
        // majority and reads back `true`, so it falls straight through.
        // Measured on `examples/github/schemas/api.github.com.yaml` — 894 of
        // 918 components read `true` through the accessor, 6 wrote it. The
        // serialisation is kept anyway because it is the only public reading
        // (`hasPropertyValue()` is protected) and it is cheap enough:
        // `declaresOpenExtras` over that document's 809 object components
        // costs 0.11s, and kilbil's whole generation is unchanged at 0.37s.
        if ($schema->additionalProperties !== true) {
            return false;
        }

        $raw = $schema->getSerializableData();
        $rawVars = $raw instanceof stdClass ? get_object_vars($raw) : [];

        return ($rawVars['additionalProperties'] ?? null) === true;
    }

    /**
     * True only when the document wrote `additionalProperties: false` — the
     * third state {@see declaresOpenExtras} names, and the one the parser never
     * substitutes: its default is `true`, so `false` can only have been written.
     * No serialisation round-trip is needed to tell it apart from silence.
     *
     * A closed shape with no declared properties accepts `{}` and nothing else,
     * which is what makes it selectable inside a union by the *absence* of
     * fields where every other branch is selectable by their presence. Exactly
     * one of the fifty-two branch schemas across both large vendor documents
     * declares it — GitHub's `empty-object` — and
     * `declare-an-undiscriminated-union-as-raw-data` measured that.
     */
    public static function declaresClosedShape(Schema $schema): bool
    {
        return $schema->additionalProperties === false;
    }
}
