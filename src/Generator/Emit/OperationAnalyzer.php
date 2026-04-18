<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Responses;
use cebe\openapi\spec\Schema;

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
     *                              query + optional scalar header)
     */
    public static function pathParameters(Operation $operation): ?array
    {
        $out = [];

        /** @var Parameter|Reference $param */
        foreach ($operation->parameters ?? [] as $param) {
            if ($param instanceof Reference) {
                return null;
            }
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
     * @return list<Parameter> query parameters in declaration order —
     *                         callers emit required ones first
     */
    public static function queryParameters(Operation $operation): array
    {
        $out = [];

        /** @var Parameter|Reference $param */
        foreach ($operation->parameters ?? [] as $param) {
            if ($param instanceof Reference) {
                continue;
            }
            if ($param->in === 'query' && self::isSupportedQueryParam($param)) {
                $out[] = $param;
            }
        }

        return $out;
    }

    /**
     * @return list<Parameter> optional scalar header parameters in
     *                         declaration order
     */
    public static function headerParameters(Operation $operation): array
    {
        $out = [];

        /** @var Parameter|Reference $param */
        foreach ($operation->parameters ?? [] as $param) {
            if ($param instanceof Reference) {
                continue;
            }
            if ($param->in === 'header' && self::isSupportedHeaderParam($param)) {
                $out[] = $param;
            }
        }

        return $out;
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
     * Resolve the `application/json` request body, if any, into a
     * `BodySpec`. Returns `null` either when the operation has no body or
     * when the body cannot be expressed as a single `$ref` or a list of
     * `$ref`s — those operations are skipped.
     */
    public static function requestBody(RequestBody|Reference|null $body): ?BodySpec
    {
        if (!$body instanceof RequestBody) {
            return null;
        }

        $json = $body->content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return null;
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            $name = self::componentNameFromRef($schema->getReference());

            return $name === '' ? null : new BodySpec($name, false);
        }

        if ($schema instanceof Schema && $schema->type === 'array') {
            $items = $schema->items;

            if ($items instanceof Reference) {
                $name = self::componentNameFromRef($items->getReference());

                return $name === '' ? null : new BodySpec($name, true);
            }
        }

        return null;
    }

    /**
     * @param Responses<Response|Reference>|null $responses
     */
    public static function returnType(?Responses $responses): ReturnSpec
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

            return self::responseReturn($response);
        }

        return ReturnSpec::void();
    }

    private static function responseReturn(Response $response): ReturnSpec
    {
        $json = $response->content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return ReturnSpec::void();
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            $name = self::componentNameFromRef($schema->getReference());

            return $name === '' ? ReturnSpec::void() : ReturnSpec::model($name);
        }

        if (!$schema instanceof Schema) {
            return ReturnSpec::void();
        }

        if ($schema->type === 'array') {
            $items = $schema->items;

            if ($items instanceof Reference) {
                $name = self::componentNameFromRef($items->getReference());

                return $name === '' ? ReturnSpec::void() : ReturnSpec::listOf($name);
            }

            return ReturnSpec::void();
        }

        if ($schema->type === 'object') {
            $additional = $schema->additionalProperties;

            if ($additional instanceof Schema) {
                $valueType = self::scalarPhpType($additional->type);

                return $valueType === null ? ReturnSpec::void() : ReturnSpec::map($valueType);
            }

            return ReturnSpec::void();
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

    private static function componentNameFromRef(string $ref): string
    {
        $parts = explode('/', $ref);

        return end($parts);
    }
}
