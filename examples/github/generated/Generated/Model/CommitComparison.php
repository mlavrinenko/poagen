<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CommitComparison implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ahead_by' => ['ahead_by', null],
        'base_commit' => ['base_commit', \Acme\GitHub\Generated\Model\Commit::class],
        'behind_by' => ['behind_by', null],
        'commits' => ['commits', ['list', \Acme\GitHub\Generated\Model\Commit::class]],
        'diff_url' => ['diff_url', null],
        'html_url' => ['html_url', null],
        'merge_base_commit' => ['merge_base_commit', \Acme\GitHub\Generated\Model\Commit::class],
        'patch_url' => ['patch_url', null],
        'permalink_url' => ['permalink_url', null],
        'status' => ['status', null],
        'total_commits' => ['total_commits', null],
        'url' => ['url', null],
        'files' => ['files', ['list', \Acme\GitHub\Generated\Model\DiffEntry::class]],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\Commit> $commits
     * @param ?list<\Acme\GitHub\Generated\Model\DiffEntry> $files
     */
    public function __construct(
        public int $ahead_by,
        public Commit $base_commit,
        public int $behind_by,
        public array $commits,
        public string $diff_url,
        public string $html_url,
        public Commit $merge_base_commit,
        public string $patch_url,
        public string $permalink_url,
        public string $status,
        public int $total_commits,
        public string $url,
        public ?array $files = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ahead_by' => $this->ahead_by,
            'base_commit' => $this->base_commit,
            'behind_by' => $this->behind_by,
            'commits' => $this->commits,
            'diff_url' => $this->diff_url,
            'html_url' => $this->html_url,
            'merge_base_commit' => $this->merge_base_commit,
            'patch_url' => $this->patch_url,
            'permalink_url' => $this->permalink_url,
            'status' => $this->status,
            'total_commits' => $this->total_commits,
            'url' => $this->url,
            'files' => $this->files,
        ];
    }
}
