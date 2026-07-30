<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;

use function is_string;

use const SORT_STRING;

/**
 * The one order every pass walks the document's operations in: path URIs sorted,
 * then each path item's own operation order.
 *
 * Shared rather than repeated because three passes need it — payload naming,
 * tag grouping, and the type-list scan — and `regeneration-is-deterministic-and-total`
 * requires emission order to derive from the schema rather than from directory or
 * hash iteration. Three copies of the rule is three chances for one of them to
 * drift and start naming a synthesised class after whichever operation the parser
 * happened to hand over first.
 *
 * @internal
 */
final readonly class OperationOrder
{
    /**
     * @return list<array{0:string,1:string,2:Operation,3:PathItem}> method, path URI, operation, path item
     */
    public static function inEmissionOrder(OpenApi $openApi): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $items = [];

        foreach ($paths as $pathUri => $pathItem) {
            if (is_string($pathUri) && $pathItem instanceof PathItem) {
                $items[$pathUri] = $pathItem;
            }
        }

        $uris = array_keys($items);
        sort($uris, SORT_STRING);

        $out = [];

        foreach ($uris as $pathUri) {
            foreach ($items[$pathUri]->getOperations() as $httpMethod => $operation) {
                $out[] = [(string) $httpMethod, $pathUri, $operation, $items[$pathUri]];
            }
        }

        return $out;
    }
}
