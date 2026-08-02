<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Responses;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

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

        return "this operation has a parameter outside paogen's supported shapes";
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

    /**
     * @param  Responses<Response|Reference>|null $responses
     * @return ReturnSpec|null                     null when the picked 2xx response sits outside
     *                                              paogen's supported shapes — the caller must refuse
     *                                              the operation (default-deny-on-degradation) rather
     *                                              than fall back to `void`; see
     *                                              {@see describeUnsupportedResponse()}
     */
    public static function returnType(?Responses $responses, NameRegistry $registry): ?ReturnSpec
    {
        return ResponseAnalyzer::resolve($responses, $registry);
    }

    /**
     * Explains why {@see returnType()} returned null — names the response
     * status, the content type(s) found, and what would make the response
     * acceptable. Only meaningful to call after {@see returnType()} has
     * returned null.
     *
     * @param Responses<Response|Reference>|null $responses
     */
    public static function describeUnsupportedResponse(?Responses $responses): string
    {
        return ResponseAnalyzer::describeUnsupported($responses);
    }
}
