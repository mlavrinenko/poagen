<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CommitSearchResultItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'comments_url' => ['comments_url', null],
        'commit' => ['commit', \Acme\GitHub\Generated\Model\CommitSearchResultItemCommit::class],
        'committer' => ['committer', \Acme\GitHub\Generated\Model\NullableGitUser::class],
        'html_url' => ['html_url', null],
        'node_id' => ['node_id', null],
        'parents' => ['parents', ['list', null]],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'score' => ['score', null],
        'sha' => ['sha', null],
        'url' => ['url', null],
        'text_matches' => ['text_matches', \Acme\GitHub\Generated\Model\SearchResultTextMatches::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'comments_url' => $this->comments_url,
            'commit' => $this->commit,
            'committer' => $this->committer,
            'html_url' => $this->html_url,
            'node_id' => $this->node_id,
            'parents' => $this->parents,
            'repository' => $this->repository,
            'score' => $this->score,
            'sha' => $this->sha,
            'url' => $this->url,
            'text_matches' => $this->text_matches,
        ];
    }
}
