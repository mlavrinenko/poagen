<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use Poagen\Generator\Generator\Profile;

use function is_string;

/**
 * Which tags the document's operations actually carry.
 *
 * Deliberately reads the operations rather than the document's top-level `tags:`
 * declaration. The two disagree in practice — a vendor declares tags they never
 * apply, and applies tags they never declared — and what decides whether a
 * sub-client exists is the second. Validating a rename against the declaration
 * would accept guidance that then applies to nothing.
 *
 * @internal
 */
final readonly class TagCatalogue
{
    /**
     * Every tag at least one operation lands on, after the profile's assignments
     * and choices. Keyed by raw tag for O(1) lookup.
     *
     * @return array<string,true>
     */
    public static function tagsCarriedByOperations(OpenApi $openApi, Profile $profile): array
    {
        $out = [];

        foreach (self::operations($openApi) as $operation) {
            foreach (SubClientPlanner::tagsFor($operation, $profile) as $tag) {
                $out[$tag] = true;
            }
        }

        return $out;
    }

    /**
     * The tags one operation declares in the document, before any profile
     * override — which is the set a `tagChoice` may narrow.
     *
     * @return list<string>
     */
    public static function declaredTagsOf(OpenApi $openApi, string $operationId): array
    {
        foreach (self::operations($openApi) as $operation) {
            if ((string) ($operation->operationId ?? '') !== $operationId) {
                continue;
            }

            $out = [];

            foreach ($operation->tags ?? [] as $tag) {
                if (is_string($tag) && $tag !== '') {
                    $out[] = $tag;
                }
            }

            return $out;
        }

        return [];
    }

    /**
     * @return iterable<Operation>
     */
    private static function operations(OpenApi $openApi): iterable
    {
        foreach ($openApi->paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            yield from $pathItem->getOperations();
        }
    }
}
