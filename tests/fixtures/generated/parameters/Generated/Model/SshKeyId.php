<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

use function assert;
use function is_int;

final readonly class SshKeyId implements ScalarBinding
{
    public function __construct(
        public int $value,
    ) {
    }

    public static function fromScalar(mixed $raw): self
    {
        assert(is_int($raw));
        return new self($raw);
    }

    public function toScalar(): int
    {
        return $this->value;
    }
}
