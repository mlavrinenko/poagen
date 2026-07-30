<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\ValueObject;

use InvalidArgumentException;
use Mlavrinenko\Paogen\Generator\Attribute\BindsFormat;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;

use function is_string;

/**
 * Fixture: a user value object that opts in as the PHP type for `format: email`
 * and implements {@see ScalarBinding} so the generator round-trips it as a
 * plain string at the wire boundary (ADR-007).
 */
#[BindsFormat('email')]
final readonly class Email implements ScalarBinding
{
    public function __construct(public string $value) {}

    public static function fromScalar(mixed $raw): self
    {
        if (!is_string($raw)) {
            throw new InvalidArgumentException(
                'Email expects a string payload, got ' . get_debug_type($raw),
            );
        }

        return new self($raw);
    }

    public function toScalar(): string
    {
        return $this->value;
    }
}
