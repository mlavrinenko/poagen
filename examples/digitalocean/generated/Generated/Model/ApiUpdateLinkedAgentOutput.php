<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateLinkedAgentOutput
{
    public function __construct(
        public ?string $child_agent_uuid = null,
        public ?string $parent_agent_uuid = null,
        public ?bool $rollback = null,
        public ?string $uuid = null,
    ) {
    }
}
