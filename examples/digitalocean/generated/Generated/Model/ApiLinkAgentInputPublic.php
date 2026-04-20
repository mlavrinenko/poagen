<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiLinkAgentInputPublic
{
    public function __construct(
        public ?string $child_agent_uuid = null,
        public ?string $if_case = null,
        public ?string $parent_agent_uuid = null,
        public ?string $route_name = null,
    ) {
    }
}
