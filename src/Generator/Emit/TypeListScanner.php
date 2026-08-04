<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;

use function sprintf;

/**
 * Refuses a schema node whose `type` names several types PHP cannot express
 * as one.
 *
 * `type: [string, integer]` is representable — PHP says `string|int` — and
 * {@see SchemaType} handles it. `type: [object, string]` is not: there is no
 * single class for an inline object member and no single item type for an
 * array member, so any type poagen emitted would be a guess or `mixed`.
 *
 * This is one probe over the document-wide walk in {@see SchemaScan}, which
 * owns the traversal and the attribution to the operation or component the
 * node sits in.
 *
 * @internal
 */
final readonly class TypeListScanner
{
    /**
     * @return string|null a complete diagnostic for a node this refuses, null
     *                     for one it accepts
     */
    public static function probe(Schema $schema): ?string
    {
        $type = SchemaType::of($schema);

        if (!$type->isUnrepresentable()) {
            return null;
        }

        return sprintf(
            'schema at %s declares `type: [%s]` — poagen emits a PHP union for a list of scalar types, but a '
                . 'list mixing `object` or `array` with anything else has no single PHP type: an inline object '
                . 'member needs a class of its own and an array member needs one item type. Split it into a '
                . '`oneOf` of named component schemas, or narrow it to one type',
            SynthesisedModel::originOf($schema),
            $type->describe(),
        );
    }
}
