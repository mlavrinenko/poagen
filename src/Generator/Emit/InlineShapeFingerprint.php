<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function array_keys;
use function array_unique;
use function is_array;
use function sort;
use function sprintf;

use const SORT_STRING;

/**
 * The one difference between two inline schemas' shapes — the question
 * `name-inline-schemas-by-operation-and-status`'s merge feature needs
 * answered with a property name a consumer recognises, not a generic diff.
 * `Profile::$inlineModels` lets a consumer name several sites into one
 * class; before that class exists, something has to confirm every site
 * actually agrees, or the merge silently keeps whichever site's fields the
 * first one claimed and drops the rest.
 *
 * Recurses property by property rather than delegating the whole comparison
 * to {@see SchemaShapeFingerprint} in one call: that class reads `properties`
 * as one opaque, unfiltered block, correct for the single leaf-vs-leaf
 * comparison `AllOfAccumulator` needs it for, but wrong here — two response
 * bodies differing only in one property's `description` would read as
 * different, because the raw block carries every nested `description` along
 * with it. Walking one property at a time and asking
 * {@see SchemaShapeFingerprint} about each *leaf* keeps its
 * documentation-is-not-disagreement reading true at every depth, not only
 * the top.
 *
 * @internal
 */
final readonly class InlineShapeFingerprint
{
    /** True when both schemas describe the same shape, all the way down. */
    public static function same(Schema $a, Schema $b): bool
    {
        return self::diff($a, $b, '(root)') === null;
    }

    /**
     * The first property at which `$a` and `$b` disagree, described for a
     * human — or null when {@see same()} would say true.
     */
    public static function firstDifference(Schema $a, Schema $b): ?string
    {
        return self::diff($a, $b, '(root)');
    }

    private static function diff(Schema $a, Schema $b, string $path): ?string
    {
        $kindA = self::kindOf($a);
        $kindB = self::kindOf($b);

        if ($kindA !== $kindB) {
            return sprintf('%s is `%s` in one and `%s` in the other', $path, $kindA, $kindB);
        }

        return match ($kindA) {
            'object' => self::diffObjects($a, $b, $path),
            'array' => self::diffProperty($a->items, $b->items, $path . '[]'),
            default => SchemaShapeFingerprint::same($a, $b) ? null : sprintf('%s differs', $path),
        };
    }

    private static function kindOf(Schema $schema): string
    {
        if (SchemaType::of($schema)->is('array')) {
            return 'array';
        }

        return ObjectShape::is($schema) ? 'object' : 'scalar';
    }

    private static function diffObjects(Schema $a, Schema $b, string $path): ?string
    {
        $propsA = $a->properties ?? [];
        $propsB = $b->properties ?? [];
        $names = array_unique([...array_keys($propsA), ...array_keys($propsB)]);
        sort($names, SORT_STRING);

        foreach ($names as $name) {
            $childPath = $path === '(root)' ? $name : $path . '.' . $name;
            $diff = self::diffProperty($propsA[$name] ?? null, $propsB[$name] ?? null, $childPath);

            if ($diff !== null) {
                return $diff;
            }
        }

        if (self::sortedRequired($a) !== self::sortedRequired($b)) {
            return sprintf('%s required set differs', $path);
        }

        return self::diffProperty(self::additionalOf($a), self::additionalOf($b), $path . ' additionalProperties');
    }

    private static function diffProperty(Schema|Reference|bool|null $childA, Schema|Reference|bool|null $childB, string $path): ?string
    {
        if ($childA === null || $childB === null) {
            return $childA === $childB ? null : sprintf("'%s' is present in one and absent in the other", $path);
        }

        if (is_bool($childA) || is_bool($childB)) {
            return $childA === $childB ? null : sprintf('%s differs', $path);
        }

        if ($childA instanceof Reference || $childB instanceof Reference) {
            return SchemaShapeFingerprint::same($childA, $childB) ? null : sprintf("'%s' points at a different component in each", $path);
        }

        return self::diff($childA, $childB, $path);
    }

    private static function additionalOf(Schema $schema): Schema|Reference|bool
    {
        return $schema->additionalProperties;
    }

    /** @return list<string> */
    private static function sortedRequired(Schema $schema): array
    {
        $required = is_array($schema->required) ? $schema->required : [];
        sort($required, SORT_STRING);

        return $required;
    }
}
