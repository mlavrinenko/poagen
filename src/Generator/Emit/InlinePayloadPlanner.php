<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;
use Mlavrinenko\Paogen\Generator\UnionGuidanceValidator;

use function is_array;

/**
 * Names a model class for every operation payload the document declared inline.
 *
 * The model pipeline is rooted in `components.schemas`, so a document that
 * names nothing gives it nothing to walk. This planner supplies the missing
 * roots: it visits each operation, finds the request body and the first 2xx
 * response, and where either is an inline object (or an array of inline
 * objects) it derives a class name and hands the node to the same FIFO that
 * already drains inline children found inside named components. Everything
 * below the root — nested objects, arrays of objects, inline enums — is then
 * reached by the machinery that was always there.
 *
 * The derivation reads the *normalised* method name rather than the raw
 * operation identifier, so a profile rename improves the model names too:
 * renaming `getclientfullbalance` to `getClientFullBalance` turns
 * `GetclientfullbalanceResponse` into `GetClientFullBalanceResponse` without a
 * second entry. `Profile::$inlineModels` overrides the derivation outright,
 * which is also how a consumer keeps their own callers working when a vendor
 * renames an operation: point the pin at the new identifier and the class name
 * they publish stays put.
 *
 * An operation the document-wide schema scan already refused (skip-is-the-only-opt-out)
 * claims nothing here — {@see build()}'s `$preScannedSkips` — so a skip entry
 * naming that operation drops its payload model along with its method rather
 * than leaving the model behind as a dangling write. A second operation that
 * reaches the same schema node (a shared `components.requestBodies` /
 * `components.responses` entry, most plainly) still claims it on its own,
 * independently of whichever other operations named it — reachability, not
 * the skip entry, decides whether the class survives.
 *
 * @internal
 */
