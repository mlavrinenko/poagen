<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Migration
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Repository> $repositories
     * @param ?list<string> $exclude
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public bool $exclude_attachments,
        public bool $exclude_git_data,
        public bool $exclude_metadata,
        public bool $exclude_owner_projects,
        public bool $exclude_releases,
        public string $guid,
        public int $id,
        public bool $lock_repositories,
        public string $node_id,
        public bool $org_metadata_only,
        public NullableSimpleUser $owner,
        public array $repositories,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $archive_url = null,
        public ?array $exclude = null,
    ) {
    }
}
