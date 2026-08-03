<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\UnionGuidanceValidator;

use function count;
use function implode;
use function in_array;
use function is_array;
use function is_string;
use function sprintf;

/**
 * Layer two: the tag that selects a branch lives on the *enclosing* object, as
 * a sibling of the union rather than a field inside it.
 *
 * This is where a real vendor puts it. GitHub's `event.payload` chooses among
 * sixteen branches on the sibling `event.type`, and nothing inside the value
 * could do the job at all — one branch, `public-event`, declares no properties.
 * `secret-scanning-location.details` is the same shape with thirteen.
 *
 * Two sources, document first. A `discriminator` the document put on the parent
 * component is honoured wherever it appears; otherwise a
 * `Profile::$unionTags` entry supplies the field and the value-to-branch map.
 * Whether that map is *true* of the document is
 * {@see UnionGuidanceValidator}'s job, not this
 * one's — this assembles, that verifies, and mixing the two would report the
 * union as the cause of a bad entry.
 *
 * A tag field that declares an `enum` gets one extra reading: any enum value
 * the map does not name is reported at generation time. The document permits a
 * shape the mapping cannot type, and a consumer should hear that here rather
 * than when the payload arrives — GitHub's `repository-ruleset.conditions` is
 * the live case, where `source_type` enumerates three values against two
 * branches.
 *
 * @internal
 */
final readonly class UnionTagBinding
{
    /**
     * @param list<Reference> $refs
     */
    public static function resolve(
        string $key,
        string $position,
        Schema $parent,
        array $refs,
        ?Profile $profile,
        OpenApi $openApi,
    ): ?UnionResolution {
        $declared = $parent->discriminator;

        if ($declared instanceof Discriminator) {
            return self::build($position, $declared->propertyName, self::mappingOf($declared, $refs), $parent, $openApi, 'declared by the document on the enclosing component');
        }

        $entry = $profile?->unionTags[$key] ?? null;

        if ($entry === null) {
            return null;
        }

        $field = $entry['field'] ?? '';
        /** @var array<string,string> $map */
        $map = $entry['map'] ?? [];

        return self::build($position, $field, $map, $parent, $openApi, "Profile::\$unionTags['" . $key . "']");
    }

    /**
     * @param array<string,string> $map
     */
    private static function build(string $position, string $field, array $map, Schema $parent, OpenApi $openApi, string $source): ?UnionResolution
    {
        if ($field === '' || $map === []) {
            return null;
        }

        return UnionResolution::tagOnParent($position, $field, $map, $source, self::unmappedNote($field, $map, $parent, $openApi));
    }

    /**
     * A document `discriminator` may carry an explicit `mapping`; without one,
     * OpenAPI's default is that the tag equals the component name.
     *
     * Public because {@see ResponseUnionPlanner}
     * needs the identical reading for a response-position tag-in-value
     * union — the same document keyword, read the same way, regardless of
     * which position it discriminates.
     *
     * @param  list<Reference>      $refs
     * @return array<string,string>
     */
    public static function mappingOf(Discriminator $discriminator, array $refs): array
    {
        $mapping = $discriminator->mapping;
        $out = [];

        if (is_array($mapping) && $mapping !== []) {
            foreach ($mapping as $tag => $ref) {
                $out[(string) $tag] = ComponentName::rawFromRef((string) $ref);
            }

            return $out;
        }

        foreach ($refs as $ref) {
            $name = ComponentName::rawFromRef($ref->getReference());
            $out[$name] = $name;
        }

        return $out;
    }

    /**
     * The sentence appended when the tag field enumerates values the map does
     * not name. Empty when it enumerates nothing, or names them all.
     *
     * @param array<string,string> $map
     */
    private static function unmappedNote(string $field, array $map, Schema $parent, OpenApi $openApi): string
    {
        /** @var array<string,Schema|Reference> $properties */
        $properties = $parent->properties ?? [];
        $node = $properties[$field] ?? null;
        $schema = $node === null ? null : EffectiveShape::resolve($node, $openApi);

        if (!$schema instanceof Schema || !is_array($schema->enum)) {
            return '';
        }

        $unmapped = [];

        foreach ($schema->enum as $value) {
            if (is_string($value) && !isset($map[$value]) && !in_array($value, $unmapped, true)) {
                $unmapped[] = $value;
            }
        }

        if ($unmapped === []) {
            return '';
        }

        return sprintf(
            ' `%s` also declares %d value(s) the mapping does not name (%s) — the document permits a shape no branch '
                . 'types, and a payload carrying one of them raises rather than being mapped to a branch nobody chose.',
            $field,
            count($unmapped),
            implode(', ', $unmapped),
        );
    }
}
