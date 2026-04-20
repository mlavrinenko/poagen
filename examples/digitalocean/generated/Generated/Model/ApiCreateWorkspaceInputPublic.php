<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateWorkspaceInputPublic
{
    /**
     * @param ?list<string> $agent_uuids
     */
    public function __construct(
        public ?array $agent_uuids = null,
        public ?string $description = null,
        public ?string $name = null,
    ) {
    }
}
