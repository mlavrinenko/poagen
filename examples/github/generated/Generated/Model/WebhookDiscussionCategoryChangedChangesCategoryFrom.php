<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookDiscussionCategoryChangedChangesCategoryFrom
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $description,
        public string $emoji,
        public int $id,
        public bool $is_answerable,
        public string $name,
        public int $repository_id,
        public string $slug,
        public string $updated_at,
        public ?string $node_id = null,
    ) {
    }
}