final readonly class InlinePayloadPlanner
{
    public const string ROLE_REQUEST = 'request';
    public const string ROLE_RESPONSE = 'response';

    /**
     * @param array<string,string> $pins            `'<operationId>.request'|'<operationId>.response'` → PHP class name
     * @param array<string,string> $xmlElements     Profile::$xmlElements
     * @param array<string,string> $preScannedSkips raw operationId → reason, from the document-wide scan that
     *                                               ran before this planner — an operation named here is refused
     *                                               regardless of `Profile::$skip`, so it claims no payload model
     * @param array<string,array{branch:string,reason:string}> $unionPins Profile::$unionPins — read only for a
     *                                               response-position key, `a-union-response-selects-its-branch`
     */
    public static function build(
        OpenApi $openApi,
        NameRegistry $operationIdRegistry,
        NameRegistry $registry,
        array $pins,
        ModelNameLedger $ledger,
        array $xmlElements = [],
        array $preScannedSkips = [],
        array $unionPins = [],
    ): InlinePayloadCatalog {
        $bodies = [];
        $returns = [];
        $roots = [];
        $requestRefusals = [];
        $responseRefusals = [];
        $unionByPointer = [];
        $unionByKey = [];

        foreach (OperationOrder::inEmissionOrder($openApi) as [, , $operation]) {
            $rawId = (string) ($operation->operationId ?? '');

            if ($rawId === '') {
                continue;
            }

            if (isset($preScannedSkips[$rawId])) {
                continue;
            }

            $base = ucfirst($operationIdRegistry->resolve($rawId, new NormalisationContext(SymbolKind::OperationId)));

            $body = RequestBodyPlanner::plan($operation, $rawId, $base, $pins, $registry, $ledger, $roots, $openApi, $requestRefusals, $xmlElements);

            if ($body instanceof BodySpec) {
                $bodies[$rawId] = $body;
            }

            $unionResolution = null;
            $return = self::planResponse($operation, $rawId, $base, $pins, $unionPins, $registry, $ledger, $roots, $openApi, $responseRefusals, $unionResolution);

            if ($return instanceof ReturnSpec) {
                $returns[$rawId] = $return;
            }

            if ($unionResolution instanceof UnionResolution) {
                $unionByPointer[$unionResolution->position] = $unionResolution;
                $unionByKey[$rawId . '.' . self::ROLE_RESPONSE] = $unionResolution;
            }
        }

        return new InlinePayloadCatalog($bodies, $returns, $roots, $requestRefusals, $responseRefusals, new UnionCatalog($unionByPointer, $unionByKey));
    }

    /**
     * @param array<string,string>                             $pins
     * @param array<string,array{branch:string,reason:string}> $unionPins
     * @param list<SynthesisedModel>                            $roots
     * @param array<string,string>                              $refusals keyed by raw operationId, mirrors {@see RequestBodyPlanner::plan()}'s
     */
    private static function planResponse(
        Operation $operation,
        string $rawId,
        string $base,
        array $pins,
        array $unionPins,
        NameRegistry $registry,
        ModelNameLedger $ledger,
        array &$roots,
        OpenApi $openApi,
        array &$refusals,
        ?UnionResolution &$unionResolution,
    ): ?ReturnSpec {
        $picked = self::successResponse($operation);

        if ($picked === null) {
            return null;
        }

        [$status, $schema] = $picked;
        $pin = $pins[$rawId . '.' . self::ROLE_RESPONSE] ?? null;

        if (is_array($schema->allOf) && $schema->allOf !== []) {
            $refusal = null;
            $return = InlineAllOfPlanner::planResponse($schema, $base, $pin, $openApi, $ledger, $roots, $refusal);

            if ($refusal !== null) {
                $refusals[$rawId] = $refusal;
            }

            return $return;
        }

        // Checked ahead of the `isSynthesisableObject()` fallback below —
        // a `oneOf`/`anyOf` schema never satisfies it (it has no properties
        // of its own), but the ordering mirrors {@see RequestBodyPlanner}'s
        // for the same reason: one construct, checked once, in one place.
        $unionRefusal = null;
        $union = ResponseUnionPlanner::planResponse($schema, $status, $base, $rawId, $openApi, $registry, $ledger, $roots, $unionPins, $unionResolution, $unionRefusal);

        if ($union instanceof ReturnSpec || $unionRefusal !== null) {
            if ($unionRefusal !== null) {
                $refusals[$rawId] = $unionRefusal;
            }

            return $union;
        }

        if (self::isSynthesisableObject($schema)) {
            $name = self::claim($pin ?? $base . 'Response', $schema, $ledger, $roots);

            return ReturnSpec::model($name);
        }

        $items = self::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            $name = self::claim($pin ?? $base . 'ResponseItem', $items, $ledger, $roots);

            return ReturnSpec::listOf($name);
        }

        return null;
    }

    /**
     * Shared with {@see InlineXmlRequestPlanner}, which claims a name off the
     * same ledger for the one content type this class does not plan itself.
     *
     * @param list<SynthesisedModel> $roots
     * @param string|null            $origin a {@see ModelNameLedger} collision diagnostic normally
     *                                        points at `$schema`'s own document position, but an
     *                                        `allOf` merge synthesises a fresh `Schema` with none —
     *                                        {@see InlineAllOfPlanner} passes the original node's
     *                                        position here so the diagnostic still points at the
     *                                        document rather than reading "(no document position)"
     */
    public static function claim(string $name, Schema $schema, ModelNameLedger $ledger, array &$roots, ?string $origin = null): string
    {
        $origin ??= SynthesisedModel::originOf($schema);
        $ledger->claim($name, $origin);
        $roots[] = new SynthesisedModel($name, $schema, [], $origin);

        return $name;
    }

    /** Shared with {@see InlineXmlRequestPlanner}. */
    public static function isSynthesisableObject(Schema $schema): bool
    {
        return ObjectShape::is($schema) && InlineObjectResolver::isSynthesisable($schema);
    }

    /**
     * The item schema of an inline array whose items are themselves an inline
     * object worth a class, or null. Shared with {@see InlineXmlRequestPlanner}.
     */
    public static function inlineObjectItemsOf(Schema $schema): ?Schema
    {
        if (!SchemaType::of($schema)->is('array')) {
            return null;
        }

        $items = $schema->items;

        return $items instanceof Schema && self::isSynthesisableObject($items) ? $items : null;
    }

    /**
     * Shared with {@see RequestBodyPlanner}.
     *
     * @param array<MediaType> $content cebe types the map's keys as `int|string`
     */
    public static function jsonSchemaOf(array $content): ?Schema
    {
        $json = $content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return null;
        }

        $schema = $json->schema;

        return $schema instanceof Schema ? $schema : null;
    }

    /**
     * Public so {@see UnionGuidanceValidator}
     * can re-locate the same response {@see ResponseUnionPlanner} would
     * plan against, to index it for `Profile::$unionTags`/`$unionPins`
     * without duplicating the 2xx-picking rule a third time.
     *
     * @return array{0:string,1:Schema}|null the picked status and its `application/json` schema — the
     *                                       status travels along so a refusal can name it, the same
     *                                       way {@see ResponseRefusal} already does
     */
    public static function successResponse(Operation $operation): ?array
    {
        $responses = $operation->responses;

        if ($responses === null) {
            return null;
        }

        foreach ($responses->getResponses() as $status => $response) {
            if (!str_starts_with((string) $status, '2')) {
                continue;
            }
            if (!$response instanceof Response) {
                continue;
            }

            $schema = self::jsonSchemaOf($response->content);

            return $schema instanceof Schema ? [(string) $status, $schema] : null;
        }

        return null;
    }
}
