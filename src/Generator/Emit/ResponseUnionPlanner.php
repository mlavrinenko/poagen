<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\UnionGuidanceValidator;

use function array_values;
use function count;
use function implode;
use function sprintf;

/**
 * Resolves a response whose whole schema *is* a `oneOf`/`anyOf` — the
 * incoming direction `a-union-response-selects-its-branch` needs, unlike a
 * request body's own `oneOf`/`anyOf`
 * ({@see RequestUnionPlanner}), which needs no branch selection at all: the
 * caller already holds a concrete instance, but a response arrives as an
 * undifferentiated JSON body and something has to say which branch it is.
 *
 * Wires the response position into the exact mechanism
 * `declare-an-undiscriminated-union-as-raw-data` already built for a
 * property — the same {@see UnionCatalog}, the same {@see BranchSelectors},
 * the same runtime `UnionBranchPicker` — rather than a second one. Two of
 * its three layers apply unchanged: a tag inside the value (the document's
 * own `discriminator`, {@see self::tagInValue()}), and a discriminating
 * field computed from the branches ({@see BranchSelectors::computeFromShapes()}).
 * The third — a tag on the *enclosing* object — has nothing to be a sibling
 * of at the top of a response body, so it never fires here;
 * {@see UnionGuidanceValidator} still accepts
 * a `Profile::$unionTags` entry naming a response key, and reports why it
 * cannot apply, rather than pretending the key does not exist.
 *
 * A branch that is a bare `array` or scalar `oneOf`/`anyOf` of two array
 * shapes — GitHub's `activity/list-stargazers-for-repo` — is a different
 * question from an object branch and is not this class's concern; see
 * {@see ResponseArrayUnionPlanner}.
 *
 * @internal
 */
