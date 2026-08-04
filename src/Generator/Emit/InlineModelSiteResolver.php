<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;

/**
 * Resolves an {@see InlineModelSite} against the parsed document — the one
 * question `Profile::$inlineModels`' merge and duplicate-report features
 * both ask: what schema, if any, does this `'<operationId>.<position>'` key
 * name?
 *
 * Answers with the same schema {@see InlinePayloadPlanner} and
 * {@see ExtraResponsePlanner} would themselves plan a class from — an inline
 * `application/json` object, or an array of them — so a site this class
 * calls "absent" is exactly a site that would never have earned a class of
 * its own either, and a site it resolves is exactly the schema those two
 * classes would have named.
 *
 * @internal
 */
final readonly class InlineModelSiteResolver
{
    /**
     * The site's own inline object schema (or the item schema of an inline
     * array of them) — null when the operation, the position, or a nameable
     * JSON schema there does not exist.
     */
    public static function schema(OpenApi $openApi, InlineModelSite $site): ?Schema
    {
        $operation = self::operation($openApi, $site->operationId);

        if (!$operation instanceof Operation) {
            return null;
        }

        $schema = $site->isRequest() ? self::requestSchema($operation) : self::responseSchema($operation, $site->position);

        if (!$schema instanceof Schema) {
            return null;
        }

        if (InlinePayloadPlanner::isSynthesisableObject($schema)) {
            return $schema;
        }

        return InlinePayloadPlanner::inlineObjectItemsOf($schema);
    }

    public static function operation(OpenApi $openApi, string $operationId): ?Operation
    {
        foreach (OperationOrder::inEmissionOrder($openApi) as [, , $operation]) {
            if ((string) ($operation->operationId ?? '') === $operationId) {
                return $operation;
            }
        }

        return null;
    }

    private static function requestSchema(Operation $operation): ?Schema
    {
        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        return $body instanceof RequestBody ? InlinePayloadPlanner::jsonSchemaOf($body->content) : null;
    }

    private static function responseSchema(Operation $operation, string $status): ?Schema
    {
        $responses = $operation->responses;

        if ($responses === null) {
            return null;
        }

        foreach ($responses->getResponses() as $candidate => $response) {
            if ((string) $candidate !== $status) {
                continue;
            }

            if (!$response instanceof Response) {
                continue;
            }

            return InlinePayloadPlanner::jsonSchemaOf($response->content);
        }

        return null;
    }
}
