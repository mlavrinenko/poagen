<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Naming\InlinePayloadName;
use Poagen\Generator\Generator\Naming\NameRegistry;

use function is_array;

/**
 * The request-body half of {@see InlinePayloadPlanner::planRequest()},
 * split into its own file to keep both under the linecop limit
 * (`quality-gates-at-maximum-strictness`) — the same reason {@see
 * InlineAllOfPlanner} was split out before it.
 *
 * @internal
 */
final readonly class RequestBodyPlanner
{
    /**
     * @param array<string,string>   $pins
     * @param list<SynthesisedModel> $roots
     * @param array<string,string>   $refusals    keyed by raw operationId — an `allOf`/`anyOf` merge's, or a
     *                                             whole-body union's, specific reason, out-parameter for the caller
     * @param array<string,string>   $xmlElements
     */
    public static function plan(
        Operation $operation,
        string $rawId,
        string $base,
        array $pins,
        NameRegistry $registry,
        ModelNameLedger $ledger,
        array &$roots,
        OpenApi $openApi,
        array &$refusals,
        array $xmlElements = [],
    ): ?BodySpec {
        $resolved = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        if (!$resolved instanceof RequestBody) {
            return null;
        }

        $pin = $pins[$rawId . '.' . InlinePayloadPlanner::ROLE_REQUEST] ?? null;
        $schema = InlinePayloadPlanner::jsonSchemaOf($resolved->content);

        if (!$schema instanceof Schema) {
            // JSON is preferred where an operation offers both, so an XML body is
            // only reached when it is the only one on offer — which is why
            // pairing the two warns about nothing.
            return InlineXmlRequestPlanner::plan($resolved, $rawId, $base, $pin, $ledger, $roots, $xmlElements);
        }

        if (is_array($schema->allOf) && $schema->allOf !== []) {
            $refusal = null;
            $body = InlineAllOfPlanner::planRequest($schema, $base, $pin, $openApi, $ledger, $roots, $refusal);

            if ($refusal !== null) {
                $refusals[$rawId] = $refusal;
            }

            return $body;
        }

        // Checked ahead of the `ObjectShape::is()` map fallback below — see
        // {@see RequestUnionPlanner} for the exact boundary and why it must
        // run first.
        $unionRefusal = null;
        $union = RequestUnionPlanner::planRequest($schema, $base, $registry, $ledger, $roots, $unionRefusal);

        if ($union instanceof BodySpec || $unionRefusal !== null) {
            if ($unionRefusal !== null) {
                $refusals[$rawId] = $unionRefusal;
            }

            return $union;
        }

        if (InlinePayloadPlanner::isSynthesisableObject($schema)) {
            $name = InlineModelClaim::named($pin, InlinePayloadName::request($base), $schema, $ledger, $roots);

            return BodySpec::json($name);
        }

        $items = InlinePayloadPlanner::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            $name = InlineModelClaim::named($pin, InlinePayloadName::request($base, item: true), $items, $ledger, $roots);

            return BodySpec::jsonList($name);
        }

        // An inline object with no declared properties to synthesise a class
        // from. The map is what the schema says, so it is what the caller
        // passes; dropping the operation for want of a class name would shrink
        // the client over a body the vendor deliberately left open.
        if (ObjectShape::is($schema)) {
            return BodySpec::jsonMap($schema);
        }

        return null;
    }
}
