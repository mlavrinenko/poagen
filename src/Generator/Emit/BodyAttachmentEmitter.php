<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

use function sprintf;

/**
 * Emits the lines that attach a request body, per {@see BodySpec::$kind}.
 *
 * Every kind routes through the runtime {@see Marshaller}
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
    public function emit(Method $method, PhpNamespace $namespace, BodySpec $body): void
    {
        if ($body->kind === BodySpec::KIND_FORM) {
            $this->emitForm($method, $namespace, $body);

            return;
        }

        $isList = $body->kind === BodySpec::KIND_JSON_LIST || $body->kind === BodySpec::KIND_XML_LIST;

        if ($isList) {
            $namespace->addUseFunction('array_map');
        }

        $payload = match ($body->kind) {
            BodySpec::KIND_JSON_LIST, BodySpec::KIND_XML_LIST => 'array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body)',
            // No model to marshal — the caller already holds the wire shape.
            BodySpec::KIND_JSON_MAP => '$body',
            default => '$this->marshaller->marshal($body)',
        };

        if ($body->isXml()) {
            $this->emitXml($method, $namespace, $body, $payload);

            return;
        }

        $namespace->addUseFunction('json_encode');
        $namespace->addUseConstant('JSON_THROW_ON_ERROR');

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/json')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(json_encode(' . $payload . ', JSON_THROW_ON_ERROR)));');
    }

    private function emitXml(Method $method, PhpNamespace $namespace, BodySpec $body, string $payload): void
    {
        $namespace->addUse(XmlWriter::class);
        $writer = $namespace->simplifyName(XmlWriter::class);

        $render = $body->kind === BodySpec::KIND_XML_LIST
            ? sprintf(
                '%s::renderList(%s, %s, %s)',
                $writer,
                $payload,
                var_export($body->rootElement, true),
                var_export($body->itemElement, true),
            )
            : sprintf(
                '%s::renderObject(%s, %s)',
                $writer,
                $payload,
                var_export($body->rootElement, true),
            );

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/xml')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(' . $render . '));');
    }

    private function emitForm(Method $method, PhpNamespace $namespace, BodySpec $body): void
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

        $namespace->addUseFunction('http_build_query');
        $namespace->addUseConstant('PHP_QUERY_RFC1738');

        $method->addBody('$request = $request');
        $method->addBody("    ->withHeader('Content-Type', 'application/x-www-form-urlencoded')");
        $method->addBody('    ->withBody($this->streamFactory->createStream(http_build_query($__form, \'\', \'&\', PHP_QUERY_RFC1738)));');
    }
}
