<?php

declare(strict_types=1);

namespace Acme\Kilbil\ValueObject;

use Mlavrinenko\Paogen\Generator\Attribute\BindsFormat;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;

/**
 * A kilbil timestamp.
 *
 * The vendor writes this format three ways and gets it wrong all three times:
 * `date time` (11 uses) is `date-time` with a space where the hyphen belongs,
 * and `data time` (3 uses) is that typo plus another. paogen reports each one
 * rather than quietly leaving 14 timestamps as strings, and this class is the
 * answer — one type for every spelling, which is why `#[BindsFormat]` is
 * repeatable.
 *
 * Implementing `ScalarBinding` is what keeps the wire honest: the generated
 * client sends and receives the vendor's string, and the consumer's code holds a
 * `DateTimeImmutable`. Nothing about the repair reaches the emitted tree.
 *
 * Note the format is bound to a *class*, not to `DateTimeImmutable` directly: an
 * attribute cannot be put on a built-in type, and a consumer wanting Carbon or
 * Chronos instead swaps only this file.
 */
#[BindsFormat('date time')]
#[BindsFormat('data time')]
final readonly class Timestamp implements ScalarBinding
{
    /**
     * The vendor's own examples use a space between date and time rather than
     * the `T` separator RFC 3339 asks for, so parsing is pinned to the format
     * they actually send rather than left to `DateTimeImmutable`'s guesswork.
     */
    private const string WIRE = 'Y-m-d H:i:s';

    public function __construct(public \DateTimeImmutable $value) {}

    public static function fromScalar(mixed $raw): self
    {
        if (!\is_string($raw)) {
            throw new \InvalidArgumentException(
                'kilbil timestamp expects a string payload, got ' . get_debug_type($raw),
            );
        }

        $parsed = \DateTimeImmutable::createFromFormat(self::WIRE, $raw);

        // Some endpoints omit the time part entirely; fall back to a permissive
        // parse rather than throwing on a value the vendor considers valid.
        return new self($parsed instanceof \DateTimeImmutable ? $parsed : new \DateTimeImmutable($raw));
    }

    public function toScalar(): string
    {
        return $this->value->format(self::WIRE);
    }
}
