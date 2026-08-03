<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\RequestBody;

use function sort;
use function sprintf;

use const SORT_STRING;

/**
 * Names every `application/json` request body whose media type declares no
 * `schema` key at all — `a-media-type-with-no-schema-takes-a-raw-body`.
 *
 * `RequestBodyAnalyzer` now passes such a body through untyped rather than
 * refusing the operation, on the reading that a document declaring nothing
 * is not the same claim as a schema paogen cannot type. Doing that silently
 * would be exactly the widening `merge-allof-members-into-one-model` exists
 * to remove: a `KIND_JSON_MAP` `array` parameter looks identical whether the
 * document left the shape open on purpose or the media type is simply
 * missing its `schema`. This reports every site instead, on the same
 * notice channel `report-unrecognised-formats` established — stderr, never
 * the exit status, because nothing here shrinks the emitted client.
 *
 * @internal
 */
final readonly class SchemalessBodyAdvisor
{
    /**
     * @return list<string> one line per site, ordered by document position
     */
    public static function notices(OpenApi $openApi): array
    {
        $sites = [];

        foreach ($openApi->paths ?? [] as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $resolved = RequestBodyAnalyzer::resolveBody($operation->requestBody);

                if (!$resolved instanceof RequestBody) {
                    continue;
                }

                $json = $resolved->content['application/json'] ?? null;

                if ($json instanceof MediaType && $json->schema === null) {
                    $sites[] = self::position($json, $resolved);
                }
            }
        }

        sort($sites, SORT_STRING);

        $notices = [];

        foreach ($sites as $site) {
            $notices[] = sprintf(
                '%s declares an application/json request body with no `schema` — the document says nothing '
                    . 'about its shape, so paogen passes it through untyped as `array<string, mixed>` rather '
                    . 'than refusing the operation.',
                $site,
            );
        }

        return $notices;
    }

    /**
     * The media type's own document position where it has one — cebe only
     * populates positions for nodes it walked while resolving `$ref`s, which
     * a media type with no `schema` still is — falling back to the request
     * body's, so a notice never reads "(no document position)" for a
     * construct this ordinary.
     */
    private static function position(MediaType $json, RequestBody $body): string
    {
        $pointer = $json->getDocumentPosition() ?? $body->getDocumentPosition();

        return $pointer instanceof JsonPointer ? $pointer->getPointer() : '(no document position)';
    }
}
