<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

/**
 * Resolves the `requestBody` of an OpenAPI Operation into a {@see BodySpec}.
 *
 * Preference order:
 *
 *   1. `application/json` with a `$ref`-to-Model or `list<$ref>` schema
 *      — produces a typed body parameter (JSON / JSON_LIST kinds).
 *   2. `application/x-www-form-urlencoded` when it is the *sole* content
 *      type, and the schema is an inline `type: object` with declared
 *      properties — one typed method parameter per property (FORM kind;
 *      T-011). A `$ref`-to-Model form body is intentionally skipped to
 *      avoid flattening a whole Model into dozens of parameters; petstore's
 *      JSON+form pairings are already covered by the JSON branch.
 *   3. `multipart/form-data` or `application/octet-stream` — produces an
 *      UNSUPPORTED stub; the method is still emitted but its body throws
 *      `\RuntimeException` at call time (T-011).
 *   4. `null` otherwise — the caller skips the op entirely.
 *
 * Extracted from {@see OperationAnalyzer} to keep that file under the
 * linecop limit (ADR-004).
 *
 * @internal
 */
final readonly class RequestBodyAnalyzer
{
    public static function resolve(RequestBody|Reference|null $body, NameRegistry $registry): ?BodySpec
    {
        if ($body instanceof Reference) {
            $resolved = $body->resolve();
            $body = $resolved instanceof RequestBody ? $resolved : null;
        }

        if (!$body instanceof RequestBody) {
            return null;
        }

        $jsonSpec = self::jsonBody($body, $registry);

        if ($jsonSpec instanceof BodySpec) {
            return $jsonSpec;
        }

        $formSpec = self::formBody($body);

        if ($formSpec instanceof BodySpec) {
            return $formSpec;
        }

        return self::unsupportedBody($body);
    }

    private static function jsonBody(RequestBody $body, NameRegistry $registry): ?BodySpec
    {
        $json = $body->content['application/json'] ?? null;

        if (!$json instanceof MediaType) {
            return null;
        }

        $schema = $json->schema;

        if ($schema instanceof Reference) {
            $ref = $schema->getReference();
            $raw = ComponentName::rawFromRef($ref);

            return $raw === '' ? null : BodySpec::json(ComponentName::phpFromRef($ref, $registry));
        }

        if ($schema instanceof Schema && $schema->type === 'array') {
            $items = $schema->items;

            if ($items instanceof Reference) {
                $ref = $items->getReference();
                $raw = ComponentName::rawFromRef($ref);

                return $raw === '' ? null : BodySpec::jsonList(ComponentName::phpFromRef($ref, $registry));
            }
        }

        return null;
    }

    /**
     * `application/x-www-form-urlencoded` is only honoured when it's the
     * *sole* content type. Pairings with JSON stay on the JSON path —
     * the form variant is redundant there.
     */
    private static function formBody(RequestBody $body): ?BodySpec
    {
        if (!isset($body->content['application/x-www-form-urlencoded'])) {
            return null;
        }

        if (\count($body->content) > 1) {
            return null;
        }

        $media = $body->content['application/x-www-form-urlencoded'];

        if (!$media instanceof MediaType) {
            return null;
        }

        $schema = $media->schema;

        if (!$schema instanceof Schema || $schema->type !== 'object') {
            return null;
        }

        $properties = $schema->properties;

        if (!\is_array($properties) || $properties === []) {
            return null;
        }

        $required = \is_array($schema->required) ? $schema->required : [];
        $fields = [];

        foreach ($properties as $name => $propSchema) {
            if (!\is_string($name)) {
                continue;
            }
            if ($name === '') {
                continue;
            }
            if (!$propSchema instanceof Schema && !$propSchema instanceof Reference) {
                continue;
            }
            $fields[] = new FormField($name, $propSchema, \in_array($name, $required, true));
        }

        if ($fields === []) {
            return null;
        }

        return BodySpec::form($fields);
    }

    /**
     * `multipart/form-data` and `application/octet-stream` bodies are
     * unsupported today; the emitter produces a method whose body throws
     * instead of silently dropping the operation from the client.
     */
    private static function unsupportedBody(RequestBody $body): ?BodySpec
    {
        foreach (['multipart/form-data', 'application/octet-stream'] as $contentType) {
            if (isset($body->content[$contentType])) {
                return BodySpec::unsupported($contentType);
            }
        }

        return null;
    }

}
