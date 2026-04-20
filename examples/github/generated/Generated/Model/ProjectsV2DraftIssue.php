<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ProjectsV2DraftIssue
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public float $id,
        public string $node_id,
        public string $title,
        public DateTimeImmutable $updated_at,
        public NullableSimpleUser $user,
        public ?string $body = null,
    ) {
    }
}
