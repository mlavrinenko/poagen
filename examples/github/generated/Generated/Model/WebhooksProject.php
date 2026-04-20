<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhooksProject
{
    public function __construct(
        public ?string $body = null,
        public string $columns_url,
        public DateTimeImmutable $created_at,
        public WebhooksProjectCreator $creator,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public int $number,
        public string $owner_url,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $url,
    ) {
    }
}
