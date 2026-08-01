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
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function sprintf;

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
     *                              supported subset (path + scalar/array
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
            if ($param->in === 'path') {
                $out[] = $param;
                continue;
            }
            if ($param->in === 'query' && self::isSupportedQueryParam($param)) {
                continue;
            }
            if ($param->in === 'header' && self::isSupportedHeaderParam($param)) {
                continue;
            }

            return null;
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
            return 'a parameter `$ref` does not resolve to a component parameter — paogen supports path '
                . 'parameters, scalar/array query parameters, and optional scalar header parameters; fix or remove the $ref';
        }

        $params = ParameterCollector::collect($operation, $pathItem) ?? [];

        foreach ($params as $param) {
            if ($param->in === 'path') {
                continue;
            }
            if ($param->in === 'query' && self::isSupportedQueryParam($param)) {
                continue;
            }
            if ($param->in === 'header' && self::isSupportedHeaderParam($param)) {
                continue;
            }

            $schema = $param->schema;
            $type = $schema instanceof Schema ? SchemaType::of($schema)->describe() : 'unspecified';

            return sprintf(
                "parameter '%s' (in: %s, type: %s) is outside paogen's supported parameter shapes — paogen "
                    . 'supports path parameters, scalar/array query parameters, and optional scalar header parameters',
                $param->name,
                $param->in,
                $type,
            );
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
            static fn(Parameter $p): bool => $p->in === 'query' && self::isSupportedQueryParam($p),
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
            static fn(Parameter $p): bool => $p->in === 'header' && self::isSupportedHeaderParam($p),
        ));
    }

    public static function isArrayQueryParam(Parameter $param): bool
    {
        $schema = $param->schema;

        return $schema instanceof Schema && SchemaType::of($schema)->is('array');
    }

    private static function isSupportedQueryParam(Parameter $param): bool
    {
        $schema = $param->schema;

        if (!$schema instanceof Schema) {
            return false;
        }

        $type = SchemaType::of($schema);

        if ($type->isScalar()) {
            return true;
        }

        if ($type->is('array')) {
            $items = $schema->items;

            return $items instanceof Schema && SchemaType::of($items)->isScalar();
        }

        return false;
    }

    private static function isSupportedHeaderParam(Parameter $param): bool
    {
        if ($param->required) {
            return false;
        }

        $schema = $param->schema;

        return $schema instanceof Schema && SchemaType::of($schema)->isScalar();
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
