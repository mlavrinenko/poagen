<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class TopicSearchResultItem
{
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
}
