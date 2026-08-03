<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function count;
use function in_array;
use function is_array;
use function is_string;

/**
 * Resolves the `requestBody` of an OpenAPI Operation into a {@see BodySpec}.
 *
 * `application/xml` is handled earlier, by {@see InlinePayloadPlanner} — an
 * inline object (or array of one) named in `Profile::$xmlElements` — so it
 * never reaches this class as a success. It does reach {@see
 * describeUnsupported()} when the planner declined it (missing element name,
 * or a shape XML cannot serialise), which is why that method names the XML
 * remedy rather than treating it as an unrecognised content type.
 *
 * Preference order for what this class resolves itself:
 *
 *   1. `application/json` with a `$ref`-to-Model or `list<$ref>` schema
 *      — produces a typed body parameter (JSON / JSON_LIST kinds).
 *   2. `application/x-www-form-urlencoded` when it is the *sole* content
 *      type, and the schema is an inline `type: object` with declared
 *      properties — one typed method parameter per property (FORM kind;
 *      T-011). A `$ref`-to-Model form body is intentionally skipped to
 *      avoid flattening a whole Model into dozens of parameters; petstore's
 *      JSON+form pairings are already covered by the JSON branch.
 *   3. A text content type over a `type: string` schema — one `string`
 *      parameter, sent under the first such content type the document
 *      declared (TEXT kind). {@see BodyMediaType::firstText()} carries the
 *      reasoning for why several text types on one body stay one method.
 *   4. `application/octet-stream`, or any `format: binary` schema — one
 *      `Psr\Http\Message\StreamInterface` parameter, handed to the transport
 *      unread (BINARY kind).
 *   5. `null` otherwise — the caller refuses the operation; {@see
 *      describeUnsupported()} explains why, for the operation to be
 *      reported instead of silently dropped (abort-on-unrepresentable-constructs,
 *      default-deny-on-degradation).
 *
 * Extracted from {@see OperationAnalyzer} to keep that file under the
 * linecop limit (`quality-gates-at-maximum-strictness`); the diagnostics half
 * moved on to {@see RequestBodyRefusal} for the same reason.
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

        $formSpec = self::formBody($resolved);

        if ($formSpec instanceof BodySpec) {
            return $formSpec;
        }

        return self::opaqueBody($resolved);
    }

    /**
     * A body the document declared as characters or as bytes.
     *
     * Neither needs a Model: the schema says `type: string` and that is the
     * whole shape. Text wins over binary when a document declares both,
     * because a `type: string` schema without `format: binary` is the more
     * specific claim.
     */
    private static function opaqueBody(RequestBody $body): ?BodySpec
    {
        $text = BodyMediaType::firstText($body->content);

        if ($text !== null) {
            return BodySpec::text($text);
        }

        $binary = BodyMediaType::firstBinary($body->content);

        return $binary === null ? null : BodySpec::binary($binary);
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
        return RequestBodyRefusal::describe($body);
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

        if ($schema instanceof Schema && SchemaType::of($schema)->is('array')) {
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

        if (count($body->content) > 1) {
            return null;
        }

        $media = $body->content['application/x-www-form-urlencoded'];

        if (!$media instanceof MediaType) {
            return null;
        }

        $schema = $media->schema;

        if (!$schema instanceof Schema || !SchemaType::of($schema)->is('object')) {
            return null;
        }

        $properties = $schema->properties;

        if (!is_array($properties) || $properties === []) {
            return null;
        }

        $required = is_array($schema->required) ? $schema->required : [];
        $fields = [];

        foreach ($properties as $name => $propSchema) {
            if (!is_string($name)) {
                continue;
            }
            if ($name === '') {
                continue;
            }
            if (!$propSchema instanceof Schema && !$propSchema instanceof Reference) {
                continue;
            }
            $fields[] = new FormField($name, $propSchema, in_array($name, $required, true));
        }

        if ($fields === []) {
            return null;
        }

        return BodySpec::form($fields);
    }
}
