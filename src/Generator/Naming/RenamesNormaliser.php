<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

use Mlavrinenko\Paogen\Exception\InvalidProfileException;

/**
 * Looks up the raw name in a static map. Returns the mapped value if
 * present, null otherwise. Validates each mapped value against the
 * PHP-identifier grammar at construction so a typo is caught up front
 * rather than at code-emission.
 */
final readonly class RenamesNormaliser implements NameNormaliser
{
    private const string IDENTIFIER = '/^[A-Za-z_]\w*$/';

    /**
     * @param array<string,string> $map raw name → desired PHP identifier
     */
    public function __construct(
        private array $map,
        private ?string $pattern = null,
    ) {
        foreach ($map as $raw => $php) {
            if (preg_match(self::IDENTIFIER, $php) !== 1) {
                throw new InvalidProfileException(\sprintf(
                    "Profile renames map: '%s' is not a valid PHP identifier (mapped from '%s').",
                    $php,
                    $raw,
                ));
            }
        }
    }

    public function normalise(string $raw, NormalisationContext $context): ?string
    {
        if ($this->pattern !== null && preg_match($this->pattern, $raw) !== 1) {
            return null;
        }

        return $this->map[$raw] ?? null;
    }
}
