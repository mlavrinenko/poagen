<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

use Mlavrinenko\Paogen\Exception\NameNormalisationException;

/**
 * Walks an ordered list of strategies. First non-null result wins.
 * If every strategy returns null, throws — no silent identity
 * fallback so a misconfigured pipeline surfaces immediately.
 */
final readonly class CompositeNormaliser implements NameNormaliser
{
    /**
     * @param list<NameNormaliser> $strategies
     */
    public function __construct(
        private array $strategies,
    ) {}

    public function normalise(string $raw, NormalisationContext $context): string
    {
        foreach ($this->strategies as $strategy) {
            $result = $strategy->normalise($raw, $context);
            if ($result !== null) {
                return $result;
            }
        }

        throw NameNormalisationException::unhandled($raw, $context, \count($this->strategies));
    }
}
