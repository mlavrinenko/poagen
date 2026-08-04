<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

/**
 * Result of a single {@see ModelEmitter::emit()} call: the rendered PHP
 * source plus the list of inline-object schemas that were promoted to
 * named classes and still need to be emitted (T-013).
 */
final readonly class ModelEmission
{
    /**
     * @param list<SynthesisedModel> $children
     */
    public function __construct(
        public string $source,
        public array $children,
    ) {}
}
