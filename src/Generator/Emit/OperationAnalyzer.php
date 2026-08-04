<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use Poagen\Generator\Generator\Naming\NameRegistry;

/**
 * Summary of an operation used by the emitter, with `null` meaning the
 * operation falls outside the supported shapes and should be skipped.
 *
 * @internal
 */
final readonly class OperationAnalyzer
{
    /**
     * @return list<Parameter>|null null if any parameter sits outside the
     *                              supported subset {@see ParameterShape}
     *                              defines (scalar path + scalar/array
     *                              query + optional scalar header) or a
     *                              `$ref` could not be resolved.
     *                              Parameter-name normalisation lives in
     *                              the emitter (T-025) — analyser no
     *                              longer drops ops on identifier shape.
     */
    public static function pathParameters(Operation $operation, ?PathItem $pathItem = null): ?array
    {
        $params = ParameterCollector::collect($operation, $pathItem);

        if ($params === null) {
            return null;
        }

        $out = [];

        foreach ($params as $param) {
            if (!ParameterShape::supports($param)) {
                return null;
            }

            if ($param->in === 'path') {
                $out[] = $param;
            }
        }

        return $out;
    }

    /**
     * Explains why {@see pathParameters()} returned null for this
     * operation — names the offending parameter (or an unresolved
     * `$ref`) and what would make it acceptable. Only meaningful to call
     * after {@see pathParameters()} has returned null.
     */
    public static function describeUnresolvableParameter(Operation $operation, ?PathItem $pathItem = null): string
    {
        if (
            self::hasUnresolvedRef($operation->parameters ?? [])
            || ($pathItem instanceof PathItem && self::hasUnresolvedRef($pathItem->parameters))
        ) {
            return 'a parameter `$ref` does not resolve to a component parameter — fix or remove the $ref, '
                . 'or declare the parameter inline on the operation';
        }

        $params = ParameterCollector::collect($operation, $pathItem) ?? [];

        foreach ($params as $param) {
            if (!ParameterShape::supports($param)) {
                return ParameterShape::describe($param);
            }
        }

        return "this operation has a parameter outside poagen's supported shapes";
    }

    /**
     * Document-wide pass over every operation's path parameters, run before
     * {@see InlinePayloadPlanner::build()} plans anything — the
     * path-parameter counterpart to the schema-scan skips {@see SchemaScan}
     * already supplies. Walks in {@see OperationOrder::inEmissionOrder()},
     * the same order every other document-wide pass uses, and asks
     * {@see pathParameters()} the same question {@see OperationEmitter::emit()}
     * asks at emission time — one predicate, two call sites, so the two
     * never drift into disagreeing lists of refused operation ids
     * (path-parameter-skip-leaks-its-payload-model-the-same-way).
     *
     * @return list<SkippedOperation>
     */
    public static function scanUnresolvablePathParameters(OpenApi $openApi): array
    {
        $out = [];

        foreach (OperationOrder::inEmissionOrder($openApi) as [$httpMethod, $pathUri, $operation, $pathItem]) {
            if (self::pathParameters($operation, $pathItem) !== null) {
                continue;
            }

            $out[] = new SkippedOperation(
                $httpMethod,
                $pathUri,
                (string) ($operation->operationId ?? ''),
                self::describeUnresolvableParameter($operation, $pathItem),
            );
        }

        return $out;
    }

    /**
     * `Generator::plan()`'s one merged view of every operation refused
     * before payload naming runs — the document-wide schema-scan skips it
     * already computed, plus {@see scanUnresolvablePathParameters()}'s. One
     * map, not two lists computed at two different phases
     * (path-parameter-skip-leaks-its-payload-model-the-same-way): both
     * {@see InlinePayloadPlanner::build()} and {@see OperationEmitter::emit()}
     * read this same result. A schema-scan reason wins a name collision — it
     * was authoritative before this pass existed.
     *
     * @param list<SkippedOperation> $schemaSkips
     * @return array<string,string>   raw operationId → reason
     */
    public static function preScanSkips(OpenApi $openApi, array $schemaSkips): array
    {
        $out = [];

        foreach ($schemaSkips as $skip) {
            $out[$skip->operationId] = $skip->reason;
        }

        foreach (self::scanUnresolvablePathParameters($openApi) as $skip) {
            $out[$skip->operationId] ??= $skip->reason;
        }

        return $out;
    }

    /**
     * @param iterable<Parameter|Reference> $raw
     */
    private static function hasUnresolvedRef(iterable $raw): bool
    {
        foreach ($raw as $param) {
            if ($param instanceof Parameter) {
                continue;
            }
            if (!$param instanceof Reference) {
                return true;
            }
            if (!$param->resolve() instanceof Parameter) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<Parameter> query parameters in declaration order —
     *                         callers emit required ones first
     */
    public static function queryParameters(Operation $operation, ?PathItem $pathItem = null): array
    {
        return array_values(array_filter(
            ParameterCollector::collect($operation, $pathItem) ?? [],
            static fn(Parameter $p): bool => $p->in === 'query' && ParameterShape::supports($p),
        ));
    }

    /**
     * @return list<Parameter> optional scalar header parameters in
     *                         declaration order
     */
    public static function headerParameters(Operation $operation, ?PathItem $pathItem = null): array
    {
        return array_values(array_filter(
            ParameterCollector::collect($operation, $pathItem) ?? [],
            static fn(Parameter $p): bool => $p->in === 'header' && ParameterShape::supports($p),
        ));
    }

    public static function isArrayQueryParam(Parameter $param): bool
    {
        return ParameterShape::isArrayQuery($param);
    }

    /**
     * Resolve a request body into a {@see BodySpec}. See
     * {@see RequestBodyAnalyzer::resolve()} for the preference order.
     */
    public static function requestBody(RequestBody|Reference|null $body, NameRegistry $registry): ?BodySpec
    {
        return RequestBodyAnalyzer::resolve($body, $registry);
    }
}
