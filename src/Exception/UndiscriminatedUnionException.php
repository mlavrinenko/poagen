<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Exception;

use RuntimeException;

use function sprintf;

/**
 * Thrown when a property-level `oneOf` / `anyOf` ref union has no
 * `discriminator` in the schema and no `Profile::$discriminators`
 * override resolves one. Silent structural matching is ADR-010-banned
 * (see T-030): a generator-time error is strictly louder and safer
 * than a runtime branch guess.
 */
final class UndiscriminatedUnionException extends RuntimeException
{
    public static function forProperty(string $componentName, string $propertyName): self
    {
        return new self(sprintf(
            "Component '%s' property '%s' uses `oneOf`/`anyOf` without `discriminator`; "
            . 'paogen refuses structural branch matching (ADR-010). '
            . 'Either add `discriminator.propertyName` in the schema, or set '
            . "`Profile::\$discriminators['%s.%s' => '<wireField>']`.",
            $componentName,
            $propertyName,
            $componentName,
            $propertyName,
        ));
    }
}
