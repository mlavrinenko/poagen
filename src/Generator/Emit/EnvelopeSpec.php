<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Contract\StatusResponseMap;

/**
 * One operation's whole response surface, resolved: every declared status
 * paired with the {@see ReturnSpec} its body hydrates into.
 *
 * Replaces the single picked-2xx {@see ReturnSpec} `InlinePayloadCatalog`
 * used to carry per operation — the owner ruling behind `typed-error-responses`
 * says the status does not change the shape of the return, so every declared
 * status earns a body shape rather than only the one that used to drive the
 * method's return type.
 *
 * `$exact` and `$ranges` are lists of pairs, not maps keyed by status text,
 * for the same reason {@see StatusResponseMap}
 * is: a status such as `'200'` is exactly the numeric-looking string PHP
 * folds to an `int` array key, so `$exact['200']` silently becomes
 * `$exact[200]` the moment it is assigned — a pair keeps the status text a
 * value, never a key, in the generator's own data just as much as in the
 * code it emits.
 *
 * @internal
 */
final readonly class EnvelopeSpec
{
    /**
     * @param list<array{0: string, 1: ReturnSpec}> $exact  exact status text, as the document spells it
     * @param list<array{0: string, 1: ReturnSpec}> $ranges range key text, as the document spells it — `'4XX'`
     */
    public function __construct(
        public array $exact = [],
        public array $ranges = [],
        public ?ReturnSpec $default = null,
    ) {}

    /**
     * Every declared status paired with its body shape, in the order the
     * document declared them within each bucket — exact, then ranges, then
     * `default` last. The order a runtime `StatusResponseMap` literal is
     * built in, and the order a body-type union is read off in.
     *
     * @return list<array{0: string, 1: ReturnSpec}>
     */
    public function entries(): array
    {
        $out = [...$this->exact, ...$this->ranges];

        if ($this->default instanceof ReturnSpec) {
            $out[] = ['default', $this->default];
        }

        return $out;
    }
}
