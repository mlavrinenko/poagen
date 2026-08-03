<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\Generator;

/**
 * What {@see InlinePayloadPlanner} decided about the operations whose payloads
 * the document declared inline rather than naming.
 *
 * One object serves both halves of the run, and that is the whole reason it
 * exists. The model planner needs the classes so it can emit them; the
 * operation emitter needs the same names so its parameters and return types
 * point at them. Deriving each independently would let the two drift into a
 * client that references models nobody emitted.
 *
 * Only inline payloads appear here. A `$ref` body or response is still read by
 * {@see RequestBodyAnalyzer} and {@see OperationAnalyzer}, so the two paths are
 * disjoint and the caller can consult this one first without ambiguity.
 *
 * An operation the document-wide schema scan already refused has no entry
 * here at all — {@see InlinePayloadPlanner::build()} never queries it, so its
 * absence is indistinguishable from an operation that declared no inline
 * payload in the first place (skipped-operation-still-emits-its-payload-model).
 *
 * @internal
 */
final readonly class InlinePayloadCatalog
{
    /**
     * @param array<string,BodySpec>   $bodies           keyed by raw operationId
     * @param array<string,ReturnSpec> $returns          keyed by raw operationId
     * @param list<SynthesisedModel>   $roots            payload classes to emit, in document order
     * @param array<string,string>     $requestRefusals  keyed by raw operationId — the specific reason
     *                                                    an `allOf`/`anyOf` merge in the request body could
     *                                                    not resolve, preferred over
     *                                                    {@see RequestBodyAnalyzer}'s generic diagnosis, which
     *                                                    never attempted the merge and so cannot name it
     * @param array<string,string>     $responseRefusals keyed by raw operationId, mirrors $requestRefusals
     *                                                    for the response side
     * @param UnionCatalog              $responseUnions   how every response-position union resolved —
     *                                                    {@see Generator}
     *                                                    merges this into the property-position catalog
     *                                                    {@see DiscriminatorEnforcer}
     *                                                    built, so `Profile::$unionTags`/`$unionPins`
     *                                                    staleness and the per-run notice both cover
     *                                                    both positions from one object
     */
    public function __construct(
        private array $bodies = [],
        private array $returns = [],
        private array $roots = [],
        private array $requestRefusals = [],
        private array $responseRefusals = [],
        private UnionCatalog $responseUnions = new UnionCatalog(),
    ) {}

    public function bodyFor(string $rawOperationId): ?BodySpec
    {
        return $this->bodies[$rawOperationId] ?? null;
    }

    public function returnFor(string $rawOperationId): ?ReturnSpec
    {
        return $this->returns[$rawOperationId] ?? null;
    }

    public function requestRefusalFor(string $rawOperationId): ?string
    {
        return $this->requestRefusals[$rawOperationId] ?? null;
    }

    public function responseRefusalFor(string $rawOperationId): ?string
    {
        return $this->responseRefusals[$rawOperationId] ?? null;
    }

    /**
     * @return list<SynthesisedModel>
     */
    public function roots(): array
    {
        return $this->roots;
    }

    public function responseUnions(): UnionCatalog
    {
        return $this->responseUnions;
    }
}
