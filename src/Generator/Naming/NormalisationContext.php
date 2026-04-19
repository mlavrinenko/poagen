<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

/**
 * Side-channel data threaded into {@see NameNormaliser::normalise()}.
 *
 * Today the only piece is the symbol kind. Extend (carefully) when a
 * future strategy proves it needs more — e.g., the JSON pointer of
 * the source node, the parent component name, etc.
 */
final readonly class NormalisationContext
{
    public function __construct(
        public SymbolKind $kind,
    ) {}
}
