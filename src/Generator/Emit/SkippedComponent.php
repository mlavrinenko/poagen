<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

/**
 * A top-level `components.schemas` entry the generator could not materialise.
 *
 * Drained from the planner into {@see \Mlavrinenko\Paogen\Generator\GenerationPlan}
 * so the CLI prints a diagnostic instead of silently losing the component
 * (mirrors the T-025 `SkippedOperation` pattern).
 */
final readonly class SkippedComponent
{
    public const string REASON_UNKNOWN_SHAPE = 'unknown_shape';

    public function __construct(
        public string $rawName,
        public string $reason,
    ) {}
}
