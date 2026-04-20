<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDedicatedEgressIpStatus;

final readonly class AppsDedicatedEgressIp
{
    public function __construct(
        public ?string $id = null,
        public ?string $ip = null,
        public ?AppsDedicatedEgressIpStatus $status = null,
    ) {
    }
}
