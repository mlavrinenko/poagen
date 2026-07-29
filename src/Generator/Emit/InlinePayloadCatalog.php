<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

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
 * @internal
 */
final readonly class InlinePayloadCatalog
{
    /**
     * @param array<string,BodySpec>   $bodies  keyed by raw operationId
     * @param array<string,ReturnSpec> $returns keyed by raw operationId
     * @param list<SynthesisedModel>   $roots   payload classes to emit, in document order
     */
    public function __construct(
        private array $bodies = [],
        private array $returns = [],
        private array $roots = [],
    ) {}

    public function bodyFor(string $rawOperationId): ?BodySpec
    {
        return $this->bodies[$rawOperationId] ?? null;
    }

    public function returnFor(string $rawOperationId): ?ReturnSpec
    {
        return $this->returns[$rawOperationId] ?? null;
    }

    /**
     * @return list<SynthesisedModel>
     */
    public function roots(): array
    {
        return $this->roots;
    }
}
