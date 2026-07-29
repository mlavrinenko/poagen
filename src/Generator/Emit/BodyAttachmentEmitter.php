<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;
use Nette\PhpGenerator\Method;

/**
 * Emits the lines that attach a request body, per {@see BodySpec::$kind}.
 *
 * Every kind routes through the runtime {@see \Mlavrinenko\Paogen\Runtime\Marshal\Marshaller}
 * first, so wire names, scalar bindings and date formats are decided once and the
 * content types cannot disagree about a value. Only the last step differs: JSON
 * hands the array to `json_encode`, XML hands the same array to
 * {@see XmlWriter}, and form-encoded builds a query string from the flattened
 * fields — the shape OAuth2 token endpoints and Stripe-style APIs expect.
 *
 * Extracted from {@see RequestAssembler} to keep that class under the linecop
 * limit (ADR-004).
 *
 * @internal
 */
final readonly class BodyAttachmentEmitter
{
    public function emit(Method $method, BodySpec $body): void
    {
        if ($body->kind === BodySpec::KIND_FORM) {
            $this->emitForm($method, $body);

            return;
        }

        $payload = match ($body->kind) {
            BodySpec::KIND_JSON_LIST, BodySpec::KIND_XML_LIST => '\\array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body)',
            // No model to marshal — the caller already holds the wire shape.
            BodySpec::KIND_JSON_MAP => '$body',
            default => '$this->marshaller->marshal($body)',
        };

        if ($body->isXml()) {
            $this->emitXml($method, $body, $payload);

            return;
        }

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/json')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(\\json_encode(' . $payload . ', \\JSON_THROW_ON_ERROR)));');
    }

    private function emitXml(Method $method, BodySpec $body, string $payload): void
    {
        $render = $body->kind === BodySpec::KIND_XML_LIST
            ? \sprintf(
                '\\%s::renderList(%s, %s, %s)',
                XmlWriter::class,
                $payload,
                var_export($body->rootElement, true),
                var_export($body->itemElement, true),
            )
            : \sprintf(
                '\\%s::renderObject(%s, %s)',
                XmlWriter::class,
                $payload,
                var_export($body->rootElement, true),
            );

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/xml')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(' . $render . '));');
    }

    private function emitForm(Method $method, BodySpec $body): void
    {
        $method->addBody('$__form = [];');

        foreach ($body->formFields as $field) {
            if ($field->required) {
                $method->addBody('$__form[?] = $' . $field->name . ';', [$field->name]);

                continue;
            }

            $method->addBody(
                'if ($' . $field->name . ' !== null) { $__form[?] = $' . $field->name . '; }',
                [$field->name],
            );
        }

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/x-www-form-urlencoded')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(\\http_build_query($__form, \'\', \'&\', \\PHP_QUERY_RFC1738)));');
    }
}
