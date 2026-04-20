<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GistSimple
{
    /**
     * @param ?array<string, array<string, mixed>> $files
     * @param ?list<array<string, mixed>> $forks
     * @param ?list<\Acme\GitHub\Generated\Model\GistHistory> $history
     */
    public function __construct(
        public ?int $comments = null,
        public ?bool $comments_enabled = null,
        public ?string $comments_url = null,
        public ?string $commits_url = null,
        public ?string $created_at = null,
        public ?string $description = null,
        public ?array $files = null,
        public ?GistSimpleFork_of $fork_of = null,
        public ?array $forks = null,
        public ?string $forks_url = null,
        public ?string $git_pull_url = null,
        public ?string $git_push_url = null,
        public ?array $history = null,
        public ?string $html_url = null,
        public ?string $id = null,
        public ?string $node_id = null,
        public ?SimpleUser $owner = null,
        public ?bool $public = null,
        public ?bool $truncated = null,
        public ?string $updated_at = null,
        public ?string $url = null,
        public ?string $user = null,
    ) {
    }
}
