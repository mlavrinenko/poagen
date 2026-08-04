<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Poagen\Generator\Generator\GenerationPlan;

/**
 * A top-level `components.schemas` entry the generator could not materialise,
 * or one whose property-level `oneOf`/`anyOf` union has no discriminator.
 *
 * Drained from planning into {@see GenerationPlan}.
 * `$reason` is a complete diagnostic — construct, location, and remedy — so
 * it can be printed or aggregated as-is (abort-on-unrepresentable-constructs).
 */
final readonly class SkippedComponent
{
    public function __construct(
        public string $rawName,
        public string $reason,
    ) {}
}
