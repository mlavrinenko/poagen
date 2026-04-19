<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Migration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'exclude_attachments' => ['exclude_attachments', null],
        'exclude_git_data' => ['exclude_git_data', null],
        'exclude_metadata' => ['exclude_metadata', null],
        'exclude_owner_projects' => ['exclude_owner_projects', null],
        'exclude_releases' => ['exclude_releases', null],
        'guid' => ['guid', null],
        'id' => ['id', null],
        'lock_repositories' => ['lock_repositories', null],
        'node_id' => ['node_id', null],
        'org_metadata_only' => ['org_metadata_only', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'repositories' => ['repositories', ['list', \Acme\GitHub\Generated\Model\Repository::class]],
        'state' => ['state', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'archive_url' => ['archive_url', null],
        'exclude' => ['exclude', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'exclude_attachments' => $this->exclude_attachments,
            'exclude_git_data' => $this->exclude_git_data,
            'exclude_metadata' => $this->exclude_metadata,
            'exclude_owner_projects' => $this->exclude_owner_projects,
            'exclude_releases' => $this->exclude_releases,
            'guid' => $this->guid,
            'id' => $this->id,
            'lock_repositories' => $this->lock_repositories,
            'node_id' => $this->node_id,
            'org_metadata_only' => $this->org_metadata_only,
            'owner' => $this->owner,
            'repositories' => $this->repositories,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'archive_url' => $this->archive_url,
            'exclude' => $this->exclude,
        ];
    }
}
