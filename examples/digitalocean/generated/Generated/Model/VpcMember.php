<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class VpcMember
{
    public function __construct(
        public ?string $created_at = null,
        public ?string $name = null,
        public ?Urn $urn = null,
    ) {
    }
}
