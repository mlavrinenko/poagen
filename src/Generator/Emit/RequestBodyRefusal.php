<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;

use function count;
use function implode;
use function sprintf;

/**
 * Why {@see RequestBodyAnalyzer::resolve()} refused a request body.
 *
 * Split off from the analyser so both stay under the linecop limit
 * (`quality-gates-at-maximum-strictness`) and so the diagnostics read as one
 * body of prose rather than as branches interleaved with the resolution they
 * explain. Every message names the construct, where it sits in the document,
 * and what would make it acceptable — a refusal a consumer can act on is the
 * whole point of refusing (abort-on-unrepresentable-constructs).
 *
 * @internal
 */
final readonly class RequestBodyRefusal
{
    private const string SUPPORTED = 'paogen emits application/json ($ref or list<$ref>), '
        . 'application/x-www-form-urlencoded, application/xml (inline object/array, elements named in '
        . 'Profile::$xmlElements), a text content type over a `type: string` schema, and '
        . 'application/octet-stream as a PSR-7 stream';

    public static function describe(RequestBody $body): string
    {
        $types = array_keys($body->content);
        $pointer = $body->getDocumentPosition();
        $location = $pointer instanceof JsonPointer ? ' (' . $pointer->getPointer() . ')' : '';

        if (isset($body->content[BodyMediaType::MULTIPART])) {
            return 'multipart/form-data request body' . $location
                . ' — every part carries its own content type and encoding, which paogen does not model; '
                . self::SUPPORTED;
        }

        if (isset($body->content[BodyMediaType::JSON])) {
            return 'application/json request body with an inline (non-$ref) schema' . $location
                . ' — paogen only emits a typed body for a $ref to a component schema, or list<$ref>; '
                . 'move the schema into components.schemas and reference it';
        }

        $form = $body->content['application/x-www-form-urlencoded'] ?? null;

        if ($form instanceof MediaType) {
            return self::describeForm($form, $types, $location);
        }

        if (isset($body->content[BodyMediaType::XML])) {
            return 'application/xml request body' . $location
                . ' — paogen serialises an inline object (or an array of inline objects) schema declared '
                . 'application/xml, naming the document root (and, for a list, the repeated item element) in '
                . 'Profile::$xmlElements; add the missing entry, or — if the schema is a $ref, a scalar, or an '
                . 'inline object with no declared properties — it cannot be named there and stays unrepresentable';
        }

        $typeList = $types === [] ? '(none declared)' : implode(', ', $types);

        return sprintf("request body content type(s) '%s'%s — %s", $typeList, $location, self::SUPPORTED);
    }

    /**
     * @param list<string> $types
     */
    private static function describeForm(MediaType $form, array $types, string $location): string
    {
        if (count($types) > 1) {
            $others = implode(', ', array_values(array_diff($types, ['application/x-www-form-urlencoded'])));

            return "application/x-www-form-urlencoded request body paired with other content type(s) ({$others}){$location}"
                . ' — paogen only honours it when it is the sole content type';
        }

        $schema = $form->schema;

        if (!$schema instanceof Schema || !SchemaType::of($schema)->is('object')) {
            return "application/x-www-form-urlencoded request body{$location} whose schema is not an inline `type: object`"
                . ' — paogen flattens declared properties into method parameters and needs an inline object schema';
        }

        return "application/x-www-form-urlencoded request body{$location} declares no properties"
            . ' — paogen needs at least one property to generate method parameters from';
    }
}
