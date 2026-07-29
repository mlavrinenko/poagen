<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
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
 *   3. `null` otherwise — the caller skips the op entirely; {@see
 *      describeUnsupported()} explains why, for the operation to be
 *      reported instead of silently dropped (abort-on-unrepresentable-constructs).
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
        $resolved = self::resolveBody($body);

        if (!$resolved instanceof RequestBody) {
            return null;
        }

        $jsonSpec = self::jsonBody($resolved, $registry);

        if ($jsonSpec instanceof BodySpec) {
            return $jsonSpec;
        }

        return self::formBody($resolved);
    }

    /**
     * Resolves a `$ref` request body to its concrete node. Exposed so a
     * caller whose {@see resolve()} call returned null can build a precise
     * diagnostic via {@see describeUnsupported()} instead of a generic one.
     */
    public static function resolveBody(RequestBody|Reference|null $body): ?RequestBody
    {
        if ($body instanceof Reference) {
            $resolved = $body->resolve();

            return $resolved instanceof RequestBody ? $resolved : null;
        }

        return $body;
    }

    /**
     * Explains why {@see resolve()} returned null for a resolved, non-null
     * request body — names the unsupported content type(s)/shape and what
     * would make the body acceptable.
     */
    public static function describeUnsupported(RequestBody $body): string
    {
        $types = array_keys($body->content);
        $pointer = $body->getDocumentPosition();
        $location = $pointer instanceof JsonPointer ? ' (' . $pointer->getPointer() . ')' : '';

        if (isset($body->content['multipart/form-data'])) {
            return 'multipart/form-data request body' . $location
                . ' — paogen emits JSON ($ref or list<$ref>) and application/x-www-form-urlencoded bodies only';
        }

        if (isset($body->content['application/octet-stream'])) {
            return 'application/octet-stream request body' . $location
                . ' — paogen emits JSON ($ref or list<$ref>) and application/x-www-form-urlencoded bodies only';
        }

        if (isset($body->content['application/json'])) {
            return 'application/json request body with an inline (non-$ref) schema' . $location
                . ' — paogen only emits a typed body for a $ref to a component schema, or list<$ref>; '
                . 'move the schema into components.schemas and reference it';
        }

        $form = $body->content['application/x-www-form-urlencoded'] ?? null;

        if ($form instanceof MediaType) {
            return self::describeUnsupportedForm($form, $types, $location);
        }

        $typeList = $types === [] ? '(none declared)' : implode(', ', $types);

        return \sprintf(
            "request body content type(s) '%s'%s — paogen supports application/json (\$ref/list<\$ref>) and "
                . 'application/x-www-form-urlencoded as the sole content type with an inline object schema only',
            $typeList,
            $location,
        );
    }

    /**
     * @param list<string> $types
     */
    private static function describeUnsupportedForm(MediaType $form, array $types, string $location): string
    {
        if (\count($types) > 1) {
            $others = implode(', ', array_values(array_diff($types, ['application/x-www-form-urlencoded'])));

            return "application/x-www-form-urlencoded request body paired with other content type(s) ({$others}){$location}"
                . ' — paogen only honours it when it is the sole content type';
        }

        $schema = $form->schema;

        if (!$schema instanceof Schema || $schema->type !== 'object') {
            return "application/x-www-form-urlencoded request body{$location} whose schema is not an inline `type: object`"
                . ' — paogen flattens declared properties into method parameters and needs an inline object schema';
        }

        return "application/x-www-form-urlencoded request body{$location} declares no properties"
            . ' — paogen needs at least one property to generate method parameters from';
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
}
