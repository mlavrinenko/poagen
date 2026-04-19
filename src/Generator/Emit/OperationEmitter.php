<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

/**
 * Emits one method on the ApiClient class for one OpenAPI operation.
 *
 * Scope:
 *   - parameters may be `path` (required), scalar/array `query`, or
 *     optional scalar `header`;
 *   - request body may be absent or `application/json` whose schema is
 *     either `$ref`-to-Model or `list<$ref>`;
 *   - 2xx response body may be absent, `$ref`-to-Model, `list<$ref>`,
 *     a scalar, or an `additionalProperties` map.
 *
 * Anything else is skipped: the op is simply not emitted.
 */
final readonly class OperationEmitter
{
    public function __construct(
        private string $modelNamespace,
        private ?EnumCatalog $enums = null,
        private RequestAssembler $requestAssembler = new RequestAssembler(),
        private ResponseHandler $responseHandler = new ResponseHandler(),
    ) {}

    public function emit(
        ClassType $class,
        PhpNamespace $namespace,
        string $httpMethod,
        string $pathUri,
        Operation $operation,
        Bindings $bindings,
        ?PathItem $pathItem = null,
        ?SecuritySchemeCatalog $securityCatalog = null,
    ): bool {
        $operationId = (string) ($operation->operationId ?? '');

        if ($operationId === '') {
            return false;
        }

        $pathParams = OperationAnalyzer::pathParameters($operation, $pathItem);

        if ($pathParams === null) {
            return false;
        }

        $body = OperationAnalyzer::requestBody($operation->requestBody);

        if ($operation->requestBody !== null && !$body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            return false;
        }

        $queryParams = OperationAnalyzer::queryParameters($operation, $pathItem);
        $headerParams = OperationAnalyzer::headerParameters($operation, $pathItem);
        $requiredQuery = array_values(array_filter($queryParams, static fn(Parameter $p): bool => $p->required));
        $optionalQuery = array_values(array_filter($queryParams, static fn(Parameter $p): bool => !$p->required));

        $return = OperationAnalyzer::returnType($operation->responses);

        $method = $class->addMethod($operationId)->setPublic();

        $this->addPathParams($method, $namespace, $pathParams, $bindings, $operationId);
        $this->addQueryParams($method, $namespace, $requiredQuery, $bindings, required: true, operationId: $operationId);

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            $this->addBodyParam($method, $namespace, $body);
        }

        $this->addQueryParams($method, $namespace, $optionalQuery, $bindings, required: false, operationId: $operationId);
        $this->addHeaderParams($method, $namespace, $headerParams, $bindings, $operationId);

        $this->applyReturnType($method, $namespace, $return);

        $activeSchemes = $securityCatalog instanceof SecuritySchemeCatalog
            ? $securityCatalog->activeSchemesFor($operation)
            : [];

        $this->requestAssembler->emitRequest(
            $method,
            $httpMethod,
            $pathUri,
            $pathParams,
            $queryParams,
            $headerParams,
            $body,
            $bindings,
            $activeSchemes,
        );
        $this->responseHandler->emit($method, $return);

        return true;
    }

    /**
     * @param list<Parameter> $params
     */
    private function addPathParams(Method $method, PhpNamespace $namespace, array $params, Bindings $bindings, string $operationId): void
    {
        foreach ($params as $param) {
            $resolved = $this->resolveParamType($param, $bindings, $operationId);
            $this->importParamType($namespace, $resolved);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }
        }
    }

    /**
     * @param list<Parameter> $params
     */
    private function addQueryParams(Method $method, PhpNamespace $namespace, array $params, Bindings $bindings, bool $required, string $operationId): void
    {
        foreach ($params as $param) {
            $resolved = $this->resolveParamType($param, $bindings, $operationId);
            $this->importParamType($namespace, $resolved);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }

            if ($resolved->phpDoc !== null) {
                $method->addComment('@param ' . $resolved->phpDoc . ' $' . $param->name);
            }

            if (!$required) {
                $phpParam->setNullable()->setDefaultValue(null);
            }
        }
    }

    /**
     * @param list<Parameter> $params
     */
    private function addHeaderParams(Method $method, PhpNamespace $namespace, array $params, Bindings $bindings, string $operationId): void
    {
        foreach ($params as $param) {
            $resolved = $this->resolveParamType($param, $bindings, $operationId);
            $this->importParamType($namespace, $resolved);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }

            $phpParam->setNullable()->setDefaultValue(null);
        }
    }

    private function importParamType(PhpNamespace $namespace, TypeResolver $resolved): void
    {
        $type = $resolved->phpType;
        if ($type === null || !str_contains($type, '\\')) {
            return;
        }
        $namespace->addUse(ltrim($type, '\\'));
    }

    /**
     * Resolve the PHP type for one parameter. If the parameter's schema is
     * an inline enum, synthesise a backed enum named after the operation +
     * parameter and use its FQCN as the type.
     */
    private function resolveParamType(Parameter $param, Bindings $bindings, string $operationId): TypeResolver
    {
        $schema = $param->schema instanceof Schema ? $param->schema : null;
        $synthFqcn = $this->synthesizeParamEnum($schema, $operationId, $param->name);

        if ($synthFqcn !== null) {
            return new TypeResolver($synthFqcn, null, null, false);
        }

        return TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace, $this->enums);
    }

    private function synthesizeParamEnum(?Schema $schema, string $operationId, string $paramName): ?string
    {
        if (!$schema instanceof \cebe\openapi\spec\Schema || !$this->enums instanceof \Mlavrinenko\Paogen\Generator\Enum\EnumCatalog) {
            return null;
        }

        $synthName = EnumCatalog::pascalize($operationId) . EnumCatalog::pascalize($paramName);
        $spec = EnumCatalog::specFromSchema($synthName, $schema);

        if (!$spec instanceof \Mlavrinenko\Paogen\Generator\Enum\EnumSpec) {
            return null;
        }

        $this->enums->synthesize($synthName, $spec);

        return $this->enums->synthesizedFqcn($synthName);
    }

    private function addBodyParam(Method $method, PhpNamespace $namespace, BodySpec $body): void
    {
        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $body->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        $phpParam = $method->addParameter('body');

        if ($body->isList) {
            $phpParam->setType('array');
            $method->addComment('@param list<' . $fqcn . '> $body');

            return;
        }

        $phpParam->setType($fqcn);
    }

    private function applyReturnType(Method $method, PhpNamespace $namespace, ReturnSpec $return): void
    {
        switch ($return->kind) {
            case ReturnSpec::KIND_VOID:
                $method->setReturnType('void');

                return;

            case ReturnSpec::KIND_SCALAR:
                $method->setReturnType((string) $return->scalarPhpType);

                return;

            case ReturnSpec::KIND_MAP:
                $method->setReturnType('array');
                $method->addComment('@return array<string, ' . $return->mapValuePhpType . '>');

                return;
        }

        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $return->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        if ($return->kind === ReturnSpec::KIND_LIST) {
            $method->setReturnType('array');
            $method->addComment('@return list<' . $fqcn . '>');

            return;
        }

        $method->setReturnType($fqcn);
    }
}
