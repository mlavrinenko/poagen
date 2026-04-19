<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class EnterpriseWebhooks implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'slug' => ['slug', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'description' => ['description', null],
        'website_url' => ['website_url', null],
    ];

    public function __construct(
        public string $avatar_url,
        public ?DateTimeImmutable $created_at = null,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public string $slug,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $description = null,
        public ?string $website_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'slug' => $this->slug,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'website_url' => $this->website_url,
        ];
    }
}
