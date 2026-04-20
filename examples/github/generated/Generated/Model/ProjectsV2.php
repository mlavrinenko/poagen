<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ProjectsV2
{
    public function __construct(
        public ?DateTimeImmutable $closed_at = null,
        public DateTimeImmutable $created_at,
        public SimpleUser $creator,
        public ?DateTimeImmutable $deleted_at = null,
        public NullableSimpleUser $deleted_by,
        public ?string $description = null,
        public float $id,
        public string $node_id,
        public int $number,
        public SimpleUser $owner,
        public bool $public,
        public ?string $short_description = null,
        public string $title,
        public DateTimeImmutable $updated_at,
        public ?bool $is_template = null,
        public ?NullableProjectsV2StatusUpdate $latest_status_update = null,
        public ?string $state = null,
    ) {
    }
}
