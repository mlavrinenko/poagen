<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Workflow
{
    public function __construct(
        public string $badge_url,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public string $path,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?DateTimeImmutable $deleted_at = null,
    ) {
    }
}
