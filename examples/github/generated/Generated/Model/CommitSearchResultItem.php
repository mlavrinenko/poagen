<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CommitSearchResultItem
{
    /**
     * @param list<array<string, mixed>> $parents
     */
    public function __construct(
        public NullableSimpleUser $author,
        public string $comments_url,
        public CommitSearchResultItemCommit $commit,
        public NullableGitUser $committer,
        public string $html_url,
        public string $node_id,
        public array $parents,
        public MinimalRepository $repository,
        public float $score,
        public string $sha,
        public string $url,
        public ?SearchResultTextMatches $text_matches = null,
    ) {
    }
}
