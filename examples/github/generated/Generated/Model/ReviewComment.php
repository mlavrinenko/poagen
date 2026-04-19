<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ReviewComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\ReviewComment_links::class],
        'author_association' => ['author_association', ['enum', \Acme\GitHub\Generated\Enum\AuthorAssociation::class]],
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
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'body_html' => ['body_html', null],
        'body_text' => ['body_text', null],
        'in_reply_to_id' => ['in_reply_to_id', null],
        'line' => ['line', null],
        'original_line' => ['original_line', null],
        'original_start_line' => ['original_start_line', null],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\ReactionRollup::class],
        'side' => ['side', null],
        'start_line' => ['start_line', null],
        'start_side' => ['start_side', null],
        'subject_type' => ['subject_type', null],
    ];

    public function __construct(
        public ReviewComment_links $_links,
        public AuthorAssociation $author_association,
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
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?int $in_reply_to_id = null,
        public ?int $line = null,
        public ?int $original_line = null,
        public ?int $original_start_line = null,
        public ?ReactionRollup $reactions = null,
        public ?string $side = null,
        public ?int $start_line = null,
        public ?string $start_side = null,
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
            'node_id' => $this->node_id,
            'original_commit_id' => $this->original_commit_id,
            'original_position' => $this->original_position,
            'path' => $this->path,
            'position' => $this->position,
            'pull_request_review_id' => $this->pull_request_review_id,
            'pull_request_url' => $this->pull_request_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'body_html' => $this->body_html,
            'body_text' => $this->body_text,
            'in_reply_to_id' => $this->in_reply_to_id,
            'line' => $this->line,
            'original_line' => $this->original_line,
            'original_start_line' => $this->original_start_line,
            'reactions' => $this->reactions,
            'side' => $this->side,
            'start_line' => $this->start_line,
            'start_side' => $this->start_side,
            'subject_type' => $this->subject_type,
        ];
    }
}
