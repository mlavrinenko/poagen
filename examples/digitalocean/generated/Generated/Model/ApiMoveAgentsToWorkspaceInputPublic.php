<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiMoveAgentsToWorkspaceInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_uuids' => ['agent_uuids', ['list', null]],
        'workspace_uuid' => ['workspace_uuid', null],
    ];

    /**
     * @param ?list<string> $agent_uuids
     */
    public function __construct(
        public ?array $agent_uuids = null,
        public ?string $workspace_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_uuids' => $this->agent_uuids,
            'workspace_uuid' => $this->workspace_uuid,
        ];
    }
}
