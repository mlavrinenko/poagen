<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;
use Mlavrinenko\Paogen\Generator\Profile;

/**
 * Groups the document's operations into the sub-clients that will be emitted.
 *
 * Grain is the whole point. A flat client is the wrong injection unit: a service
 * touching three endpoints would have to accept an object exposing every
 * operation in the document, and a unit test faking it would stand in for a
 * surface it never calls. Against kilbil that is a 36-method dependency for code
 * that uses two. `caller-surface-is-injectable` states the rule; a tag is the
 * only grouping the document itself supplies.
 *
 * Four resolutions, in this order:
 *
 *   1. `Profile::$tagAssignments` gives an untagged operation a tag, so a
 *      consumer repairs an under-tagged document without editing it;
 *   2. `Profile::$tagChoice` picks one tag for an operation carrying several —
 *      absent a choice it is emitted on every one of them, because dropping it
 *      from any would be an omission nobody asked for;
 *   3. an operation still untagged goes on the root client, and no `DefaultApi`
 *      type is invented for it;
 *   4. the tag's PHP name comes from the shared normalisation pipeline, so
 *      `Profile::$tagRenames` and the ASCII fold both apply.
 *
 * @internal
 */
final readonly class SubClientPlanner
{
    /**
     * @return list<TagGroup> the root group first when it has operations, then
     *                        one per tag in ascending PHP-name order
     */
    public static function plan(OpenApi $openApi, Profile $profile, NameRegistry $tagRegistry): array
    {
        /** @var array<string,list<array{0:string,1:string,2:Operation,3:PathItem}>> $byTag */
        $byTag = [];
        /** @var list<array{0:string,1:string,2:Operation,3:PathItem}> $untagged */
        $untagged = [];

        foreach (OperationOrder::inEmissionOrder($openApi) as $entry) {
            foreach (self::tagsFor($entry[2], $profile) as $rawTag) {
                $byTag[$rawTag][] = $entry;
            }

            if (self::tagsFor($entry[2], $profile) === []) {
                $untagged[] = $entry;
            }
        }

        $context = new NormalisationContext(SymbolKind::Tag);
        $groups = [];

        foreach ($byTag as $rawTag => $operations) {
            $groups[] = new TagGroup(
                (string) $rawTag,
                $tagRegistry->resolve((string) $rawTag, $context) . 'Client',
                $operations,
            );
        }

        usort($groups, static fn(TagGroup $a, TagGroup $b): int => strcmp($a->phpName, $b->phpName));

        if ($untagged !== []) {
            // Root group first: it is the client a consumer constructs, and
            // reading the emitted tree top-down should start there.
            return [new TagGroup('', 'ApiClient', $untagged), ...$groups];
        }

        return $groups;
    }

    /**
     * The tags one operation lands on, after the profile's assignment and choice
     * overrides. Empty means the root client.
     *
     * @return list<string>
     */
    public static function tagsFor(Operation $operation, Profile $profile): array
    {
        $rawId = (string) ($operation->operationId ?? '');
        $declared = [];

        foreach ($operation->tags ?? [] as $tag) {
            if (\is_string($tag) && $tag !== '') {
                $declared[] = $tag;
            }
        }

        if ($declared === []) {
            $assigned = $profile->tagAssignments[$rawId] ?? null;

            return \is_string($assigned) && $assigned !== '' ? [$assigned] : [];
        }

        $choice = $profile->tagChoice[$rawId] ?? null;

        if (\is_string($choice) && \in_array($choice, $declared, true)) {
            return [$choice];
        }

        return array_values(array_unique($declared));
    }

}
