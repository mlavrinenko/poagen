<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use stdClass;

use function array_key_exists;
use function get_object_vars;
use function json_encode;

/**
 * Whether two schema (or `$ref`) nodes describe the same PHP-emitted shape —
 * shared by {@see AllOfAccumulator}, which uses it to tell an `allOf`
 * member's second declaration of a property from a genuine conflict, and by
 * {@see InlineShapeFingerprint}, which uses it to tell whether a
 * `Profile::$inlineModels` merge candidate's sites agree.
 *
 * Judged on {@see SHAPE_KEYS} only — the keywords that decide the emitted
 * PHP type — not the full node. Two declarations of `type: string` for the
 * same property with two different `description`/`example` strings are
 * documentation, not disagreement.
 *
 * @internal
 */
final readonly class SchemaShapeFingerprint
{
    /** @var list<string> the JSON Schema keywords that decide an emitted PHP type */
    private const array SHAPE_KEYS = [
        'type', 'format', 'nullable', 'enum', 'items', 'properties', 'required',
        'additionalProperties', 'allOf', 'oneOf', 'anyOf', 'not', 'discriminator',
    ];

    public static function same(Schema|Reference $a, Schema|Reference $b): bool
    {
        return json_encode(self::of($a)) === json_encode(self::of($b));
    }

    /** @return array<string,mixed> */
    private static function of(Schema|Reference $node): array
    {
        if ($node instanceof Reference) {
            return ['$ref' => $node->getReference()];
        }

        $raw = $node->getSerializableData();
        $vars = $raw instanceof stdClass ? get_object_vars($raw) : [];
        $shape = [];

        foreach (self::SHAPE_KEYS as $key) {
            if (array_key_exists($key, $vars)) {
                $shape[$key] = $vars[$key];
            }
        }

        return $shape;
    }
}
