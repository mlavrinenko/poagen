<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateWorkspaceInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_uuids' => ['agent_uuids', ['list', null]],
        'description' => ['description', null],
        'name' => ['name', null],
    ];

    /**
     * @param ?list<string> $agent_uuids
     */
    public function __construct(
        public ?array $agent_uuids = null,
        public ?string $description = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_uuids' => $this->agent_uuids,
            'description' => $this->description,
            'name' => $this->name,
        ];
    }
}
