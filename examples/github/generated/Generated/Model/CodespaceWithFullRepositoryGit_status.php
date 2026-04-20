<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodespaceWithFullRepositoryGit_status
{
    public function __construct(
        public ?int $ahead = null,
        public ?int $behind = null,
        public ?bool $has_uncommitted_changes = null,
        public ?bool $has_unpushed_changes = null,
        public ?string $ref = null,
    ) {
    }
}
