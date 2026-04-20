<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiMoveAgentsToWorkspaceInputPublic
{
    /**
     * @param ?list<string> $agent_uuids
     */
    public function __construct(
        public ?array $agent_uuids = null,
        public ?string $workspace_uuid = null,
    ) {
    }
}
