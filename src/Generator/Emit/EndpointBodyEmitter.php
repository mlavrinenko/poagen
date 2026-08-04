<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Http\PsrRequestBuilder;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;

use function sprintf;
use function var_export;

/**
 * The chain segment that gives an {@see Endpoint} its request body.
 *
 * Each body kind names itself and hands over the value the caller already
 * holds — a Model, a list of Models, an array of declared fields.
 * Marshalling reads the value's own runtime class
 * ({@see Marshaller::marshal()} takes a
 * bare `object`), so `KIND_JSON_UNION` — one of an `allOf`'s synthesised
 * `oneOf`/`anyOf` branch classes — needs no branch of its own here and falls
 * through the same `->json($body)` call `KIND_JSON` does. Encoding and the
 * content-type header are the transport's, which is why every other kind is
 * one call here rather than three emitted lines each.
 *
 * @internal
 */
final readonly class EndpointBodyEmitter
{
    public function segment(BodySpec $body): string
    {
        return match ($body->kind) {
            BodySpec::KIND_JSON_LIST => '->jsonList($body)',
            // The document declared an object with no properties, so the
            // caller passes the wire shape and there is nothing to marshal.
            BodySpec::KIND_JSON_MAP => '->jsonRaw($body)',
            BodySpec::KIND_XML => sprintf('->xml($body, %s)', var_export($body->rootElement, true)),
            BodySpec::KIND_XML_LIST => $this->xmlList($body),
            BodySpec::KIND_FORM => $this->form($body),
            // Both carry the content type the document declared rather than
            // one implied by the kind: a `format: binary` schema is binary
            // under whatever type the vendor named it (`application/pdf` in
            // DigitalOcean's corpus), not only under octet-stream.
            BodySpec::KIND_TEXT => sprintf('->text($body, %s)', var_export($body->contentType, true)),
            BodySpec::KIND_BINARY => sprintf('->binary($body, %s)', var_export($body->contentType, true)),
            default => '->json($body)',
        };
    }

    /**
     * `$body->nestedContainers` is the whole reason this task exists:
     * emitted straight onto the call so `Endpoint::xmlList()` — and, through
     * it, {@see PsrRequestBuilder} — knows
     * about a nested container without a consumer rebuilding the map by
     * hand. Omitted entirely when empty, so an operation with no nested
     * binding emits exactly the call it always has.
     */
    private function xmlList(BodySpec $body): string
    {
        if ($body->nestedContainers === []) {
            return sprintf(
                '->xmlList($body, %s, %s)',
                var_export($body->rootElement, true),
                var_export($body->itemElement, true),
            );
        }

        return sprintf(
            '->xmlList($body, %s, %s, %s)',
            var_export($body->rootElement, true),
            var_export($body->itemElement, true),
            $this->nestedContainersLiteral($body->nestedContainers),
        );
    }

    /**
     * A short-array literal, one `key => value` pair per property — the same
     * hand-built style {@see form()} uses, rather than `var_export`'s
     * legacy `array (...)` form, which would not read as one call.
     *
     * @param array<string,string> $nestedContainers
     */
    private function nestedContainersLiteral(array $nestedContainers): string
    {
        $pairs = [];

        foreach ($nestedContainers as $property => $child) {
            $pairs[] = var_export($property, true) . ' => ' . var_export($child, true);
        }

        return '[' . implode(', ', $pairs) . ']';
    }

    /**
     * Form fields are passed as one array literal. A field the caller left
     * out arrives as null and is dropped at the boundary, so an optional
     * field costs no `if`.
     */
    private function form(BodySpec $body): string
    {
        $pairs = [];

        foreach ($body->formFields as $field) {
            $pairs[] = var_export($field->name, true) . ' => $' . $field->name;
        }

        return '->form([' . implode(', ', $pairs) . '])';
    }
}
