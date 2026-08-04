<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Psr\Http\Message\StreamInterface;

use function assert;
use function implode;

/**
 * Materialises a {@see BodySpec} as zero-or-more method parameters on an
 * emitted ApiClient method.
 *
 * Extracted from {@see OperationEmitter} to keep that class under the
 * linecop limit (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class RequestBodyParameterEmitter
{
    public function __construct(
        private string $modelNamespace,
        private ?EnumCatalog $enums = null,
        private ?NameRegistry $registry = null,
    ) {
        assert($registry instanceof NameRegistry, 'NameRegistry is required (T-023).');
    }

    public function addBodyParams(Method $method, PhpNamespace $namespace, BodySpec $body, Bindings $bindings): void
    {
        switch ($body->kind) {
            case BodySpec::KIND_JSON:
            case BodySpec::KIND_JSON_LIST:
            case BodySpec::KIND_XML:
            case BodySpec::KIND_XML_LIST:
                $this->addJsonBodyParam($method, $namespace, $body);

                return;

            case BodySpec::KIND_JSON_UNION:
                $this->addJsonUnionBodyParam($method, $namespace, $body);

                return;

            case BodySpec::KIND_JSON_MAP:
                $this->addJsonMapBodyParam($method, $namespace, $body, $bindings);

                return;

            case BodySpec::KIND_FORM:
                $this->addFormFieldParams($method, $namespace, $body, $bindings);

                return;

            case BodySpec::KIND_TEXT:
                $method->addParameter('body')->setType('string');

                return;

            case BodySpec::KIND_BINARY:
                $this->addStreamBodyParam($method, $namespace);

                return;
        }
    }

    /**
     * A binary body is typed `Psr\Http\Message\StreamInterface` rather than
     * `resource`, because PHP has no `resource` type declaration: a resource
     * body would be `mixed` plus a docblock, and `declared-shapes-become-types`
     * forbids a declared shape becoming `mixed`. The runtime already requires
     * `psr/http-message`, so this names an interface the consumer's PSR-17
     * factory hands them rather than adding a dependency or a wrapper of our
     * own.
     */
    private function addStreamBodyParam(Method $method, PhpNamespace $namespace): void
    {
        $namespace->addUse(StreamInterface::class);
        $method->addParameter('body')->setType(StreamInterface::class);
    }

    private function addJsonBodyParam(Method $method, PhpNamespace $namespace, BodySpec $body): void
    {
        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $body->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        $phpParam = $method->addParameter('body');

        if ($body->isList()) {
            $phpParam->setType('array');
            $method->addComment('@param ' . DocTypeSimplifier::shorten($namespace, 'list<' . $fqcn . '>') . ' $body');

            return;
        }

        $phpParam->setType($fqcn);
    }

    /**
     * The PHP union across an `allOf`'s synthesised `oneOf`/`anyOf` branch
     * classes — one native union type, no PHPStan annotation needed, per
     * `ruling: an anyOf member becomes a union of branches`. Nette's
     * `Parameter::setType()` already accepts a `|`-joined string; a
     * property-level `oneOf`/`anyOf` of `$ref`s goes through the same call
     * via {@see CompositionResolver::resolveUnion} and {@see ParameterAdder}.
     */
    private function addJsonUnionBodyParam(Method $method, PhpNamespace $namespace, BodySpec $body): void
    {
        $fqcns = [];

        foreach ($body->models as $model) {
            $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $model;
            $namespace->addUse(ltrim($fqcn, '\\'));
            $fqcns[] = $fqcn;
        }

        $method->addParameter('body')->setType(implode('|', $fqcns));
    }

    /**
     * An inline object body with no declared properties. `additionalProperties`
     * still types the values when the document supplied it, so the phpdoc comes
     * from the same resolver that types such a schema on a model property.
     */
    private function addJsonMapBodyParam(Method $method, PhpNamespace $namespace, BodySpec $body, Bindings $bindings): void
    {
        assert($this->registry instanceof NameRegistry);
        $schema = $body->schema ?? new Schema(['type' => 'object']);
        $resolved = InlineObjectResolver::resolve($schema, $bindings, $this->modelNamespace, $this->registry, $this->enums);
        $docType = DocTypeSimplifier::shorten($namespace, $resolved->phpDoc ?? 'array<string, mixed>');

        $method->addParameter('body')->setType('array');
        $method->addComment('@param ' . $docType . ' $body');
    }

    private function addFormFieldParams(Method $method, PhpNamespace $namespace, BodySpec $body, Bindings $bindings): void
    {
        // Required fields first, then optionals (mirrors query-param order).
        $required = [];
        $optional = [];

        foreach ($body->formFields as $field) {
            if ($field->required) {
                $required[] = $field;
                continue;
            }
            $optional[] = $field;
        }

        foreach ($required as $field) {
            $this->addFormFieldParam($method, $namespace, $field, $bindings, required: true);
        }
        foreach ($optional as $field) {
            $this->addFormFieldParam($method, $namespace, $field, $bindings, required: false);
        }
    }

    private function addFormFieldParam(
        Method $method,
        PhpNamespace $namespace,
        FormField $field,
        Bindings $bindings,
        bool $required,
    ): void {
        assert($this->registry instanceof NameRegistry);
        $resolved = TypeResolver::resolve($field->schema, $bindings, $this->modelNamespace, $this->registry, $this->enums);
        $type = $resolved->phpType;

        if ($type !== null && str_contains($type, '\\')) {
            $namespace->addUse(ltrim($type, '\\'));
        }

        $phpParam = $method->addParameter($field->name);

        if ($type !== null) {
            $phpParam->setType($type);
        }

        if (!$required) {
            $phpParam->setNullable()->setDefaultValue(null);
        }
    }
}
