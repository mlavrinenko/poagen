<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class FloatingIpCreateAssignToDroplet implements FloatingIpCreate
{
    public function __construct(
        public int $droplet_id,
    ) {
    }
}
