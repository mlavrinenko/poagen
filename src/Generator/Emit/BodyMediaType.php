<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function is_string;
use function str_ends_with;

/**
 * What class of payload a content type names, read once for both directions.
 *
 * The request and response analysers ask the same questions of a `content`
 * map and used to answer them separately. The vendor's subtype is not the
 * evidence — the schema under it is. GitHub answers `GET /octocat` with
 * `application/octocat-stream`, a subtype no registry lists and whose name
 * says "stream", over a schema that plainly declares `type: string`
 * (`/paths/~1octocat/get/responses/200`). Classifying on the subtype would
 * have made that a binary body; classifying on the schema makes it the
 * string the document declared.
 *
 * Four classes, in the order every caller decides them:
 *
 *   - JSON (`application/json`, `*+json`) — every other branch's
 *     precondition, resolved first everywhere.
 *   - XML (`application/xml`, `*+xml`) — serialised on the request side by
 *     {@see InlinePayloadPlanner} and refused on the response side by
 *     `xml-responses-refused-at-generation-time`, so neither text nor binary
 *     may claim it.
 *   - Binary — `application/octet-stream`, or any schema carrying
 *     `format: binary`.
 *   - Text — anything left whose schema declares `type: string`. Wider than
 *     `text/*` on purpose, for the octocat case above.
 *
 * A content type matching none of these is unrepresentable and its caller
 * refuses the operation by name (default-deny-on-degradation).
 *
 * @internal
 */
final readonly class BodyMediaType
{
    public const string JSON = 'application/json';
    public const string XML = 'application/xml';
    public const string OCTET_STREAM = 'application/octet-stream';
    public const string MULTIPART = 'multipart/form-data';

    public static function isJson(string $mediaType): bool
    {
        return $mediaType === self::JSON || str_ends_with($mediaType, '+json');
    }

    public static function isXml(string $mediaType): bool
    {
        return $mediaType === self::XML || str_ends_with($mediaType, '+xml');
    }

    /**
     * A body the wire carries as opaque bytes: the octet-stream content type,
     * or a schema the document annotated `format: binary` under any content
     * type at all.
     */
    public static function isBinary(string $mediaType, ?Schema $schema): bool
    {
        if ($mediaType === self::OCTET_STREAM) {
            return true;
        }

        return $schema instanceof Schema && $schema->format === 'binary';
    }

    /**
     * A body the wire carries as characters. `format: binary` disqualifies a
     * `type: string` schema, which is exactly how OpenAPI 3.0 spells a file
     * upload.
     */
    public static function isText(string $mediaType, ?Schema $schema): bool
    {
        if (self::isJson($mediaType) || self::isXml($mediaType)) {
            return false;
        }

        if (self::isBinary($mediaType, $schema)) {
            return false;
        }

        return $schema instanceof Schema && SchemaType::of($schema)->is('string');
    }

    /**
     * The first text content type in the map, in the document's own
     * declaration order.
     *
     * Declaration order is the whole content-negotiation policy for a body
     * that names several text types, and it is why GitHub's
     * `text/plain, text/x-markdown` pair emits one method rather than two:
     * `text/plain` is declared first, so `text/plain` is what poagen sends.
     * The alternative — a method per content type, or a content-type
     * argument — asks the caller to answer a question the document already
     * answered.
     *
     * The key type is `array-key` rather than `string` because that is what
     * the parser declares: `RequestBody::$content` and `Response::$content`
     * are both `MediaType[]`, so PHPStan reads their keys as `array-key`
     * even though a content map is keyed by media type and nothing else.
     * The `is_string()` guard below is that narrowing, and it belongs to the
     * same family of understated accessor declarations AGENT.md records for
     * `allOf` and `servers` — do not delete it as redundant.
     *
     * @param array<array-key, MediaType> $content
     */
    public static function firstText(array $content): ?string
    {
        foreach ($content as $mediaType => $media) {
            if (!is_string($mediaType)) {
                continue;
            }
            if (self::isText($mediaType, self::schemaOf($media))) {
                return $mediaType;
            }
        }

        return null;
    }

    /**
     * The first binary content type in the map, in declaration order.
     *
     * @param array<array-key, MediaType> $content
     */
    public static function firstBinary(array $content): ?string
    {
        foreach ($content as $mediaType => $media) {
            if (!is_string($mediaType)) {
                continue;
            }
            if (self::isBinary($mediaType, self::schemaOf($media))) {
                return $mediaType;
            }
        }

        return null;
    }

    /**
     * The inline schema under one content-type entry, or null when the entry
     * declares none or reaches it through a `$ref` this class cannot read a
     * `type` off without resolving.
     */
    public static function schemaOf(MediaType|Reference|null $media): ?Schema
    {
        if (!$media instanceof MediaType) {
            return null;
        }

        $schema = $media->schema;

        return $schema instanceof Schema ? $schema : null;
    }
}
