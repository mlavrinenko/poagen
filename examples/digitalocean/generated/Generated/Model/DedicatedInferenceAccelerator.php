<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DedicatedInferenceAccelerator implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'role' => ['role', null],
        'slug' => ['slug', null],
        'status' => ['status', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $role = null,
        public ?string $slug = null,
        public ?string $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'slug' => $this->slug,
            'status' => $this->status,
        ];
    }
}
