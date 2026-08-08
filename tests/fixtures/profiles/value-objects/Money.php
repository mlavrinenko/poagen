<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Fixtures\ValueObject;

use InvalidArgumentException;
use Poagen\Runtime\ScalarBinding;

use function get_debug_type;
use function is_float;
use function is_int;

/**
 * Fixture: a user value object bound to one property of one model via
 * `Profile::$propertyFormats` rather than via `#[BindsFormat]` — it carries
 * no `#[BindsFormat]` attribute at all, on purpose, so its presence under
 * `discoverIn` proves nothing about `format: double` document-wide
 * (bind-a-format-per-property).
 */
final readonly class Money implements ScalarBinding
{
    public function __construct(public string $amount) {}

    public static function fromScalar(mixed $raw): self
    {
        if (!is_float($raw) && !is_int($raw)) {
            throw new InvalidArgumentException(
                'Money expects a numeric payload, got ' . get_debug_type($raw),
            );
        }

        return new self(number_format((float) $raw, 2, '.', ''));
    }

    public function toScalar(): float
    {
        return (float) $this->amount;
    }
}
