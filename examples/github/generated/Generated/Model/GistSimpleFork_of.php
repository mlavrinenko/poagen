<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class GistSimpleFork_of
{
    /**
     * @param array<string, array<string, mixed>> $files
     * @param ?list<mixed> $forks
     * @param ?list<mixed> $history
     */
    public function __construct(
        public int $comments,
        public string $comments_url,
        public string $commits_url,
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public array $files,
        public string $forks_url,
        public string $git_pull_url,
        public string $git_push_url,
        public string $html_url,
        public string $id,
        public string $node_id,
        public bool $public,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?bool $comments_enabled = null,
        public ?array $forks = null,
        public ?array $history = null,
        public ?NullableSimpleUser $owner = null,
        public ?bool $truncated = null,
    ) {
    }
}
