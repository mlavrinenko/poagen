<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Firewall implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'droplet_ids' => ['droplet_ids', ['list', null]],
        'id' => ['id', null],
        'inbound_rules' => ['inbound_rules', ['list', null]],
        'name' => ['name', null],
        'outbound_rules' => ['outbound_rules', ['list', null]],
        'pending_changes' => ['pending_changes', ['list', null]],
        'status' => ['status', null],
        'tags' => ['tags', null],
    ];

    /**
     * @param ?list<int> $droplet_ids
     * @param ?list<mixed> $inbound_rules
     * @param ?list<mixed> $outbound_rules
     * @param ?list<array<string, mixed>> $pending_changes
     * @param ?mixed $tags
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?array $droplet_ids = null,
        public ?string $id = null,
        public ?array $inbound_rules = null,
        public ?string $name = null,
        public ?array $outbound_rules = null,
        public ?array $pending_changes = null,
        public ?string $status = null,
        public $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'droplet_ids' => $this->droplet_ids,
            'id' => $this->id,
            'inbound_rules' => $this->inbound_rules,
            'name' => $this->name,
            'outbound_rules' => $this->outbound_rules,
            'pending_changes' => $this->pending_changes,
            'status' => $this->status,
            'tags' => $this->tags,
        ];
    }
}
