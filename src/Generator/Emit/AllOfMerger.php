<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function array_key_exists;
use function implode;
use function in_array;
use function is_array;
use function is_string;
use function sprintf;

/**
 * The recursive `allOf` merge engine behind {@see CompositionResolver::mergeAllOf()}.
 *
 * Reads the node's own `properties`/`required` plus every member's,
 * recursing into a member whose own target carries `allOf` again — the
 * "seven bodies nest one level" gap the non-recursive `flattenAllOf` left.
 * At most one member may be a `oneOf`/`anyOf`; when one is found its
 * branches are merged in last, each producing its own full
 * {@see AllOfBranch} (`ruling: an anyOf member becomes a union of branches`).
 *
 * Every unrepresentable shape refuses by throwing {@see AllOfRefusal}, caught
 * once here and turned into {@see AllOfMerge::refused()} — never a silently
 * dropped constraint (abort-on-unrepresentable-constructs).
 *
 * Split from {@see CompositionResolver} to keep both under the linecop limit.
 *
 * @internal
 */
final readonly class AllOfMerger
{
    public static function merge(Schema $node, OpenApi $openApi): AllOfMerge
    {
        $acc = new AllOfAccumulator();

        try {
            self::accumulate($node, $openApi, $acc, []);

            if ($acc->unionMember instanceof Schema) {
                return AllOfMerge::union(AllOfBranchBuilder::build($acc));
            }

            self::assertRequiredDeclared($acc->required, $acc->properties, $acc->memberSites);

            return AllOfMerge::object(self::schemaFrom($acc->properties, $acc->required));
        } catch (AllOfRefusal $refusal) {
            return AllOfMerge::refused($refusal->getMessage());
        }
    }

    /**
     * @param list<string> $visited member sites already recursed into, cycle guard
     */
    private static function accumulate(Schema $node, OpenApi $openApi, AllOfAccumulator $acc, array $visited): void
    {
        $ownSite = self::siteOf($node);
        self::foldProperties($acc, $node->properties ?? [], $ownSite);
        self::foldRequired($acc, $node->required ?? []);

        $members = is_array($node->allOf) ? $node->allOf : [];

        foreach ($members as $member) {
            self::mergeMember($member, $openApi, $acc, $visited);
        }
    }

    /**
     * @param list<string> $visited
     */
    private static function mergeMember(Schema|Reference $member, OpenApi $openApi, AllOfAccumulator $acc, array $visited): void
    {
        $site = self::siteOf($member);
        $target = self::resolve($member, $openApi);

        if (!$target instanceof Schema) {
            throw new AllOfRefusal(sprintf(
                'allOf member %s does not resolve to a component schema — fix the $ref or inline the member',
                $site,
            ));
        }

        $acc->memberSites[] = $site;
        $branches = self::rawBranches($target);

        if ($branches !== []) {
            self::claimUnionMember($target, $site, $acc);

            return;
        }

        if (is_array($target->allOf) && $target->allOf !== []) {
            if (in_array($site, $visited, true)) {
                throw new AllOfRefusal("allOf member {$site} forms a \$ref cycle");
            }

            self::accumulate($target, $openApi, $acc, [...$visited, $site]);

            return;
        }

        self::foldProperties($acc, $target->properties ?? [], $site);
        self::foldRequired($acc, $target->required ?? []);
    }

    private static function claimUnionMember(Schema $target, string $site, AllOfAccumulator $acc): void
    {
        if ($acc->unionMember instanceof Schema) {
            throw new AllOfRefusal(sprintf(
                'allOf declares more than one oneOf/anyOf member (%s and %s) — paogen merges at most one union '
                    . 'member per allOf',
                $acc->unionSite,
                $site,
            ));
        }

        if (is_array($target->allOf) && $target->allOf !== []) {
            throw new AllOfRefusal(sprintf(
                'allOf member %s combines oneOf/anyOf with its own allOf — paogen does not model that combination',
                $site,
            ));
        }

        $acc->unionMember = $target;
        $acc->unionSite = $site;
    }

    /**
     * @param list<string>                   $required
     * @param array<string,Schema|Reference> $properties
     * @param list<string>                   $memberSites
     */
    public static function assertRequiredDeclared(array $required, array $properties, array $memberSites): void
    {
        foreach ($required as $name) {
            if (array_key_exists($name, $properties)) {
                continue;
            }

            throw new AllOfRefusal(sprintf(
                "allOf requires '%s' but no member declares it as a property — members searched: %s",
                $name,
                $memberSites === [] ? '(none)' : implode(', ', $memberSites),
            ));
        }
    }

    /**
     * @param array<string,Schema|Reference> $properties
     * @param list<string>                   $required
     */
    public static function schemaFrom(array $properties, array $required): Schema
    {
        return new Schema([
            'type' => 'object',
            'properties' => $properties,
            'required' => $required,
        ]);
    }

    /**
     * @param array<array-key,Schema|Reference> $props
     */
    public static function foldProperties(AllOfAccumulator $acc, array $props, string $site): void
    {
        foreach ($props as $name => $schema) {
            if (is_string($name)) {
                $acc->addProperty($name, $schema, $site);
            }
        }
    }

    /**
     * @param array<array-key,mixed> $required
     */
    public static function foldRequired(AllOfAccumulator $acc, array $required): void
    {
        foreach ($required as $name) {
            if (is_string($name)) {
                $acc->addRequired($name);
            }
        }
    }

    private static function resolve(Schema|Reference $member, OpenApi $openApi): ?Schema
    {
        if ($member instanceof Schema) {
            return $member;
        }

        $name = ComponentName::rawFromRef($member->getReference());
        $components = $openApi->components;

        if ($components === null) {
            return null;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $target = $schemas[$name] ?? null;

        return $target instanceof Schema ? $target : null;
    }

    public static function siteOf(Schema|Reference $node): string
    {
        if ($node instanceof Reference) {
            return $node->getReference();
        }

        $pointer = $node->getDocumentPosition();

        return $pointer instanceof JsonPointer ? $pointer->getPointer() : '(inline schema, no document position)';
    }

    /**
     * The raw `oneOf` or `anyOf` branch list, `oneOf` preferred when a schema
     * declares both — mirrors {@see CompositionResolver}'s own reading.
     * Public: also read by {@see AllOfBranchBuilder}, both for the union
     * member itself and to refuse a branch that nests further composition.
     *
     * @return array<Schema|Reference>
     */
    public static function rawBranches(Schema $node): array
    {
        /** @var array<Schema|Reference> $oneOf */
        $oneOf = $node->oneOf ?? [];
        /** @var array<Schema|Reference> $anyOf */
        $anyOf = $node->anyOf ?? [];

        return $oneOf !== [] ? $oneOf : $anyOf;
    }
}
