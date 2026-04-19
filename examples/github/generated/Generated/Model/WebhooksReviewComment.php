<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksReviewComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\WebhooksReviewComment_links::class],
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'commit_id' => ['commit_id', null],
        'created_at' => ['created_at', ['datetime', null]],
        'diff_hunk' => ['diff_hunk', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'line' => ['line', null],
        'node_id' => ['node_id', null],
        'original_commit_id' => ['original_commit_id', null],
        'original_line' => ['original_line', null],
        'original_position' => ['original_position', null],
        'original_start_line' => ['original_start_line', null],
        'path' => ['path', null],
        'position' => ['position', null],
        'pull_request_review_id' => ['pull_request_review_id', null],
        'pull_request_url' => ['pull_request_url', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhooksReviewCommentReactions::class],
        'side' => ['side', null],
        'start_line' => ['start_line', null],
        'start_side' => ['start_side', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhooksReviewCommentUser::class],
        'in_reply_to_id' => ['in_reply_to_id', null],
        'subject_type' => ['subject_type', null],
    ];

    public function __construct(
        public WebhooksReviewComment_links $_links,
        public string $author_association,
        public string $body,
        public string $commit_id,
        public DateTimeImmutable $created_at,
        public string $diff_hunk,
        public string $html_url,
        public int $id,
        public ?int $line = null,
        public string $node_id,
        public string $original_commit_id,
        public int $original_line,
        public int $original_position,
        public ?int $original_start_line = null,
        public string $path,
        public ?int $position = null,
        public ?int $pull_request_review_id = null,
        public string $pull_request_url,
        public WebhooksReviewCommentReactions $reactions,
        public string $side,
        public ?int $start_line = null,
        public ?string $start_side = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhooksReviewCommentUser $user,
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
            'author_association' => $this->author_association,
            'body' => $this->body,
            'commit_id' => $this->commit_id,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'diff_hunk' => $this->diff_hunk,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'line' => $this->line,
            'node_id' => $this->node_id,
            'original_commit_id' => $this->original_commit_id,
            'original_line' => $this->original_line,
            'original_position' => $this->original_position,
            'original_start_line' => $this->original_start_line,
            'path' => $this->path,
            'position' => $this->position,
            'pull_request_review_id' => $this->pull_request_review_id,
            'pull_request_url' => $this->pull_request_url,
            'reactions' => $this->reactions,
            'side' => $this->side,
            'start_line' => $this->start_line,
            'start_side' => $this->start_side,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'in_reply_to_id' => $this->in_reply_to_id,
            'subject_type' => $this->subject_type,
        ];
    }
}
