<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class IssueType
{
    public function __construct(
        public ?string $description = null,
        public int $id,
        public string $name,
        public string $node_id,
        public ?string $color = null,
        public ?DateTimeImmutable $created_at = null,
        public ?bool $is_enabled = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
