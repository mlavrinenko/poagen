<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

use Mlavrinenko\Paogen\Exception\NameNormalisationException;

/**
 * Single source of truth for "raw OpenAPI symbol → PHP identifier"
 * decisions within one generator run.
 *
 * Memoises the normaliser so each raw key is decided exactly once
 * (so user-supplied strategies need not be idempotent themselves).
 * Detects collisions: two distinct raw keys landing on the same PHP
 * identifier abort the run with both keys named.
 */
final class NameRegistry
{
    /** @var array<string,string> raw → php */
    private array $rawToPhp = [];

    /** @var array<string,string> php → raw (for collision diagnostics) */
    private array $phpToRaw = [];

    public function __construct(
        private readonly NameNormaliser $normaliser,
    ) {}

    public function resolve(string $raw, NormalisationContext $context): string
    {
        if (isset($this->rawToPhp[$raw])) {
            return $this->rawToPhp[$raw];
        }

        $php = $this->normaliser->normalise($raw, $context);

        if ($php === null) {
            // Composite throws on this path; a non-composite returning
            // null is a programming error, but we surface it cleanly.
            throw NameNormalisationException::unhandled($raw, $context, 1);
        }

        if (isset($this->phpToRaw[$php]) && $this->phpToRaw[$php] !== $raw) {
            throw NameNormalisationException::collision($php, $this->phpToRaw[$php], $raw);
        }

        $this->rawToPhp[$raw] = $php;
        $this->phpToRaw[$php] = $raw;

        return $php;
    }
}
