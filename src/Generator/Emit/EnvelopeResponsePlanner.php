<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Naming\InlinePayloadName;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function is_array;
use function sprintf;

/**
 * Every status one operation declares, resolved into an {@see EnvelopeSpec}
 * — the per-operation counterpart {@see InlinePayloadPlanner::build()}
 * used to carry only the picked 2xx before `typed-error-responses`.
 *
 * A file of its own rather than another method on {@see InlinePayloadPlanner}
 * — `quality-gates-at-maximum-strictness` caps a PHP file at 250 lines, and
 * this status-by-status resolution is its own concern once every status
 * carries a body rather than only the picked 2xx.
 *
 * @internal
 */
final readonly class EnvelopeResponsePlanner
{
    /**
     * Every status the operation declares, resolved into one
     * {@see EnvelopeSpec} — or a refusal naming the status the generator
     * could not represent, per the settled implementation plan behind
     * `typed-error-responses`: a status whose shape cannot be honoured
     * refuses the whole operation rather than dropping that one branch
     * quietly (default-deny-on-degradation).
     *
     * @param array<string,string>                             $pins
     * @param array<string,array{branch:string,reason:string}> $unionPins
     * @param list<SynthesisedModel>                            $roots
     */
    public static function plan(
        Operation $operation,
        string $rawId,
        string $base,
        array $pins,
        array $unionPins,
        NameRegistry $registry,
        Bindings $bindings,
        ModelNameLedger $ledger,
        array &$roots,
        OpenApi $openApi,
        ?UnionResolution &$unionResolution,
        ?string &$refusal,
    ): ?EnvelopeSpec {
        $responses = $operation->responses?->getResponses() ?? [];

        if ($responses === []) {
            $refusal = sprintf(
                '`%s` declares no responses at all — paogen cannot build an envelope with no status to attach a '
                    . 'body to; add at least one response, or accept this operation by name in Profile::$skip',
                $rawId,
            );

            return null;
        }

        $exact = [];
        $ranges = [];
        $default = null;

        foreach ($responses as $status => $response) {
            $status = (string) $status;

            if ($response instanceof Reference) {
                $resolved = $response->resolve();
                $response = $resolved instanceof Response ? $resolved : null;
            }

            if (!$response instanceof Response) {
                $refusal = sprintf(
                    'status %s of `%s`: response $ref does not resolve to a component response — fix or remove '
                        . 'the $ref, or accept this operation by name in Profile::$skip',
                    $status,
                    $rawId,
                );

                return null;
            }

            $statusRefusal = null;
            $spec = self::planOneStatus($response, $rawId, $base, $status, $pins, $unionPins, $registry, $bindings, $ledger, $roots, $openApi, $unionResolution, $statusRefusal);

            if (!$spec instanceof ReturnSpec) {
                $refusal = sprintf('status %s of `%s`: %s', $status, $rawId, $statusRefusal ?? ResponseAnalyzer::describeOne($status, $response));

                return null;
            }

            if ($status === 'default') {
                $default = $spec;
            } elseif (InlinePayloadName::isRangeKey($status)) {
                $ranges[] = [$status, $spec];
            } else {
                $exact[] = [$status, $spec];
            }
        }

        return new EnvelopeSpec($exact, $ranges, $default);
    }

    /**
     * One status's body, tried as an inline synthesis first — `allOf`, a
     * response union, an inline object or an array of them — and falling
     * back to {@see ResponseAnalyzer} for everything else a status can
     * still legally be: a `$ref`, a scalar, a map, a scalar list, no body
     * at all.
     *
     * @param array<string,string>                             $pins       forwarded from {@see plan()} unchanged
     * @param array<string,array{branch:string,reason:string}> $unionPins  forwarded from {@see plan()} unchanged
     * @param list<SynthesisedModel>                            $roots     forwarded from {@see plan()} unchanged
     */
    private static function planOneStatus(
        Response $response,
        string $rawId,
        string $base,
        string $status,
        array $pins,
        array $unionPins,
        NameRegistry $registry,
        Bindings $bindings,
        ModelNameLedger $ledger,
        array &$roots,
        OpenApi $openApi,
        ?UnionResolution &$unionResolution,
        ?string &$refusal,
    ): ?ReturnSpec {
        $schema = InlinePayloadPlanner::jsonSchemaOf($response->content);

        if (!$schema instanceof Schema) {
            return ResponseAnalyzer::resolveOne($response, $registry, $bindings);
        }

        $pin = $pins[$rawId . '.' . $status] ?? null;

        if (is_array($schema->allOf) && $schema->allOf !== []) {
            $allOfRefusal = null;
            $return = InlineAllOfPlanner::planResponse($schema, $base, $status, $pin, $openApi, $ledger, $roots, $allOfRefusal);

            if ($return instanceof ReturnSpec) {
                return $return;
            }

            if ($allOfRefusal !== null) {
                $refusal = $allOfRefusal;

                return null;
            }

            return ResponseAnalyzer::resolveOne($response, $registry, $bindings);
        }

        // Checked ahead of the `isSynthesisableObject()` fallback below —
        // a `oneOf`/`anyOf` schema never satisfies it (it has no properties
        // of its own), but the ordering mirrors {@see RequestBodyPlanner}'s
        // for the same reason: one construct, checked once, in one place.
        $unionRefusal = null;
        $union = ResponseUnionPlanner::planResponse($schema, $status, $base, $rawId, $openApi, $registry, $ledger, $roots, $unionPins, $unionResolution, $unionRefusal);

        if ($union instanceof ReturnSpec) {
            return $union;
        }

        if ($unionRefusal !== null) {
            $refusal = $unionRefusal;

            return null;
        }

        if (InlinePayloadPlanner::isSynthesisableObject($schema)) {
            $name = InlineModelClaim::named($pin, InlinePayloadName::response($base, $status), $schema, $ledger, $roots);

            return ReturnSpec::model($name);
        }

        $items = InlinePayloadPlanner::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            $name = InlineModelClaim::named($pin, InlinePayloadName::response($base, $status, item: true), $items, $ledger, $roots);

            return ReturnSpec::listOf($name);
        }

        return ResponseAnalyzer::resolveOne($response, $registry, $bindings);
    }
}
