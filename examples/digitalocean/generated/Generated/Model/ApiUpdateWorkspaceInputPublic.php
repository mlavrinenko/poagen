<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiUpdateWorkspaceInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'name' => ['name', null],
        'workspace_uuid' => ['workspace_uuid', null],
    ];

    public function __construct(
        public ?string $description = null,
        public ?string $name = null,
        public ?string $workspace_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'name' => $this->name,
            'workspace_uuid' => $this->workspace_uuid,
        ];
    }
}
