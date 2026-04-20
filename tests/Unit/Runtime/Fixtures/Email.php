<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

final readonly class Email implements ScalarBinding
{
    public function __construct(public string $value) {}

    public static function fromScalar(mixed $raw): self
    {
        \assert(\is_string($raw));

        return new self($raw);
    }

    public function toScalar(): string
    {
        return $this->value;
    }
}
