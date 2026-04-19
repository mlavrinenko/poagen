<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PullRequestReviewCommentEventComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\PullRequestReviewCommentEventComment_links::class],
        'body' => ['body', null],
        'commit_id' => ['commit_id', null],
        'created_at' => ['created_at', ['datetime', null]],
        'diff_hunk' => ['diff_hunk', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'original_commit_id' => ['original_commit_id', null],
        'original_position' => ['original_position', null],
        'path' => ['path', null],
        'position' => ['position', null],
        'pull_request_review_id' => ['pull_request_review_id', null],
        'pull_request_url' => ['pull_request_url', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\PullRequestReviewCommentEventCommentReactions::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\PullRequestReviewCommentEventCommentUser::class],
        'in_reply_to_id' => ['in_reply_to_id', null],
        'subject_type' => ['subject_type', null],
    ];

    public function __construct(
        public PullRequestReviewCommentEventComment_links $_links,
        public string $body,
        public string $commit_id,
        public DateTimeImmutable $created_at,
        public string $diff_hunk,
        public string $html_url,
        public int $id,
        public string $node_id,
        public string $original_commit_id,
        public int $original_position,
        public string $path,
        public ?int $position = null,
        public ?int $pull_request_review_id = null,
        public string $pull_request_url,
        public PullRequestReviewCommentEventCommentReactions $reactions,
        public DateTimeImmutable $updated_at,
        public string $url,
        public PullRequestReviewCommentEventCommentUser $user,
        public ?int $in_reply_to_id = null,
        public ?string $subject_type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'body' => $this->body,
            'commit_id' => $this->commit_id,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'diff_hunk' => $this->diff_hunk,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'original_commit_id' => $this->original_commit_id,
            'original_position' => $this->original_position,
            'path' => $this->path,
            'position' => $this->position,
            'pull_request_review_id' => $this->pull_request_review_id,
            'pull_request_url' => $this->pull_request_url,
            'reactions' => $this->reactions,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'in_reply_to_id' => $this->in_reply_to_id,
            'subject_type' => $this->subject_type,
        ];
    }
}
