<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\EffectiveShape;

use function implode;
use function in_array;
use function is_array;
use function is_string;
use function sprintf;

/**
 * The per-entry checks {@see UnionGuidanceValidator::validateTags()} runs
 * against one `Profile::$unionTags` entry. Split off to keep both files
 * under the linecop limit (`quality-gates-at-maximum-strictness`) —
 * {@see UnionGuidanceValidator} keeps the orchestration (which entries
 * exist, which union each names), this keeps the document-facing checks
 * (is the field a real sibling, does every mapped branch exist, does every
 * mapped value stay inside the field's own `enum`).
 *
 * @internal
 */
final readonly class UnionTagGuidanceChecks
{
    /**
     * @return list<string>
     */
    public static function field(string $key, string $field, ?Schema $parent): array
    {
        if (!$parent instanceof Schema) {
            return [sprintf(
                "Profile::\$unionTags['%s'] names a response-position union. A response body has no enclosing "
                    . 'object for a tag to be a sibling of — it is the top of its own payload — so this layer '
                    . 'never applies there. Read the tag from inside the value instead (a document '
                    . '`discriminator`), or narrow the response with Profile::$unionPins.',
                $key,
            )];
        }

        /** @var array<string,Schema|Reference> $properties */
        $properties = $parent->properties ?? [];

        if ($field !== '' && isset($properties[$field])) {
            return [];
        }

        return [sprintf(
            "Profile::\$unionTags['%s'] names the tag field '%s', which the enclosing component does not declare. "
                . 'The tag has to be a sibling of the union — one of %s.',
            $key,
            $field,
            implode(', ', array_map(strval(...), array_keys($properties))),
        )];
    }

    /**
     * @param array<string,string> $map
     * @param list<string>         $branches
     *
     * @return list<string>
     */
    public static function branches(string $key, array $map, array $branches): array
    {
        $failures = [];

        if ($map === []) {
            return [sprintf(
                "Profile::\$unionTags['%s'] carries no value-to-branch map, so it names a tag field and no branches "
                    . 'for it to select.',
                $key,
            )];
        }

        foreach ($map as $tag => $branch) {
            if (!in_array($branch, $branches, true)) {
                $failures[] = sprintf(
                    "Profile::\$unionTags['%s'] maps '%s' to '%s', which is not one of that union's branches (%s).",
                    $key,
                    $tag,
                    $branch,
                    implode(', ', $branches),
                );
            }
        }

        return $failures;
    }

    /**
     * A tag value outside the field's own `enum` is a claim the document
     * contradicts. An enum value the map does not cover is not — the run
     * reports it as a notice, because permitting a shape nobody typed is the
     * vendor's choice rather than the consumer's mistake.
     *
     * @param array<string,string> $map
     *
     * @return list<string>
     */
    public static function tagValues(string $key, string $field, array $map, ?Schema $parent, OpenApi $openApi): array
    {
        if (!$parent instanceof Schema) {
            // field() already reported the real problem for a
            // response-position key — nothing here to add to it.
            return [];
        }

        /** @var array<string,Schema|Reference> $properties */
        $properties = $parent->properties ?? [];
        $node = $properties[$field] ?? null;
        $schema = $node === null ? null : EffectiveShape::resolve($node, $openApi);

        if (!$schema instanceof Schema || !is_array($schema->enum) || $schema->enum === []) {
            return [];
        }

        $permitted = [];

        foreach ($schema->enum as $value) {
            if (is_string($value)) {
                $permitted[] = $value;
            }
        }

        $failures = [];

        foreach (array_keys($map) as $tag) {
            if (!in_array((string) $tag, $permitted, true)) {
                $failures[] = sprintf(
                    "Profile::\$unionTags['%s'] maps the value '%s', which '%s' does not enumerate (%s).",
                    $key,
                    $tag,
                    $field,
                    implode(', ', $permitted),
                );
            }
        }

        return $failures;
    }

    public static function absent(string $property, string $key): string
    {
        return sprintf(
            "Profile::%s['%s'] names no union in the document. The key is either '<ComponentName>.<propertyName>' "
                . 'for a property-level `oneOf`/`anyOf`, or \'<rawOperationId>.response\' for one that is a whole '
                . "2xx response — and this one matches neither: the component or operation doesn't exist, the "
                . 'property is not declared, or the site names something other than a union of two or more '
                . 'branches (`a-union-response-selects-its-branch`).',
            $property,
            $key,
        );
    }
}
