<?php

declare(strict_types=1);

namespace Acme\Kilbil\ValueObject;

use Mlavrinenko\Paogen\Generator\Attribute\BindsFormat;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;

/**
 * A kilbil calendar date.
 *
 * `data` (1 use) is `date` mistyped. paogen already handles the correct spelling
 * with a built-in, so this covers only the typo — which is also why binding it
 * here does not disturb the eight fields that spell it properly and keep arriving
 * as `DateTimeImmutable` from the built-in path.
 */
#[BindsFormat('data')]
final readonly class CalendarDate implements ScalarBinding
{
    private const string WIRE = 'Y-m-d';

    public function __construct(public \DateTimeImmutable $value) {}

    public static function fromScalar(mixed $raw): self
    {
        if (!\is_string($raw)) {
            throw new \InvalidArgumentException(
                'kilbil date expects a string payload, got ' . get_debug_type($raw),
            );
        }

        // The `!` resets the time fields, so a date-only value does not pick up
        // the current clock and make output non-deterministic.
        $parsed = \DateTimeImmutable::createFromFormat('!' . self::WIRE, $raw);

        return new self($parsed instanceof \DateTimeImmutable ? $parsed : new \DateTimeImmutable($raw));
    }

    public function toScalar(): string
    {
        return $this->value->format(self::WIRE);
    }
}
