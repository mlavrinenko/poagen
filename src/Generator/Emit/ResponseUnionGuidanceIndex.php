<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;
use Mlavrinenko\Paogen\Generator\UnionGuidanceValidator;

use function count;

/**
 * Every response-position union the document carries, keyed
 * `'<rawOperationId>.response'` — the other half of
 * {@see UnionGuidanceValidator}'s index,
 * alongside {@see DiscriminatorEnforcer::unionProperties()} for the
 * property-position half. Split into its own file so both stay under the
 * linecop limit (`quality-gates-at-maximum-strictness`).
 *
 * A response union carries no parent `Schema` — nothing plays the role
 * `Profile::$unionTags` needs a sibling field on — which is exactly what
 * {@see UnionGuidanceValidator::checkField()}
 * turns into a clear failure rather than a null-pointer.
 *
 * @internal
 */
final readonly class ResponseUnionGuidanceIndex
{
    /**
     * @return array<string,array{0:null,1:Schema,2:list<string>}>
     */
    public static function build(OpenApi $openApi, NameRegistry $operationIdRegistry): array
    {
        $out = [];

        foreach ($openApi->paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $entry = self::entryFor($operation, $operationIdRegistry);

                if ($entry !== null) {
                    $out[$entry[0]] = $entry[1];
                }
            }
        }

        return $out;
    }

    /**
     * @return array{0:string,1:array{0:null,1:Schema,2:list<string>}}|null
     */
    private static function entryFor(Operation $operation, NameRegistry $operationIdRegistry): ?array
    {
        $rawId = (string) ($operation->operationId ?? '');

        if ($rawId === '') {
            return null;
        }

        $picked = InlinePayloadPlanner::successResponse($operation);

        if ($picked === null) {
            return null;
        }

        [, $schema] = $picked;
        $branches = SchemaWalk::oneOfOrAnyOf($schema);

        if (count($branches) < 2) {
            return null;
        }

        $base = ucfirst($operationIdRegistry->resolve($rawId, new NormalisationContext(SymbolKind::OperationId)));
        $key = $rawId . '.' . InlinePayloadPlanner::ROLE_RESPONSE;

        return [$key, [null, $schema, ResponseUnionBranches::branchIdentities($branches, $base)]];
    }
}
