<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

/**
 * Result of a single {@see ModelEmitter::emit()} call: the rendered PHP
 * source, the list of inline-object schemas that were promoted to named
 * classes and still need to be emitted (T-013), and any profile guidance the
 * model could not honour.
 *
 * The source is returned alongside the failures rather than instead of them
 * because emission is a plan, not a write: {@see Generator::plan()} collects
 * every failure across the whole run and refuses once, and nothing reaches
 * disk until it has (abort-on-unrepresentable-constructs).
 */
final readonly class ModelEmission
{
    /**
     * @param list<SynthesisedModel> $children
     * @param list<string>           $failures
     */
    public function __construct(
        public string $source,
        public array $children,
        public array $failures = [],
    ) {}
}
