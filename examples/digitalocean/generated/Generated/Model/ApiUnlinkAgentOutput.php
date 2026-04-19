<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiUnlinkAgentOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'child_agent_uuid' => ['child_agent_uuid', null],
        'parent_agent_uuid' => ['parent_agent_uuid', null],
    ];

    public function __construct(
        public ?string $child_agent_uuid = null,
        public ?string $parent_agent_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'child_agent_uuid' => $this->child_agent_uuid,
            'parent_agent_uuid' => $this->parent_agent_uuid,
        ];
    }
}
