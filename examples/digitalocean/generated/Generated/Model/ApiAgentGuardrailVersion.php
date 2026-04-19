<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAgentGuardrailVersion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'is_deleted' => ['is_deleted', null],
        'name' => ['name', null],
        'priority' => ['priority', null],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public ?bool $is_deleted = null,
        public ?string $name = null,
        public ?int $priority = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'is_deleted' => $this->is_deleted,
            'name' => $this->name,
            'priority' => $this->priority,
            'uuid' => $this->uuid,
        ];
    }
}
