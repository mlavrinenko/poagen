<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

final readonly class CodeScanningAlertCreateRequest implements ScalarBinding
{
    public function __construct(
        public bool $value,
    ) {
    }

    public static function fromScalar(mixed $raw): self
    {
        \assert(\is_bool($raw));
        return new self($raw);
    }

    public function toScalar(): bool
    {
        return $this->value;
    }
}
