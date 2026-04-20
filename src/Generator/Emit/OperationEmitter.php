<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

/**
 * Emits one method on the ApiClient class for one OpenAPI operation.
 *
 * Scope:
 *   - parameters may be `path` (required), scalar/array `query`, or
 *     optional scalar `header`;
 *   - request body may be absent, `application/json` (`$ref`-to-Model or
 *     `list<$ref>`), `application/x-www-form-urlencoded` with declared
 *     properties, or an unsupported `multipart/form-data` /
 *     `application/octet-stream` body which is emitted as a throwing stub
 *     (T-011);
 *   - 2xx response body may be absent, `$ref`-to-Model, `list<$ref>`,
 *     a scalar, or an `additionalProperties` map.
 *
 * Anything else returns an {@see EmitOutcome::skipped()} carrying a
 * {@see SkippedOperation} so the user learns *which* endpoint did not
 * make it into the client (T-025).
 */
final readonly class OperationEmitter
{
    private RequestBodyParameterEmitter $bodyParamEmitter;
    private ParameterAdder $paramAdder;

    public function __construct(
        private string $modelNamespace,
        ?EnumCatalog $enums = null,
        private ?NameRegistry $registry = null,
        private ?NameRegistry $operationIdRegistry = null,
        private ?NameNormaliser $paramNormaliser = null,
        private RequestAssembler $requestAssembler = new RequestAssembler(),
        private ResponseHandler $responseHandler = new ResponseHandler(),
    ) {
        \assert($registry instanceof NameRegistry, 'NameRegistry is required (T-023).');
        \assert($operationIdRegistry instanceof NameRegistry, 'operationIdRegistry is required (T-025).');
        \assert($paramNormaliser instanceof NameNormaliser, 'paramNormaliser is required (T-025).');
        $this->bodyParamEmitter = new RequestBodyParameterEmitter($modelNamespace, $enums, $registry);
        $this->paramAdder = new ParameterAdder($modelNamespace, $enums, $registry);
    }

    public function emit(
        ClassType $class,
        PhpNamespace $namespace,
        string $httpMethod,
        string $pathUri,
        Operation $operation,
        Bindings $bindings,
        ?PathItem $pathItem = null,
        ?SecuritySchemeCatalog $securityCatalog = null,
    ): EmitOutcome {
        $rawOperationId = (string) ($operation->operationId ?? '');

        if ($rawOperationId === '') {
            return EmitOutcome::skipped(new SkippedOperation(
                $httpMethod,
                $pathUri,
                $rawOperationId,
                SkippedOperation::REASON_MISSING_OPERATION_ID,
            ));
        }

        \assert($this->operationIdRegistry instanceof NameRegistry);
        $operationId = $this->operationIdRegistry->resolve(
            $rawOperationId,
            new NormalisationContext(SymbolKind::OperationId),
        );

        $rawPathParams = OperationAnalyzer::pathParameters($operation, $pathItem);

        if ($rawPathParams === null) {
            return EmitOutcome::skipped(new SkippedOperation(
                $httpMethod,
                $pathUri,
                $rawOperationId,
                SkippedOperation::REASON_UNRESOLVABLE_PARAMETER,
            ));
        }

        \assert($this->registry instanceof NameRegistry);
        $body = OperationAnalyzer::requestBody($operation->requestBody, $this->registry);

        if ($operation->requestBody !== null && !$body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            return EmitOutcome::skipped(new SkippedOperation(
                $httpMethod,
                $pathUri,
                $rawOperationId,
                SkippedOperation::REASON_UNSUPPORTED_BODY,
            ));
        }

        // Per-op registry: parameter-name uniqueness only matters within
        // a single PHP method signature, so each emit call gets a fresh
        // scope rather than aliasing across ops.
        \assert($this->paramNormaliser instanceof NameNormaliser);
        $paramRegistry = new NameRegistry($this->paramNormaliser);

        $pathParams = $this->resolveParameters($rawPathParams, $paramRegistry);
        $queryParams = $this->resolveParameters(OperationAnalyzer::queryParameters($operation, $pathItem), $paramRegistry);
        $headerParams = $this->resolveParameters(OperationAnalyzer::headerParameters($operation, $pathItem), $paramRegistry);
        $requiredQuery = array_values(array_filter($queryParams, static fn(ResolvedParameter $p): bool => $p->param->required));
        $optionalQuery = array_values(array_filter($queryParams, static fn(ResolvedParameter $p): bool => !$p->param->required));

        $return = OperationAnalyzer::returnType($operation->responses, $this->registry);

        $method = $class->addMethod($operationId)->setPublic();

        $this->paramAdder->addPath($method, $namespace, $pathParams, $bindings, $rawOperationId);
        $this->paramAdder->addQuery($method, $namespace, $requiredQuery, $bindings, required: true, operationId: $rawOperationId);

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec) {
            $this->bodyParamEmitter->addBodyParams($method, $namespace, $body, $bindings);
        }

        $this->paramAdder->addQuery($method, $namespace, $optionalQuery, $bindings, required: false, operationId: $rawOperationId);
        $this->paramAdder->addHeader($method, $namespace, $headerParams, $bindings, $rawOperationId);

        if ($body instanceof \Mlavrinenko\Paogen\Generator\Emit\BodySpec && $body->kind === BodySpec::KIND_UNSUPPORTED) {
            $this->bodyParamEmitter->emitUnsupportedStub($method, $body, $rawOperationId);

            return EmitOutcome::emitted();
        }

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

        return EmitOutcome::emitted();
    }

    /**
     * @param  list<Parameter>         $params
     * @return list<ResolvedParameter>
     */
    private function resolveParameters(array $params, NameRegistry $paramRegistry): array
    {
        $context = new NormalisationContext(SymbolKind::ParameterName);
        $out = [];

        foreach ($params as $param) {
            $out[] = new ResolvedParameter($param, $paramRegistry->resolve($param->name, $context));
        }

        return $out;
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
