<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

final readonly class CodeScanningAnalysisEnvironment implements ScalarBinding
{
    public function __construct(
        public string $value,
    ) {
    }

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
