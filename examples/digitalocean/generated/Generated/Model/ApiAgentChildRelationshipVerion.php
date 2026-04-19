<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAgentChildRelationshipVerion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_name' => ['agent_name', null],
        'child_agent_uuid' => ['child_agent_uuid', null],
        'if_case' => ['if_case', null],
        'is_deleted' => ['is_deleted', null],
        'route_name' => ['route_name', null],
    ];

    public function __construct(
        public ?string $agent_name = null,
        public ?string $child_agent_uuid = null,
        public ?string $if_case = null,
        public ?bool $is_deleted = null,
        public ?string $route_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_name' => $this->agent_name,
            'child_agent_uuid' => $this->child_agent_uuid,
            'if_case' => $this->if_case,
            'is_deleted' => $this->is_deleted,
            'route_name' => $this->route_name,
        ];
    }
}
