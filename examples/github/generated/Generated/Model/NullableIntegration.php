<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class NullableIntegration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'events' => ['events', ['list', null]],
        'external_url' => ['external_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'owner' => [
            'owner',
            [
                'union',
                [\Acme\GitHub\Generated\Model\SimpleUser::class, \Acme\GitHub\Generated\Model\Enterprise::class],
                null,
            ],
        ],
        'permissions' => ['permissions', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'client_id' => ['client_id', null],
        'installations_count' => ['installations_count', null],
        'slug' => ['slug', null],
    ];

    /**
     * @param list<string> $events
     * @param array<string, string> $permissions
     * @todo Inline object mixes declared properties with additionalProperties; emitted as array<string, mixed>. See T-013 out-of-scope.
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public array $events,
        public string $external_url,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public SimpleUser|Enterprise $owner,
        public array $permissions,
        public DateTimeImmutable $updated_at,
        public ?string $client_id = null,
        public ?int $installations_count = null,
        public ?string $slug = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'events' => $this->events,
            'external_url' => $this->external_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'owner' => $this->owner,
            'permissions' => $this->permissions,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'client_id' => $this->client_id,
            'installations_count' => $this->installations_count,
            'slug' => $this->slug,
        ];
    }
}
