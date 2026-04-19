<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GistSimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comments' => ['comments', null],
        'comments_enabled' => ['comments_enabled', null],
        'comments_url' => ['comments_url', null],
        'commits_url' => ['commits_url', null],
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'files' => ['files', null],
        'fork_of' => ['fork_of', \Acme\GitHub\Generated\Model\GistSimpleFork_of::class],
        'forks' => ['forks', ['list', null]],
        'forks_url' => ['forks_url', null],
        'git_pull_url' => ['git_pull_url', null],
        'git_push_url' => ['git_push_url', null],
        'history' => ['history', ['list', \Acme\GitHub\Generated\Model\GistHistory::class]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'public' => ['public', null],
        'truncated' => ['truncated', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
        'user' => ['user', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'comments' => $this->comments,
            'comments_enabled' => $this->comments_enabled,
            'comments_url' => $this->comments_url,
            'commits_url' => $this->commits_url,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'files' => $this->files,
            'fork_of' => $this->fork_of,
            'forks' => $this->forks,
            'forks_url' => $this->forks_url,
            'git_pull_url' => $this->git_pull_url,
            'git_push_url' => $this->git_push_url,
            'history' => $this->history,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'owner' => $this->owner,
            'public' => $this->public,
            'truncated' => $this->truncated,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'user' => $this->user,
        ];
    }
}
