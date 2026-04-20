<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CommitComparison
{
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
}
