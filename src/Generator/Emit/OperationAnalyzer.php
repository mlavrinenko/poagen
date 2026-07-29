<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Responses;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

/**
 * Summary of an operation used by the emitter, with `null` meaning the
 * operation falls outside the supported shapes and should be skipped.
 *
 * @internal
 */
final readonly class OperationAnalyzer
{
    private const array SCALAR_TYPES = ['string', 'integer', 'number', 'boolean'];

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
            $type = $schema instanceof Schema && \is_string($schema->type) ? $schema->type : 'unspecified';

            return \sprintf(
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

        return $schema instanceof Schema && $schema->type === 'array';
    }

    private static function isSupportedQueryParam(Parameter $param): bool
    {
        $schema = $param->schema;

        if (!$schema instanceof Schema) {
            return false;
        }

        if (\in_array($schema->type, self::SCALAR_TYPES, true)) {
            return true;
        }

        if ($schema->type === 'array') {
            $items = $schema->items;

            return $items instanceof Schema && \in_array($items->type, self::SCALAR_TYPES, true);
        }

        return false;
    }

    private static function isSupportedHeaderParam(Parameter $param): bool
    {
        if ($param->required) {
            return false;
        }

        $schema = $param->schema;

        return $schema instanceof Schema && \in_array($schema->type, self::SCALAR_TYPES, true);
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
     * @param Responses<Response|Reference>|null $responses
     */
    public static function returnType(?Responses $responses, NameRegistry $registry): ReturnSpec
    {
        if (!$responses instanceof \cebe\openapi\spec\Responses) {
            return ReturnSpec::void();
        }

        foreach ($responses->getResponses() as $status => $response) {
            if (!str_starts_with((string) $status, '2')) {
                continue;
            }
            if (!$response instanceof Response) {
                continue;
            }

            return self::responseReturn($response, $registry);
        }

        return ReturnSpec::void();
    }

    private static function responseReturn(Response $response, NameRegistry $registry): ReturnSpec
    {
        $json = $response->content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return ReturnSpec::void();
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            $ref = $schema->getReference();
            $raw = ComponentName::rawFromRef($ref);

            return $raw === '' ? ReturnSpec::void() : ReturnSpec::model(ComponentName::phpFromRef($ref, $registry));
        }

        if (!$schema instanceof Schema) {
            return ReturnSpec::void();
        }

        if ($schema->type === 'array') {
            $items = $schema->items;

            if ($items instanceof Reference) {
                $ref = $items->getReference();
                $raw = ComponentName::rawFromRef($ref);

                return $raw === '' ? ReturnSpec::void() : ReturnSpec::listOf(ComponentName::phpFromRef($ref, $registry));
            }

            return ReturnSpec::void();
        }

        if ($schema->type === 'object') {
            $additional = $schema->additionalProperties;

            if ($additional instanceof Schema) {
                $valueType = self::scalarPhpType($additional->type);

                return $valueType === null ? ReturnSpec::map('mixed') : ReturnSpec::map($valueType);
            }

            // An inline object with declared properties never reaches here —
            // InlinePayloadPlanner synthesised a Model for it. What is left is
            // an object the document left unconstrained, and a map of unknown
            // values is what it says. Returning void instead would drop a body
            // the vendor declared, which is the shrink `silence-means-success`
            // forbids.
            return ReturnSpec::map('mixed');
        }

        $scalar = self::scalarPhpType($schema->type);

        return $scalar === null ? ReturnSpec::void() : ReturnSpec::scalar($scalar);
    }

    private static function scalarPhpType(mixed $openApiType): ?string
    {
        return match ($openApiType) {
            'string' => 'string',
            'integer' => 'int',
            'number' => 'float',
            'boolean' => 'bool',
            default => null,
        };
    }

}
