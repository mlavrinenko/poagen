<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAuditHeader
{
    public function __construct(
        public ?string $actor_id = null,
        public ?string $actor_ip = null,
        public ?string $actor_uuid = null,
        public ?string $context_urn = null,
        public ?string $origin_application = null,
        public ?string $user_id = null,
        public ?string $user_uuid = null,
    ) {
    }
}
