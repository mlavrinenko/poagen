<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class EnterpriseTeam implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'group_id' => ['group_id', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'members_url' => ['members_url', null],
        'name' => ['name', null],
        'slug' => ['slug', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'description' => ['description', null],
        'group_name' => ['group_name', null],
        'organization_selection_type' => ['organization_selection_type', null],
        'sync_to_organizations' => ['sync_to_organizations', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $group_id = null,
        public string $html_url,
        public int $id,
        public string $members_url,
        public string $name,
        public string $slug,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $description = null,
        public ?string $group_name = null,
        public ?string $organization_selection_type = null,
        public ?string $sync_to_organizations = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'group_id' => $this->group_id,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'members_url' => $this->members_url,
            'name' => $this->name,
            'slug' => $this->slug,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'description' => $this->description,
            'group_name' => $this->group_name,
            'organization_selection_type' => $this->organization_selection_type,
            'sync_to_organizations' => $this->sync_to_organizations,
        ];
    }
}
