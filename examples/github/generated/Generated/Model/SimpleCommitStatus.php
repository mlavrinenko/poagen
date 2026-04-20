<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class SimpleCommitStatus
{
    public function __construct(
        public ?string $avatar_url = null,
        public string $context,
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public int $id,
        public string $node_id,
        public string $state,
        public ?string $target_url = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?bool $required = null,
    ) {
    }
}
