<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAgentChildRelationshipVerion
{
    public function __construct(
        public ?string $agent_name = null,
        public ?string $child_agent_uuid = null,
        public ?string $if_case = null,
        public ?bool $is_deleted = null,
        public ?string $route_name = null,
    ) {
    }
}
