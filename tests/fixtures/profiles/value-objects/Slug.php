<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Fixtures\ValueObject;

use InvalidArgumentException;
use Poagen\Runtime\ScalarBinding;

use function get_debug_type;
use function is_string;
use function strtolower;

/**
 * Fixture: a user value object carrying no `#[BindsFormat]` at all, so it can
 * only ever reach a property by being named in `Profile::$formats` or
 * `Profile::$propertyFormats`. That is what makes it usable as the winning
 * side of a precedence test — bound to a format {@see Email} already claims
 * by attribute, or to one poagen has a built-in for, its presence in the
 * emitted type is proof the profile beat the other route rather than proof
 * the two agreed.
 */
final readonly class Slug implements ScalarBinding
{
    public function __construct(public string $value) {}

    public static function fromScalar(mixed $raw): self
    {
        if (!is_string($raw)) {
            throw new InvalidArgumentException(
                'Slug expects a string payload, got ' . get_debug_type($raw),
            );
        }

        return new self(strtolower($raw));
    }

    public function toScalar(): string
    {
        return $this->value;
    }
}
