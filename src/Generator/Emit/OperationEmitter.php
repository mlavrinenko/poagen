<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
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
    ): bool {
        $operationId = (string) ($operation->operationId ?? '');

        if ($operationId === '') {
            return false;
        }

        $pathParams = OperationAnalyzer::pathParameters($operation);

        if ($pathParams === null) {
            return false;
        }

        $body = OperationAnalyzer::requestBody($operation->requestBody);

        if ($operation->requestBody !== null && !$body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            return false;
        }

        $queryParams = OperationAnalyzer::queryParameters($operation);
        $headerParams = OperationAnalyzer::headerParameters($operation);
        $requiredQuery = array_values(array_filter($queryParams, static fn(Parameter $p): bool => $p->required));
        $optionalQuery = array_values(array_filter($queryParams, static fn(Parameter $p): bool => !$p->required));

        $return = OperationAnalyzer::returnType($operation->responses);

        $method = $class->addMethod($operationId)->setPublic();

        $this->addPathParams($method, $pathParams, $bindings);
        $this->addQueryParams($method, $requiredQuery, $bindings, required: true);

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            $this->addBodyParam($method, $namespace, $body);
        }

        $this->addQueryParams($method, $optionalQuery, $bindings, required: false);
        $this->addHeaderParams($method, $headerParams, $bindings);

        $this->applyReturnType($method, $namespace, $return);
        $this->requestAssembler->emitRequest(
            $method,
            $httpMethod,
            $pathUri,
            $pathParams,
            $queryParams,
            $headerParams,
            $body,
        );
        $this->responseHandler->emit($method, $return);

        return true;
    }

    /**
     * @param list<Parameter> $params
     */
    private function addPathParams(Method $method, array $params, Bindings $bindings): void
    {
        foreach ($params as $param) {
            $resolved = TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }
        }
    }

    /**
     * @param list<Parameter> $params
     */
    private function addQueryParams(Method $method, array $params, Bindings $bindings, bool $required): void
    {
        foreach ($params as $param) {
            $resolved = TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace);
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
    private function addHeaderParams(Method $method, array $params, Bindings $bindings): void
    {
        foreach ($params as $param) {
            $resolved = TypeResolver::resolve($param->schema ?? new Schema([]), $bindings, $this->modelNamespace);
            $phpParam = $method->addParameter($param->name);

            if ($resolved->phpType !== null) {
                $phpParam->setType($resolved->phpType);
            }

            $phpParam->setNullable()->setDefaultValue(null);
        }
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
