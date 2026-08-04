<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Naming;

use Poagen\Generator\Exception\InvalidProfileException;

use function sprintf;

/**
 * Looks up the raw name in a static map. Returns the mapped value if
 * present, null otherwise. Validates each mapped value against the
 * PHP-identifier grammar at construction so a typo is caught up front
 * rather than at code-emission.
 *
 * Scoped to one {@see SymbolKind} when `$kind` is set, which is how the
 * default pipeline keeps the profile's several rename maps from bleeding into
 * each other. Unscoped it applies to every kind, so a component rename would
 * also silently rename an operation that happened to share its raw name — the
 * kind of coincidence nobody notices until the emitted method moves.
 */
final readonly class RenamesNormaliser implements NameNormaliser
{
    private const string IDENTIFIER = '/^[A-Za-z_]\w*$/';

    /**
     * @param array<string,string> $map   raw name → desired PHP identifier
     * @param SymbolKind|null $kind the only kind this map applies to; null applies it to all
     * @param string               $label how to name this map in an error, e.g. `renames`
     */
    public function __construct(
        private array $map,
        private ?string $pattern = null,
        private ?SymbolKind $kind = null,
        string $label = 'renames',
    ) {
        foreach ($map as $raw => $php) {
            if (preg_match(self::IDENTIFIER, $php) !== 1) {
                throw new InvalidProfileException(sprintf(
                    "Profile %s map: '%s' is not a valid PHP identifier (mapped from '%s').",
                    $label,
                    $php,
                    $raw,
                ));
            }
        }
    }

    public function normalise(string $raw, NormalisationContext $context): ?string
    {
        if ($this->kind instanceof SymbolKind && $context->kind !== $this->kind) {
            return null;
        }
        if ($this->pattern !== null && preg_match($this->pattern, $raw) !== 1) {
            return null;
        }

        return $this->map[$raw] ?? null;
    }
}
