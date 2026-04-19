<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

/**
 * Materialises a {@see BodySpec} as zero-or-more method parameters on an
 * emitted ApiClient method, and (for UNSUPPORTED kinds) wires the throwing
 * stub.
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
    ) {}

    public function addBodyParams(Method $method, PhpNamespace $namespace, BodySpec $body, Bindings $bindings): void
    {
        switch ($body->kind) {
            case BodySpec::KIND_JSON:
            case BodySpec::KIND_JSON_LIST:
                $this->addJsonBodyParam($method, $namespace, $body);

                return;

            case BodySpec::KIND_FORM:
                $this->addFormFieldParams($method, $namespace, $body, $bindings);

                return;

            case BodySpec::KIND_UNSUPPORTED:
                // No body parameter; `emitUnsupportedStub` wires the throw.
                return;
        }
    }

    public function emitUnsupportedStub(Method $method, BodySpec $body, string $operationId): void
    {
        // Loud runtime signal rather than silent skip: anyone whose schema
        // uses multipart or octet-stream sees the gap at call time. The
        // throw itself is the generator-time warning — simpler than a
        // side-channel logger and impossible to miss downstream.
        $method->setReturnType('never');
        $method->addComment('@psalm-return never');
        $method->addComment('');
        $method->addComment('TODO(multipart): see task 011 — unsupported body content type');
        $method->addComment('Body content-type: ' . $body->unsupportedContentType);
        $method->addBody(
            'throw new \RuntimeException(?);',
            [\sprintf("%s not yet supported: operationId '%s'", $body->unsupportedContentType, $operationId)],
        );
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
        $resolved = TypeResolver::resolve($field->schema, $bindings, $this->modelNamespace, $this->enums);
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
