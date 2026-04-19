<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Event implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor' => ['actor', \Acme\GitHub\Generated\Model\Actor::class],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'payload' => [
            'payload',
            [
                'union',
                [
                    \Acme\GitHub\Generated\Model\CreateEvent::class,
                    \Acme\GitHub\Generated\Model\DeleteEvent::class,
                    \Acme\GitHub\Generated\Model\DiscussionEvent::class,
                    \Acme\GitHub\Generated\Model\IssuesEvent::class,
                    \Acme\GitHub\Generated\Model\IssueCommentEvent::class,
                    \Acme\GitHub\Generated\Model\ForkEvent::class,
                    \Acme\GitHub\Generated\Model\GollumEvent::class,
                    \Acme\GitHub\Generated\Model\MemberEvent::class,
                    \Acme\GitHub\Generated\Model\PublicEvent::class,
                    \Acme\GitHub\Generated\Model\PushEvent::class,
                    \Acme\GitHub\Generated\Model\PullRequestEvent::class,
                    \Acme\GitHub\Generated\Model\PullRequestReviewCommentEvent::class,
                    \Acme\GitHub\Generated\Model\PullRequestReviewEvent::class,
                    \Acme\GitHub\Generated\Model\CommitCommentEvent::class,
                    \Acme\GitHub\Generated\Model\ReleaseEvent::class,
                    \Acme\GitHub\Generated\Model\WatchEvent::class,
                ],
                null,
            ],
        ],
        'public' => ['public', null],
        'repo' => ['repo', \Acme\GitHub\Generated\Model\EventRepo::class],
        'type' => ['type', null],
        'org' => ['org', \Acme\GitHub\Generated\Model\Actor::class],
    ];

    public function __construct(
        public Actor $actor,
        public ?DateTimeImmutable $created_at = null,
        public string $id,
        public CreateEvent|DeleteEvent|DiscussionEvent|IssuesEvent|IssueCommentEvent|ForkEvent|GollumEvent|MemberEvent|PublicEvent|PushEvent|PullRequestEvent|PullRequestReviewCommentEvent|PullRequestReviewEvent|CommitCommentEvent|ReleaseEvent|WatchEvent $payload,
        public bool $public,
        public EventRepo $repo,
        public ?string $type = null,
        public ?Actor $org = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor' => $this->actor,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'payload' => $this->payload,
            'public' => $this->public,
            'repo' => $this->repo,
            'type' => $this->type,
            'org' => $this->org,
        ];
    }
}
