<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateAgentApikeyInputPublic
{
    public function __construct(
        public ?string $agent_uuid = null,
        public ?string $api_key_uuid = null,
        public ?string $name = null,
    ) {
    }
}
