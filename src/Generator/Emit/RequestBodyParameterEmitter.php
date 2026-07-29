<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

/**
 * Materialises a {@see BodySpec} as zero-or-more method parameters on an
 * emitted ApiClient method.
 *
 * Extracted from {@see OperationEmitter} to keep that class under the
 * linecop limit (ADR-004).
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
        \assert($registry instanceof NameRegistry, 'NameRegistry is required (T-023).');
    }

    public function addBodyParams(Method $method, PhpNamespace $namespace, BodySpec $body, Bindings $bindings): void
    {
        switch ($body->kind) {
            case BodySpec::KIND_JSON:
            case BodySpec::KIND_JSON_LIST:
                $this->addJsonBodyParam($method, $namespace, $body);

                return;

            case BodySpec::KIND_JSON_MAP:
                $this->addJsonMapBodyParam($method, $body, $bindings);

                return;

            case BodySpec::KIND_FORM:
                $this->addFormFieldParams($method, $namespace, $body, $bindings);

                return;
        }
    }

    private function addJsonBodyParam(Method $method, PhpNamespace $namespace, BodySpec $body): void
    {
        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $body->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        $phpParam = $method->addParameter('body');

        if ($body->isList()) {
            $phpParam->setType('array');
            $method->addComment('@param list<' . $fqcn . '> $body');

            return;
        }

        $phpParam->setType($fqcn);
    }

    /**
     * An inline object body with no declared properties. `additionalProperties`
     * still types the values when the document supplied it, so the phpdoc comes
     * from the same resolver that types such a schema on a model property.
     */
    private function addJsonMapBodyParam(Method $method, BodySpec $body, Bindings $bindings): void
    {
        \assert($this->registry instanceof NameRegistry);
        $schema = $body->schema ?? new \cebe\openapi\spec\Schema(['type' => 'object']);
        $resolved = InlineObjectResolver::resolve($schema, $bindings, $this->modelNamespace, $this->registry, $this->enums);

        $method->addParameter('body')->setType('array');
        $method->addComment('@param ' . ($resolved->phpDoc ?? 'array<string, mixed>') . ' $body');
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
        \assert($this->registry instanceof NameRegistry);
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
