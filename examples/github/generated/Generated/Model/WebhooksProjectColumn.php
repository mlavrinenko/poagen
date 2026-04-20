<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksProjectColumn
{
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
}
