<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookIssueCommentCreatedComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author_association' => ['author_association', null],
        'body' => ['body', null],
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'issue_url' => ['issue_url', null],
        'node_id' => ['node_id', null],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\WebhookIssueCommentCreatedCommentReactions::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookIssueCommentCreatedCommentUser::class],
        'pin' => ['pin', \Acme\GitHub\Generated\Model\NullablePinnedIssueComment::class],
    ];

    public function __construct(
        public string $author_association,
        public string $body,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public string $node_id,
        public NullableIntegration $performed_via_github_app,
        public WebhookIssueCommentCreatedCommentReactions $reactions,
        public DateTimeImmutable $updated_at,
        public string $url,
        public WebhookIssueCommentCreatedCommentUser $user,
        public ?NullablePinnedIssueComment $pin = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author_association' => $this->author_association,
            'body' => $this->body,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'issue_url' => $this->issue_url,
            'node_id' => $this->node_id,
            'performed_via_github_app' => $this->performed_via_github_app,
            'reactions' => $this->reactions,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'pin' => $this->pin,
        ];
    }
}
