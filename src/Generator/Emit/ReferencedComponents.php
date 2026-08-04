<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function array_unique;
use function array_values;
use function is_array;

/**
 * Every distinct raw `components.schemas` name a schema node reaches through
 * a `$ref`, anywhere beneath it — a property, an array's `items`, an
 * `additionalProperties` map, or any `allOf`/`oneOf`/`anyOf` branch.
 *
 * Split out of {@see SchemaWalk} rather than added to it: that class already
 * sits at linecop's line cap, and this asks a different question of the same
 * tree — not "is there a problem here" but "what does this point at" — so it
 * earns its own file rather than crowding the one every refusal probe walks.
 *
 * A `$ref` is recorded and not followed, the same discipline {@see
 * SchemaWalk::children()} keeps: the component it names is its own root,
 * walked on its own rather than inlined here. That is what makes this safe to
 * run over every component and every operation once each — a schema this walk
 * has already visited cannot be re-entered through a reference, so there is no
 * cycle to guard against.
 *
 * Used by {@see DanglingReferenceScanner} to find every operation and
 * component still pointing at one the generator refused to emit
 * (a-skipped-component-leaves-dangling-references-behind-it).
 *
 * @internal
 */
final readonly class ReferencedComponents
{
    /**
     * @return list<string>
     */
    public static function of(Schema $schema): array
    {
        $out = [];
        self::collect($schema, $out);

        return array_values(array_unique($out));
    }

    /**
     * @param list<string> $out
     */
    private static function collect(Schema $schema, array &$out): void
    {
        foreach (is_array($schema->properties) ? $schema->properties : [] as $property) {
            self::collectFromNode($property, $out);
        }

        foreach ([$schema->items, $schema->additionalProperties] as $node) {
            self::collectFromNode($node, $out);
        }

        foreach (SchemaWalk::compositionBranches($schema) as $branch) {
            self::collectFromNode($branch, $out);
        }
    }

    /**
     * @param list<string> $out
     */
    private static function collectFromNode(Schema|Reference|bool|null $node, array &$out): void
    {
        if ($node instanceof Reference) {
            $out[] = ComponentName::rawFromRef($node->getReference());

            return;
        }

        if ($node instanceof Schema) {
            self::collect($node, $out);
        }
    }
}
