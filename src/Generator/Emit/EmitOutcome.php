<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

/**
 * The outcome of {@see OperationEmitter::emit()}: either the operation
 * was emitted (its method now exists on the ApiClient class) or it was
 * skipped, and {@see $skip} carries the diagnostic for the caller's
 * log.
 *
 * @internal
 */
final readonly class EmitOutcome
{
    private function __construct(
        public bool $wasEmitted,
        public ?SkippedOperation $skip,
    ) {}

    public static function emitted(): self
    {
        return new self(true, null);
    }

    public static function skipped(SkippedOperation $skip): self
    {
        return new self(false, $skip);
    }
}
