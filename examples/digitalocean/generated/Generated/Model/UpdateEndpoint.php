<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class UpdateEndpoint
{
    public function __construct(
        public ?string $certificate_id = null,
        public ?string $custom_domain = null,
        public ?int $ttl = null,
    ) {
    }
}
