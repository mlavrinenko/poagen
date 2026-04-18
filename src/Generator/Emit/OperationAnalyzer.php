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
 * operation falls outside the PoC's supported shapes and should be skipped.
 *
 * @internal
 */
final readonly class OperationAnalyzer
{
    /**
     * @return list<Parameter>|null null if any parameter sits outside the
     *                              supported subset (path + optional header)
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
            if ($param->in === 'header' && !$param->required) {
                continue;
            }

            return null;
        }

        return $out;
    }

    /**
     * @return non-empty-string|null component name of the `application/json`
     *                                request body, or null if unsupported.
     */
    public static function requestBodyRef(RequestBody|Reference|null $body): ?string
    {
        if (!$body instanceof RequestBody) {
            return null;
        }

        $json = $body->content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return null;
        }

        $schema = $json->schema;

        if (!$schema instanceof Reference) {
            return null;
        }

        $name = self::componentNameFromRef($schema->getReference());

        return $name === '' ? null : $name;
    }

    /**
     * @param Responses<Response|Reference>|null $responses
     */
    public static function returnType(?Responses $responses): ReturnSpec
    {
        if (!$responses instanceof \cebe\openapi\spec\Responses) {
            return new ReturnSpec(null, false);
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

        return new ReturnSpec(null, false);
    }

    private static function responseReturn(Response $response): ReturnSpec
    {
        $json = $response->content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return new ReturnSpec(null, false);
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            $name = self::componentNameFromRef($schema->getReference());

            return $name === '' ? new ReturnSpec(null, false) : new ReturnSpec($name, false);
        }

        if ($schema instanceof Schema && $schema->type === 'array') {
            $items = $schema->items;

            if ($items instanceof Reference) {
                $name = self::componentNameFromRef($items->getReference());

                return $name === '' ? new ReturnSpec(null, false) : new ReturnSpec($name, true);
            }
        }

        return new ReturnSpec(null, false);
    }

    private static function componentNameFromRef(string $ref): string
    {
        $parts = explode('/', $ref);

        return end($parts);
    }
}
