<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ReservedIpCreateAssignToDroplet implements ReservedIpCreate
{
    public function __construct(
        public int $droplet_id,
    ) {
    }
}
