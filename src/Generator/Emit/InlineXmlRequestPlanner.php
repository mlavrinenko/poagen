<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Schema;

use function count;
use function explode;
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
            return BodySpec::xml(InlineModelClaim::named($pin, \Poagen\Generator\Generator\Naming\InlinePayloadName::request($base), $schema, $ledger, $roots), $root);
        }

        $items = InlinePayloadPlanner::inlineObjectItemsOf($schema);
        $item = $xmlElements[$rawId . '.item'] ?? null;

        if ($items instanceof Schema && is_string($item) && $item !== '') {
            return BodySpec::xmlList(
                InlineModelClaim::named($pin, \Poagen\Generator\Generator\Naming\InlinePayloadName::request($base, item: true), $items, $ledger, $roots),
                $root,
                $item,
                self::nestedContainersFor($rawId, $xmlElements),
            );
        }

        return null;
    }

    /**
     * Every `'<rawId>.item.<property>'` entry of `Profile::$xmlElements`,
     * reduced to the shape {@see BodySpec::xmlList()} carries onward — the
     * property alone, since the item element itself is already `$item`. This
     * is the one place a validated binding turns into something the emitted
     * client actually sends; {@see XmlNestedContainerValidator} already
     * proved every key here names a real property, so nothing further is
     * checked.
     *
     * @param  array<string,string> $xmlElements
     * @return array<string,string>
     */
    private static function nestedContainersFor(string $rawId, array $xmlElements): array
    {
        $containers = [];

        foreach ($xmlElements as $key => $child) {
            $parts = explode('.', $key, 3);

            if (count($parts) === 3 && $parts[0] === $rawId && $parts[1] === 'item') {
                $containers[$parts[2]] = $child;
            }
        }

        return $containers;
    }

    /**
     * The item schema of `$operationId`'s `application/xml` list request body,
     * or null when the operation, its XML body, or an array-of-objects shape
     * there does not exist. Shared with {@see XmlNestedContainerValidator},
     * which needs the same schema {@see plan()} would itself claim a model
     * from to check a `'<operationId>.item.<property>'` entry of
     * `Profile::$xmlElements` against — the property a nested-container
     * binding names lives here, one level below the item class {@see plan()}
     * already synthesises.
     */
    public static function itemSchemaOf(OpenApi $openApi, string $operationId): ?Schema
    {
        $operation = InlineModelSiteResolver::operation($openApi, $operationId);

        if (!$operation instanceof Operation) {
            return null;
        }

        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        if (!$body instanceof RequestBody) {
            return null;
        }

        $xml = $body->content['application/xml'] ?? null;
        $schema = $xml instanceof MediaType && $xml->schema instanceof Schema ? $xml->schema : null;

        return $schema instanceof Schema ? InlinePayloadPlanner::inlineObjectItemsOf($schema) : null;
    }
}
