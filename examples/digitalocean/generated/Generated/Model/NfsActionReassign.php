<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionReassign
{
    public function __construct(
        public string $type,
        public ?NfsActionReassignParams $params = null,
        public ?string $region = null,
    ) {
    }
}
