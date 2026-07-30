<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use function sprintf;
use function var_export;

/**
 * The chain segment that gives an {@see Endpoint} its request body.
 *
 * Each body kind names itself and hands over the value the caller already
 * holds — a Model, a list of Models, an array of declared fields. Marshalling,
 * encoding and the content-type header are the transport's, which is why
 * every kind is one call here rather than three emitted lines each.
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
            BodySpec::KIND_XML_LIST => sprintf(
                '->xmlList($body, %s, %s)',
                var_export($body->rootElement, true),
                var_export($body->itemElement, true),
            ),
            BodySpec::KIND_FORM => $this->form($body),
            default => '->json($body)',
        };
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
