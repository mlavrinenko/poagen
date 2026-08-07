<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Emit\CompositionResolver;

use function array_keys;
use function is_int;

/**
 * The wire property names a raw component declares, shared by every profile
 * validator that keys on `'<RawComponentName>.<wirePropertyName>'`
 * ({@see PropertyRenameValidator}, {@see PhpDocTypeValidator}).
 *
 * One place, one reading: `allOf` is flattened through the same
 * {@see CompositionResolver::materialiseAllOf} the real run uses, so a
 * validator and emission always agree on what "the model" contains. Null
 * means the name is not a component a property-keyed profile field can target
 * at all — absent from the document, or a shape with no properties of its own
 * (enum, scalar, array, union, or an `allOf` with nothing mergeable).
 *
 * @internal
 */
final readonly class ComponentPropertyNames
{
    /**
     * @return list<string>|null
     */
    public static function of(OpenApi $openApi, Emit\ComponentCatalog $components, string $rawName): ?array
    {
        $shape = $components->shapeOf($rawName);

        if (!$shape instanceof Emit\ComponentShape) {
            return null;
        }

        $schema = match ($shape->kind) {
            Emit\ComponentShape::KIND_OBJECT => $shape->schema,
            Emit\ComponentShape::KIND_ALLOF_OBJECT => $shape->schema instanceof Schema
                ? CompositionResolver::materialiseAllOf($shape->schema, $openApi)
                : null,
            default => null,
        };

        if (!$schema instanceof Schema) {
            return null;
        }

        // YAML parses a purely numeric key as an int; coerce to string the
        // same way {@see Emit\ModelEmitter} does, so a numeric-looking property
        // name compares correctly against the profile's (string) key.
        $names = [];

        foreach (array_keys($schema->properties ?? []) as $name) {
            $names[] = is_int($name) ? (string) $name : $name;
        }

        return $names;
    }
}
