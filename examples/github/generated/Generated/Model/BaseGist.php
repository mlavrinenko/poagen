<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class BaseGist implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comments' => ['comments', null],
        'comments_url' => ['comments_url', null],
        'commits_url' => ['commits_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'files' => ['files', null],
        'forks_url' => ['forks_url', null],
        'git_pull_url' => ['git_pull_url', null],
        'git_push_url' => ['git_push_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'public' => ['public', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'comments_enabled' => ['comments_enabled', null],
        'forks' => ['forks', ['list', null]],
        'history' => ['history', ['list', null]],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'truncated' => ['truncated', null],
    ];

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
        public ?SimpleUser $owner = null,
        public ?bool $truncated = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'comments' => $this->comments,
            'comments_url' => $this->comments_url,
            'commits_url' => $this->commits_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'files' => $this->files,
            'forks_url' => $this->forks_url,
            'git_pull_url' => $this->git_pull_url,
            'git_push_url' => $this->git_push_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'public' => $this->public,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'comments_enabled' => $this->comments_enabled,
            'forks' => $this->forks,
            'history' => $this->history,
            'owner' => $this->owner,
            'truncated' => $this->truncated,
        ];
    }
}
