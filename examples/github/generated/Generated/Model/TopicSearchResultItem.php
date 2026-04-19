<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class TopicSearchResultItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'created_by' => ['created_by', null],
        'curated' => ['curated', null],
        'description' => ['description', null],
        'display_name' => ['display_name', null],
        'featured' => ['featured', null],
        'name' => ['name', null],
        'released' => ['released', null],
        'score' => ['score', null],
        'short_description' => ['short_description', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'aliases' => ['aliases', ['list', null]],
        'logo_url' => ['logo_url', null],
        'related' => ['related', ['list', null]],
        'repository_count' => ['repository_count', null],
        'text_matches' => ['text_matches', \Acme\GitHub\Generated\Model\SearchResultTextMatches::class],
    ];

    /**
     * @param ?list<array<string, mixed>> $aliases
     * @param ?list<array<string, mixed>> $related
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $created_by = null,
        public bool $curated,
        public ?string $description = null,
        public ?string $display_name = null,
        public bool $featured,
        public string $name,
        public ?string $released = null,
        public float $score,
        public ?string $short_description = null,
        public DateTimeImmutable $updated_at,
        public ?array $aliases = null,
        public ?string $logo_url = null,
        public ?array $related = null,
        public ?int $repository_count = null,
        public ?SearchResultTextMatches $text_matches = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'created_by' => $this->created_by,
            'curated' => $this->curated,
            'description' => $this->description,
            'display_name' => $this->display_name,
            'featured' => $this->featured,
            'name' => $this->name,
            'released' => $this->released,
            'score' => $this->score,
            'short_description' => $this->short_description,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'aliases' => $this->aliases,
            'logo_url' => $this->logo_url,
            'related' => $this->related,
            'repository_count' => $this->repository_count,
            'text_matches' => $this->text_matches,
        ];
    }
}