final readonly class ResponseUnionPlanner
{
    /**
     * @param  array<string,array{branch:string,reason:string}> $pins Profile::$unionPins, keyed
     *                                                                 '<rawOperationId>.response'
     * @param  list<SynthesisedModel>                            $roots
     * @return ReturnSpec|null null either because this is not a response union at all, or because
     *                         it is one and no rule resolves it — the two are told apart by whether
     *                         `$refusal` is set on return
     */
    public static function planResponse(
        Schema $schema,
        string $status,
        string $base,
        string $rawId,
        OpenApi $openApi,
        NameRegistry $registry,
        ModelNameLedger $ledger,
        array &$roots,
        array $pins,
        ?UnionResolution &$resolution,
        ?string &$refusal,
    ): ?ReturnSpec {
        $branches = SchemaWalk::oneOfOrAnyOf($schema);

        if (count($branches) < 2) {
            return null;
        }

        $array = ResponseArrayUnionPlanner::planResponse($branches, $schema, $status, $rawId, $openApi, $registry, $pins, $resolution, $refusal);

        if ($array instanceof ReturnSpec || $refusal !== null) {
            return $array;
        }

        return self::planObjectUnion($branches, $schema, $status, $base, $rawId, $openApi, $registry, $ledger, $roots, $pins, $resolution, $refusal);
    }

    /**
     * @param  list<Schema|Reference>                           $branches
     * @param  array<string,array{branch:string,reason:string}> $pins
     * @param  list<SynthesisedModel>                            $roots
     */
    private static function planObjectUnion(
        array $branches,
        Schema $schema,
        string $status,
        string $base,
        string $rawId,
        OpenApi $openApi,
        NameRegistry $registry,
        ModelNameLedger $ledger,
        array &$roots,
        array $pins,
        ?UnionResolution &$resolution,
        ?string &$refusal,
    ): ?ReturnSpec {
        $named = ResponseUnionBranches::name($branches, $base, $status, $rawId, $registry, $ledger, $roots, $refusal);

        if ($named === null) {
            return null;
        }

        [, $models] = $named;
        $position = SynthesisedModel::originOf($schema);
        $key = $rawId . '.' . InlinePayloadPlanner::ROLE_RESPONSE;

        $tag = self::tagInValue($schema, $branches, $models, $position);

        if ($tag instanceof UnionResolution) {
            $resolution = $tag;

            return ReturnSpec::union(array_values($models), $tag);
        }

        // Keyed by PHP model name, not by $identities — ResponseTypeEmitter
        // builds a #[BranchSelector] straight off these keys via
        // ComponentName-free class literals, so a raw kebab-case identity
        // here (GitHub's 'simple-user') would reach the printer as an
        // invalid class name rather than 'SimpleUser'.
        $selectors = BranchSelectors::computeFromShapes(ResponseUnionBranches::shapesOf($branches, array_values($models), $openApi));

        if ($selectors->decidable()) {
            $resolution = UnionResolution::structural($position, $selectors);

            return ReturnSpec::union(array_values($models), $resolution);
        }

        $pinned = self::pin($key, $position, $pins, $models, count($branches));

        if ($pinned !== null) {
            [$model, $pinResolution] = $pinned;
            $resolution = $pinResolution;

            return ReturnSpec::model($model);
        }

        $refusal = sprintf(
            '%s response of `%s` (%s): branches %s share every discriminating field — each requires nothing the '
                . 'others do not also declare, so no payload could select between them and paogen will not guess. '
                . "Resolve it by adding a `discriminator` to the document, or by a Profile::\$unionPins['%s'] "
                . 'entry pinning one branch with a written reason.',
            $status,
            $rawId,
            $position,
            implode(', ', $selectors->undecidable),
            $key,
        );

        return null;
    }

    /**
     * Layer one, read straight off the response schema's own `discriminator`
     * — the same keyword {@see DiscriminatorEnforcer} reads for a property,
     * with one difference this position actually exercises: the mapping.
     * A property-position discriminator never carries an explicit `mapping`
     * in either vendored document, so nothing there has ever needed
     * {@see UnionTagBinding::mappingOf()}'s reading of it; three response
     * unions here do (`users/get-authenticated`, `users/get-by-id`,
     * `users/get-by-username`, plus `repos/get-content`'s four-branch one),
     * and their wire values (`public`, `private`, `array`, `file`, ...)
     * do not equal any branch's class name, so skipping the mapping would
     * hydrate every one of them into the wrong class silently.
     *
     * Only fires when every branch is a `$ref` — {@see UnionTagBinding::mappingOf()}
     * has nothing to resolve a mapping value against otherwise, and no
     * measured case pairs an inline branch with a document `discriminator`.
     *
     * @param list<Schema|Reference> $branches
     * @param array<string,string>  $models    identity => PHP model name
     */
    private static function tagInValue(Schema $schema, array $branches, array $models, string $position): ?UnionResolution
    {
        $discriminator = $schema->discriminator;

        if (!$discriminator instanceof Discriminator) {
            return null;
        }

        $refs = [];

        foreach ($branches as $branch) {
            if (!$branch instanceof Reference) {
                return null;
            }

            $refs[] = $branch;
        }

        $map = [];

        foreach (UnionTagBinding::mappingOf($discriminator, $refs) as $tag => $rawName) {
            $model = $models[$rawName] ?? null;

            if ($model !== null) {
                $map[(string) $tag] = $model;
            }
        }

        return UnionResolution::tagInValue($position, $discriminator->propertyName, count($branches), $map);
    }

    /**
     * Layer three (property position's fourth): {@see Profile::$unionPins},
     * keyed the same way {@see InlinePayloadPlanner}
     * already keys `Profile::$inlineModels` — `'<rawOperationId>.response'`
     * — because a response has no `<Component>.<property>` pair to name it
     * by.
     *
     * @param  array<string,array{branch:string,reason:string}> $pins
     * @param  array<string,string>                             $models identity => PHP model name
     * @return array{0:string,1:UnionResolution}|null
     */
    private static function pin(string $key, string $position, array $pins, array $models, int $branchCount): ?array
    {
        $entry = $pins[$key] ?? null;

        if ($entry === null) {
            return null;
        }

        $branch = $entry['branch'] ?? '';
        $reason = $entry['reason'] ?? '';
        $model = $models[$branch] ?? null;

        if ($model === null) {
            // A pin naming a branch outside the union — {@see
            // \Mlavrinenko\Paogen\Generator\UnionGuidanceValidator} fails
            // the run naming the entry; resolving here would report the
            // union as the cause when the guidance is (guidance-cannot-mislead).
            return null;
        }

        return [$model, UnionResolution::pin($position, $key, $branch, $reason, $branchCount - 1)];
    }
}
