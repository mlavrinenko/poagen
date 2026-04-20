<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUnlinkAgentOutput
{
    public function __construct(
        public ?string $child_agent_uuid = null,
        public ?string $parent_agent_uuid = null,
    ) {
    }
}
