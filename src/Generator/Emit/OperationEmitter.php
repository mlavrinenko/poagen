<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\RequestBody;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameNormaliser;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\Naming\NormalisationContext;
use Poagen\Generator\Generator\Naming\SymbolKind;
use Poagen\Runtime\Contract\Envelope;

use function assert;
use function is_string;

/**
 * Emits one method on the ApiClient class for one OpenAPI operation.
 *
 * Scope:
 *   - parameters may be `path` (required), scalar/array `query`, or optional scalar `header`;
 *   - request body may be absent, `application/json` (`$ref`-to-Model or
 *     `list<$ref>`), or `application/x-www-form-urlencoded` with declared
 *     properties;
 *   - every declared response's body may be absent, `$ref`-to-Model,
 *     `list<$ref>`, a scalar, a map, or a `oneOf`/`anyOf` union — the status
 *     no longer picks one response to type; every one of them does
 *     (`typed-error-responses`).
 *
 * Anything else — including `multipart/form-data` and
 * `application/octet-stream` bodies, which used to be emitted as a
 * throwing stub, and a response declaring a content type other than
 * `application/json` (or a JSON shape this emitter does not represent) —
 * returns an {@see EmitOutcome::skipped()} carrying a
 * {@see SkippedOperation} with a full construct/location/remedy diagnostic,
 * so the caller can report *which* endpoint did not make it into the
 * client and *why* instead of emitting a method that only fails, or
 * degrades, at call time (T-025, abort-on-unrepresentable-constructs,
 * default-deny-on-degradation). A single status whose shape cannot be
 * represented skips the whole operation now, naming that status, rather
 * than dropping just that branch quietly.
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
        private EnvelopeTypeEmitter $envelopeTypes = new EnvelopeTypeEmitter(),
        private InlinePayloadCatalog $inlinePayloads = new InlinePayloadCatalog(),
        private array $preScannedSkips = [],
        private SharedResponseMapPlan $sharedResponseMaps = new SharedResponseMapPlan(),
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
                $this->inlinePayloads->requestRefusalFor($rawOperationId)
                    ?? $this->describeUnsupportedBody($operation->requestBody),
            ));
        }

        // Per-op registry: parameter-name uniqueness only matters within
        // a single PHP method signature, so each emit call gets a fresh
        // scope rather than aliasing across ops.
        assert($this->paramNormaliser instanceof NameNormaliser);
        $paramRegistry = new NameRegistry($this->paramNormaliser);

        $pathParams = ResolvedParameter::resolveAll($rawPathParams, $paramRegistry);
        $queryParams = ResolvedParameter::resolveAll(OperationAnalyzer::queryParameters($operation, $pathItem), $paramRegistry);
        $headerParams = ResolvedParameter::resolveAll(OperationAnalyzer::headerParameters($operation, $pathItem), $paramRegistry);
        $requiredQuery = array_values(array_filter($queryParams, static fn(ResolvedParameter $p): bool => $p->param->required));
        $optionalQuery = array_values(array_filter($queryParams, static fn(ResolvedParameter $p): bool => !$p->param->required));
        $requiredHeader = array_values(array_filter($headerParams, static fn(ResolvedParameter $p): bool => $p->param->required));
        $optionalHeader = array_values(array_filter($headerParams, static fn(ResolvedParameter $p): bool => !$p->param->required));

        $envelope = $this->inlinePayloads->envelopeFor($rawOperationId);

        if (!$envelope instanceof EnvelopeSpec) {
            return EmitOutcome::skipped(new SkippedOperation(
                $httpMethod,
                $pathUri,
                $rawOperationId,
                $this->inlinePayloads->responseRefusalFor($rawOperationId)
                    ?? "this operation's responses could not be resolved to an envelope — this should not happen",
            ));
        }

        $method = $class->addMethod($operationId)->setPublic();

        // First, ahead of every `@param` and the `@return`: the scopes this
        // operation's own requirement asks for are prose about the call, not
        // an annotation on one of its arguments. Added after any of them and
        // it lands *between* tags, where a doc parser reads it as the tail of
        // the preceding `@param` description rather than as its own sentence.
        SecurityDocs::addOperationComment($method, $securityCatalog, $operation);

        // Required first — path, query, header — so a required header lands
        // ahead of the optional query/header blocks below it, the same
        // requiredness ordering the query split already keeps.
        $this->paramAdder->addPath($method, $namespace, $pathParams, $bindings, $rawOperationId);
        $this->paramAdder->addQuery($method, $namespace, $requiredQuery, $bindings, required: true, operationId: $rawOperationId);
        $this->paramAdder->addHeader($method, $namespace, $requiredHeader, $bindings, $rawOperationId, required: true);

        if ($body instanceof BodySpec) {
            $this->bodyParamEmitter->addBodyParams($method, $namespace, $body, $bindings);
        }

        $this->paramAdder->addQuery($method, $namespace, $optionalQuery, $bindings, required: false, operationId: $rawOperationId);
        $this->paramAdder->addHeader($method, $namespace, $optionalHeader, $bindings, $rawOperationId);

        $envelopeDoc = DocTypeSimplifier::shorten($namespace, $this->envelopeTypes->docType($envelope, $this->modelNamespace));
        $this->applyReturnType($method, $namespace, $envelopeDoc);

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
        // A group the consumer declared replaces this operation's own map
        // literal with a call to the one shared declaration; every operation
        // no group named emits the literal exactly as it always has.
        $responseType = $this->sharedResponseMaps->expressionFor($namespace, $rawOperationId)
            ?? $this->envelopeTypes->expr($namespace, $envelope, $this->modelNamespace);
        $method->setBody($this->callBody($segments, $responseType, $envelopeDoc));

        return EmitOutcome::emitted();
    }

    /**
     * The whole emitted body: one call describing the request and naming the
     * response shape.
     *
     * The chain stays on one line while it reads as one — past that, one
     * segment per line, so an operation with many parameters is still read
     * top to bottom rather than scrolled sideways. Every operation routes
     * through the `@var`-annotated intermediate variable now — `send()`'s
     * own generic return is the bare {@see Envelope}, and PHP has no native
     * generics to spell `Envelope<Pet>` as the declared return type itself
     * (`typed-error-responses`, the same reason a top-level union always
     * needed one).
     *
     * @param list<string> $segments
     */
    private function callBody(array $segments, string $responseType, string $varType): string
    {
        $oneLine = implode('', $segments);
        $chain = strlen($oneLine) <= self::CHAIN_WIDTH
            ? $oneLine
            : implode("\n        ", $segments);

        $call = "\$this->transport->send(\n    " . $chain . ",\n    " . $responseType . ",\n)";

        return "/** @var {$varType} \$result */\n\$result = {$call};\n\nreturn \$result;";
    }

    private function describeUnsupportedBody(RequestBody|Reference $body): string
    {
        $resolved = RequestBodyAnalyzer::resolveBody($body);

        return $resolved instanceof RequestBody
            ? RequestBodyAnalyzer::describeUnsupported($resolved)
            : 'request body $ref does not resolve to a component requestBody — fix the $ref or inline the body';
    }

    /**
     * Every operation returns the bare {@see Envelope} natively — nothing
     * about the shape a status hydrates into changes what class the method
     * is declared to return — with `$envelopeDoc` (already shortened for
     * this namespace) narrowing it to `Envelope<...>` in the `@return` tag,
     * the same way a `list<Pet>` return already rides a doc tag over a bare
     * `array` native type.
     */
    private function applyReturnType(Method $method, PhpNamespace $namespace, string $envelopeDoc): void
    {
        $namespace->addUse(Envelope::class);
        $method->setReturnType('\\' . Envelope::class);
        $method->addComment('@return ' . $envelopeDoc);
    }
}
