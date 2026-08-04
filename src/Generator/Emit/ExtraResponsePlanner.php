<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\InlinePayloadName;

use function is_array;

/**
 * Names and synthesises a model for every response status
 * {@see InlinePayloadPlanner::planResponse()} does *not* already cover — every
 * status besides the one 2xx it picks to drive the operation's return type
 * (name-inline-schemas-by-operation-and-status).
 *
 * kilbil is the case this exists for: all 36 operations declare a `200` and a
 * `403`, and until this class existed the `403` body was never named or
 * emitted at all — dropped silently, the same shrinkage
 * `default-deny-on-degradation` names elsewhere. Nothing here wires the
 * result into the method's return type or into `ApiException` — that is
 * `typed-error-responses`' job, sequenced after this one. What lands here is
 * only the class, so a consumer's own code (or that follow-up task) has a
 * name to reach for.
 *
 * Deliberately narrower than {@see InlinePayloadPlanner::planResponse()}:
 * an `allOf` merge or a `oneOf`/`anyOf` union on a status nothing consumes
 * yet is skipped rather than resolved, so this file does not grow into a
 * second copy of that machinery for a status the emitted client never reads.
 * A plain inline object, or an array of them, is exactly what an error
 * envelope needs and exactly what this covers; anything else at a non-picked
 * status is silently left unnamed, the same as it was before this class
 * existed — an observation the consumer can act on, not a mandate.
 *
 * Split out of {@see InlinePayloadPlanner} to keep both files under the
 * linecop limit (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class ExtraResponsePlanner
{
    /**
     * @param array<string,string>   $pins    `'<rawOperationId>.<status>'` → PHP class name
     * @param list<SynthesisedModel> $roots
     */
    public static function plan(
        Operation $operation,
        string $rawId,
        string $base,
        ?string $pickedStatus,
        array $pins,
        ModelNameLedger $ledger,
        array &$roots,
    ): void {
        $responses = $operation->responses;

        if ($responses === null) {
            return;
        }

        foreach ($responses->getResponses() as $status => $response) {
            $status = (string) $status;

            if ($status === $pickedStatus) {
                continue;
            }

            if (!$response instanceof Response) {
                continue;
            }

            self::planOne($response, $rawId, $base, $status, $pins, $ledger, $roots);
        }
    }

    /**
     * @param array<string,string>   $pins
     * @param list<SynthesisedModel> $roots
     */
    private static function planOne(
        Response $response,
        string $rawId,
        string $base,
        string $status,
        array $pins,
        ModelNameLedger $ledger,
        array &$roots,
    ): void {
        $schema = InlinePayloadPlanner::jsonSchemaOf($response->content);

        if (!$schema instanceof Schema) {
            return;
        }

        if (is_array($schema->allOf) && $schema->allOf !== []) {
            return;
        }

        if (count(SchemaWalk::oneOfOrAnyOf($schema)) >= 2) {
            return;
        }

        $pin = $pins[$rawId . '.' . $status] ?? null;

        if (InlinePayloadPlanner::isSynthesisableObject($schema)) {
            InlinePayloadPlanner::claim($pin ?? InlinePayloadName::response($base, $status), $schema, $ledger, $roots);

            return;
        }

        $items = InlinePayloadPlanner::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            InlinePayloadPlanner::claim($pin ?? InlinePayloadName::response($base, $status, item: true), $items, $ledger, $roots);
        }
    }
}
