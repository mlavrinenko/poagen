<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;

use function array_unique;
use function array_values;

/**
 * Every raw `components.schemas` name one operation's parameters, request
 * body, or any declared response reaches.
 *
 * {@see SchemaWalk::operationRoots()} almost answers this, but every one of
 * its callers correctly guards `instanceof Schema` — they want the shape a
 * media type carries, and a bare `$ref` sitting directly under a
 * request/response body's own `schema` key (rather than nested inside an
 * inline one) is invisible to it on purpose. {@see DanglingReferenceScanner}
 * wants the pointer instead — a bare `$ref` body is exactly how a request or
 * response names a component directly, with nothing inline in between — so
 * this resolves the same request-body / response containers {@see
 * SchemaWalk} does and keeps the `Reference` rather than dropping it, then
 * falls back to {@see ReferencedComponents} for whatever is already inline.
 *
 * Parameter schemas are not covered the same way: {@see
 * PathItemParameters} resolves a `$ref` parameter to nothing, same as
 * everywhere else in {@see SchemaWalk}, and a bare `$ref` naming a schema
 * component directly on a parameter's own `schema` key — rather than one of
 * the scalar/array shapes {@see ParameterShape} supports — is not a shape
 * this generator emits regardless, so it carries no dangling reference to
 * find.
 *
 * @internal
 */
final readonly class OperationReferencedComponents
{
    /**
     * @return list<string>
     */
    public static function of(Operation $operation, ?PathItem $pathItem): array
    {
        $out = [];

        foreach (self::mediaSchemas($operation) as $node) {
            self::collect($node, $out);
        }

        foreach (SchemaWalk::operationRoots($operation, $pathItem) as $root) {
            $out = [...$out, ...ReferencedComponents::of($root)];
        }

        return array_values(array_unique($out));
    }

    /**
     * @return list<Schema|Reference>
     */
    private static function mediaSchemas(Operation $operation): array
    {
        $out = [];
        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        foreach ($body instanceof RequestBody ? $body->content : [] as $media) {
            self::pushSchema($media->schema, $out);
        }

        $responses = $operation->responses;

        foreach ($responses === null ? [] : $responses->getResponses() as $response) {
            $resolved = SchemaWalk::resolveResponse($response);

            if (!$resolved instanceof Response) {
                continue;
            }

            foreach ($resolved->content as $media) {
                self::pushSchema($media->schema, $out);
            }
        }

        return $out;
    }

    /**
     * @param list<Schema|Reference> $out
     */
    private static function pushSchema(Schema|Reference|null $schema, array &$out): void
    {
        if ($schema !== null) {
            $out[] = $schema;
        }
    }

    /**
     * @param list<string> $out
     */
    private static function collect(Schema|Reference $node, array &$out): void
    {
        if ($node instanceof Reference) {
            $out[] = ComponentName::rawFromRef($node->getReference());

            return;
        }

        $out = [...$out, ...ReferencedComponents::of($node)];
    }
}
