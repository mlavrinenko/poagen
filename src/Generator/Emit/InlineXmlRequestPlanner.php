<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\InlinePayloadName;

use function is_string;

/**
 * Plans an `application/xml` request body, whose payload model is
 * synthesised exactly as a JSON one is — the schema is declared, so nothing
 * about the shape is different. Only the element names are, and they come
 * from the profile because OpenAPI supplies no default for the document
 * root.
 *
 * Split out of {@see InlinePayloadPlanner} to keep that file under the
 * linecop limit (`quality-gates-at-maximum-strictness`). This is the branch
 * {@see InlinePayloadPlanner::planRequest()} reaches only when the body
 * offers no `application/json`, so it shares that class's naming ledger and
 * synthesisability checks rather than duplicating them.
 *
 * @internal
 */
final readonly class InlineXmlRequestPlanner
{
    /**
     * Returns null when the profile named nothing, which the caller reports as an
     * unrepresentable body rather than emitting XML with an invented root.
     *
     * @param array<string,string>   $xmlElements
     * @param list<SynthesisedModel> $roots
     */
    public static function plan(
        RequestBody $body,
        string $rawId,
        string $base,
        ?string $pin,
        ModelNameLedger $ledger,
        array &$roots,
        array $xmlElements,
    ): ?BodySpec {
        $xml = $body->content['application/xml'] ?? null;
        $schema = $xml instanceof MediaType && $xml->schema instanceof Schema ? $xml->schema : null;

        if (!$schema instanceof Schema) {
            return null;
        }

        $root = $xmlElements[$rawId] ?? null;

        if (!is_string($root) || $root === '') {
            return null;
        }

        if (InlinePayloadPlanner::isSynthesisableObject($schema)) {
            return BodySpec::xml(InlineModelClaim::named($pin, InlinePayloadName::request($base), $schema, $ledger, $roots), $root);
        }

        $items = InlinePayloadPlanner::inlineObjectItemsOf($schema);
        $item = $xmlElements[$rawId . '.item'] ?? null;

        if ($items instanceof Schema && is_string($item) && $item !== '') {
            return BodySpec::xmlList(
                InlineModelClaim::named($pin, InlinePayloadName::request($base, item: true), $items, $ledger, $roots),
                $root,
                $item,
            );
        }

        return null;
    }
}
