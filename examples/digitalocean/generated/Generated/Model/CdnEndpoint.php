<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class CdnEndpoint
{
    public function __construct(
        public string $origin,
        public ?string $certificate_id = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $custom_domain = null,
        public ?string $endpoint = null,
        public ?string $id = null,
        public ?int $ttl = null,
    ) {
    }
}
