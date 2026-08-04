<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;

use function array_keys;
use function implode;
use function is_string;
use function sprintf;

/**
 * Why {@see ResponseAnalyzer::resolve()} refused a picked 2xx response.
 *
 * Split off from the analyser so both stay under the linecop limit
 * (`quality-gates-at-maximum-strictness`), mirroring
 * {@see RequestBodyRefusal}. Each message names the status, where the
 * response sits in the document, what it declared, and the one thing that
 * would make it acceptable — including, where that thing is `Profile::$skip`,
 * saying so rather than leaving the consumer to find it.
 *
 * @internal
 */
final readonly class ResponseRefusal
{
    private const string REMEDY = 'add an application/json entry, or accept this operation by name in Profile::$skip';

    /**
     * @param array<array-key, MediaType> $content
     */
    public static function describe(string $status, Response $response, array $content): string
    {
        $pointer = $response->getDocumentPosition();
        $location = $pointer instanceof JsonPointer ? ' (' . $pointer->getPointer() . ')' : '';
        $prefix = sprintf('%s response%s', $status, $location);

        $json = $content[BodyMediaType::JSON] ?? null;

        if (!$json instanceof MediaType) {
            return self::describeContentTypes($prefix, $content);
        }

        return self::describeJson($prefix, $json);
    }

    /**
     * A response with no `application/json` entry. Text and binary are both
     * decoded now, so reaching here means the remaining content types are
     * XML (refused by `xml-responses-refused-at-generation-time`) or
     * something whose schema declares no type at all.
     *
     * @param array<array-key, MediaType> $content
     */
    private static function describeContentTypes(string $prefix, array $content): string
    {
        $types = array_keys($content);
        $typeList = $types === [] ? '(none declared)' : implode(', ', $types);

        foreach ($types as $mediaType) {
            if (!is_string($mediaType)) {
                continue;
            }

            if (BodyMediaType::isXml($mediaType)) {
                return sprintf(
                    '%s is declared %s — poagen refuses an XML response at generation time rather than decoding '
                        . 'it or handing back the raw body (xml-responses-refused-at-generation-time); %s',
                    $prefix,
                    $mediaType,
                    self::REMEDY,
                );
            }
        }

        return sprintf(
            "%s content type(s) '%s' — poagen decodes application/json responses (\$ref/list<\$ref>, a scalar, "
                . 'or an additionalProperties map), returns a text content type over a `type: string` schema as a '
                . 'string, and returns a `format: binary` body as a PSR-7 stream; %s',
            $prefix,
            $typeList,
            self::REMEDY,
        );
    }

    private static function describeJson(string $prefix, MediaType $json): string
    {
        $schema = $json->schema;

        if ($schema instanceof Reference) {
            return sprintf(
                "%s \$ref '%s' does not resolve to a component schema — fix or remove the \$ref",
                $prefix,
                $schema->getReference(),
            );
        }

        if (!$schema instanceof Schema) {
            return sprintf('%s declares application/json with no schema — poagen needs one to know what to decode', $prefix);
        }

        $type = SchemaType::of($schema);

        if ($type->is('array')) {
            return self::describeArray($prefix, $schema);
        }

        return sprintf(
            "%s has an application/json schema of type '%s', which poagen cannot represent as a method return type",
            $prefix,
            $type->describe(),
        );
    }

    private static function describeArray(string $prefix, Schema $schema): string
    {
        $items = $schema->items;

        if ($items instanceof Reference) {
            return sprintf(
                "%s array \$ref '%s' does not resolve to a component schema — fix or remove the \$ref",
                $prefix,
                $items->getReference(),
            );
        }

        return sprintf(
            '%s is a JSON array whose items declare neither a $ref nor a scalar `type` — poagen emits a typed '
                . 'list for items that are a $ref to a component schema, and a list of scalars for items that '
                . 'declare one; give the items a `type`, or move the item schema into components.schemas',
            $prefix,
        );
    }
}
