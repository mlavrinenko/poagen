<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsActionReassignParams
{
    public function __construct(
        public string $new_vpc_id,
        public string $old_vpc_id,
    ) {
    }
}
