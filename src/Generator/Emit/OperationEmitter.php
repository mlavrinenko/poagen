<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

use function assert;
use function is_string;

/**
 * Emits one method on the ApiClient class for one OpenAPI operation.
 *
 * Scope:
 *   - parameters may be `path` (required), scalar/array `query`, or
 *     optional scalar `header`;
 *   - request body may be absent, `application/json` (`$ref`-to-Model or
 *     `list<$ref>`), or `application/x-www-form-urlencoded` with declared
 *     properties;
 *   - 2xx response body may be absent, `$ref`-to-Model, `list<$ref>`,
 *     a scalar, or an `additionalProperties` map.
 *
 * Anything else — including `multipart/form-data` and
 * `application/octet-stream` bodies, which used to be emitted as a
 * throwing stub — returns an {@see EmitOutcome::skipped()} carrying a
 * {@see SkippedOperation} with a full construct/location/remedy diagnostic,
 * so the caller can report *which* endpoint did not make it into the
 * client and *why* instead of emitting a method that only fails at call
 * time (T-025, abort-on-unrepresentable-constructs).
 */
final readonly class OperationEmitter
{
    /** Width past which the endpoint chain is broken one segment per line. */
    private const int CHAIN_WIDTH = 84;

    private RequestBodyParameterEmitter $bodyParamEmitter;
    private ParameterAdder $paramAdder;

    private EndpointChainEmitter $endpoints;

    /**
     * @param array<string,string> $preScannedSkips raw operationId → reason, from a pass that ran
     *                                              over the whole document before emission
     */
    public function __construct(
        private string $modelNamespace,
        ?EnumCatalog $enums = null,
        private ?NameRegistry $registry = null,
        private ?NameRegistry $operationIdRegistry = null,
        private ?NameNormaliser $paramNormaliser = null,
        ?ComponentCatalog $components = null,
        private ResponseTypeEmitter $responseTypes = new ResponseTypeEmitter(),
        private InlinePayloadCatalog $inlinePayloads = new InlinePayloadCatalog(),
        private array $preScannedSkips = [],
    ) {
        assert($registry instanceof NameRegistry, 'NameRegistry is required (T-023).');
        assert($operationIdRegistry instanceof NameRegistry, 'operationIdRegistry is required (T-025).');
        assert($paramNormaliser instanceof NameNormaliser, 'paramNormaliser is required (T-025).');
        $this->bodyParamEmitter = new RequestBodyParameterEmitter($modelNamespace, $enums, $registry);
        $this->paramAdder = new ParameterAdder($modelNamespace, $enums, $registry);
        $this->endpoints = new EndpointChainEmitter($modelNamespace, $enums, $registry, $components);
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

        // A refusal found by a document-wide pass before emission started —
        // reported once here rather than emitted and reported both.
        $preScanned = $this->preScannedSkips[$rawOperationId] ?? null;

        if (is_string($preScanned)) {
            return EmitOutcome::skipped(new SkippedOperation($httpMethod, $pathUri, $rawOperationId, $preScanned));
        }

        assert($this->operationIdRegistry instanceof NameRegistry);
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
                OperationAnalyzer::describeUnresolvableParameter($operation, $pathItem),
            ));
        }

        assert($this->registry instanceof NameRegistry);
        // The catalog holds only inline payloads and the analyser holds only
        // `$ref` ones, so the two are disjoint and order expresses no
        // preference — it just avoids asking the analyser about a body it was
        // never going to resolve.
        $body = $this->inlinePayloads->bodyFor($rawOperationId)
            ?? OperationAnalyzer::requestBody($operation->requestBody, $this->registry);

        if ($operation->requestBody !== null && !$body instanceof BodySpec) {
            return EmitOutcome::skipped(new SkippedOperation(
                $httpMethod,
                $pathUri,
                $rawOperationId,
                $this->describeUnsupportedBody($operation->requestBody),
            ));
        }

        // Per-op registry: parameter-name uniqueness only matters within
        // a single PHP method signature, so each emit call gets a fresh
        // scope rather than aliasing across ops.
        assert($this->paramNormaliser instanceof NameNormaliser);
        $paramRegistry = new NameRegistry($this->paramNormaliser);

        $pathParams = $this->resolveParameters($rawPathParams, $paramRegistry);
        $queryParams = $this->resolveParameters(OperationAnalyzer::queryParameters($operation, $pathItem), $paramRegistry);
        $headerParams = $this->resolveParameters(OperationAnalyzer::headerParameters($operation, $pathItem), $paramRegistry);
        $requiredQuery = array_values(array_filter($queryParams, static fn(ResolvedParameter $p): bool => $p->param->required));
        $optionalQuery = array_values(array_filter($queryParams, static fn(ResolvedParameter $p): bool => !$p->param->required));

        $return = $this->inlinePayloads->returnFor($rawOperationId)
            ?? OperationAnalyzer::returnType($operation->responses, $this->registry);

        $method = $class->addMethod($operationId)->setPublic();

        $this->paramAdder->addPath($method, $namespace, $pathParams, $bindings, $rawOperationId);
        $this->paramAdder->addQuery($method, $namespace, $requiredQuery, $bindings, required: true, operationId: $rawOperationId);

        if ($body instanceof BodySpec) {
            $this->bodyParamEmitter->addBodyParams($method, $namespace, $body, $bindings);
        }

        $this->paramAdder->addQuery($method, $namespace, $optionalQuery, $bindings, required: false, operationId: $rawOperationId);
        $this->paramAdder->addHeader($method, $namespace, $headerParams, $bindings, $rawOperationId);

        $this->applyReturnType($method, $namespace, $return);

        $activeSchemes = $securityCatalog instanceof SecuritySchemeCatalog
            ? $securityCatalog->activeSchemesFor($operation)
            : [];

        $segments = $this->endpoints->segments(
            $namespace,
            $httpMethod,
            $pathUri,
            $pathParams,
            $queryParams,
            $headerParams,
            $body,
            $bindings,
            $activeSchemes,
        );
        $method->setBody($this->callBody(
            $segments,
            $this->responseTypes->expr($namespace, $return, $this->modelNamespace),
            $return->kind === ReturnSpec::KIND_VOID,
        ));

        return EmitOutcome::emitted();
    }

    /**
     * The whole emitted body: one call describing the request and naming the
     * response shape.
     *
     * The chain stays on one line while it reads as one — past that, one
     * segment per line, so an operation with many parameters is still read
     * top to bottom rather than scrolled sideways. A `void` operation drops
     * the `return` and nothing else.
     *
     * @param list<string> $segments
     */
    private function callBody(array $segments, string $responseType, bool $isVoid): string
    {
        $oneLine = implode('', $segments);
        $chain = strlen($oneLine) <= self::CHAIN_WIDTH
            ? $oneLine
            : implode("\n        ", $segments);

        return ($isVoid ? '' : 'return ')
            . "\$this->transport->send(\n    "
            . $chain
            . ",\n    "
            . $responseType
            . ",\n);";
    }

    private function describeUnsupportedBody(RequestBody|Reference $body): string
    {
        $resolved = RequestBodyAnalyzer::resolveBody($body);

        return $resolved instanceof RequestBody
            ? RequestBodyAnalyzer::describeUnsupported($resolved)
            : 'request body $ref does not resolve to a component requestBody — fix the $ref or inline the body';
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
                $method->addComment('@return ' . DocTypeSimplifier::shorten($namespace, 'array<string, ' . $return->mapValuePhpType . '>'));

                return;
        }

        $fqcn = '\\' . trim($this->modelNamespace, '\\') . '\\' . $return->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        if ($return->kind === ReturnSpec::KIND_LIST) {
            $method->setReturnType('array');
            $method->addComment('@return ' . DocTypeSimplifier::shorten($namespace, 'list<' . $fqcn . '>'));

            return;
        }

        $method->setReturnType($fqcn);
    }
}
