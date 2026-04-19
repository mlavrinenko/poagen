<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Project implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'environment' => ['environment', null],
        'id' => ['id', null],
        'is_default' => ['is_default', null],
        'name' => ['name', null],
        'owner_id' => ['owner_id', null],
        'owner_uuid' => ['owner_uuid', null],
        'purpose' => ['purpose', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $environment = null,
        public ?string $id = null,
        public ?bool $is_default = null,
        public ?string $name = null,
        public ?int $owner_id = null,
        public ?string $owner_uuid = null,
        public ?string $purpose = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'environment' => $this->environment,
            'id' => $this->id,
            'is_default' => $this->is_default,
            'name' => $this->name,
            'owner_id' => $this->owner_id,
            'owner_uuid' => $this->owner_uuid,
            'purpose' => $this->purpose,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
