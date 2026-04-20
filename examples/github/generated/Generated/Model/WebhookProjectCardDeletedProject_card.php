<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookProjectCardDeletedProject_card
{
    public function __construct(
        public bool $archived,
        public ?int $column_id = null,
        public string $column_url,
        public DateTimeImmutable $created_at,
        public WebhookProjectCardDeletedProject_cardCreator $creator,
        public int $id,
        public string $node_id,
        public ?string $note = null,
        public string $project_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?int $after_id = null,
        public ?string $content_url = null,
    ) {
    }
}
