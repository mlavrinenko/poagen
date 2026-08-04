<?php

declare(strict_types=1);

namespace Poagen\Generator\Exception;

use RuntimeException;

use function sprintf;

/**
 * Thrown when the configured `NameNormaliser` pipeline cannot map a
 * raw OpenAPI symbol name to a PHP identifier. See
 * `typed-profile-and-colocated-attributes` (T-023).
 */
final class NameNormalisationException extends RuntimeException
{
    public static function unhandled(
        string $raw,
        \Poagen\Generator\Generator\Naming\NormalisationContext $context,
        int $strategyCount,
    ): self {
        return new self(sprintf(
            "No `nameNormaliser` strategy claimed component name '%s' (kind: %s, %d strateg%s tried). "
            . 'Add the name to `Profile::$renames`, or extend `Profile::$nameNormaliser` to handle it.',
            $raw,
            $context->kind->name,
            $strategyCount,
            $strategyCount === 1 ? 'y' : 'ies',
        ));
    }

    public static function collision(string $php, string $existingRaw, string $newRaw): self
    {
        return new self(sprintf(
            "Name collision: components '%s' and '%s' both normalise to PHP class '%s'. "
            . 'Disambiguate via `Profile::$renames`.',
            $existingRaw,
            $newRaw,
            $php,
        ));
    }
}
