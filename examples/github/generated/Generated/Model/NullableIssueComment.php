<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;
use JsonSerializable;

final readonly class NullableIssueComment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'issue_url' => ['issue_url', null],
        'node_id' => ['node_id', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'author_association' => ['author_association', ['enum', \Acme\GitHub\Generated\Enum\AuthorAssociation::class]],
        'body' => ['body', null],
        'body_html' => ['body_html', null],
        'body_text' => ['body_text', null],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'pin' => ['pin', \Acme\GitHub\Generated\Model\NullablePinnedIssueComment::class],
        'reactions' => ['reactions', \Acme\GitHub\Generated\Model\ReactionRollup::class],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $issue_url,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?AuthorAssociation $author_association = null,
        public ?string $body = null,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?NullableIntegration $performed_via_github_app = null,
        public ?NullablePinnedIssueComment $pin = null,
        public ?ReactionRollup $reactions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'issue_url' => $this->issue_url,
            'node_id' => $this->node_id,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'author_association' => $this->author_association,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'body_text' => $this->body_text,
            'performed_via_github_app' => $this->performed_via_github_app,
            'pin' => $this->pin,
            'reactions' => $this->reactions,
        ];
    }
}
