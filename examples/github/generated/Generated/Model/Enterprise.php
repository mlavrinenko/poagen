<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Enterprise
{
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
}
