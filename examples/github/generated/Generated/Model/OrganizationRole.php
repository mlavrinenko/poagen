<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class OrganizationRole implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'permissions' => ['permissions', ['list', null]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'base_role' => ['base_role', null],
        'description' => ['description', null],
        'source' => ['source', null],
    ];

    /**
     * @param list<string> $permissions
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public NullableSimpleUser $organization,
        public array $permissions,
        public DateTimeImmutable $updated_at,
        public ?string $base_role = null,
        public ?string $description = null,
        public ?string $source = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'organization' => $this->organization,
            'permissions' => $this->permissions,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'base_role' => $this->base_role,
            'description' => $this->description,
            'source' => $this->source,
        ];
    }
}
