<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PublicIp
{
    public function __construct(
        public ?bool $enabled = null,
        public ?int $length = null,
        public ?string $prefix = null,
    ) {
    }
}
