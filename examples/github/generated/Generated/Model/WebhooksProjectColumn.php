<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksProjectColumn implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cards_url' => ['cards_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'project_url' => ['project_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'after_id' => ['after_id', null],
    ];

    public function __construct(
        public string $cards_url,
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public string $node_id,
        public string $project_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?int $after_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cards_url' => $this->cards_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'project_url' => $this->project_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'after_id' => $this->after_id,
        ];
    }
}
