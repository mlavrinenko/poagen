<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentApikeyInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'created_by' => ['created_by', null],
        'deleted_at' => ['deleted_at', ['datetime', null]],
        'name' => ['name', null],
        'secret_key' => ['secret_key', null],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by = null,
        public ?DateTimeImmutable $deleted_at = null,
        public ?string $name = null,
        public ?string $secret_key = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'created_by' => $this->created_by,
            'deleted_at' => $this->deleted_at?->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'secret_key' => $this->secret_key,
            'uuid' => $this->uuid,
        ];
    }
}
