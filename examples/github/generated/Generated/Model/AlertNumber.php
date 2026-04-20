<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

final readonly class AlertNumber implements ScalarBinding
{
    public function __construct(
        public int $value,
    ) {
    }

    public static function fromScalar(mixed $raw): self
    {
        \assert(\is_int($raw));
        return new self($raw);
    }

    public function toScalar(): int
    {
        return $this->value;
    }
}
