<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\UnionGuidanceValidator;

use function array_values;
use function count;
use function implode;
use function sprintf;

/**
 * The one shape {@see ResponseUnionPlanner} declines: a response whose
 * `oneOf`/`anyOf` branches are themselves arrays —
 * `activity/list-stargazers-for-repo` anyOf's `array<simple-user>` against
 * `array<stargazer>`, and `activity/list-repos-starred-by-user` the same
 * against `starred-repository`/`repository`.
 *
 * A native PHP union of two *list* types cannot be written — `list<A>` and
 * `list<B>` both erase to plain `array`, so `instanceof` narrowing (this
 * task's own acceptance bullet) is unreachable at the return-type level.
 * What each vendor is actually saying is narrower than "the whole array is
 * shape A or shape B": `stargazer` requires `starred_at` and `simple-user`
 * does not declare it, so every *element* is independently decidable the
 * same way an object branch is. Reading it as `list<A|B>` — one item type
 * that is itself a union — keeps the promise the document makes (each
 * element really is one of the two) and reuses the recursion {@see
 * ResponseTypeEmitter}/`ResponseDecoder` already have for a list item's own
 * spec, so this needed no new list kind, only a `ReturnSpec::KIND_UNION`
 * item where before every list item was a bare scalar.
 *
 * Only the structural and pin layers apply: a discriminator naming a field
 * to read makes no sense against an array, which has none, and no measured
 * case declares one here.
 *
 * @internal
 */
final readonly class ResponseArrayUnionPlanner
{
    /**
     * @param  list<Schema|Reference>                           $branches
     * @param  array<string,array{branch:string,reason:string}> $pins
     * @return ReturnSpec|null null when the branches are not this shape at all (so the caller falls
     *                         through to the object-branch reading), or when they are and nothing
     *                         resolves them (`$refusal` set)
     */
    public static function planResponse(
        array $branches,
        Schema $schema,
        string $status,
        string $rawId,
        OpenApi $openApi,
        NameRegistry $registry,
        array $pins,
        ?UnionResolution &$resolution,
        ?string &$refusal,
    ): ?ReturnSpec {
        $items = self::itemRefs($branches);

        if ($items === null) {
            return null;
        }

        $identities = [];
        $models = [];
        $shapes = [];

        foreach ($items as $ref) {
            $raw = ComponentName::rawFromRef($ref->getReference());
            $identities[] = $raw;
            $model = ComponentName::phpFromRef($ref->getReference(), $registry);
            $models[$raw] = $model;
            $target = EffectiveShape::resolve($ref, $openApi);
            // Keyed by PHP model name, not the raw identity — see the same
            // note in ResponseUnionPlanner::planObjectUnion().
            $shapes[$model] = $target instanceof Schema ? EffectiveShape::of($target, $openApi) : null;
        }

        $position = SynthesisedModel::originOf($schema);
        $key = $rawId . '.' . InlinePayloadPlanner::ROLE_RESPONSE;
        $selectors = BranchSelectors::computeFromShapes($shapes);

        if ($selectors->decidable()) {
            $resolution = UnionResolution::structural($position, $selectors);

            return ReturnSpec::scalarListOf(ReturnSpec::union(array_values($models), $resolution));
        }

        $entry = $pins[$key] ?? null;

        if ($entry !== null) {
            $branch = $entry['branch'] ?? '';
            $model = $models[$branch] ?? null;

            if ($model !== null) {
                $resolution = UnionResolution::pin($position, $key, $branch, $entry['reason'] ?? '', count($models) - 1);

                return ReturnSpec::listOf($model);
            }
        }

        $refusal = sprintf(
            '%s response of `%s` (%s): each branch is a list of a different item shape (%s), and those items share '
                . 'every discriminating field — no element could be told apart, and paogen will not guess which '
                . "list the vendor sent. Resolve it by a Profile::\$unionPins['%s'] entry pinning one item shape "
                . 'with a written reason.',
            $status,
            $rawId,
            $position,
            implode(', ', $identities),
            $key,
        );

        return null;
    }

    /**
     * Every branch is `type: array` with `items` a `$ref`, or this declines
     * — a bare inline item is a different question this class does not
     * answer, and {@see ResponseUnionPlanner} will refuse it honestly as an
     * unnameable branch rather than this class guessing at it.
     *
     * Public so {@see UnionGuidanceValidator}
     * can tell the same two shapes apart when it indexes a response union
     * for `Profile::$unionTags`/`$unionPins` — the identity a pin names is
     * the item's raw component name here, not the array branch's.
     *
     * @param  list<Schema|Reference> $branches
     * @return list<Reference>|null
     */
    public static function itemRefs(array $branches): ?array
    {
        $refs = [];

        foreach ($branches as $branch) {
            if (!$branch instanceof Schema || !SchemaType::of($branch)->is('array')) {
                return null;
            }

            $items = $branch->items;

            if (!$items instanceof Reference) {
                return null;
            }

            $refs[] = $items;
        }

        return count($refs) >= 2 ? $refs : null;
    }
}
