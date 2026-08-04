<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

/**
 * Adds path / query / header parameters to a `Method` skeleton, taking
 * the PHP identifier from a {@see ResolvedParameter} so wire names
 * (`Content-Type`) survive verbatim while PHP signatures use
 * sanitised identifiers (`$contentType`).
 *
 * Extracted from {@see OperationEmitter} to keep that class under
 * `quality-gates-at-maximum-strictness`'s 250-line limit.
 *
 * @internal
 */
final readonly class ParameterAdder
{
    public function __construct(
        private string $modelNamespace,
        private ?\Poagen\Generator\Generator\Enum\EnumCatalog $enums,
        private \Poagen\Generator\Generator\Naming\NameRegistry $registry,
    ) {}

    /**
     * @param list<ResolvedParameter> $params
     */
    public function addPath(Method $method, PhpNamespace $namespace, array $params, \Poagen\Generator\Generator\Bindings $bindings, string $operationId): void
    {
        foreach ($params as $resolvedParam) {
            $resolved = $this->resolveParamType($resolvedParam->param, $bindings, $operationId);
            $this->importParamType($namespace, $resolved);
            $phpParam = $method->addParameter($resolvedParam->phpName);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }
        }
    }

    /**
     * @param list<ResolvedParameter> $params
     */
    public function addQuery(
        Method $method,
        PhpNamespace $namespace,
        array $params,
        \Poagen\Generator\Generator\Bindings $bindings,
        bool $required,
        string $operationId,
    ): void {
        foreach ($params as $resolvedParam) {
            $resolved = $this->resolveParamType($resolvedParam->param, $bindings, $operationId);
            $this->importParamType($namespace, $resolved);
            $phpParam = $method->addParameter($resolvedParam->phpName);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }

            if ($resolved->phpDoc !== null) {
                $docType = DocTypeSimplifier::shorten($namespace, $resolved->phpDoc);
                $method->addComment('@param ' . $docType . ' $' . $resolvedParam->phpName);
            }

            if (!$required) {
                $phpParam->setNullable()->setDefaultValue(null);
            }
        }
    }

    /**
     * A required header is a required method argument, same as a required
     * query parameter — the caller passes `required: true` for that block
     * and `false` for the optional one, mirroring {@see addQuery}.
     *
     * @param list<ResolvedParameter> $params
     */
    public function addHeader(
        Method $method,
        PhpNamespace $namespace,
        array $params,
        \Poagen\Generator\Generator\Bindings $bindings,
        string $operationId,
        bool $required = false,
    ): void {
        foreach ($params as $resolvedParam) {
            $resolved = $this->resolveParamType($resolvedParam->param, $bindings, $operationId);
            $this->importParamType($namespace, $resolved);
            $phpParam = $method->addParameter($resolvedParam->phpName);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }

            if (!$required) {
                $phpParam->setNullable()->setDefaultValue(null);
            }
        }
    }

    /**
     * Resolve the PHP type for one parameter. Inline enum schemas
     * synthesise a backed enum named after the operation + parameter.
     */
    private function resolveParamType(Parameter $param, \Poagen\Generator\Generator\Bindings $bindings, string $operationId): TypeResolver
    {
        $schema = $param->schema instanceof Schema ? $param->schema : null;
        $synthFqcn = $this->synthesizeParamEnum($schema, $operationId, $param->name);

        if ($synthFqcn !== null) {
            return new TypeResolver($synthFqcn, null, null, false);
        }

        return TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace, $this->registry, $this->enums);
    }

    private function synthesizeParamEnum(?Schema $schema, string $operationId, string $paramName): ?string
    {
        if (!$schema instanceof Schema || !$this->enums instanceof \Poagen\Generator\Generator\Enum\EnumCatalog) {
            return null;
        }

        $synthName = \Poagen\Generator\Generator\Enum\EnumCatalog::pascalize($operationId) . \Poagen\Generator\Generator\Enum\EnumCatalog::pascalize($paramName);
        $spec = \Poagen\Generator\Generator\Enum\EnumCatalog::specFromSchema($synthName, $schema);

        if (!$spec instanceof \Poagen\Generator\Generator\Enum\EnumSpec) {
            return null;
        }

        $this->enums->synthesize($synthName, $spec);

        return $this->enums->synthesizedFqcn($synthName);
    }

    private function importParamType(PhpNamespace $namespace, TypeResolver $resolved): void
    {
        $type = $resolved->phpType;
        if ($type === null) {
            return;
        }
        // A composition resolver may hand us a `Foo|Bar` union — addUse
        // accepts one FQCN at a time, so split before importing.
        foreach (explode('|', $type) as $part) {
            $part = ltrim($part, '\\');
            if (!str_contains($part, '\\')) {
                continue;
            }
            $namespace->addUse($part);
        }
    }
}
